@php
    $isAuthed = auth()->check();
    $primaryUrl = $isAuthed ? route('dashboard') : route('login');
    $primaryLabel = $isAuthed ? 'Ke Dashboard' : 'Ke Halaman Masuk';
    $secondaryUrl = $isAuthed ? route('search') : route('register');
    $secondaryLabel = $isAuthed ? 'Cari Sesuatu' : 'Daftar Akun';
@endphp
<!DOCTYPE html>
<html class="dark" lang="id">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>404 | My Finance</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}" />
    <link rel="shortcut icon" href="{{ asset('favicon.png') }}" />
    <link rel="apple-touch-icon" href="{{ asset('favicon.png') }}" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <style>
        :root {
            --bg: #131313;
            --surface: rgba(53, 53, 52, 0.42);
            --surface-2: rgba(19, 19, 19, 0.86);
            --stroke: rgba(255, 255, 255, 0.08);
            --text: #e5e2e1;
            --muted: rgba(193, 198, 215, 0.75);
            --primary: #adc6ff;
            --primary-2: #4b8eff;
            --danger: #ff516a;
            --shadow: rgba(0, 0, 0, 0.65);
        }

        * { box-sizing: border-box; }
        html, body { height: 100%; }
        body {
            margin: 0;
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
            background: var(--bg);
            color: var(--text);
        }

        .ms {
            font-variation-settings: 'FILL' 0, 'wght' 520, 'GRAD' 0, 'opsz' 24;
        }

        .wrap {
            min-height: 100%;
            display: grid;
            place-items: center;
            padding: 28px 16px;
            position: relative;
            overflow: hidden;
        }

        .bg {
            position: absolute;
            inset: 0;
            background:
                radial-gradient(circle at top left, rgba(173, 198, 255, 0.20), transparent 42%),
                radial-gradient(circle at bottom right, rgba(78, 222, 163, 0.14), transparent 40%),
                linear-gradient(160deg, #0d1320 0%, #101827 44%, #0a0f19 100%);
            filter: saturate(0.95);
            opacity: 0.95;
        }

        .grid {
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);
            background-size: 44px 44px;
            opacity: 0.22;
        }

        .orb {
            position: absolute;
            width: 420px;
            height: 420px;
            border-radius: 999px;
            filter: blur(90px);
            opacity: 0.55;
        }

        .orb.one { top: -120px; left: -140px; background: rgba(173, 198, 255, 0.28); }
        .orb.two { bottom: -140px; right: -150px; background: rgba(255, 81, 106, 0.22); }

        .card {
            position: relative;
            width: min(760px, 100%);
            border: 1px solid var(--stroke);
            border-radius: 24px;
            background: var(--surface);
            backdrop-filter: blur(20px);
            box-shadow: 0 26px 70px var(--shadow);
            overflow: hidden;
        }

        .card-inner {
            display: grid;
            grid-template-columns: 1.1fr 0.9fr;
            gap: 0;
        }

        .left {
            padding: 28px 28px 22px;
        }

        .right {
            padding: 28px;
            background: linear-gradient(180deg, rgba(19, 19, 19, 0.65) 0%, rgba(19, 19, 19, 0.92) 100%);
            border-left: 1px solid rgba(255,255,255,0.06);
        }

        .brand {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 14px;
            border: 1px solid rgba(255,255,255,0.08);
            background: rgba(255,255,255,0.04);
        }

        .brand-badge {
            width: 38px;
            height: 38px;
            border-radius: 14px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-2) 100%);
            color: #07111f;
            display: grid;
            place-items: center;
            font-weight: 900;
        }

        .kicker {
            margin: 16px 0 8px;
            font-size: 11px;
            letter-spacing: 0.16em;
            text-transform: uppercase;
            color: rgba(173, 198, 255, 0.72);
        }

        h1 {
            margin: 0;
            font-size: clamp(28px, 4.6vw, 40px);
            line-height: 1.08;
            letter-spacing: -0.03em;
        }

        .lead {
            margin: 10px 0 0;
            color: var(--muted);
            line-height: 1.6;
            max-width: 44ch;
        }

        .code {
            margin-top: 16px;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 16px;
            border: 1px solid rgba(255,255,255,0.08);
            background: rgba(0,0,0,0.22);
            color: rgba(229,226,225,0.92);
            font-weight: 800;
        }

        .code small {
            font-weight: 700;
            color: rgba(193,198,215,0.70);
        }

        .btns {
            margin-top: 18px;
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .btn {
            appearance: none;
            border: 0;
            border-radius: 16px;
            padding: 12px 14px;
            font-weight: 800;
            letter-spacing: 0.01em;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: transform 140ms ease, opacity 140ms ease, background-color 140ms ease, border-color 140ms ease;
            user-select: none;
        }

        .btn:active { transform: translateY(1px); }
        .btn:hover { opacity: 0.92; }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-2) 100%);
            color: #07111f;
        }

        .btn-ghost {
            background: rgba(255,255,255,0.04);
            color: rgba(229,226,225,0.95);
            border: 1px solid rgba(255,255,255,0.10);
        }

        .help {
            display: grid;
            gap: 10px;
        }

        .help h2 {
            margin: 0;
            font-size: 14px;
            letter-spacing: 0.02em;
            color: rgba(229,226,225,0.9);
        }

        .help ul {
            margin: 0;
            padding-left: 18px;
            color: rgba(193,198,215,0.70);
            line-height: 1.65;
            font-size: 13px;
        }

        .links {
            margin-top: 14px;
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .link {
            font-size: 12px;
            color: rgba(173,198,255,0.84);
            text-decoration: none;
            border-bottom: 1px solid rgba(173,198,255,0.22);
            padding-bottom: 2px;
        }

        .link:hover {
            border-bottom-color: rgba(173,198,255,0.55);
        }

        @media (max-width: 860px) {
            .card-inner { grid-template-columns: 1fr; }
            .right { border-left: 0; border-top: 1px solid rgba(255,255,255,0.06); }
            .lead { max-width: none; }
        }
    </style>
</head>
<body>
    <div class="wrap">
        <div class="bg" aria-hidden="true"></div>
        <div class="grid" aria-hidden="true"></div>
        <div class="orb one" aria-hidden="true"></div>
        <div class="orb two" aria-hidden="true"></div>

        <section class="card" aria-label="Halaman tidak ditemukan">
            <div class="card-inner">
                <div class="left">
                    <div class="brand">
                        <div class="brand-badge">
                            <span class="material-symbols-outlined ms" style="font-variation-settings:'FILL' 1">account_balance_wallet</span>
                        </div>
                        <div>
                            <div style="font-weight: 900; letter-spacing: -0.02em;">My Finance</div>
                            <div style="font-size: 12px; color: rgba(193,198,215,0.70); margin-top: 2px;">
                                Halaman tidak ditemukan
                            </div>
                        </div>
                    </div>

                    <div class="kicker">Error 404</div>
                    <h1>Alamat yang Anda buka tidak tersedia.</h1>
                    <p class="lead">
                        Kemungkinan tautan sudah berubah, halaman sudah dipindahkan, atau alamatnya salah ketik.
                    </p>

                    <div class="code">
                        <span class="material-symbols-outlined ms" aria-hidden="true" style="color: rgba(255, 81, 106, 0.9);">link_off</span>
                        <div>
                            <div>404 <small>Not Found</small></div>
                        </div>
                    </div>

                    <div class="btns">
                        <a class="btn btn-primary" href="{{ $primaryUrl }}">
                            <span class="material-symbols-outlined ms" aria-hidden="true">home</span>
                            {{ $primaryLabel }}
                        </a>
                        <button class="btn btn-ghost" type="button" onclick="history.length > 1 ? history.back() : (window.location = '{{ $primaryUrl }}')">
                            <span class="material-symbols-outlined ms" aria-hidden="true">arrow_back</span>
                            Kembali
                        </button>
                        <a class="btn btn-ghost" href="{{ $secondaryUrl }}">
                            <span class="material-symbols-outlined ms" aria-hidden="true">search</span>
                            {{ $secondaryLabel }}
                        </a>
                    </div>
                </div>

                <aside class="right">
                    <div class="help">
                        <h2>Yang bisa Anda lakukan</h2>
                        <ul>
                            <li>Periksa kembali URL (mis. huruf besar/kecil).</li>
                            <li>Jika Anda mencari data, coba gunakan fitur pencarian.</li>
                            <li>Gunakan tautan bantuan, privasi, atau keamanan untuk informasi lebih lanjut.</li>
                        </ul>
                    </div>
                    <div class="links">
                        <a class="link" href="{{ route('help') }}">Bantuan</a>
                        <a class="link" href="{{ route('privacy') }}">Privasi</a>
                        <a class="link" href="{{ route('security') }}">Keamanan</a>
                    </div>
                </aside>
            </div>
        </section>
    </div>
</body>
</html>

