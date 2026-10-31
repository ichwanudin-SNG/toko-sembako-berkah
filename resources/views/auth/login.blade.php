<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk — Toko Sembako Berkah</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            margin: 0;
            color: #172033;
            font-family: 'Segoe UI', Arial, sans-serif;
        }

        .login-page {
            display: grid;
            min-height: 100vh;
            grid-template-columns: minmax(420px, 1fr) minmax(420px, 1fr);
        }

        .login-panel {
            display: flex;
            flex-direction: column;
            padding: 30px clamp(32px, 7vw, 100px);
        }

        .login-brand {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            color: #172033;
            font-size: 1.15rem;
            font-weight: 700;
            text-decoration: none;
        }

        .login-brand-mark {
            display: inline-grid;
            width: 36px;
            height: 36px;
            place-items: center;
            border-radius: 10px;
            background: #f0fdf4;
            font-size: 1.35rem;
        }

        .login-content {
            width: 100%;
            max-width: 410px;
            margin: auto;
            padding: 56px 0;
        }

        .login-eyebrow {
            margin: 0 0 10px;
            color: #64748b;
            font-size: 0.95rem;
        }

        .login-content h1 {
            margin: 0;
            color: #172033;
            font-size: clamp(1.8rem, 3vw, 2.2rem);
            letter-spacing: -0.04em;
        }

        .login-subtitle {
            margin: 10px 0 34px;
            color: #64748b;
            line-height: 1.6;
        }

        .login-alert {
            margin-bottom: 20px;
            padding: 12px 14px;
            border: 1px solid #fecaca;
            border-radius: 8px;
            background: #fef2f2;
            color: #991b1b;
            font-size: 0.9rem;
        }

        .login-alert ul {
            margin: 0;
            padding-left: 20px;
        }

        .login-field {
            margin-bottom: 20px;
        }

        .login-field label {
            display: block;
            margin-bottom: 8px;
            color: #253047;
            font-size: 0.92rem;
            font-weight: 600;
        }

        .login-field input {
            width: 100%;
            height: 52px;
            padding: 0 15px;
            border: 1px solid #d5d9e2;
            border-radius: 7px;
            background: #fff;
            color: #172033;
            font: inherit;
            outline: none;
            transition: border-color 0.15s, box-shadow 0.15s;
        }

        .login-field input:focus {
            border-color: #16803d;
            box-shadow: 0 0 0 3px rgba(22, 128, 61, 0.13);
        }

        .login-options {
            display: flex;
            align-items: center;
            margin: 2px 0 25px;
        }

        .login-remember {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #475569;
            font-size: 0.9rem;
            cursor: pointer;
        }

        .login-remember input {
            width: 16px;
            height: 16px;
            accent-color: #16803d;
        }

        .login-submit {
            width: 100%;
            min-height: 52px;
            border: 0;
            border-radius: 7px;
            background: #16803d;
            color: #fff;
            font: inherit;
            font-weight: 700;
            cursor: pointer;
            transition: background 0.15s, transform 0.15s;
        }

        .login-submit:hover {
            transform: translateY(-1px);
            background: #126b33;
        }

        .login-register {
            margin: 24px 0 0;
            color: #64748b;
            font-size: 0.9rem;
            text-align: center;
        }

        .login-register a {
            color: #16803d;
            font-weight: 600;
            text-decoration: none;
        }

        .login-register a:hover {
            text-decoration: underline;
        }

        .login-art {
            position: relative;
            display: grid;
            min-height: 100vh;
            overflow: hidden;
            place-items: center;
            padding: 48px;
            background: #a78bda;
        }

        .login-art::before,
        .login-art::after {
            position: absolute;
            width: 380px;
            height: 380px;
            border: 1px solid rgba(75, 48, 132, 0.18);
            border-radius: 50%;
            content: '';
        }

        .login-art::before {
            top: -150px;
            right: -80px;
        }

        .login-art::after {
            bottom: -200px;
            left: -100px;
            width: 500px;
            height: 500px;
        }

        .login-illustration {
            position: relative;
            z-index: 1;
            width: min(100%, 560px);
            height: auto;
        }

        .login-art-caption {
            position: absolute;
            z-index: 1;
            right: 24px;
            bottom: 24px;
            left: 24px;
            color: rgba(43, 30, 75, 0.78);
            font-size: 0.9rem;
            text-align: center;
        }

        @media (max-width: 800px) {
            .login-page {
                display: block;
            }

            .login-panel {
                min-height: 100vh;
                padding: 24px clamp(24px, 8vw, 72px);
            }

            .login-content {
                padding: 48px 0;
            }

            .login-art {
                display: none;
            }
        }

        @media (max-width: 420px) {
            .login-panel {
                padding-right: 22px;
                padding-left: 22px;
            }
        }
    </style>
