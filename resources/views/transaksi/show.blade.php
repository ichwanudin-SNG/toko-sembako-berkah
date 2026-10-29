@extends('layouts.app')

@section('title', 'Nota ' . $transaksi->no_transaksi . ' — Toko Sembako Berkah')

@section('content')
<div class="judul-halaman">
    <span>Detail Nota Transaksi</span>
    <div style="display: flex; gap: 0.5rem;">
        <a href="{{ route('transaksi.index') }}" class="btn btn-secondary">&larr; Riwayat</a>
        <a href="{{ route('transaksi.print', $transaksi->id) }}" target="_blank" class="btn btn-warning">🖨️ Cetak Nota</a>
        <a href="{{ route('transaksi.create') }}" class="btn btn-primary">+ Transaksi Baru</a>
    </div>
</div>

<div class="tabel-kartu" style="max-width: 650px; margin: 0 auto; padding: 2rem;">
    <div style="text-align: center; border-bottom: 2px dashed #e5e7eb; padding-bottom: 1.2rem; margin-bottom: 1.5rem;">
        <h2 style="color: var(--hijau-utama); margin-bottom: 0.2rem;">🌾 TOKO SEMBAKO BERKAH</h2>
        <p style="color: #6b7280; font-size: 0.9rem;">Menyediakan Sembako Murah, Lengkap, dan Berkualitas</p>
        <p style="font-size: 0.85rem; color: #9ca3af;">Jl. Raya Pasar Induk No. 12 &bull; Telp: 0812-3456-7890</p>
    </div>

    <!-- Informasi Transaksi -->
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.5rem; font-size: 0.9rem; margin-bottom: 1.5rem;">
        <div><strong>No. Transaksi:</strong> {{ $transaksi->no_transaksi }}</div>
        <div style="text-align: right;"><strong>Tanggal:</strong> {{ $transaksi->created_at->format('d/m/Y H:i:s') }}</div>
        <div><strong>Kasir:</strong> {{ $transaksi->user->name ?? 'Kasir' }}</div>
        <div style="text-align: right;"><strong>Pembeli:</strong> {{ $transaksi->nama_pembeli ?: 'Pelanggan Umum' }}</div>
    </div>

    <!-- Rincian Produk -->
    <table style="width: 100%; border-collapse: collapse; margin-bottom: 1.5rem; font-size: 0.95rem;">
        <thead>
            <tr style="border-bottom: 1px solid #15803d; border-top: 1px solid #15803d;">
                <th style="padding: 0.6rem 0; text-align: left;">Item</th>
                <th style="padding: 0.6rem 0; text-align: center; width: 60px;">Qty</th>
                <th style="padding: 0.6rem 0; text-align: right;">Harga</th>
                <th style="padding: 0.6rem 0; text-align: right;">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaksi->detailTransaksis as $detail)
                <tr style="border-bottom: 1px solid #f3f4f6;">
                    <td style="padding: 0.6rem 0;">
                        {{ $detail->produk->nama_produk ?? 'Barang Terhapus' }}
                    </td>
                    <td style="padding: 0.6rem 0; text-align: center;">
                        {{ $detail->jumlah }} {{ $detail->produk->satuan ?? '' }}
                    </td>
                    <td style="padding: 0.6rem 0; text-align: right; color: #6b7280;">
                        Rp {{ number_format($detail->harga_saat_jual, 0, ',', '.') }}
                    </td>
                    <td style="padding: 0.6rem 0; text-align: right; font-weight: 600;">
                        Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Ringkasan Finansial Nota -->
    <div style="border-top: 2px dashed #e5e7eb; padding-top: 1rem; font-size: 1rem;">
        <div style="display: flex; justify-content: space-between; margin-bottom: 0.4rem;">
            <span>Total Tagihan:</span>
            <span style="font-weight: 700; color: #15803d; font-size: 1.15rem;">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</span>
        </div>
        <div style="display: flex; justify-content: space-between; margin-bottom: 0.4rem; color: #4b5563;">
            <span>Tunai / Bayar:</span>
            <span>Rp {{ number_format($transaksi->bayar, 0, ',', '.') }}</span>
        </div>
        <div style="display: flex; justify-content: space-between; font-weight: 600;">
            <span>Kembalian:</span>
            <span style="color: #0f172a;">Rp {{ number_format($transaksi->kembalian, 0, ',', '.') }}</span>
        </div>
    </div>

    <div style="text-align: center; margin-top: 2rem; color: #9ca3af; font-size: 0.85rem;">
        <p>*** Terima kasih telah berbelanja di Toko Sembako Berkah ***</p>
        <p>Barang yang sudah dibeli tidak dapat ditukar atau dikembalikan kecuali ada perjanjian.</p>
    </div>
</div>
@endsection

