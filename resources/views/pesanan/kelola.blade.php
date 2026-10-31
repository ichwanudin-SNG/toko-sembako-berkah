@extends('layouts.app')

@section('title', 'Kelola Pesanan Pelanggan — Toko Sembako Berkah')

@section('content')
<div class="judul-halaman">
    <span>📦 Kelola Pesanan Pelanggan</span>
    <span style="font-size: 1rem; font-weight: 400; color: #6b7280;">Total: {{ $pesanans->count() }} pesanan</span>
</div>

@if($pesanans->isEmpty())
    <div class="tabel-kartu" style="padding: 2.5rem; text-align: center; color: #6b7280;">
        Belum ada pesanan dari pelanggan.
    </div>
@else
    @foreach($pesanans as $psn)
    <div class="tabel-kartu" style="margin-bottom: 1rem; overflow: hidden;">
        <div style="padding: 0.9rem 1.5rem; background: #f9fafb; border-bottom: 1px solid #e5e7eb; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.5rem;">
            <div>
                <strong>{{ $psn->no_pesanan }}</strong>
                <span style="font-size: 0.85rem; color: #6b7280; margin-left: 0.8rem;">{{ $psn->created_at->format('d M Y, H:i') }}</span>
                <span style="font-size: 0.85rem; color: #374151; margin-left: 0.8rem;">— 👤 {{ $psn->user->name }}</span>
            </div>
            <div style="display: flex; align-items: center; gap: 0.8rem;">
                <span class="badge {{ $psn->status_badge }}">{{ $psn->status_label }}</span>
                {{-- Update status --}}
                <form action="{{ route('pesanan.update-status', $psn->id) }}" method="POST" style="display: flex; gap: 0.4rem;">
                    @csrf @method('PATCH')
                    <select name="status" class="input-teks" style="padding: 0.3rem 0.6rem; font-size: 0.85rem; width: auto;">
                        <option value="menunggu"   {{ $psn->status === 'menunggu'   ? 'selected' : '' }}>⏳ Menunggu</option>
                        <option value="diproses"   {{ $psn->status === 'diproses'   ? 'selected' : '' }}>🔄 Diproses</option>
                        <option value="selesai"    {{ $psn->status === 'selesai'    ? 'selected' : '' }}>✅ Selesai</option>
                        <option value="dibatalkan" {{ $psn->status === 'dibatalkan' ? 'selected' : '' }}>❌ Dibatalkan</option>
                    </select>
                    <button type="submit" class="btn btn-primary btn-sm">Update</button>
                </form>
            </div>
        </div>
        <div style="padding: 0.8rem 1.5rem;">
            @foreach($psn->details as $det)
            <div style="display: flex; justify-content: space-between; font-size: 0.88rem; padding: 0.3rem 0; border-bottom: 1px solid #f3f4f6;">
                <span>{{ $det->produk->nama_produk ?? '-' }}</span>
                <span style="color:#6b7280;">{{ $det->jumlah }} × Rp {{ number_format($det->harga_saat_pesan, 0, ',', '.') }}</span>
                <strong>Rp {{ number_format($det->subtotal, 0, ',', '.') }}</strong>
            </div>
            @endforeach
            <div style="text-align:right; margin-top:0.6rem; font-weight:700; color:var(--hijau-utama);">
                Total: Rp {{ number_format($psn->total_harga, 0, ',', '.') }}
            </div>
            @if($psn->catatan)
            <div style="font-size:0.82rem; color:#6b7280; margin-top:0.3rem;">💬 {{ $psn->catatan }}</div>
            @endif
        </div>
    </div>
    @endforeach
@endif
@endsection
