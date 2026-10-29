<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaksi::with(['user', 'detailTransaksis.produk']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('no_transaksi', 'like', "%{$search}%")
                  ->orWhere('nama_pembeli', 'like', "%{$search}%");
            });
        }

        if ($request->filled('tanggal')) {
            $query->whereDate('created_at', $request->tanggal);
        }

        $transaksis = $query->latest()->paginate(10)->withQueryString();

        return view('transaksi.index', compact('transaksis'));
    }

    public function create()
    {
        $produks = Produk::with('kategori')
            ->where('stok', '>', 0)
            ->orderBy('nama_produk')
            ->get();

        return view('transaksi.create', compact('produks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pembeli' => ['nullable', 'string', 'max:100'],
            'bayar' => ['required', 'numeric', 'min:0'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.produk_id' => ['required', 'exists:produks,id'],
            'items.*.jumlah' => ['required', 'integer', 'min:1'],
        ], [
            'items.required' => 'Keranjang belanja tidak boleh kosong.',
            'items.min' => 'Pilih minimal 1 produk untuk melakukan transaksi.',
            'bayar.required' => 'Nominal uang pembayaran wajib diisi.',
        ]);

        return DB::transaction(function () use ($request) {
            $totalHarga = 0;
            $itemsData = [];

            // 1. Verifikasi ketersediaan stok dan hitung total
            foreach ($request->items as $item) {
                $produk = Produk::lockForUpdate()->findOrFail($item['produk_id']);

                if ($produk->stok < $item['jumlah']) {
                    return back()->withInput()->with('error', "Stok untuk produk '{$produk->nama_produk}' tidak mencukupi (sisa: {$produk->stok} {$produk->satuan}).");
                }

                $subtotal = $produk->harga_jual * $item['jumlah'];
                $totalHarga += $subtotal;

                $itemsData[] = [
                    'produk' => $produk,
                    'jumlah' => $item['jumlah'],
                    'harga_saat_jual' => $produk->harga_jual,
                    'subtotal' => $subtotal,
                ];
            }

            // 2. Cek uang pembayaran
            $bayar = (float) $request->bayar;
            if ($bayar < $totalHarga) {
                return back()->withInput()->with('error', 'Uang pembayaran kurang dari total tagihan (Total: Rp ' . number_format($totalHarga, 0, ',', '.') . ').');
            }

            $kembalian = $bayar - $totalHarga;

            // 3. Generate nomor invoice unik
            $today = date('Ymd');
            $countToday = Transaksi::whereDate('created_at', today())->count() + 1;
            $noTransaksi = 'TRX-' . $today . '-' . str_pad($countToday, 4, '0', STR_PAD_LEFT);

            // 4. Buat record transaksi
            $transaksi = Transaksi::create([
                'no_transaksi' => $noTransaksi,
                'user_id' => Auth::id() ?? 1,
                'nama_pembeli' => $request->nama_pembeli ?: 'Pelanggan Umum',
                'total_harga' => $totalHarga,
                'bayar' => $bayar,
                'kembalian' => $kembalian,
            ]);

            // 5. Simpan detail dan kurangi stok
            foreach ($itemsData as $data) {
                DetailTransaksi::create([
                    'transaksi_id' => $transaksi->id,
                    'produk_id' => $data['produk']->id,
                    'jumlah' => $data['jumlah'],
                    'harga_saat_jual' => $data['harga_saat_jual'],
                    'subtotal' => $data['subtotal'],
                ]);

                // Kurangi stok produk
                $data['produk']->decrement('stok', $data['jumlah']);
            }

            return redirect()->route('transaksi.show', $transaksi->id)
                ->with('success', "Transaksi {$noTransaksi} berhasil diproses!");
        });
    }

    public function show(Transaksi $transaksi)
    {
        $transaksi->load(['user', 'detailTransaksis.produk.kategori']);
        return view('transaksi.show', compact('transaksi'));
    }

    public function printReceipt(Transaksi $transaksi)
    {
        $transaksi->load(['user', 'detailTransaksis.produk']);
        return view('transaksi.print', compact('transaksi'));
    }
}