</head>
<body>
    <main class="login-page">
        <section class="login-panel">
            <a class="login-brand" href="{{ route('home') }}">
                <span class="login-brand-mark" aria-hidden="true">🌾</span>
                <span>Toko Sembako Berkah</span>
            </a>

            <div class="login-content">
                <p class="login-eyebrow">Selamat datang kembali</p>
                <h1>Masuk ke Sistem</h1>
                <p class="login-subtitle">Masukkan username dan password untuk melanjutkan.</p>

                @if($errors->any())
                    <div class="login-alert" role="alert">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('login.post') }}" method="POST">
                    @csrf
                    <div class="login-field">
                        <label for="username">Username</label>
                        <input id="username" type="text" name="username" value="{{ old('username') }}" placeholder="Masukkan username" autocomplete="username" required autofocus>
                    </div>

                    <div class="login-field">
                        <label for="password">Password</label>
                        <input id="password" type="password" name="password" placeholder="Masukkan password" autocomplete="current-password" required>
                    </div>

                    <div class="login-options">
                        <label class="login-remember">
                            <input type="checkbox" name="remember" value="1">
                            Ingat Saya
                        </label>
                    </div>

                    <button class="login-submit" type="submit">Masuk Sekarang</button>
                </form>

                <p class="login-register">
                    Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a>
                </p>
            </div>
        </section>

        <aside class="login-art" aria-label="Ilustrasi belanja kebutuhan sehari-hari">
            <svg class="login-illustration" viewBox="0 0 560 520" role="img" aria-labelledby="illustration-title">
                <title id="illustration-title">Tas belanja berisi kebutuhan sembako segar</title>
                <circle cx="280" cy="260" r="205" fill="#c4b1e7" opacity=".55"/>
                <circle cx="280" cy="260" r="165" fill="#b69cde" opacity=".55"/>

                <g fill="none" stroke="#7659aa" stroke-linecap="round" stroke-width="3" opacity=".62">
                    <path d="M75 143h44m-22-22v44"/>
                    <path d="M443 123l24 24m0-24l-24 24"/>
                    <path d="M89 357c20-22 40 22 60 0s40 22 60 0"/>
                    <path d="M379 387c18-19 36 19 54 0s36 19 54 0"/>
                    <circle cx="438" cy="241" r="13"/>
                    <circle cx="113" cy="267" r="8"/>
                    <circle cx="414" cy="180" r="5"/>
                    <circle cx="163" cy="110" r="5"/>
                </g>

                <g transform="translate(137 100)">
                    <path d="M92 138c0-53 34-88 72-88s72 35 72 88" fill="none" stroke="#594080" stroke-linecap="round" stroke-width="16"/>
                    <path d="M60 143h208l-21 221H81z" fill="#fffdf8" stroke="#594080" stroke-linejoin="round" stroke-width="8"/>
                    <path d="M75 190h177l-12 131H87z" fill="#f3edff"/>
                    <path d="M118 140c-12-47 4-95 30-105 27-9 49 24 48 78l-8 29z" fill="#f7bd4b" stroke="#5b4385" stroke-width="6"/>
                    <path d="M151 145c-2-53 23-91 45-90 24 1 32 40 14 92l-22 4z" fill="#f28c58" stroke="#5b4385" stroke-width="6"/>
                    <path d="M189 143c10-42 38-66 57-57 18 9 10 43-17 73l-28 1z" fill="#77b77c" stroke="#5b4385" stroke-width="6"/>
                    <path d="M114 154c-19-28-43-35-55-23-12 13 3 37 34 48l27-4z" fill="#80bf7d" stroke="#5b4385" stroke-width="6"/>
                    <path d="M166 245h-3c-19 0-34 15-34 34v12h71v-12c0-19-15-34-34-34z" fill="#16803d"/>
                    <path d="M149 243c-5-16-2-31 6-37m27 37c5-16 2-31-6-37" fill="none" stroke="#16803d" stroke-linecap="round" stroke-width="8"/>
                    <path d="M122 322h83" stroke="#d7c7ee" stroke-linecap="round" stroke-width="5"/>
                </g>

                <g transform="translate(82 203)">
                    <circle cx="38" cy="38" r="35" fill="#fff" opacity=".94"/>
                    <path d="M22 38l11 11 22-24" fill="none" stroke="#694a9e" stroke-linecap="round" stroke-linejoin="round" stroke-width="6"/>
                </g>
                <g transform="translate(424 298)">
                    <circle cx="27" cy="27" r="25" fill="#fff" opacity=".9"/>
                    <path d="M27 13v15m0 9h.1" fill="none" stroke="#694a9e" stroke-linecap="round" stroke-width="5"/>
                </g>
            </svg>
            <p class="login-art-caption">Belanja kebutuhan harian dengan mudah dan nyaman.</p>
        </aside>
    </main>
</body>
</html>
