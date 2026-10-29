@extends('layouts.app')

@section('title', 'Riwayat Transaksi — Toko Sembako Berkah')

@section('content')
<div class="judul-halaman">
    <span>Riwayat Transaksi Penjualan</span>
    <a href="{{ route('transaksi.create') }}" class="btn btn-primary">🛒 Kasir Baru / Transaksi</a>
</div>

<!-- Filter dan Pencarian -->
<div class="bar-aksi">
    <form action="{{ route('transaksi.index') }}" method="GET" class="kotak-cari">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari No. Invoice atau Nama Pembeli..." class="input-teks">
        <input type="date" name="tanggal" value="{{ request('tanggal') }}" class="input-teks" style="width: auto; max-width: 180px;">
        <button type="submit" class="btn btn-primary">Filter</button>
        @if(request('search') || request('tanggal'))
            <a href="{{ route('transaksi.index') }}" class="btn btn-secondary">Reset</a>
        @endif
    </form>
</div>

<!-- Tabel Transaksi -->
<div class="tabel-kartu">
    <table class="tabel-berkah">
        <thead>
            <tr>
                <th style="width: 50px; text-align: center;">No</th>
                <th>No. Transaksi</th>
                <th>Waktu Transaksi</th>
                <th>Kasir / Petugas</th>
                <th>Nama Pembeli</th>
                <th>Total Belanja</th>
                <th style="text-align: center; width: 180px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transaksis as $index => $trx)
                <tr>
                    <td style="text-align: center; font-weight: 600;">
                        {{ $transaksis->firstItem() + $index }}
                    </td>
                    <td>
                        <strong style="color: var(--hijau-utama);">{{ $trx->no_transaksi }}</strong>
                        <div style="font-size: 0.8rem; color: #6b7280;">{{ $trx->detailTransaksis->count() }} item barang</div>
                    </td>
                    <td>
                        {{ $trx->created_at->format('d/m/Y H:i') }}
                    </td>
                    <td>
                        <span class="badge badge-info">{{ $trx->user->name ?? 'Kasir' }}</span>
                    </td>
                    <td>
                        {{ $trx->nama_pembeli ?: 'Pelanggan Umum' }}
                    </td>
                    <td style="font-weight: 700; color: #15803d; font-size: 1rem;">
                        Rp {{ number_format($trx->total_harga, 0, ',', '.') }}
                    </td>
                    <td style="text-align: center;">
                        <a href="{{ route('transaksi.show', $trx->id) }}" class="btn btn-secondary btn-sm">Lihat Nota</a>
                        <a href="{{ route('transaksi.print', $trx->id) }}" target="_blank" class="btn btn-warning btn-sm">Cetak</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 2.5rem; color: #6b7280;">
                        <em>Belum ada transaksi penjualan yang tercatat.</em>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div style="margin-top: 1.5rem; display: flex; justify-content: center;">
    {{ $transaksis->links() }}
</div>
@endsection

