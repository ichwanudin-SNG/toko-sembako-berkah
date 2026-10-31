@extends('layouts.app')

@section('title', 'Daftar Akun Baru — Toko Sembako Berkah')

@section('content')
<div style="max-width: 480px; margin: 2rem auto;">
    <div class="tabel-kartu" style="padding: 2.5rem; text-align: center;">
        <div style="font-size: 2.5rem; margin-bottom: 0.5rem;">🌾</div>
        <h2 style="color: var(--hijau-utama); margin-bottom: 0.3rem;">Daftar Akun Baru</h2>
        <p style="color: #6b7280; font-size: 0.9rem; margin-bottom: 1.5rem;">Daftar sebagai Pelanggan Toko Sembako Berkah</p>

        <form action="{{ route('register.post') }}" method="POST" style="text-align: left;">
            @csrf

            <div style="margin-bottom: 1rem;">
                <label style="display: block; font-weight: 600; margin-bottom: 0.3rem; font-size: 0.9rem;">Nama Lengkap *</label>
                <input type="text" name="name" value="{{ old('name') }}" class="input-teks" placeholder="Nama lengkap..." required>
            </div>

            <div style="margin-bottom: 1rem;">
                <label style="display: block; font-weight: 600; margin-bottom: 0.3rem; font-size: 0.9rem;">Username *</label>
                <input type="text" name="username" value="{{ old('username') }}" class="input-teks" placeholder="Username tanpa spasi..." required>
            </div>

            <div style="margin-bottom: 1rem;">
                <label style="display: block; font-weight: 600; margin-bottom: 0.3rem; font-size: 0.9rem;">Alamat Email *</label>
                <input type="email" name="email" value="{{ old('email') }}" class="input-teks" placeholder="email@contoh.com" required>
            </div>

            {{-- Role hidden: selalu pelanggan untuk registrasi publik --}}

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.8rem; margin-bottom: 1.5rem;">
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 0.3rem; font-size: 0.9rem;">Password *</label>
                    <input type="password" name="password" class="input-teks" placeholder="Minimal 6 digit" required>
                </div>
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 0.3rem; font-size: 0.9rem;">Konfirmasi *</label>
                    <input type="password" name="password_confirmation" class="input-teks" placeholder="Ulangi password" required>
                </div>
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; padding: 0.75rem; font-size: 1rem;">
                Daftar Akun
            </button>
        </form>

        <div style="margin-top: 1.5rem; font-size: 0.9rem; color: #6b7280;">
            Sudah punya akun? <a href="{{ route('login') }}" style="color: var(--hijau-utama); font-weight: 600; text-decoration: none;">Masuk di sini</a>
        </div>
    </div>
</div>
@endsection

