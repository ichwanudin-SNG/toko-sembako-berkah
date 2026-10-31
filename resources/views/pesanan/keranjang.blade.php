@extends('layouts.app')

@section('title', 'Keranjang Belanja — Toko Sembako Berkah')

@section('content')
<div class="judul-halaman">
    <span>🛒 Keranjang Belanja</span>
    <a href="{{ route('produk.index') }}" class="btn btn-secondary">← Lanjut Belanja</a>
</div>

@if(empty($keranjang))
    <div class="tabel-kartu" style="padding: 3rem; text-align: center;">
        <div style="font-size: 4rem; margin-bottom: 1rem;">🛒</div>
        <h3 style="color: #6b7280; margin-bottom: 1rem;">Keranjang masih kosong</h3>
        <p style="color: #9ca3af; margin-bottom: 1.5rem;">Yuk, pilih produk sembako yang Anda butuhkan!</p>
        <a href="{{ route('produk.index') }}" class="btn btn-primary">🌾 Lihat Katalog Produk</a>
    </div>
@else
    <div style="display: grid; grid-template-columns: 1fr 320px; gap: 1.5rem; align-items: start;">
        {{-- Daftar item keranjang --}}
        <div class="tabel-kartu">
            <table class="tabel-berkah">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Harga Satuan</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($keranjang as $key => $item)
                    <tr>
                        <td>
                            <div style="display: flex; align-items: center; gap: 0.8rem;">
                                <img src="{{ $item['gambar'] }}" alt="{{ $item['nama_produk'] }}"
                                     style="width: 48px; height: 48px; object-fit: contain; border-radius: 6px; background: #f3f4f6; padding: 4px;">
                                <div>
                                    <strong style="font-size: 0.95rem;">{{ $item['nama_produk'] }}</strong><br>
                                    <span style="font-size: 0.8rem; color: #6b7280;">per {{ $item['satuan'] }}</span>
                                </div>
                            </div>
                        </td>
                        <td>Rp {{ number_format($item['harga'], 0, ',', '.') }}</td>
                        <td>
                            <form action="{{ route('pesanan.update-keranjang', $key) }}" method="POST" style="display: flex; gap: 0.4rem; align-items: center;">
                                @csrf @method('PATCH')
                                <input type="number" name="jumlah" value="{{ $item['jumlah'] }}" min="1"
                                       style="width: 65px; padding: 0.35rem 0.5rem; border: 1px solid #d1d5db; border-radius: 5px; text-align: center;">
                                <button type="submit" class="btn btn-primary btn-sm">✓</button>
                            </form>
                        </td>
                        <td><strong style="color: var(--hijau-utama);">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</strong></td>
                        <td>
                            <form action="{{ route('pesanan.hapus-keranjang', $key) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Hapus item ini?')">🗑</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Ringkasan pesanan --}}
        <div class="tabel-kartu" style="padding: 1.5rem; position: sticky; top: 1rem;">
            <h3 style="color: var(--hijau-utama); margin: 0 0 1rem 0; font-size: 1.1rem;">📋 Ringkasan</h3>
            <div style="border-top: 1px solid #e5e7eb; padding-top: 1rem;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 0.8rem; font-size: 0.95rem;">
                    <span style="color: #6b7280;">Total Item</span>
                    <span>{{ collect($keranjang)->sum('jumlah') }} item</span>
                </div>
                <div style="display: flex; justify-content: space-between; font-size: 1.15rem; font-weight: 700; color: var(--hijau-utama); border-top: 1px solid #e5e7eb; padding-top: 0.8rem; margin-top: 0.5rem;">
                    <span>Total</span>
                    <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>
            </div>
            <a href="{{ route('pesanan.checkout') }}" class="btn btn-primary"
               style="width: 100%; justify-content: center; margin-top: 1.2rem; padding: 0.85rem; font-size: 1rem;">
                ✅ Lanjut Checkout
            </a>
        </div>
    </div>
@endif
@endsection
