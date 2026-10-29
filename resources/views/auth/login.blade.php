@extends('layouts.app')

@section('title', 'Login Pengguna — Toko Sembako Berkah')

@section('content')
<div style="max-width: 420px; margin: 3rem auto;">
    <div class="tabel-kartu" style="padding: 2.5rem; text-align: center;">
        <div style="font-size: 2.5rem; margin-bottom: 0.5rem;">🌾</div>
        <h2 style="color: var(--hijau-utama); margin-bottom: 0.3rem;">Masuk ke Sistem</h2>
        <p style="color: #6b7280; font-size: 0.9rem; margin-bottom: 1.5rem;">Sistem Manajemen Toko Sembako Berkah</p>

        <!-- Akun Demo Box -->
        <div style="background: #f0fdf4; border: 1px dashed #86efac; padding: 0.8rem; border-radius: 6px; font-size: 0.82rem; text-align: left; margin-bottom: 1.5rem; color: #166534;">
            <strong>Demo Akun Cepat:</strong><br>
            &bull; Pemilik: username: <code>pemilik</code> | pass: <code>password123</code><br>
            &bull; Kasir: username: <code>kasir</code> | pass: <code>password123</code>
        </div>

        <form action="{{ route('login.post') }}" method="POST" style="text-align: left;">
            @csrf

            <div style="margin-bottom: 1.2rem;">
                <label style="display: block; font-weight: 600; margin-bottom: 0.3rem; font-size: 0.9rem;">Username</label>
                <input type="text" name="username" value="{{ old('username') }}" class="input-teks" placeholder="Masukkan username..." required autofocus>
            </div>

            <div style="margin-bottom: 1.2rem;">
                <label style="display: block; font-weight: 600; margin-bottom: 0.3rem; font-size: 0.9rem;">Password</label>
                <input type="password" name="password" class="input-teks" placeholder="Masukkan password..." required>
            </div>

            <div style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center; font-size: 0.85rem;">
                <label style="display: flex; align-items: center; gap: 6px; cursor: pointer;">
                    <input type="checkbox" name="remember"> Ingat Saya
                </label>
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; padding: 0.75rem; font-size: 1rem;">
                Masuk Sekarang
            </button>
        </form>

        <div style="margin-top: 1.5rem; font-size: 0.9rem; color: #6b7280;">
            Belum punya akun? <a href="{{ route('register') }}" style="color: var(--hijau-utama); font-weight: 600; text-decoration: none;">Daftar di sini</a>
        </div>
    </div>
</div>
@endsection

