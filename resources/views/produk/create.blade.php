@extends('layouts.app')

@section('title', 'Tambah Produk Baru — Toko Sembako Berkah')

@section('content')
<div class="judul-halaman">
    <span>Tambah Produk Sembako</span>
    <a href="{{ route('produk.index') }}" class="btn btn-secondary">&larr; Kembali</a>
</div>

<div class="tabel-kartu" style="padding: 2rem; max-width: 700px; margin: 0 auto;">
    <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div style="margin-bottom: 1.2rem;">
            <label style="display: block; font-weight: 600; margin-bottom: 0.4rem;">Kode Produk / SKU *</label>
            <input type="text" name="kode_produk" value="{{ old('kode_produk', 'BRG-' . rand(100, 999)) }}" class="input-teks" required>
        </div>

        <div style="margin-bottom: 1.2rem;">
            <label style="display: block; font-weight: 600; margin-bottom: 0.4rem;">Nama Produk Sembako *</label>
            <input type="text" name="nama_produk" value="{{ old('nama_produk') }}" placeholder="Contoh: Beras Rojo Lele 5kg" class="input-teks" required>
        </div>

        <div style="margin-bottom: 1.2rem;">
            <label style="display: block; font-weight: 600; margin-bottom: 0.4rem;">Kategori Sembako *</label>
            <select name="kategori_id" class="input-teks" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach($kategoris as $kat)
                    <option value="{{ $kat->id }}" {{ old('kategori_id') == $kat->id ? 'selected' : '' }}>
                        {{ $kat->nama_kategori }}
                    </option>
                @endforeach
            </select>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.2rem;">
            <div>
                <label style="display: block; font-weight: 600; margin-bottom: 0.4rem;">Harga Beli (Modal) *</label>
                <input type="number" step="100" name="harga_beli" value="{{ old('harga_beli') }}" placeholder="0" class="input-teks" required>
            </div>
            <div>
                <label style="display: block; font-weight: 600; margin-bottom: 0.4rem;">Harga Jual *</label>
                <input type="number" step="100" name="harga_jual" value="{{ old('harga_jual') }}" placeholder="0" class="input-teks" required>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem;">
            <div>
                <label style="display: block; font-weight: 600; margin-bottom: 0.4rem;">Stok Awal *</label>
                <input type="number" name="stok" value="{{ old('stok', 0) }}" class="input-teks" min="0" required>
            </div>
            <div>
                <label style="display: block; font-weight: 600; margin-bottom: 0.4rem;">Satuan Unit *</label>
                <input type="text" name="satuan" value="{{ old('satuan', 'pcs') }}" placeholder="pcs / kg / karung / liter" class="input-teks" required>
            </div>
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; font-weight: 600; margin-bottom: 0.4rem;">Foto / Gambar Produk (Opsional)</label>
            <input type="file" name="gambar" class="input-teks" accept="image/*" style="padding: 0.4rem;">
            <div style="font-size: 0.8rem; color: #6b7280; margin-top: 0.3rem;">Format: JPG, PNG, WEBP, SVG (Maksimal 2MB). Jika dikosongkan, gambar sembako default akan digunakan.</div>
        </div>

        <div style="text-align: right; display: flex; justify-content: flex-end; gap: 0.8rem;">
            <a href="{{ route('produk.index') }}" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan Produk</button>
        </div>
    </form>
</div>
@endsection

