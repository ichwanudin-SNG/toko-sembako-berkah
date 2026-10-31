<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Toko Sembako Berkah') — Sistem Manajemen Sembako</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        /* Desain Tambahan Sesuai Screenshot Toko Sembako Berkah */
        :root {
            --hijau-utama: #15803d;
            --hijau-gelap: #166534;
            --hijau-muda: #22c55e;
            --hijau-aksen: #bbf7d0;
            --latar: #f9fafb;
            --kartu: #ffffff;
            --teks: #1f2937;
            --abu-border: #e5e7eb;
            --merah: #dc2626;
            --kuning: #d97706;
            --biru: #2563eb;
        }

        body {
            background-color: var(--latar);
            color: var(--teks);
            font-family: 'Segoe UI', Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Navbar Sesuai Screenshot */
        nav.nav-berkah {
            background-color: var(--hijau-utama);
            padding: 1rem 0;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .nav-wrap {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1.5rem;
        }

        .logo-berkah {
            font-size: 1.4rem;
            font-weight: 700;
            color: #ffffff;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .menu-berkah {
            display: flex;
            align-items: center;
            gap: 1.2rem;
            flex-wrap: wrap;
        }

        .menu-berkah a {
            color: #ffffff;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.95rem;
            transition: color 0.2s;
        }

        .menu-berkah a:hover, .menu-berkah a.active {
            color: var(--hijau-aksen);
            font-weight: 600;
        }

        .btn-masuk {
            background-color: #ffffff;
            color: var(--hijau-utama) !important;
            padding: 0.45rem 1.2rem;
            border-radius: 6px;
            font-weight: 600 !important;
            transition: all 0.2s;
        }

        .btn-masuk:hover {
            background-color: #f0fdf4;
            transform: translateY(-1px);
        }

        .main-container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1.5rem;
            flex: 1;
            width: 100%;
            box-sizing: border-box;
        }

        /* Judul Section dengan Garis Hijau di Bawah (Persis Screenshot) */
        .judul-halaman {
            font-size: 1.7rem;
            font-weight: 700;
            color: var(--hijau-utama);
            margin-bottom: 1.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #86efac;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        /* Alert Notifikasi */
        .alert {
            padding: 1rem 1.2rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            font-size: 0.95rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .alert-success {
            background-color: #dcfce7;
            color: #166534;
            border: 1px solid #86efac;
        }
        .alert-danger {
            background-color: #fee2e2;
            color: #991b1b;
            border: 1px solid #fca5a5;
        }

        /* Kartu & Tabel Styling Sesuai Screenshot */
        .tabel-kartu {
            background-color: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.06);
            border: 1px solid var(--abu-border);
        }

        table.tabel-berkah {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        table.tabel-berkah thead th {
            background-color: var(--hijau-utama);
            color: #ffffff;
            padding: 1rem 1.2rem;
            font-weight: 600;
            font-size: 0.95rem;
        }

        table.tabel-berkah tbody td {
            padding: 0.9rem 1.2rem;
            border-bottom: 1px solid var(--abu-border);
            font-size: 0.95rem;
            vertical-align: middle;
        }

        table.tabel-berkah tbody tr:hover {
            background-color: #f9fafb;
        }

        /* Form & Filter Bar */
        .bar-aksi {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
        }

        .kotak-cari {
            flex: 1;
            min-width: 250px;
            display: flex;
            gap: 0.5rem;
        }

        .input-teks {
            width: 100%;
            padding: 0.65rem 1rem;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 0.95rem;
            outline: none;
            transition: border-color 0.2s;
        }

        .input-teks:focus {
            border-color: var(--hijau-utama);
            box-shadow: 0 0 0 3px rgba(21, 128, 61, 0.15);
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 0.65rem 1.2rem;
            font-size: 0.95rem;
            font-weight: 600;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s;
        }

        .btn-primary {
            background-color: var(--hijau-utama);
            color: #ffffff;
        }
        .btn-primary:hover {
            background-color: var(--hijau-gelap);
        }

        .btn-secondary {
            background-color: #4b5563;
            color: #ffffff;
        }

        .btn-danger {
            background-color: var(--merah);
            color: #ffffff;
        }

        .btn-warning {
            background-color: var(--kuning);
            color: #ffffff;
        }

        .btn-sm {
            padding: 0.35rem 0.75rem;
            font-size: 0.85rem;
        }

        .badge {
            display: inline-block;
            padding: 0.25rem 0.6rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        .badge-success { background: #dcfce7; color: #166534; }
        .badge-warning { background: #fef3c7; color: #92400e; }
        .badge-danger { background: #fee2e2; color: #991b1b; }
        .badge-info { background: #e0f2fe; color: #075985; }

        /* Footer */
        footer.footer-berkah {
            background-color: #1e293b;
            color: #94a3b8;
            padding: 1.5rem 0;
            text-align: center;
            font-size: 0.9rem;
            margin-top: auto;
        }

        footer.footer-berkah a {
            color: #38bdf8;
            text-decoration: none;
        }
    </style>
    @stack('styles')
</head>
<body>

    <!-- Header Navigation Persis Desain Toko Sembako Berkah -->
    <nav class="nav-berkah">
        <div class="nav-wrap">
            <a href="{{ route('home') }}" class="logo-berkah">
                🌾 Toko Sembako Berkah
            </a>
            <div class="menu-berkah">
                @auth
                    @if(!auth()->user()->isPelanggan())
                        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>
                    @else
                        <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a>
                    @endif
                @else
                    <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a>
                @endauth

                <a href="{{ route('produk.index') }}" class="{{ request()->routeIs('produk.*') ? 'active' : '' }}">Produk</a>
                <a href="{{ route('kategori.index') }}" class="{{ request()->routeIs('kategori.*') ? 'active' : '' }}">Kategori</a>
                
                @auth
                    @if(!auth()->user()->isPelanggan())
                        <a href="{{ route('transaksi.index') }}" class="{{ request()->routeIs('transaksi.*') ? 'active' : '' }}">Transaksi</a>
                    @endif
                    
                    @if(auth()->user()->isPemilik())
                        <a href="{{ route('laporan.index') }}" class="{{ request()->routeIs('laporan.*') ? 'active' : '' }}">Laporan</a>
                    @endif

                    <a href="{{ route('profile') }}" class="{{ request()->routeIs('profile') ? 'active' : '' }}">Profil</a>

                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn-masuk" style="border: none; cursor: pointer;">Keluar ({{ auth()->user()->role }})</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn-masuk">Masuk</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Main Content Container -->
    <main class="main-container">
        @if(session('success'))
            <div class="alert alert-success">
                <span>✓ {{ session('success') }}</span>
                <span style="cursor: pointer;" onclick="this.parentElement.remove();">&times;</span>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                <span>⚠️ {{ session('error') }}</span>
                <span style="cursor: pointer;" onclick="this.parentElement.remove();">&times;</span>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul style="margin: 0; padding-left: 1.2rem;">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="footer-berkah">
        <div class="container">
            <p>&copy; {{ date('Y') }} Toko Sembako Berkah — Aplikasi Web Manajemen Full-Stack Laravel (Tugas UAS Cakrawala)</p>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>

