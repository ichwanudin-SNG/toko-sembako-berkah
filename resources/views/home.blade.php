<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#15803d">
    <title>Beranda — Toko Sembako Berkah</title>
    <style>
        :root {
            color-scheme: light;
            --green: #15803d;
            --green-dark: #166534;
            --green-soft: #eaf5ec;
            --ink: #202522;
            --muted: #64716a;
            --paper: #f7f8f5;
        }

        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;
            background: var(--paper);
            color: var(--ink);
            font-family: 'Segoe UI', Arial, sans-serif;
        }

        a {
            color: inherit;
        }

        .home-nav {
            position: relative;
            z-index: 2;
            background: var(--green);
            color: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, .1);
        }

        .home-nav-inner {
            display: flex;
            min-height: 104px;
            align-items: center;
            justify-content: space-between;
            gap: 32px;
            margin: 0;
            padding: 14px 4.6%;
        }

        .home-brand {
            display: inline-flex;
            flex-shrink: 0;
            align-items: center;
            gap: 10px;
            color: #fff;
            font-size: 1.4rem;
            font-weight: 750;
            text-decoration: none;
        }

        .home-brand-icon {
            display: inline-grid;
            width: 44px;
            height: 44px;
            place-items: center;
            font-size: 1.75rem;
        }

        .home-nav-links {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: clamp(16px, 2.1vw, 32px);
            white-space: nowrap;
        }

        .home-nav-links a {
            color: #fff;
            font-size: 1rem;
            font-weight: 550;
            text-decoration: none;
            transition: color .18s ease;
        }

        .home-nav-links a:hover,
        .home-nav-links a:focus-visible {
            color: #a7e4b7;
        }

        .home-nav-links .home-nav-cta {
            padding: 12px 19px;
            border-radius: 9px;
            background: #fff;
            color: var(--green-dark);
            font-weight: 650;
        }

        .home-nav-links .home-nav-cta:hover,
        .home-nav-links .home-nav-cta:focus-visible {
            background: #f0fdf4;
            color: var(--green-dark);
        }

        .home-nav-links form {
            margin: 0;
        }

        .home-nav-links .home-nav-logout {
            border: 0;
            cursor: pointer;
            font: inherit;
        }

        .home-cart-link {
            position: relative;
        }

        .home-cart-count {
            position: absolute;
            top: -9px;
            right: -12px;
            display: grid;
            width: 18px;
            height: 18px;
            place-items: center;
            border-radius: 50%;
            background: #ef4444;
            color: #fff;
            font-size: .68rem;
            font-weight: 700;
        }

        .home-hero {
            position: relative;
            isolation: isolate;
            display: flex;
            min-height: min(660px, calc(100vh - 104px));
            align-items: center;
            overflow: hidden;
            background:
                radial-gradient(ellipse at 82% 10%, rgba(196, 224, 192, .7), transparent 34%),
                linear-gradient(112deg, #f8faf5 0%, #f1f5ec 53%, #e1eddd 100%);
        }

        .home-hero::before {
            position: absolute;
            z-index: -1;
            top: -270px;
            left: -150px;
            width: 600px;
            height: 480px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .75);
            content: '';
        }

        .home-hero-inner {
            display: grid;
            width: 100%;
            max-width: 1240px;
            grid-template-columns: minmax(0, .92fr) minmax(400px, 1.08fr);
            align-items: center;
            gap: 38px;
            margin: 0 auto;
            padding: 60px 32px 68px;
        }

        .home-hero-copy {
            position: relative;
            z-index: 1;
            padding: 24px 0;
        }

        .home-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin: 0 0 20px;
            color: var(--green-dark);
            font-size: .83rem;
            font-weight: 750;
            letter-spacing: .12em;
            text-transform: uppercase;
        }

        .home-eyebrow::before {
            width: 24px;
            height: 2px;
            background: #79b886;
            content: '';
        }

        .home-hero h1 {
            max-width: 600px;
            margin: 0;
            color: #1c2921;
            font-size: clamp(2.7rem, 5.2vw, 4.65rem);
            font-weight: 780;
            letter-spacing: -.055em;
            line-height: 1.08;
        }

        .home-hero h1 span {
            color: var(--green);
        }

        .home-hero-description {
            max-width: 510px;
            margin: 22px 0 30px;
            color: #58665d;
            font-size: clamp(1rem, 1.45vw, 1.13rem);
            line-height: 1.75;
        }

        .home-hero-actions {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 13px;
        }

        .home-button {
            display: inline-flex;
            min-height: 48px;
            align-items: center;
            justify-content: center;
            gap: 9px;
            padding: 0 20px;
            border: 1px solid transparent;
            border-radius: 7px;
            font-size: .96rem;
            font-weight: 700;
            text-decoration: none;
            transition: transform .18s ease, background .18s ease, border-color .18s ease;
        }

        .home-button:hover {
            transform: translateY(-2px);
        }

        .home-button-primary {
            background: var(--green);
            color: #fff;
            box-shadow: 0 8px 18px rgba(22, 128, 61, .18);
        }

        .home-button-primary:hover {
            background: var(--green-dark);
        }

        .home-button-secondary {
            border-color: #cdd8cd;
            background: rgba(255, 255, 255, .68);
            color: #34443a;
        }

        .home-button-secondary:hover {
            border-color: #97b99d;
            background: #fff;
        }

        .home-hero-art {
            position: relative;
            width: 100%;
            max-width: 610px;
            justify-self: end;
        }

        .home-hero-art::before {
            position: absolute;
            inset: 9% 5% 7% 7%;
            border-radius: 48% 52% 43% 57% / 54% 40% 60% 46%;
            background: #d3e5d0;
            content: '';
            transform: rotate(-5deg);
        }

        .home-hero-art svg {
            position: relative;
            display: block;
            width: 100%;
            height: auto;
            filter: drop-shadow(0 22px 24px rgba(36, 74, 45, .13));
        }

        .home-art-label {
            position: absolute;
            right: 3%;
            bottom: 8%;
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 12px 16px;
            border: 1px solid rgba(226, 234, 224, .9);
            border-radius: 10px;
            background: rgba(255, 255, 255, .94);
            box-shadow: 0 10px 25px rgba(38, 63, 43, .12);
            color: #314238;
            font-size: .82rem;
            font-weight: 650;
        }

        .home-art-label-icon {
            display: grid;
            width: 34px;
            height: 34px;
            place-items: center;
            border-radius: 9px;
            background: var(--green-soft);
            color: var(--green);
            font-size: 1.05rem;
        }

        .home-benefits {
            display: grid;
            max-width: 1240px;
            grid-template-columns: repeat(3, 1fr);
            gap: 18px;
            margin: 0 auto;
            padding: 30px 32px 62px;
        }

        .home-benefit {
            display: flex;
            align-items: flex-start;
            gap: 14px;
            padding: 20px;
            border: 1px solid #e6ebe4;
            border-radius: 11px;
            background: #fff;
        }

        .home-benefit-icon {
            display: grid;
            width: 42px;
            height: 42px;
            flex: 0 0 42px;
            place-items: center;
            border-radius: 11px;
            background: var(--green-soft);
            font-size: 1.25rem;
        }

        .home-benefit h2 {
            margin: 1px 0 6px;
            color: #26372b;
            font-size: .98rem;
        }

        .home-benefit p {
            margin: 0;
            color: var(--muted);
            font-size: .88rem;
            line-height: 1.55;
        }

        .home-footer {
            padding: 22px 24px;
            background: #202522;
            color: #c9d1cb;
            font-size: .85rem;
            text-align: center;
        }

        @media (max-width: 900px) {
            .home-nav-inner {
                flex-wrap: wrap;
                gap: 14px;
                padding-right: 28px;
                padding-left: 28px;
            }

            .home-nav-links {
                flex-wrap: wrap;
                gap: 13px 20px;
            }

            .home-hero-inner {
                grid-template-columns: minmax(0, .95fr) minmax(300px, 1.05fr);
                gap: 18px;
            }
        }

        @media (max-width: 700px) {
            .home-nav-inner {
                align-items: flex-start;
                padding: 16px 21px;
            }

            .home-nav-links {
                width: 100%;
                justify-content: flex-start;
                gap: 12px 18px;
            }

            .home-hero {
                min-height: auto;
            }

            .home-hero-inner {
                grid-template-columns: 1fr;
                gap: 20px;
                padding: 50px 23px 42px;
            }

            .home-hero-copy {
                padding: 0;
            }

            .home-hero h1 {
                max-width: 540px;
                font-size: clamp(2.65rem, 11vw, 4rem);
            }

            .home-hero-art {
                width: min(100%, 470px);
                justify-self: center;
            }

            .home-benefits {
                grid-template-columns: 1fr;
                padding: 22px 23px 42px;
            }
        }

        @media (max-width: 420px) {
            .home-nav-links {
                gap: 12px 16px;
            }

            .home-nav-links a {
                font-size: .84rem;
            }

            .home-hero-actions {
                align-items: stretch;
                flex-direction: column;
            }

            .home-button {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <header class="home-nav">
        <nav class="home-nav-inner" aria-label="Navigasi utama">
            <a class="home-brand" href="{{ route('home') }}">
                <span class="home-brand-icon" aria-hidden="true">🌾</span>
                <span>Toko Sembako Berkah</span>
            </a>
            <div class="home-nav-links">
                <a href="{{ route('home') }}" aria-current="page">Beranda</a>
                <a href="{{ route('produk.index') }}">Produk</a>
                <a href="{{ route('kategori.index') }}">Kategori</a>
                @auth
                    @if(auth()->user()->isPelanggan())
                        <a class="home-cart-link" href="{{ route('pesanan.keranjang') }}">
                            🛒 Keranjang
                            @php $jmlKeranjang = count(session('keranjang', [])); @endphp
                            @if($jmlKeranjang > 0)
                                <span class="home-cart-count">{{ $jmlKeranjang }}</span>
                            @endif
                        </a>
                        <a href="{{ route('pesanan.riwayat') }}">📜 Pesanan</a>
                        <a href="{{ route('profile') }}">Profil</a>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button class="home-nav-cta home-nav-logout" type="submit">Keluar ({{ auth()->user()->role }})</button>
                        </form>
                    @else
                        <a href="#keunggulan">Keunggulan</a>
                        <a class="home-nav-cta" href="{{ route('dashboard') }}">Dashboard</a>
                    @endif
                @else
                    <a href="#keunggulan">Keunggulan</a>
                    <a href="{{ route('login') }}">Masuk</a>
                    <a class="home-nav-cta" href="{{ route('register') }}">Daftar</a>
                @endauth
            </div>
        </nav>
    </header>

    <main>
        <section class="home-hero">
            <div class="home-hero-inner">
                <div class="home-hero-copy">
                    <p class="home-eyebrow">Belanja lebih mudah</p>
                    <h1>Kebutuhan harian, <span>lebih dekat.</span></h1>
                    <p class="home-hero-description">
                        Temukan sembako pilihan dengan harga bersahabat. Belanja kebutuhan rumah
                        sehari-hari jadi praktis, cepat, dan nyaman bersama Toko Sembako Berkah.
                    </p>
                    <div class="home-hero-actions">
                        <a class="home-button home-button-primary" href="{{ route('produk.index') }}">
                            Jelajahi Produk <span aria-hidden="true">→</span>
                        </a>
                        @guest
                            <a class="home-button home-button-secondary" href="{{ route('login') }}">Masuk ke Akun</a>
                        @endguest
                    </div>
                </div>

                <div class="home-hero-art">
                    <svg viewBox="0 0 620 490" role="img" aria-labelledby="home-illustration-title">
                        <title id="home-illustration-title">Ilustrasi tas belanja berisi kebutuhan sembako segar</title>
                        <ellipse cx="314" cy="423" rx="195" ry="25" fill="#739873" opacity=".17"/>

                        <g fill="none" stroke="#8eb18d" stroke-linecap="round" stroke-width="3" opacity=".7">
                            <path d="M92 139h45m-22-22v44"/>
                            <path d="M474 105l23 23m0-23l-23 23"/>
                            <path d="M83 325c19-20 38 20 57 0s38 20 57 0"/>
                            <path d="M439 352c17-17 34 17 51 0s34 17 51 0"/>
                            <circle cx="480" cy="220" r="10"/>
                            <circle cx="144" cy="214" r="6"/>
                            <circle cx="406" cy="99" r="5"/>
                        </g>

                        <g transform="translate(130 48)">
                            <path d="M104 149c0-57 37-94 80-94s80 37 80 94" fill="none" stroke="#287443" stroke-linecap="round" stroke-width="17"/>
                            <path d="M64 150h242l-25 243H89z" fill="#fffdf8" stroke="#287443" stroke-linejoin="round" stroke-width="8"/>
                            <path d="M83 192h204l-17 159H100z" fill="#eff6ec"/>
                            <path d="M123 153c-13-50 5-100 33-110 30-10 55 25 54 83l-9 31z" fill="#f3bd55" stroke="#427d49" stroke-width="6"/>
                            <path d="M160 155c-2-56 24-98 49-97 27 1 36 44 20 98l-24 4z" fill="#e88960" stroke="#427d49" stroke-width="6"/>
                            <path d="M204 153c11-45 42-71 62-61 20 10 11 47-18 79l-31 1z" fill="#7bad65" stroke="#427d49" stroke-width="6"/>
                            <path d="M118 165c-21-30-47-38-61-24-13 14 4 41 38 53l30-4z" fill="#88b970" stroke="#427d49" stroke-width="6"/>
                            <path d="M176 246c-23 0-41 18-41 40v16h84v-16c0-22-19-40-43-40z" fill="#16803d"/>
                            <path d="M157 242c-6-18-3-35 7-42m31 42c6-18 3-35-7-42" fill="none" stroke="#16803d" stroke-linecap="round" stroke-width="9"/>
                            <path d="M133 328h100" stroke="#cddfca" stroke-linecap="round" stroke-width="6"/>
                            <path d="M132 350h82" stroke="#dce8d9" stroke-linecap="round" stroke-width="5"/>
                            <circle cx="117" cy="223" r="15" fill="#eece73"/>
                            <circle cx="253" cy="218" r="13" fill="#d95f4c"/>
                        </g>

                        <g transform="translate(75 200)">
                            <circle cx="38" cy="38" r="35" fill="#fff" opacity=".96"/>
                            <path d="M22 38l11 11 22-24" fill="none" stroke="#16803d" stroke-linecap="round" stroke-linejoin="round" stroke-width="6"/>
                        </g>
                        <g transform="translate(467 283)">
                            <circle cx="28" cy="28" r="26" fill="#fff" opacity=".94"/>
                            <path d="M28 14v16m0 9h.1" fill="none" stroke="#16803d" stroke-linecap="round" stroke-width="5"/>
                        </g>
                    </svg>
                    <div class="home-art-label">
                        <span class="home-art-label-icon" aria-hidden="true">✓</span>
                        <span>Belanja nyaman, harga bersahabat</span>
                    </div>
                </div>
            </div>
        </section>

        <section class="home-benefits" id="keunggulan" aria-label="Keunggulan toko">
            <article class="home-benefit">
                <span class="home-benefit-icon" aria-hidden="true">🛒</span>
                <div>
                    <h2>Belanja Praktis</h2>
                    <p>Pilih produk favorit dan pesan dari mana saja.</p>
                </div>
            </article>
            <article class="home-benefit">
                <span class="home-benefit-icon" aria-hidden="true">🌱</span>
                <div>
                    <h2>Produk Pilihan</h2>
                    <p>Kebutuhan sembako lengkap untuk rumah Anda.</p>
                </div>
            </article>
            <article class="home-benefit">
                <span class="home-benefit-icon" aria-hidden="true">🏷️</span>
                <div>
                    <h2>Harga Bersahabat</h2>
                    <p>Belanja harian lebih hemat dan nyaman.</p>
                </div>
            </article>
        </section>
    </main>

    <footer class="home-footer">
        &copy; {{ date('Y') }} Toko Sembako Berkah. Semua kebutuhan harian, lebih dekat.
    </footer>
</body>
</html>
