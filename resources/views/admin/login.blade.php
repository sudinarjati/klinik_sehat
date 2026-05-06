<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Manajemen — Klinik Pratama Hanjawar</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --primary: #1e40af; --primary-dark: #1e3a8a; --primary-light: #eff6ff;
            --text-dark: #1e293b; --text-mid: #475569; --text-light: #94a3b8;
            --border: #e2e8f0; --bg: #f8fafc; --white: #fff; --danger: #ef4444;
            --radius: 10px;
        }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 50%, #2563eb 100%);
            min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 24px;
        }
        .login-wrap {
            display: grid; grid-template-columns: 1fr 420px; gap: 0;
            background: var(--white); border-radius: 24px;
            box-shadow: 0 25px 60px rgba(0,0,0,0.25);
            overflow: hidden; width: 100%; max-width: 820px;
        }
        .login-left {
            background: linear-gradient(135deg, #1e3a8a, #2563eb);
            padding: 48px 40px; display: flex; flex-direction: column;
            justify-content: center; color: white;
        }
        .login-left-logo {
            width: 72px; height: 72px; margin-bottom: 24px;
            object-fit: contain;
        }
        .login-left h1 { font-size: 24px; font-weight: 700; line-height: 1.3; margin-bottom: 12px; }
        .login-left p { font-size: 14px; opacity: 0.75; line-height: 1.6; }
        .login-left-divider { height: 1px; background: rgba(255,255,255,0.2); margin: 24px 0; }
        .login-left-info { font-size: 12px; opacity: 0.6; }
        .login-left-info div { display: flex; align-items: center; gap: 8px; margin-bottom: 8px; }

        .login-right { padding: 48px 40px; }
        .login-right h2 { font-size: 20px; font-weight: 700; color: var(--text-dark); margin-bottom: 4px; }
        .login-right p { font-size: 13px; color: var(--text-light); margin-bottom: 28px; }

        .form-group { margin-bottom: 16px; }
        .form-label { display: block; font-size: 13px; font-weight: 500; color: var(--text-mid); margin-bottom: 6px; }
        .input-wrap { position: relative; }
        .input-icon { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--text-light); }
        .form-control {
            width: 100%; padding: 11px 14px 11px 38px;
            border: 1px solid var(--border); border-radius: var(--radius);
            font-size: 14px; font-family: inherit; color: var(--text-dark);
            outline: none; transition: all 0.15s; background: var(--bg);
        }
        .form-control:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(37,99,235,0.1); background: white; }
        .form-control::placeholder { color: var(--text-light); }

        .alert-err {
            background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5;
            border-radius: var(--radius); padding: 10px 14px;
            font-size: 13px; margin-bottom: 16px; display: flex; align-items: center; gap: 8px;
        }
        .btn-submit {
            width: 100%; padding: 13px; background: var(--primary); color: white;
            border: none; border-radius: var(--radius);
            font-size: 15px; font-weight: 700; font-family: inherit;
            cursor: pointer; transition: background 0.15s;
            display: flex; align-items: center; justify-content: center; gap: 8px;
        }
        .btn-submit:hover { background: var(--primary-dark); }
        .back-to-klinik {
            display: block; text-align: center; margin-top: 20px;
            font-size: 13px; color: var(--text-light); text-decoration: none;
            transition: color 0.15s;
        }
        .back-to-klinik:hover { color: var(--primary); }
    </style>
</head>
<body>
    <div class="login-wrap">
        <div class="login-left">
            <img src="{{ asset('logo.png') }}" alt="Logo" class="login-left-logo">
            <h1>Panel Manajemen<br>Klinik Pratama Hanjawar</h1>
            <p>Kelola data obat, alkes, tindakan medis, dan pemeriksaan laboratorium klinik.</p>
            <div class="login-left-divider"></div>
            <div class="login-left-info">
                <div>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    Akses terbatas hanya untuk manajer klinik
                </div>
                <div>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                    Login terpisah dari akun karyawan
                </div>
            </div>
        </div>

        <div class="login-right">
            <h2>Masuk Panel Manajemen</h2>
            <p>Gunakan akun manajer untuk mengakses halaman ini.</p>

            @if($errors->has('login'))
                <div class="alert-err">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    {{ $errors->first('login') }}
                </div>
            @endif

            <form action="{{ route('admin.login.post') }}" method="POST">
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
                    Masuk ke Panel
                </button>
            </form>

            <a href="{{ route('login') }}" class="back-to-klinik">
                ← Kembali ke Login Karyawan
            </a>
        </div>
    </div>
</body>
</html>