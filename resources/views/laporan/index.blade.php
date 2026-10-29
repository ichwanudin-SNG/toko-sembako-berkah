@extends('layouts.app')

@section('title', 'Laporan Keuangan & Laba Rugi — Toko Sembako Berkah')

@section('content')
<div class="judul-halaman">
    <span>Laporan Keuangan & Finansial</span>
    <button onclick="window.print()" class="btn btn-warning">🖨️ Cetak Laporan</button>
</div>

<!-- Filter Periode Laporan -->
<div class="tabel-kartu" style="padding: 1.5rem; margin-bottom: 1.5rem;">
    <form action="{{ route('laporan.index') }}" method="GET" style="display: flex; gap: 1rem; align-items: flex-end; flex-wrap: wrap;">
        <div>
            <label style="display: block; font-weight: 600; font-size: 0.9rem; margin-bottom: 0.3rem;">Dari Tanggal:</label>
            <input type="date" name="start_date" value="{{ $startDate }}" class="input-teks">
        </div>
        <div>
            <label style="display: block; font-weight: 600; font-size: 0.9rem; margin-bottom: 0.3rem;">Sampai Tanggal:</label>
            <input type="date" name="end_date" value="{{ $endDate }}" class="input-teks">
        </div>
        <div>
            <button type="submit" class="btn btn-primary">Filter Periode</button>
            <a href="{{ route('laporan.index') }}" class="btn btn-secondary">Bulan Ini</a>
        </div>
    </form>
</div>

<!-- Kartu Ringkasan Finansial Periode -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1.2rem; margin-bottom: 2rem;">
    <div class="tabel-kartu" style="padding: 1.2rem; border-top: 4px solid #15803d;">
        <div style="font-size: 0.85rem; color: #6b7280; font-weight: 600;">TOTAL OMSET (PENJUALAN)</div>
        <div style="font-size: 1.4rem; font-weight: 700; color: #15803d; margin-top: 0.3rem;">
            Rp {{ number_format($totalPenghasilan, 0, ',', '.') }}
        </div>
        <div style="font-size: 0.8rem; color: #6b7280;">{{ $totalTransaksiCount }} transaksi</div>
    </div>

    <div class="tabel-kartu" style="padding: 1.2rem; border-top: 4px solid #d97706;">
        <div style="font-size: 0.85rem; color: #6b7280; font-weight: 600;">HARGA POKOK PENJUALAN (HPP)</div>
        <div style="font-size: 1.4rem; font-weight: 700; color: #b45309; margin-top: 0.3rem;">
            Rp {{ number_format($totalHpp, 0, ',', '.') }}
        </div>
        <div style="font-size: 0.8rem; color: #6b7280;">Modal barang yang terjual</div>
    </div>

    <div class="tabel-kartu" style="padding: 1.2rem; border-top: 4px solid #2563eb;">
        <div style="font-size: 0.85rem; color: #6b7280; font-weight: 600;">LABA KOTOR (KEUNTUNGAN)</div>
        <div style="font-size: 1.4rem; font-weight: 700; color: #1d4ed8; margin-top: 0.3rem;">
            Rp {{ number_format($labaBersih, 0, ',', '.') }}
        </div>
        <div style="font-size: 0.8rem; color: #6b7280;">
            Margin laba: {{ $totalPenghasilan > 0 ? number_format(($labaBersih / $totalPenghasilan) * 100, 1) : 0 }}%
        </div>
    </div>
</div>

<!-- Rincian Tabel Laporan Transaksi -->
<div class="tabel-kartu">
    <table class="tabel-berkah">
        <thead>
            <tr>
                <th style="width: 50px; text-align: center;">No</th>
                <th>Tanggal</th>
                <th>No. Transaksi</th>
                <th>Kasir</th>
                <th>Pembeli</th>
                <th>Total Belanja</th>
                <th style="text-align: center;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transaksis as $index => $t)
                <tr>
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td>{{ $t->created_at->format('d/m/Y H:i') }}</td>
                    <td><strong style="color: var(--hijau-utama);">{{ $t->no_transaksi }}</strong></td>
                    <td><span class="badge badge-info">{{ $t->user->name ?? 'Kasir' }}</span></td>
                    <td>{{ $t->nama_pembeli ?: 'Umum' }}</td>
                    <td style="font-weight: 600; color: #15803d;">Rp {{ number_format($t->total_harga, 0, ',', '.') }}</td>
                    <td style="text-align: center;">
                        <a href="{{ route('transaksi.show', $t->id) }}" class="btn btn-secondary btn-sm">Nota</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 2rem; color: #6b7280;">
                        Tidak ada catatan transaksi pada periode yang dipilih.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

