@extends('layouts.app')

@section('title', 'Dashboard Finansial & Operasional — Toko Sembako Berkah')

@section('content')
<div class="judul-halaman">
    <div>
        <span>Dashboard Ringkasan Finansial</span>
        <div style="font-size: 0.95rem; color: #6b7280; font-weight: 400; margin-top: 0.2rem;">
            Halo <strong>{{ auth()->user()->name }}</strong>, Anda masuk sebagai <span class="badge badge-info">{{ ucfirst(auth()->user()->role) }}</span>
        </div>
    </div>
    <div style="display: flex; gap: 0.6rem;">
        <a href="{{ route('transaksi.create') }}" class="btn btn-primary">🛒 Buka Kasir Penjualan</a>
        @if(auth()->user()->isPemilik())
            <a href="{{ route('laporan.index') }}" class="btn btn-secondary">📊 Laporan Laba Rugi</a>
        @endif
    </div>
</div>

<!-- 4 Kartu Metrik Finansial Utama -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1.2rem; margin-bottom: 2rem;">
    <!-- Omset Hari Ini -->
    <div class="tabel-kartu" style="padding: 1.5rem; border-left: 4px solid #15803d;">
        <div style="color: #6b7280; font-size: 0.85rem; font-weight: 600; text-transform: uppercase;">Penghasilan Hari Ini</div>
        <div style="font-size: 1.5rem; font-weight: 700; color: #15803d; margin: 0.4rem 0;">
            Rp {{ number_format($omsetHariIni, 0, ',', '.') }}
        </div>
        <div style="font-size: 0.85rem; color: #4b5563;">
            {{ $transaksiHariIni }} transaksi penjualan berhasil
        </div>
    </div>

    <!-- Total Omset Keseluruhan -->
    <div class="tabel-kartu" style="padding: 1.5rem; border-left: 4px solid #2563eb;">
        <div style="color: #6b7280; font-size: 0.85rem; font-weight: 600; text-transform: uppercase;">Total Akumulasi Omset</div>
        <div style="font-size: 1.5rem; font-weight: 700; color: #1e40af; margin: 0.4rem 0;">
            Rp {{ number_format($totalOmset, 0, ',', '.') }}
        </div>
        <div style="font-size: 0.85rem; color: #4b5563;">
            Dari total {{ $totalTransaksi }} transaksi tercatat
        </div>
    </div>

    <!-- Modal Nilai Inventaris (Pengeluaran Barang) -->
    <div class="tabel-kartu" style="padding: 1.5rem; border-left: 4px solid #d97706;">
        <div style="color: #6b7280; font-size: 0.85rem; font-weight: 600; text-transform: uppercase;">Modal Inventaris Sembako</div>
        <div style="font-size: 1.5rem; font-weight: 700; color: #b45309; margin: 0.4rem 0;">
            Rp {{ number_format($totalModalInventaris, 0, ',', '.') }}
        </div>
        <div style="font-size: 0.85rem; color: #4b5563;">
            {{ $totalProduk }} jenis barang di {{ $totalKategori }} kategori
        </div>
    </div>

    <!-- Estimasi Keuntungan Bersih -->
    <div class="tabel-kartu" style="padding: 1.5rem; border-left: 4px solid #16a34a;">
        <div style="color: #6b7280; font-size: 0.85rem; font-weight: 600; text-transform: uppercase;">Estimasi Laba Kotor</div>
        <div style="font-size: 1.5rem; font-weight: 700; color: #15803d; margin: 0.4rem 0;">
            Rp {{ number_format($keuntunganKotor, 0, ',', '.') }}
        </div>
        <div style="font-size: 0.85rem; color: #4b5563;">
            Selisih harga jual terhadap modal pokok
        </div>
    </div>
</div>

