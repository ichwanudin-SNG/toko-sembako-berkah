@extends('layouts.app')

@section('title', 'Riwayat Pesanan — Toko Sembako Berkah')

@section('content')
<div class="judul-halaman">
    <span>📜 Riwayat Pesanan Saya</span>
    <a href="{{ route('produk.index') }}" class="btn btn-primary">🛒 Belanja Lagi</a>
</div>

@if($pesanans->isEmpty())
    <div class="tabel-kartu" style="padding: 3rem; text-align: center;">
        <div style="font-size: 4rem; margin-bottom: 1rem;">📦</div>
        <h3 style="color: #6b7280; margin-bottom: 0.5rem;">Belum ada pesanan</h3>
        <p style="color: #9ca3af; margin-bottom: 1.5rem;">Mulai belanja dan pesan produk sembako pilihan Anda!</p>
        <a href="{{ route('produk.index') }}" class="btn btn-primary">🌾 Lihat Produk</a>
    </div>
@else
    @foreach($pesanans as $psn)
    <div class="tabel-kartu" style="margin-bottom: 1.2rem; overflow: hidden;">
        {{-- Header pesanan --}}
        <div style="padding: 1rem 1.5rem; background: #f9fafb; border-bottom: 1px solid #e5e7eb; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.5rem;">
            <div>
                <strong style="font-size: 1rem;">{{ $psn->no_pesanan }}</strong>
                <span style="font-size: 0.85rem; color: #6b7280; margin-left: 0.8rem;">{{ $psn->created_at->format('d M Y, H:i') }}</span>
            </div>
            <div style="display: flex; align-items: center; gap: 0.8rem;">
                <span class="badge {{ $psn->status_badge }}" style="font-size: 0.85rem; padding: 0.3rem 0.8rem;">
                    {{ $psn->status_label }}
                </span>
                <a href="{{ route('pesanan.show', $psn->id) }}" class="btn btn-secondary btn-sm">Detail</a>
                @if($psn->status === 'menunggu')
                <form action="{{ route('pesanan.batal', $psn->id) }}" method="POST" style="display:inline;">
                    @csrf @method('PATCH')
                    <button type="submit" class="btn btn-danger btn-sm"
                            onclick="return confirm('Batalkan pesanan {{ $psn->no_pesanan }}?')">Batalkan</button>
                </form>
                @endif
            </div>
        </div>

        {{-- Item produk --}}
        <div style="padding: 1rem 1.5rem;">
            @foreach($psn->details as $detail)
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.4rem 0; border-bottom: 1px solid #f3f4f6; font-size: 0.9rem;">
                <div style="display: flex; align-items: center; gap: 0.6rem;">
                    <img src="{{ $detail->produk->gambar_url }}" style="width: 36px; height: 36px; object-fit: contain; background: #f3f4f6; border-radius: 4px; padding: 3px;">
                    <span>{{ $detail->produk->nama_produk }}</span>
                </div>
                <span style="color: #6b7280;">{{ $detail->jumlah }} × Rp {{ number_format($detail->harga_saat_pesan, 0, ',', '.') }}</span>
                <strong>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</strong>
            </div>
            @endforeach

            <div style="text-align: right; margin-top: 0.8rem; font-weight: 700; font-size: 1.05rem; color: var(--hijau-utama);">
                Total: Rp {{ number_format($psn->total_harga, 0, ',', '.') }}
            </div>
            @if($psn->catatan)
            <div style="margin-top: 0.5rem; font-size: 0.85rem; color: #6b7280;">
                💬 Catatan: {{ $psn->catatan }}
            </div>
            @endif
        </div>
    </div>
    @endforeach
@endif
@endsection
