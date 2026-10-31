@extends('layouts.app')

@section('title', 'Detail Pesanan {{ $pesanan->no_pesanan }}')

@section('content')
<div class="judul-halaman">
    <span>📦 Detail Pesanan</span>
    <a href="{{ route('pesanan.riwayat') }}" class="btn btn-secondary">← Riwayat Pesanan</a>
</div>

<div style="display: grid; grid-template-columns: 1fr 300px; gap: 1.5rem; align-items: start;">
    <div>
        <div class="tabel-kartu" style="margin-bottom: 1.2rem;">
            <div style="padding: 1rem 1.5rem; background: #f9fafb; border-bottom: 1px solid #e5e7eb;">
                <h3 style="margin: 0; font-size: 1rem; color: #374151;">{{ $pesanan->no_pesanan }}</h3>
                <span style="font-size: 0.85rem; color: #6b7280;">{{ $pesanan->created_at->format('d F Y, H:i') }}</span>
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
                    @foreach($pesanan->details as $detail)
                    <tr>
                        <td>
                            <div style="display: flex; align-items: center; gap: 0.7rem;">
                                <img src="{{ $detail->produk->gambar_url }}" style="width: 40px; height: 40px; object-fit: contain; background: #f3f4f6; border-radius: 5px; padding: 3px;">
                                <strong>{{ $detail->produk->nama_produk }}</strong>
                            </div>
                        </td>
                        <td style="text-align:right;">Rp {{ number_format($detail->harga_saat_pesan, 0, ',', '.') }}</td>
                        <td style="text-align:center;">{{ $detail->jumlah }}</td>
                        <td style="text-align:right; font-weight:600; color:var(--hijau-utama);">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr style="background: #f0fdf4;">
                        <td colspan="3" style="text-align:right; font-weight:700; padding: 0.9rem 1.2rem;">Total</td>
                        <td style="text-align:right; font-weight:700; font-size:1.1rem; color:var(--hijau-utama); padding: 0.9rem 1.2rem;">
                            Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <div>
        <div class="tabel-kartu" style="padding: 1.5rem; margin-bottom: 1rem;">
            <h4 style="margin: 0 0 1rem 0; color: var(--hijau-utama);">📋 Status Pesanan</h4>
            <span class="badge {{ $pesanan->status_badge }}" style="font-size: 1rem; padding: 0.5rem 1rem;">
                {{ $pesanan->status_label }}
            </span>
            @if($pesanan->catatan)
            <div style="margin-top: 1rem; font-size: 0.9rem; color: #374151; background: #f9fafb; padding: 0.8rem; border-radius: 6px;">
                💬 <strong>Catatan:</strong><br>{{ $pesanan->catatan }}
            </div>
            @endif
        </div>

        <div class="tabel-kartu" style="padding: 1.5rem;">
            <h4 style="margin: 0 0 0.8rem 0; color: #374151;">👤 Info Pemesan</h4>
            <div style="font-size: 0.88rem; color: #374151; line-height: 1.8;">
                <div><strong>Nama:</strong> {{ $pesanan->user->name }}</div>
                <div><strong>Email:</strong> {{ $pesanan->user->email }}</div>
            </div>
        </div>

        @if($pesanan->status === 'menunggu' && auth()->id() === $pesanan->user_id)
        <form action="{{ route('pesanan.batal', $pesanan->id) }}" method="POST" style="margin-top: 1rem;">
            @csrf @method('PATCH')
            <button type="submit" class="btn btn-danger" style="width:100%; justify-content:center;"
                    onclick="return confirm('Batalkan pesanan ini?')">
                ❌ Batalkan Pesanan
            </button>
        </form>
        @endif
    </div>
</div>
@endsection
