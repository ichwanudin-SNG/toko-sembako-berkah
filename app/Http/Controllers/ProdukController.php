<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    public function index(Request $request)
    {
        $query = Produk::with('kategori');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_produk', 'like', "%{$search}%")
                  ->orWhere('kode_produk', 'like', "%{$search}%");
            });
        }

        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }

        $produks = $query->latest()->paginate(10)->withQueryString();
        $kategoris = Kategori::orderBy('nama_kategori')->get();

        return view('produk.index', compact('produks', 'kategoris'));
    }

    public function create()
    {
        $kategoris = Kategori::orderBy('nama_kategori')->get();
        return view('produk.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_produk' => ['required', 'string', 'max:50', 'unique:produks,kode_produk'],
            'nama_produk' => ['required', 'string', 'max:150'],
            'kategori_id' => ['required', 'exists:kategoris,id'],
            'stok' => ['required', 'integer', 'min:0'],
            'harga_beli' => ['required', 'numeric', 'min:0'],
            'harga_jual' => ['required', 'numeric', 'min:0', 'gte:harga_beli'],
            'satuan' => ['required', 'string', 'max:30'],
            'gambar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,svg', 'max:2048'],
        ], [
            'kode_produk.unique' => 'Kode produk ini sudah dipakai.',
            'harga_jual.gte' => 'Harga jual tidak boleh lebih kecil dari harga beli.',
            'kategori_id.exists' => 'Kategori yang dipilih tidak valid.',
            'gambar.image' => 'File harus berupa gambar valid.',
            'gambar.max' => 'Ukuran gambar maksimal adalah 2MB.',
        ]);

        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('produk', 'public');
            $validated['gambar'] = $path;
        }

        Produk::create($validated);

        return redirect()->route('produk.index')->with('success', 'Produk sembako berhasil ditambahkan!');
    }

    public function edit(Produk $produk)
    {
        $kategoris = Kategori::orderBy('nama_kategori')->get();
        return view('produk.edit', compact('produk', 'kategoris'));
    }

    public function update(Request $request, Produk $produk)
    {
        $validated = $request->validate([
            'kode_produk' => ['required', 'string', 'max:50', 'unique:produks,kode_produk,' . $produk->id],
            'nama_produk' => ['required', 'string', 'max:150'],
            'kategori_id' => ['required', 'exists:kategoris,id'],
            'stok' => ['required', 'integer', 'min:0'],
            'harga_beli' => ['required', 'numeric', 'min:0'],
            'harga_jual' => ['required', 'numeric', 'min:0', 'gte:harga_beli'],
            'satuan' => ['required', 'string', 'max:30'],
            'gambar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,svg', 'max:2048'],
        ], [
            'kode_produk.unique' => 'Kode produk ini sudah dipakai.',
            'harga_jual.gte' => 'Harga jual tidak boleh lebih kecil dari harga beli.',
            'kategori_id.exists' => 'Kategori yang dipilih tidak valid.',
            'gambar.image' => 'File harus berupa gambar valid.',
            'gambar.max' => 'Ukuran gambar maksimal adalah 2MB.',
        ]);

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada di storage/app/public
            if ($produk->gambar && !str_starts_with($produk->gambar, 'images/') && !str_starts_with($produk->gambar, 'http')) {
                Storage::disk('public')->delete($produk->gambar);
            }
            $path = $request->file('gambar')->store('produk', 'public');
            $validated['gambar'] = $path;
        }

        $produk->update($validated);

        return redirect()->route('produk.index')->with('success', 'Data produk berhasil diperbarui!');
    }

    public function destroy(Produk $produk)
    {
        // Cek jika produk pernah ada dalam transaksi
        if ($produk->detailTransaksis()->exists()) {
            return back()->with('error', 'Produk tidak dapat dihapus karena sudah memiliki riwayat transaksi.');
        }

        if ($produk->gambar && !str_starts_with($produk->gambar, 'images/') && !str_starts_with($produk->gambar, 'http')) {
            Storage::disk('public')->delete($produk->gambar);
        }

        $produk->delete();

        return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus.');
    }
}