<!-- Grid Peringatan Stok & Transaksi Terbaru -->
<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; align-items: start;">
    
    <!-- Peringatan Stok Menipis -->
    <div class="tabel-kartu" style="padding: 1.5rem;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
            <h3 style="color: #b91c1c; font-size: 1.1rem; display: flex; align-items: center; gap: 6px;">
                ⚠️ Peringatan Stok Menipis (&le; 5)
            </h3>
            <span class="badge badge-danger">{{ $stokMenipis->count() }} Produk</span>
        </div>

        @if($stokMenipis->count() > 0)
            <table style="width: 100%; border-collapse: collapse; font-size: 0.9rem;">
                <thead>
                    <tr style="border-bottom: 2px solid #fee2e2; background: #fff5f5;">
                        <th style="padding: 0.5rem; text-align: left;">Nama Produk</th>
                        <th style="padding: 0.5rem; text-align: left;">Kategori</th>
                        <th style="padding: 0.5rem; text-align: center;">Sisa Stok</th>
                        @if(auth()->user()->isPemilik())
                            <th style="padding: 0.5rem; text-align: center;">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach($stokMenipis as $item)
                        <tr style="border-bottom: 1px solid #f3f4f6;">
                            <td style="padding: 0.6rem 0.5rem;">
                                <strong>{{ $item->nama_produk }}</strong>
                                <div style="font-size: 0.75rem; color: #6b7280;">{{ $item->kode_produk }}</div>
                            </td>
                            <td style="padding: 0.6rem 0.5rem; color: #4b5563;">
                                {{ $item->kategori->nama_kategori ?? '-' }}
                            </td>
                            <td style="padding: 0.6rem 0.5rem; text-align: center;">
                                <span class="badge badge-danger">{{ $item->stok }} {{ $item->satuan }}</span>
                            </td>
                            @if(auth()->user()->isPemilik())
                                <td style="padding: 0.6rem 0.5rem; text-align: center;">
                                    <a href="{{ route('produk.edit', $item->id) }}" class="btn btn-warning btn-sm" style="font-size: 0.75rem; padding: 2px 6px;">Tambah Stok</a>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div style="text-align: center; padding: 2rem; color: #166534; background: #f0fdf4; border-radius: 6px;">
                ✓ Semua persediaan barang sembako dalam kondisi aman.
            </div>
        @endif
    </div>

    <!-- Transaksi Terakhir -->
    <div class="tabel-kartu" style="padding: 1.5rem;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
            <h3 style="color: var(--hijau-utama); font-size: 1.1rem;">
                🕒 5 Transaksi Terakhir
            </h3>
            <a href="{{ route('transaksi.index') }}" style="font-size: 0.85rem; color: var(--hijau-utama); text-decoration: none; font-weight: 600;">Lihat Semua &rarr;</a>
        </div>

        <table style="width: 100%; border-collapse: collapse; font-size: 0.9rem;">
            <thead>
                <tr style="border-bottom: 2px solid #e5e7eb; background: #f9fafb;">
                    <th style="padding: 0.5rem; text-align: left;">No. Faktur</th>
                    <th style="padding: 0.5rem; text-align: left;">Pembeli</th>
                    <th style="padding: 0.5rem; text-align: right;">Total</th>
                    <th style="padding: 0.5rem; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transaksiTerbaru as $trx)
                    <tr style="border-bottom: 1px solid #f3f4f6;">
                        <td style="padding: 0.6rem 0.5rem;">
                            <strong style="color: var(--hijau-utama);">{{ $trx->no_transaksi }}</strong>
                            <div style="font-size: 0.75rem; color: #6b7280;">{{ $trx->created_at->diffForHumans() }}</div>
                        </td>
                        <td style="padding: 0.6rem 0.5rem; color: #4b5563;">
                            {{ $trx->nama_pembeli ?: 'Umum' }}
                        </td>
                        <td style="padding: 0.6rem 0.5rem; text-align: right; font-weight: 600; color: #15803d;">
                            Rp {{ number_format($trx->total_harga, 0, ',', '.') }}
                        </td>
                        <td style="padding: 0.6rem 0.5rem; text-align: center;">
                            <a href="{{ route('transaksi.show', $trx->id) }}" class="btn btn-secondary btn-sm" style="font-size: 0.75rem; padding: 2px 6px;">Nota</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align: center; padding: 2rem; color: #9ca3af;">
                            Belum ada riwayat transaksi.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection

