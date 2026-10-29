@extends('layouts.app')

@section('title', 'Edit Produk — Toko Sembako Berkah')

@section('content')
<div class="judul-halaman">
    <span>Edit Produk Sembako</span>
    <a href="{{ route('produk.index') }}" class="btn btn-secondary">&larr; Kembali</a>
</div>

<div class="tabel-kartu" style="padding: 2rem; max-width: 700px; margin: 0 auto;">
    <form action="{{ route('produk.update', $produk->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div style="margin-bottom: 1.2rem;">
            <label style="display: block; font-weight: 600; margin-bottom: 0.4rem;">Kode Produk / SKU *</label>
            <input type="text" name="kode_produk" value="{{ old('kode_produk', $produk->kode_produk) }}" class="input-teks" required>
        </div>

        <div style="margin-bottom: 1.2rem;">
            <label style="display: block; font-weight: 600; margin-bottom: 0.4rem;">Nama Produk Sembako *</label>
            <input type="text" name="nama_produk" value="{{ old('nama_produk', $produk->nama_produk) }}" class="input-teks" required>
        </div>

        <div style="margin-bottom: 1.2rem;">
            <label style="display: block; font-weight: 600; margin-bottom: 0.4rem;">Kategori Sembako *</label>
            <select name="kategori_id" class="input-teks" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach($kategoris as $kat)
                    <option value="{{ $kat->id }}" {{ old('kategori_id', $produk->kategori_id) == $kat->id ? 'selected' : '' }}>
                        {{ $kat->nama_kategori }}
                    </option>
                @endforeach
            </select>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.2rem;">
            <div>
                <label style="display: block; font-weight: 600; margin-bottom: 0.4rem;">Harga Beli (Modal) *</label>
                <input type="number" step="100" name="harga_beli" value="{{ old('harga_beli', $produk->harga_beli) }}" class="input-teks" required>
            </div>
            <div>
                <label style="display: block; font-weight: 600; margin-bottom: 0.4rem;">Harga Jual *</label>
                <input type="number" step="100" name="harga_jual" value="{{ old('harga_jual', $produk->harga_jual) }}" class="input-teks" required>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem;">
            <div>
                <label style="display: block; font-weight: 600; margin-bottom: 0.4rem;">Stok Tersedia *</label>
                <input type="number" name="stok" value="{{ old('stok', $produk->stok) }}" class="input-teks" min="0" required>
            </div>
            <div>
                <label style="display: block; font-weight: 600; margin-bottom: 0.4rem;">Satuan Unit *</label>
                <input type="text" name="satuan" value="{{ old('satuan', $produk->satuan) }}" class="input-teks" required>
            </div>
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; font-weight: 600; margin-bottom: 0.4rem;">Foto / Gambar Produk</label>
            <div style="display: flex; gap: 1rem; align-items: center; margin-bottom: 0.5rem;">
                <img src="{{ $produk->gambar_url }}" alt="{{ $produk->nama_produk }}" style="width: 60px; height: 60px; object-fit: contain; border-radius: 8px; border: 1px solid #e5e7eb; background: #fff; padding: 4px;">
                <div style="flex: 1;">
                    <input type="file" name="gambar" class="input-teks" accept="image/*" style="padding: 0.4rem;">
                    <small style="color: #6b7280;">Pilih file baru jika ingin mengganti gambar produk (JPG, PNG, WEBP, SVG).</small>
                </div>
            </div>
        </div>

        <div style="text-align: right; display: flex; justify-content: flex-end; gap: 0.8rem;">
            <a href="{{ route('produk.index') }}" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">Perbarui Produk</button>
        </div>
    </form>
</div>
@endsection

