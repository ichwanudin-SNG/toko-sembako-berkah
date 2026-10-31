@extends('layouts.app')

@section('title', 'Checkout Pesanan — Toko Sembako Berkah')

@section('content')
<div class="judul-halaman">
    <span>✅ Konfirmasi Pesanan</span>
    <a href="{{ route('pesanan.keranjang') }}" class="btn btn-secondary">← Kembali ke Keranjang</a>
</div>

<div style="display: grid; grid-template-columns: 1fr 350px; gap: 1.5rem; align-items: start;">
    {{-- Detail item --}}
    <div>
        <div class="tabel-kartu" style="margin-bottom: 1.2rem;">
            <div style="padding: 1rem 1.2rem; background: #f9fafb; border-bottom: 1px solid #e5e7eb; font-weight: 600; font-size: 0.95rem; color: #374151;">
                📦 Daftar Produk yang Dipesan
            </div>
            <table class="tabel-berkah">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th style="text-align:right;">Harga</th>
                        <th style="text-align:center;">Qty</th>
                        <th style="text-align:right;">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($keranjang as $item)
                    <tr>
                        <td>
                            <div style="display: flex; align-items: center; gap: 0.7rem;">
                                <img src="{{ $item['gambar'] }}" style="width: 40px; height: 40px; object-fit: contain; background: #f3f4f6; border-radius: 5px; padding: 3px;">
                                <div>
                                    <strong>{{ $item['nama_produk'] }}</strong><br>
                                    <small style="color:#6b7280;">per {{ $item['satuan'] }}</small>
                                </div>
                            </div>
                        </td>
                        <td style="text-align:right;">Rp {{ number_format($item['harga'], 0, ',', '.') }}</td>
                        <td style="text-align:center;">{{ $item['jumlah'] }}</td>
                        <td style="text-align:right; font-weight: 600; color: var(--hijau-utama);">
                            Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr style="background: #f0fdf4;">
                        <td colspan="3" style="text-align:right; font-weight: 700; padding: 0.9rem 1.2rem;">Total Pesanan</td>
                        <td style="text-align:right; font-weight: 700; font-size: 1.1rem; color: var(--hijau-utama); padding: 0.9rem 1.2rem;">
                            Rp {{ number_format($total, 0, ',', '.') }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>

        {{-- Form catatan --}}
        <div class="tabel-kartu" style="padding: 1.5rem;">
            <h4 style="margin: 0 0 1rem 0; color: #374151;">💬 Catatan untuk Toko (Opsional)</h4>
            <form action="{{ route('pesanan.proses') }}" method="POST" id="form-checkout">
                @csrf
                <textarea name="catatan" rows="3" class="input-teks"
                    placeholder="Contoh: Antar ke alamat saya, tolong bungkus dengan rapi, dll."
                    style="resize: vertical;">{{ old('catatan') }}</textarea>
            </form>
        </div>
    </div>

    {{-- Ringkasan & info --}}
    <div>
        <div class="tabel-kartu" style="padding: 1.5rem; margin-bottom: 1rem;">
            <h3 style="margin: 0 0 1rem 0; color: var(--hijau-utama);">👤 Info Pemesan</h3>
            <div style="font-size: 0.9rem; color: #374151; line-height: 1.8;">
                <div><strong>Nama:</strong> {{ auth()->user()->name }}</div>
                <div><strong>Email:</strong> {{ auth()->user()->email }}</div>
                <div><strong>Username:</strong> {{ auth()->user()->username }}</div>
            </div>
        </div>

        <div class="tabel-kartu" style="padding: 1.5rem; margin-bottom: 1rem; background: #fffbeb; border: 1px solid #fde68a;">
            <p style="margin: 0; font-size: 0.88rem; color: #92400e; line-height: 1.6;">
                ⚠️ <strong>Catatan:</strong> Pesanan akan diproses oleh kasir toko. Pembayaran dilakukan saat pengambilan/pengiriman barang.
            </p>
        </div>

        <div class="tabel-kartu" style="padding: 1.5rem;">
            <div style="display: flex; justify-content: space-between; font-size: 1.2rem; font-weight: 700; color: var(--hijau-utama); margin-bottom: 1.2rem;">
                <span>Total</span>
                <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
            </div>
            <button type="submit" form="form-checkout" class="btn btn-primary"
                    style="width: 100%; justify-content: center; padding: 0.9rem; font-size: 1rem;">
                🛍️ Buat Pesanan Sekarang
            </button>
            <a href="{{ route('pesanan.keranjang') }}" class="btn btn-secondary"
               style="width: 100%; justify-content: center; margin-top: 0.7rem; padding: 0.7rem;">
                ← Ubah Keranjang
            </a>
        </div>
    </div>
</div>
@endsection
