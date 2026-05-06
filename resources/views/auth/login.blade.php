<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk — Klinik Pratama Hanjawar Ad-Dawa</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --primary: #2d9d8f; --primary-dark: #23796e; --primary-light: #e8f5f3;
            --text-dark: #1a2e2b; --text-mid: #4a5e5a; --text-light: #8a9e9a;
            --border: #e0ebe9; --bg: #f4f7f6; --white: #fff;
            --danger: #e05252; --radius: 10px;
        }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg); min-height: 100vh;
            display: flex; align-items: center; justify-content: center; padding: 24px;
        }
        .login-card {
            background: var(--white); border-radius: 20px;
            border: 1px solid var(--border);
            box-shadow: 0 8px 40px rgba(0,0,0,0.08);
            padding: 40px; width: 100%; max-width: 460px;
        }
        .login-header { text-align: center; margin-bottom: 32px; }
        .login-logo {
            width: 88px; height: 88px;
            margin: 0 auto 14px;
            display: flex; align-items: center; justify-content: center;
        }
        .login-logo img {
            width: 100%; height: 100%;
            object-fit: contain;
        }
        .login-title {
            font-size: 18px; font-weight: 700; color: var(--text-dark);
            line-height: 1.3;
        }
        .login-title span {
            display: block;
            font-size: 13px; font-weight: 500;
            color: var(--primary); margin-top: 3px;
        }
        .login-desc { font-size: 13px; color: var(--text-light); margin-top: 8px; }

        .divider {
            border: none; border-top: 1px solid var(--border);
            margin: 20px 0;
        }

        .form-group { margin-bottom: 16px; }
        .form-label { display: block; font-size: 13px; font-weight: 500; color: var(--text-mid); margin-bottom: 6px; }
        .input-wrap { position: relative; }
        .input-icon {
            position: absolute; left: 12px; top: 50%; transform: translateY(-50%);
            color: var(--text-light); pointer-events: none;
        }
        .form-control {
            width: 100%; padding: 10px 14px 10px 38px;
            border: 1px solid var(--border); border-radius: var(--radius);
            font-size: 14px; font-family: inherit; color: var(--text-dark);
            outline: none; transition: border-color 0.15s, box-shadow 0.15s;
            background: var(--white);
        }
        .form-control:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(45,157,143,0.12); }
        .form-control::placeholder { color: var(--text-light); }

        .alert-err {
            background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5;
            border-radius: var(--radius); padding: 10px 14px;
            font-size: 13px; margin-bottom: 16px;
            display: flex; align-items: center; gap: 8px;
        }

        .btn-submit {
            width: 100%; padding: 13px;
            background: var(--primary); color: white;
            border: none; border-radius: var(--radius);
            font-size: 15px; font-weight: 700; font-family: inherit;
            cursor: pointer; margin-top: 8px; transition: background 0.15s;
            display: flex; align-items: center; justify-content: center; gap: 8px;
        }
        .btn-submit:hover { background: var(--primary-dark); }

        .akun-info {
            margin-top: 20px;
            background: var(--bg);
            border-radius: var(--radius);
            padding: 14px;
            border: 1px solid var(--border);
        }
        .akun-info-title {
            font-size: 11px; font-weight: 700;
            text-transform: uppercase; letter-spacing: 0.05em;
            color: var(--text-light); margin-bottom: 10px;
        }
        .akun-row {
            display: flex; justify-content: space-between; align-items: center;
            font-size: 12px; padding: 5px 0;
            border-bottom: 1px solid var(--border);
        }
        .akun-row:last-child { border-bottom: none; }
        .akun-peran {
            font-weight: 600; color: var(--text-dark);
            display: flex; align-items: center; gap: 6px;
        }
        .akun-user { color: var(--text-mid); font-family: monospace; font-size: 11px; }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-header">
            <div class="login-logo">
                <img src="{{ asset('logo.png') }}" alt="Logo Klinik Pratama Hanjawar Ad-Dawa">
            </div>
            <h1 class="login-title">
                Klinik Pratama Hanjawar
                <span>Ad-Dawa</span>
            </h1>
            <p class="login-desc">Silakan masuk dengan akun karyawan Anda</p>
        </div>

        <hr class="divider">

        @if($errors->has('login'))
            <div class="alert-err">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                {{ $errors->first('login') }}
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST">
            @csrf

            <div class="form-group">
                <label class="form-label">Username</label>
                <div class="input-wrap">
                    <span class="input-icon">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    </span>
                    <input type="text" name="username" class="form-control"
                        placeholder="Masukkan username"
                        value="{{ old('username') }}" required autofocus>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Password</label>
                <div class="input-wrap">
                    <span class="input-icon">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                    </span>
                    <input type="password" name="password" class="form-control"
                        placeholder="Masukkan password" required>
                </div>
            </div>

            <button type="submit" class="btn-submit">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 3h4a2 2 0 012 2v14a2 2 0 01-2 2h-4M10 17l5-5-5-5M15 12H3"/></svg>
                Masuk ke Aplikasi
            </button>
        </form>

        {{-- Info akun --}}
        <div class="akun-info">
            <div class="akun-info-title">🔑 Akun Default</div>
            <div class="akun-row">
                <span class="akun-peran">🗂️ Pendaftaran</span>
                <span class="akun-user">pendaftaran / pendaftaran123</span>
            </div>
            <div class="akun-row">
                <span class="akun-peran">🩺 Dokter</span>
                <span class="akun-user">dokter / dokter123</span>
            </div>
            <div class="akun-row">
                <span class="akun-peran">💳 Kasir</span>
                <span class="akun-user">kasir / kasir123</span>
            </div>
            <div class="akun-row">
                <span class="akun-peran">💊 Apoteker</span>
                <span class="akun-user">apoteker / apoteker123</span>
            </div>
        </div>
    </div>
</body>
</html>