<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\DetailPesanan;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PesananController extends Controller
{
    // ─── Keranjang (Session-based) ────────────────────────────────

    public function keranjang()
    {
        $keranjang = session('keranjang', []);
        $total = collect($keranjang)->sum('subtotal');
        return view('pesanan.keranjang', compact('keranjang', 'total'));
    }

    public function tambahKeranjang(Request $request, Produk $produk)
    {
        $request->validate([
            'jumlah' => ['required', 'integer', 'min:1'],
        ]);

        $jumlah = (int) $request->jumlah;

        if ($produk->stok < $jumlah) {
            return back()->with('error', "Stok {$produk->nama_produk} tidak mencukupi (tersisa {$produk->stok} {$produk->satuan}).");
        }

        $keranjang = session('keranjang', []);
        $key = 'produk_' . $produk->id;

        if (isset($keranjang[$key])) {
            $jumlahBaru = $keranjang[$key]['jumlah'] + $jumlah;
            if ($produk->stok < $jumlahBaru) {
                return back()->with('error', "Total pesanan melebihi stok yang tersedia ({$produk->stok} {$produk->satuan}).");
            }
            $keranjang[$key]['jumlah']   = $jumlahBaru;
            $keranjang[$key]['subtotal'] = $jumlahBaru * $produk->harga_jual;
        } else {
            $keranjang[$key] = [
                'produk_id'   => $produk->id,
                'nama_produk' => $produk->nama_produk,
                'harga'       => $produk->harga_jual,
                'satuan'      => $produk->satuan,
                'jumlah'      => $jumlah,
                'subtotal'    => $jumlah * $produk->harga_jual,
                'gambar'      => $produk->gambar_url,
            ];
        }

        session(['keranjang' => $keranjang]);
        return back()->with('success', "{$produk->nama_produk} ditambahkan ke keranjang!");
    }

    public function updateKeranjang(Request $request, $key)
    {
        $request->validate(['jumlah' => ['required', 'integer', 'min:1']]);
        $keranjang = session('keranjang', []);

        if (isset($keranjang[$key])) {
            $produk = Produk::find($keranjang[$key]['produk_id']);
            $jumlah = (int) $request->jumlah;
            if ($produk && $produk->stok < $jumlah) {
                return back()->with('error', "Stok tidak mencukupi ({$produk->stok} {$produk->satuan}).");
            }
            $keranjang[$key]['jumlah']   = $jumlah;
            $keranjang[$key]['subtotal'] = $jumlah * $keranjang[$key]['harga'];
            session(['keranjang' => $keranjang]);
        }

        return back()->with('success', 'Keranjang diperbarui.');
    }

    public function hapusKeranjang($key)
    {
        $keranjang = session('keranjang', []);
        unset($keranjang[$key]);
        session(['keranjang' => $keranjang]);
        return back()->with('success', 'Item dihapus dari keranjang.');
    }

    // ─── Checkout ─────────────────────────────────────────────────

    public function checkout()
    {
        $keranjang = session('keranjang', []);
        if (empty($keranjang)) {
            return redirect()->route('pesanan.keranjang')->with('error', 'Keranjang masih kosong!');
        }
        $total = collect($keranjang)->sum('subtotal');
        return view('pesanan.checkout', compact('keranjang', 'total'));
    }

    public function prosesPesanan(Request $request)
    {
        $request->validate([
            'catatan' => ['nullable', 'string', 'max:500'],
        ]);

        $keranjang = session('keranjang', []);
        if (empty($keranjang)) {
            return redirect()->route('produk.index')->with('error', 'Keranjang kosong!');
        }

        DB::transaction(function () use ($keranjang, $request) {
            $total = collect($keranjang)->sum('subtotal');
            $noPesanan = 'PSN-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -5));

            $pesanan = Pesanan::create([
                'no_pesanan'  => $noPesanan,
                'user_id'     => Auth::id(),
                'status'      => 'menunggu',
                'total_harga' => $total,
                'catatan'     => $request->catatan,
            ]);

            foreach ($keranjang as $item) {
                DetailPesanan::create([
                    'pesanan_id'      => $pesanan->id,
                    'produk_id'       => $item['produk_id'],
                    'jumlah'          => $item['jumlah'],
                    'harga_saat_pesan'=> $item['harga'],
                    'subtotal'        => $item['subtotal'],
                ]);

                // Kurangi stok produk
                Produk::where('id', $item['produk_id'])
                    ->decrement('stok', $item['jumlah']);
            }

            session()->forget('keranjang');
        });

        return redirect()->route('pesanan.riwayat')
            ->with('success', '🎉 Pesanan berhasil dibuat! Kami akan segera memproses pesanan Anda.');
    }

    // ─── Riwayat Pesanan (Pelanggan) ──────────────────────────────

    public function riwayat()
    {
        $pesanans = Pesanan::where('user_id', Auth::id())
            ->with('details.produk')
            ->latest()
            ->get();
        return view('pesanan.riwayat', compact('pesanans'));
    }

    public function show(Pesanan $pesanan)
    {
        if ($pesanan->user_id !== Auth::id() && !Auth::user()->isPemilik()) {
            return redirect()->route('pesanan.riwayat')->with('error', 'Akses ditolak.');
        }
        $pesanan->load('details.produk', 'user');
        return view('pesanan.show', compact('pesanan'));
    }

    public function batal(Pesanan $pesanan)
    {
        if ($pesanan->user_id !== Auth::id()) {
            return redirect()->route('pesanan.riwayat')->with('error', 'Akses ditolak.');
        }
        if (!in_array($pesanan->status, ['menunggu'])) {
            return back()->with('error', 'Pesanan ini tidak dapat dibatalkan.');
        }

        DB::transaction(function () use ($pesanan) {
            // Kembalikan stok
            foreach ($pesanan->details as $detail) {
                Produk::where('id', $detail->produk_id)->increment('stok', $detail->jumlah);
            }
            $pesanan->update(['status' => 'dibatalkan']);
        });

        return back()->with('success', 'Pesanan berhasil dibatalkan.');
    }

    // ─── Kelola Pesanan (Pemilik) ──────────────────────────────────

    public function kelolaIndex()
    {
        $pesanans = Pesanan::with('user', 'details')->latest()->get();
        return view('pesanan.kelola', compact('pesanans'));
    }

    public function updateStatus(Request $request, Pesanan $pesanan)
    {
        $request->validate([
            'status' => ['required', 'in:menunggu,diproses,selesai,dibatalkan'],
        ]);

        if ($request->status === 'dibatalkan' && $pesanan->status !== 'dibatalkan') {
            DB::transaction(function () use ($pesanan, $request) {
                foreach ($pesanan->details as $detail) {
                    Produk::where('id', $detail->produk_id)->increment('stok', $detail->jumlah);
                }
                $pesanan->update(['status' => $request->status]);
            });
        } else {
            $pesanan->update(['status' => $request->status]);
        }

        return back()->with('success', "Status pesanan #{$pesanan->no_pesanan} diperbarui.");
    }
}
