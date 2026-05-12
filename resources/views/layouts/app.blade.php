<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Klinik Hanjawar')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --primary: #2d9d8f;
            --primary-dark: #23796e;
            --primary-light: #e8f5f3;
            --primary-muted: #b2ddd8;
            --text-dark: #1a2e2b;
            --text-mid: #4a5e5a;
            --text-light: #8a9e9a;
            --border: #e0ebe9;
            --bg: #f4f7f6;
            --white: #ffffff;
            --danger: #e05252;
            --warning: #e8a830;
            --success: #2d9d6b;
            --info: #3b82a0;
            --radius: 10px;
            --radius-lg: 16px;
            --shadow: 0 1px 3px rgba(0,0,0,0.06), 0 4px 12px rgba(0,0,0,0.04);
        }

        html, body { height: 100%; font-family: 'Plus Jakarta Sans', sans-serif; background: var(--bg); color: var(--text-dark); font-size: 14px; line-height: 1.5; }

        .navbar {
    background: var(--text-dark);
    height: 60px;
    display: flex;
    align-items: center;
    padding: 0 28px;
    position: sticky;
    top: 0;
    z-index: 100;
    box-shadow: 0 2px 12px rgba(0,0,0,0.15);
        }
        .navbar-brand {
            display: flex; align-items: center; gap: 10px;
            text-decoration: none; color: var(--white);
            font-weight: 700; margin-right: 8px;
            flex-shrink: 0;
        }
        .navbar-nav { display: flex; gap: 2px; list-style: none; flex: 1; }
        .nav-link {
            display: flex; align-items: center; gap: 6px;
            padding: 7px 14px; border-radius: 8px;
            text-decoration: none; color: rgba(255,255,255,0.6);
            font-size: 13px; font-weight: 500; transition: all 0.15s;
        }
        .nav-link:hover { background: rgba(255,255,255,0.08); color: var(--white); }
        .nav-link.active { background: rgba(255,255,255,0.12); color: var(--white); }
        .navbar-right { display: flex; align-items: center; gap: 10px; margin-left: auto; }
        .user-name { font-size: 13px; font-weight: 600; color: var(--white); }
        .user-role {
            font-size: 10px; background: var(--primary); color: white;
            padding: 1px 8px; border-radius: 20px; display: inline-block;
            margin-top: 2px; font-weight: 600; letter-spacing: 0.03em;
        }
        .btn-icon {
            width: 34px; height: 34px; border: none;
            background: rgba(255,255,255,0.08); border-radius: 8px;
            cursor: pointer; display: flex; align-items: center; justify-content: center;
            color: rgba(255,255,255,0.7); transition: all 0.15s; text-decoration: none;
        }
        .btn-icon:hover { background: rgba(255,255,255,0.16); color: white; }

        .main-content { padding: 28px 32px; max-width: 1400px; margin: 0 auto; }

        .page-header { margin-bottom: 24px; }
        .page-title { font-size: 22px; font-weight: 700; }
        .page-desc { color: var(--text-light); margin-top: 3px; font-size: 13px; }

        .card { background: var(--white); border-radius: var(--radius-lg); border: 1px solid var(--border); box-shadow: var(--shadow); }
        .card-header { padding: 16px 20px; border-bottom: 1px solid var(--border); display: flex; align-items: center; gap: 8px; font-weight: 600; font-size: 14px; }
        .card-body { padding: 20px; }

        .form-group { margin-bottom: 16px; }
        .form-label { display: block; font-size: 13px; font-weight: 500; color: var(--text-mid); margin-bottom: 6px; }
        .form-label .required { color: var(--danger); }
        .form-control {
            width: 100%; padding: 9px 13px;
            border: 1px solid var(--border); border-radius: var(--radius);
            font-size: 14px; font-family: inherit; color: var(--text-dark);
            background: var(--white); transition: border-color 0.15s, box-shadow 0.15s; outline: none;
        }
        .form-control:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(45,157,143,0.12); }
        .form-control::placeholder { color: var(--text-light); }
        select.form-control { cursor: pointer; }
        textarea.form-control { resize: vertical; min-height: 80px; }
        .form-error { font-size: 12px; color: var(--danger); margin-top: 4px; }

        .form-grid { display: grid; gap: 16px; }
        .form-grid-2 { grid-template-columns: 1fr 1fr; }
        .col-full { grid-column: 1 / -1; }

        .btn {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 9px 18px; border-radius: var(--radius);
            font-size: 14px; font-weight: 600; font-family: inherit;
            border: none; cursor: pointer; text-decoration: none;
            transition: all 0.15s; white-space: nowrap;
        }
        .btn-primary { background: var(--primary); color: white; }
        .btn-primary:hover { background: var(--primary-dark); }
        .btn-full { width: 100%; justify-content: center; }
        .btn-lg { padding: 12px 24px; font-size: 15px; }
        .btn-sm { padding: 6px 12px; font-size: 12px; }
        .btn-outline { background: transparent; border: 1px solid var(--border); color: var(--text-mid); }
        .btn-outline:hover { background: var(--bg); }

        .badge { display: inline-flex; align-items: center; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; }
        .badge-warning { background: #fef3cd; color: #856404; }
        .badge-success { background: #d1fae5; color: #065f46; }
        .badge-info { background: #dbeafe; color: #1e40af; }
        .badge-primary { background: var(--primary-light); color: var(--primary-dark); }
        .badge-secondary { background: #f3f4f6; color: #4b5563; }

        .alert { padding: 12px 16px; border-radius: var(--radius); font-size: 13px; margin-bottom: 16px; display: flex; align-items: center; gap: 8px; }
        .alert-success { background: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; }
        .alert-danger { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }

        .antrian-item { display: flex; align-items: center; gap: 12px; padding: 12px 0; border-bottom: 1px solid var(--border); }
        .antrian-item:last-child { border-bottom: none; padding-bottom: 0; }
        .antrian-item:first-child { padding-top: 0; }
        .antrian-number { width: 36px; height: 36px; background: var(--primary-light); color: var(--primary); border-radius: 10px; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 15px; flex-shrink: 0; }
        .antrian-info { flex: 1; }
        .antrian-nama { font-weight: 600; font-size: 14px; }
        .antrian-time { font-size: 12px; color: var(--text-light); margin-top: 1px; }

        .patient-card { background: var(--white); border: 1px solid var(--border); border-radius: var(--radius-lg); overflow: hidden; box-shadow: var(--shadow); }
        .patient-card-header { padding: 14px 16px; border-bottom: 1px solid var(--border); }
        .patient-card-meta { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 4px; }
        .patient-card-no { font-size: 11px; background: var(--primary-light); color: var(--primary); padding: 2px 8px; border-radius: 20px; font-weight: 600; }
        .patient-card-date { font-size: 11px; color: var(--text-light); }
        .patient-card-name { font-size: 17px; font-weight: 700; }
        .patient-card-doctor { font-size: 12px; color: var(--text-light); margin-top: 3px; }
        .patient-card-body { padding: 14px 16px; }
        .patient-card-footer { padding: 12px 16px; border-top: 1px solid var(--border); }

        .rincian-label { font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-light); margin-bottom: 8px; }
        .rincian-row { display: flex; justify-content: space-between; font-size: 13px; margin-bottom: 4px; }
        .rincian-row.indent { padding-left: 12px; color: var(--text-mid); font-size: 12px; }
        .rincian-total { display: flex; justify-content: space-between; font-weight: 700; font-size: 15px; color: var(--primary); padding-top: 8px; margin-top: 4px; border-top: 1px solid var(--border); }

        .toggle-wrap { display: flex; align-items: center; gap: 12px; padding: 14px; background: var(--bg); border-radius: var(--radius); }
        .toggle { position: relative; width: 40px; height: 22px; flex-shrink: 0; }
        .toggle input { opacity: 0; width: 0; height: 0; }
        .toggle-slider { position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background: #d1d5db; border-radius: 22px; transition: 0.2s; }
        .toggle-slider:before { content: ''; position: absolute; height: 16px; width: 16px; left: 3px; bottom: 3px; background: white; border-radius: 50%; transition: 0.2s; }
        .toggle input:checked + .toggle-slider { background: var(--primary); }
        .toggle input:checked + .toggle-slider:before { transform: translateX(18px); }
        .toggle-title { font-weight: 600; font-size: 13px; }
        .toggle-desc { font-size: 12px; color: var(--text-light); }

        .tindakan-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
        .tindakan-item { display: flex; align-items: center; gap: 10px; padding: 12px 14px; border: 1px solid var(--border); border-radius: var(--radius); cursor: pointer; transition: all 0.15s; }
        .tindakan-item:hover { border-color: var(--primary-muted); background: var(--primary-light); }
        .tindakan-item input[type="checkbox"] { width: 16px; height: 16px; accent-color: var(--primary); cursor: pointer; flex-shrink: 0; }
        .tindakan-nama { font-size: 13px; font-weight: 500; }
        .tindakan-harga { font-size: 12px; color: var(--text-light); }

        .resep-item { border: 1px solid var(--border); border-radius: var(--radius); padding: 14px; margin-bottom: 10px; position: relative; }
        .resep-grid { display: grid; grid-template-columns: 2fr 1fr 2fr; gap: 10px; align-items: end; }
        .btn-remove-resep { position: absolute; top: 8px; right: 8px; background: none; border: none; cursor: pointer; color: var(--text-light); padding: 4px; border-radius: 4px; transition: color 0.15s; }
        .btn-remove-resep:hover { color: var(--danger); }

        .estimasi-sticky { position: sticky; top: 72px; }
        .estimasi-row { display: flex; justify-content: space-between; font-size: 13px; padding: 4px 0; color: var(--text-mid); }
        .estimasi-total { display: flex; justify-content: space-between; font-weight: 700; font-size: 16px; color: var(--primary); padding-top: 10px; margin-top: 6px; border-top: 2px solid var(--primary-light); }

        .obat-pill { background: var(--bg); border-radius: var(--radius); padding: 8px 12px; margin-bottom: 6px; }
        .obat-pill-header { display: flex; justify-content: space-between; align-items: center; }
        .obat-pill-nama { font-weight: 600; font-size: 13px; }
        .obat-jumlah { background: var(--primary-light); color: var(--primary); font-weight: 700; border-radius: 6px; padding: 2px 8px; font-size: 13px; }
        .obat-aturan { font-size: 12px; color: var(--text-light); margin-top: 4px; }

        .layout-split { display: grid; grid-template-columns: 1fr 320px; gap: 24px; align-items: start; }
        .layout-cards { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }

        .section-title { font-size: 14px; font-weight: 600; display: flex; align-items: center; gap: 8px; margin-bottom: 14px; }
        .back-link { display: inline-flex; align-items: center; gap: 6px; color: var(--text-light); text-decoration: none; font-size: 13px; margin-bottom: 16px; transition: color 0.15s; }
        .back-link:hover { color: var(--primary); }

        .empty-state { text-align: center; padding: 48px 24px; }
        .empty-icon { font-size: 40px; margin-bottom: 12px; opacity: 0.4; }
        .empty-title { font-weight: 600; font-size: 15px; color: var(--text-mid); }
        .empty-desc { font-size: 13px; color: var(--text-light); margin-top: 4px; }

        .pagination { display: flex; gap: 6px; justify-content: center; margin-top: 20px; flex-wrap: wrap; }
        .pagination a, .pagination span { padding: 6px 12px; border-radius: 8px; font-size: 13px; text-decoration: none; border: 1px solid var(--border); color: var(--text-mid); }
        .pagination .active span { background: var(--primary); color: white; border-color: var(--primary); }
        .pagination a:hover { background: var(--bg); }

        .mt-2 { margin-top: 8px; } .mt-3 { margin-top: 12px; } .mt-4 { margin-top: 16px; }
        .mb-0 { margin-bottom: 0; } .text-center { text-align: center; }
        .text-muted { color: var(--text-light); } .text-sm { font-size: 12px; }
        .font-bold { font-weight: 700; }
        .flex { display: flex; } .flex-1 { flex: 1; }
        .items-center { align-items: center; } .justify-between { justify-content: space-between; }
        .gap-2 { gap: 8px; }
    </style>
</head>
<body>
    <nav class="navbar">
        <a href="{{ route('dashboard') }}" class="navbar-brand">
            <img src="{{ asset('logo.png') }}" alt="Logo" style="width:36px; height:36px; object-fit:contain;">
            <div>
                <div style="font-size:14px; font-weight:700; line-height:1.2;">Klinik Pratama Hanjawar</div>
                <div style="font-size:10px; font-weight:400; opacity:0.6; line-height:1.2; letter-spacing:0.05em;">AD-DAWA</div>
            </div>
        </a>

        <div style="height:28px; width:1px; background:rgba(255,255,255,0.15); margin: 0 16px;"></div>

        <ul class="navbar-nav">
            @yield('nav-links')
        </ul>

        <div class="navbar-right">
            <div style="text-align:right;">
                <div class="user-name">{{ session('karyawan_nama') }}</div>
                <div class="user-role">
                    {{ session('karyawan_peran') === 'pendaftaran_kasir' ? 'Pendaftaran & Kasir' : ucfirst(session('karyawan_peran')) }}
                </div>
            </div>
            <div style="width:34px; height:34px; background:rgba(255,255,255,0.1); border-radius:50%; display:flex; align-items:center; justify-content:center;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.8)" stroke-width="2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
        </div>
        <form action="{{ route('logout') }}" method="POST" style="display:inline">
            @csrf
            <button type="submit" class="btn-icon" title="Keluar">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4M16 17l5-5-5-5M21 12H9"/>
                </svg>
            </button>
        </form>
    </div>
</nav>

    <div class="main-content">
        @if(session('success'))
            <div class="alert alert-success">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </div>

    @stack('scripts')
</body>
</html>