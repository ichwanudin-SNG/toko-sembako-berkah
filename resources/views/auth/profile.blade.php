@extends('layouts.app')

@section('title', 'Profil Pengguna — Toko Sembako Berkah')

@section('content')
<div class="judul-halaman">
    <span>Profil Pengguna</span>
</div>

<div class="tabel-kartu" style="max-width: 550px; margin: 0 auto; padding: 2rem;">
    @auth
        <div style="text-align: center; margin-bottom: 1.5rem;">
            <div style="width: 80px; height: 80px; border-radius: 50%; background: #dcfce7; color: #15803d; font-size: 2.2rem; display: flex; align-items: center; justify-content: center; margin: 0 auto 0.8rem auto; font-weight: 700;">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <h2 style="color: var(--hijau-utama); margin-bottom: 0.2rem;">{{ auth()->user()->name }}</h2>
            <span class="badge badge-info" style="font-size: 0.9rem;">Peran: {{ ucfirst(auth()->user()->role) }}</span>
        </div>

        <div style="border-top: 1px solid #e5e7eb; padding-top: 1rem; font-size: 0.95rem;">
            <div style="display: flex; justify-content: space-between; padding: 0.6rem 0; border-bottom: 1px solid #f3f4f6;">
                <span style="color: #6b7280;">Username</span>
                <strong>{{ auth()->user()->username }}</strong>
            </div>
            <div style="display: flex; justify-content: space-between; padding: 0.6rem 0; border-bottom: 1px solid #f3f4f6;">
                <span style="color: #6b7280;">Email</span>
                <strong>{{ auth()->user()->email }}</strong>
            </div>
            <div style="display: flex; justify-content: space-between; padding: 0.6rem 0; border-bottom: 1px solid #f3f4f6;">
                <span style="color: #6b7280;">Terdaftar Sejak</span>
                <span>{{ auth()->user()->created_at->format('d F Y, H:i') }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; padding: 0.6rem 0;">
                <span style="color: #6b7280;">Hak Akses</span>
                <span style="color: #15803d; font-weight: 600;">
                    {{ auth()->user()->isPemilik() ? 'Akses Penuh (Admin/Pemilik Toko)' : 'Akses Operasional Kasir & Penjualan' }}
                </span>
            </div>
        </div>

        <div style="margin-top: 1.5rem; text-align: center;">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger" style="width: 100%; justify-content: center;">
                    Keluar dari Akun (Logout)
                </button>
            </form>
        </div>
    @else
        <div style="text-align: center; padding: 2rem;">
            <p style="color: #6b7280; margin-bottom: 1.2rem;">Anda belum masuk ke sistem.</p>
            <a href="{{ route('login') }}" class="btn btn-primary">Masuk ke Akun</a>
        </div>
    @endauth
</div>
@endsection

