@extends('layouts.app')

@section('title', 'Daftar Produk — Toko Sembako Berkah')

@section('content')
<div class="judul-halaman">
    <span>Daftar Produk</span>
    @auth
        @if(auth()->user()->isPemilik())
            <a href="{{ route('produk.create') }}" class="btn btn-primary">+ Tambah Produk</a>
        @endif
    @else
        <a href="{{ route('login') }}" class="btn btn-primary">+ Tambah Produk</a>
    @endauth
</div>

<!-- Pencarian dan Filter -->
<div class="bar-aksi">
    <form action="{{ route('produk.index') }}" method="GET" class="kotak-cari">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama produk atau kode..." class="input-teks">
        
        <select name="kategori_id" class="input-teks" style="width: auto; max-width: 200px;" onchange="this.form.submit()">
            <option value="">-- Semua Kategori --</option>
            @foreach($kategoris as $kat)
                <option value="{{ $kat->id }}" {{ request('kategori_id') == $kat->id ? 'selected' : '' }}>
                    {{ $kat->nama_kategori }}
                </option>
            @endforeach
        </select>

        <button type="submit" class="btn btn-primary">Cari</button>
        @if(request('search') || request('kategori_id'))
            <a href="{{ route('produk.index') }}" class="btn btn-secondary">Reset</a>
        @endif
    </form>
</div>

<!-- Tabel Daftar Produk Persis Sesuai Mockup UAS -->
<div class="tabel-kartu">
    <table class="tabel-berkah">
        <thead>
            <tr>
                <th style="width: 45px; text-align: center;">No</th>
                <th style="width: 60px; text-align: center;">Foto</th>
                <th>Nama Produk</th>
                <th>Kategori</th>
                <th>Harga Jual</th>
                <th>Harga Beli</th>
                <th style="text-align: center;">Stok</th>
                <th style="text-align: center; width: 160px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($produks as $index => $item)
                <tr>
                    <td style="text-align: center; font-weight: 600;">
                        {{ $produks->firstItem() + $index }}
                    </td>
                    <td style="text-align: center;">
                        <img src="{{ $item->gambar_url }}" alt="{{ $item->nama_produk }}" style="width: 44px; height: 44px; object-fit: contain; border-radius: 8px; border: 1px solid #e5e7eb; background: #ffffff; padding: 2px;">
                    </td>
                    <td>
                        <strong>{{ $item->nama_produk }}</strong>
                        <div style="font-size: 0.8rem; color: #6b7280;">Kode: {{ $item->kode_produk }}</div>
                    </td>
                    <td>
                        <span class="badge badge-info">{{ $item->kategori->nama_kategori ?? 'Umum' }}</span>
                    </td>
                    <td style="font-weight: 600; color: #15803d;">
                        Rp {{ number_format($item->harga_jual, 0, ',', '.') }}
                    </td>
                    <td style="color: #6b7280; font-size: 0.9rem;">
                        Rp {{ number_format($item->harga_beli, 0, ',', '.') }}
                    </td>
                    <td style="text-align: center;">
                        @if($item->stok <= 5)
                            <span class="badge badge-danger">{{ $item->stok }} {{ $item->satuan }} (Menipis)</span>
                        @else
                            <span class="badge badge-success">{{ $item->stok }} {{ $item->satuan }}</span>
                        @endif
                    </td>
                    <td style="text-align: center;">
                        @auth
                            @if(auth()->user()->isPemilik())
                                <a href="{{ route('produk.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                
                                <form action="{{ route('produk.destroy', $item->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            @elseif(auth()->user()->isPelanggan())
                                <form action="{{ route('pesanan.tambah-keranjang', $item->id) }}" method="POST" style="display: inline-flex; align-items: center; gap: 4px;">
                                    @csrf
                                    <input type="number" name="jumlah" value="1" min="1" max="{{ $item->stok }}" aria-label="Jumlah {{ $item->nama_produk }}" style="width: 54px; padding: 0.3rem; border: 1px solid #d1d5db; border-radius: 6px;" {{ $item->stok < 1 ? 'disabled' : '' }}>
                                    <button type="submit" class="btn btn-primary btn-sm" {{ $item->stok < 1 ? 'disabled' : '' }}>
                                        {{ $item->stok < 1 ? 'Habis' : 'Tambah' }}
                                    </button>
                                </form>
                            @else
                                <span style="font-size: 0.85rem; color: #6b7280;">Hanya Pemilik</span>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="btn btn-secondary btn-sm">Login</a>
                        @endauth
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align: center; padding: 2.5rem; color: #6b7280;">
                        <em>Tidak ada produk yang ditemukan.</em>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination Links -->
<div style="margin-top: 1.5rem; display: flex; justify-content: center;">
    {{ $produks->links() }}
</div>
@endsection
