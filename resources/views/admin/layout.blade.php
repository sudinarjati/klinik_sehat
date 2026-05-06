<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Manajemen') — Klinik Pratama Hanjawar</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --primary: #1e40af; --primary-dark: #1e3a8a; --primary-light: #eff6ff;
            --text-dark: #1e293b; --text-mid: #475569; --text-light: #94a3b8;
            --border: #e2e8f0; --bg: #f8fafc; --white: #fff;
            --danger: #ef4444; --success: #10b981; --warning: #f59e0b;
            --radius: 10px; --radius-lg: 14px;
            --shadow: 0 1px 3px rgba(0,0,0,0.06), 0 4px 12px rgba(0,0,0,0.04);
            --sidebar: 240px;
        }
        html, body { height: 100%; font-family: 'Plus Jakarta Sans', sans-serif; background: var(--bg); color: var(--text-dark); font-size: 14px; }

        /* Sidebar */
        .sidebar {
            position: fixed; top: 0; left: 0; bottom: 0;
            width: var(--sidebar);
            background: #1e293b;
            display: flex; flex-direction: column;
            z-index: 100;
        }
        .sidebar-brand {
            padding: 20px 16px;
            border-bottom: 1px solid rgba(255,255,255,0.08);
            display: flex; align-items: center; gap: 10px;
        }
        .sidebar-brand img { width: 36px; height: 36px; object-fit: contain; border-radius: 8px; }
        .sidebar-brand-text { font-size: 12px; font-weight: 700; color: white; line-height: 1.3; }
        .sidebar-brand-sub { font-size: 10px; color: rgba(255,255,255,0.4); font-weight: 400; }

        .sidebar-menu { padding: 12px 8px; flex: 1; overflow-y: auto; }
        .sidebar-label {
            font-size: 10px; font-weight: 700; text-transform: uppercase;
            letter-spacing: 0.08em; color: rgba(255,255,255,0.3);
            padding: 8px 8px 4px;
        }
        .sidebar-link {
            display: flex; align-items: center; gap: 10px;
            padding: 9px 12px; border-radius: 8px;
            text-decoration: none; color: rgba(255,255,255,0.6);
            font-size: 13px; font-weight: 500;
            transition: all 0.15s; margin-bottom: 2px;
        }
        .sidebar-link:hover { background: rgba(255,255,255,0.07); color: white; }
        .sidebar-link.active { background: var(--primary); color: white; }
        .sidebar-link svg { flex-shrink: 0; }

        .sidebar-footer {
            padding: 12px 8px;
            border-top: 1px solid rgba(255,255,255,0.08);
        }
        .sidebar-user {
            display: flex; align-items: center; gap: 10px;
            padding: 8px 12px; border-radius: 8px;
            margin-bottom: 6px;
        }
        .sidebar-user-avatar {
            width: 32px; height: 32px;
            background: var(--primary); border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 13px; font-weight: 700; color: white; flex-shrink: 0;
        }
        .sidebar-user-name { font-size: 12px; font-weight: 600; color: white; }
        .sidebar-user-role { font-size: 11px; color: rgba(255,255,255,0.4); }

        .btn-logout {
            display: flex; align-items: center; gap: 8px;
            width: 100%; padding: 8px 12px; border-radius: 8px;
            background: rgba(239,68,68,0.1); border: none;
            color: #fca5a5; font-size: 13px; font-weight: 500;
            font-family: inherit; cursor: pointer; transition: all 0.15s;
        }
        .btn-logout:hover { background: rgba(239,68,68,0.2); color: #f87171; }

        /* Main */
        .main { margin-left: var(--sidebar); min-height: 100vh; }
        .topbar {
            background: var(--white); border-bottom: 1px solid var(--border);
            padding: 0 28px; height: 56px;
            display: flex; align-items: center; justify-content: space-between;
            position: sticky; top: 0; z-index: 50;
        }
        .topbar-title { font-size: 16px; font-weight: 700; }
        .topbar-breadcrumb { font-size: 12px; color: var(--text-light); margin-top: 2px; }

        .content { padding: 24px 28px; }

        /* Card */
        .card { background: var(--white); border-radius: var(--radius-lg); border: 1px solid var(--border); box-shadow: var(--shadow); }
        .card-header { padding: 14px 20px; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; }
        .card-header-title { font-weight: 700; font-size: 14px; display: flex; align-items: center; gap: 8px; }
        .card-body { padding: 20px; }

        /* Stats */
        .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 24px; }
        .stat-card {
            background: var(--white); border-radius: var(--radius-lg);
            border: 1px solid var(--border); padding: 20px;
            display: flex; align-items: center; gap: 14px;
        }
        .stat-icon {
            width: 48px; height: 48px; border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .stat-value { font-size: 24px; font-weight: 700; }
        .stat-label { font-size: 12px; color: var(--text-light); margin-top: 2px; }

        /* Table */
        .table { width: 100%; border-collapse: collapse; }
        .table th {
            padding: 10px 16px; text-align: left;
            font-size: 11px; font-weight: 700; text-transform: uppercase;
            letter-spacing: 0.05em; color: var(--text-light);
            background: var(--bg); border-bottom: 1px solid var(--border);
        }
        .table td { padding: 12px 16px; border-bottom: 1px solid var(--border); font-size: 13px; }
        .table tr:last-child td { border-bottom: none; }
        .table tr:hover td { background: var(--bg); }

        /* Badge */
        .badge { display: inline-flex; align-items: center; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; }
        .badge-success { background: #d1fae5; color: #065f46; }
        .badge-danger  { background: #fee2e2; color: #991b1b; }
        .badge-warning { background: #fef3cd; color: #856404; }

        /* Form */
        .form-group { margin-bottom: 14px; }
        .form-label { display: block; font-size: 12px; font-weight: 600; color: var(--text-mid); margin-bottom: 5px; }
        .form-control {
            width: 100%; padding: 8px 12px;
            border: 1px solid var(--border); border-radius: 8px;
            font-size: 13px; font-family: inherit; color: var(--text-dark);
            outline: none; transition: all 0.15s;
        }
        .form-control:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(37,99,235,0.1); }
        .form-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
        .form-grid-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 12px; }

        /* Buttons */
        .btn { display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; border-radius: 8px; font-size: 13px; font-weight: 600; font-family: inherit; border: none; cursor: pointer; text-decoration: none; transition: all 0.15s; }
        .btn-primary { background: var(--primary); color: white; }
        .btn-primary:hover { background: var(--primary-dark); }
        .btn-success { background: var(--success); color: white; }
        .btn-success:hover { background: #059669; }
        .btn-warning { background: var(--warning); color: white; }
        .btn-warning:hover { background: #d97706; }
        .btn-danger { background: var(--danger); color: white; }
        .btn-danger:hover { background: #dc2626; }
        .btn-outline { background: transparent; border: 1px solid var(--border); color: var(--text-mid); }
        .btn-outline:hover { background: var(--bg); }
        .btn-sm { padding: 5px 10px; font-size: 12px; }
        .btn-full { width: 100%; justify-content: center; }

        /* Alert */
        .alert { padding: 12px 16px; border-radius: var(--radius); font-size: 13px; margin-bottom: 16px; display: flex; align-items: center; gap: 8px; }
        .alert-success { background: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; }
        .alert-danger  { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }

        /* Modal */
        .modal-overlay { display:none; position:fixed; inset:0; background:rgba(0,0,0,0.4); z-index:200; align-items:center; justify-content:center; }
        .modal-overlay.show { display:flex; }
        .modal { background:white; border-radius:16px; width:100%; max-width:480px; box-shadow:0 20px 60px rgba(0,0,0,0.2); }
        .modal-header { padding:16px 20px; border-bottom:1px solid var(--border); display:flex; justify-content:space-between; align-items:center; font-weight:700; }
        .modal-body { padding:20px; }
        .modal-footer { padding:14px 20px; border-top:1px solid var(--border); display:flex; gap:10px; justify-content:flex-end; }
        .btn-close { background:none; border:none; cursor:pointer; color:var(--text-light); font-size:18px; line-height:1; }

        .stok-badge {
            display:inline-flex; align-items:center; padding:2px 8px;
            border-radius:20px; font-size:11px; font-weight:700;
        }

        .empty-state { text-align:center; padding:40px; color:var(--text-light); }
        .empty-icon { font-size:36px; margin-bottom:10px; opacity:0.4; }
    </style>
</head>
<body>
    {{-- Sidebar --}}
    <div class="sidebar">
        <div class="sidebar-brand">
            <img src="{{ asset('logo.png') }}" alt="Logo">
            <div>
                <div class="sidebar-brand-text">Klinik Pratama<br>Hanjawar</div>
                <div class="sidebar-brand-sub">Panel Manajemen</div>
            </div>
        </div>

        <div class="sidebar-menu">
            <div class="sidebar-label">Utama</div>
            <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
                Dashboard
            </a>

            <div class="sidebar-label" style="margin-top:12px;">Harga & Layanan</div>
            <a href="{{ route('admin.tindakan') }}" class="sidebar-link {{ request()->routeIs('admin.tindakan') ? 'active' : '' }}">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                Tindakan Medis
            </a>
            <a href="{{ route('admin.lab') }}" class="sidebar-link {{ request()->routeIs('admin.lab') ? 'active' : '' }}">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 3H5a2 2 0 00-2 2v4m6-6h10a2 2 0 012 2v4M9 3v18m0 0h10a2 2 0 002-2v-4M9 21H5a2 2 0 01-2-2v-4m0 0h18"/></svg>
                Pemeriksaan Lab
            </a>

            <div class="sidebar-label" style="margin-top:12px;">Stok & Belanja</div>
            <a href="{{ route('admin.obat') }}" class="sidebar-link {{ request()->routeIs('admin.obat') ? 'active' : '' }}">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.5 20H4a2 2 0 01-2-2V5c0-1.1.9-2 2-2h3.93a2 2 0 011.66.9l.82 1.2a2 2 0 001.66.9H20a2 2 0 012 2v3"/><circle cx="18" cy="18" r="3"/><path d="M18 15v3l2 1"/></svg>
                Obat
            </a>
            <a href="{{ route('admin.alkes') }}" class="sidebar-link {{ request()->routeIs('admin.alkes') ? 'active' : '' }}">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4.5 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM14.25 8.625a3.375 3.375 0 116.75 0 3.375 3.375 0 01-6.75 0zM1.5 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122zM17.25 19.128l-.001.144a2.25 2.25 0 01-.233.96 10.088 10.088 0 005.06-1.01.75.75 0 00.42-.643 4.875 4.875 0 00-6.957-4.611 8.586 8.586 0 011.71 5.157v.003z"/></svg>
                Alat Kesehatan
            </a>
        </div>

        <div class="sidebar-footer">
            <div class="sidebar-user">
                <div class="sidebar-user-avatar">{{ substr(session('admin_nama', 'A'), 0, 1) }}</div>
                <div>
                    <div class="sidebar-user-name">{{ session('admin_nama') }}</div>
                    <div class="sidebar-user-role">Manajer Klinik</div>
                </div>
            </div>
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn-logout">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4M16 17l5-5-5-5M21 12H9"/></svg>
                    Keluar
                </button>
            </form>
        </div>
    </div>

    {{-- Main Content --}}
    <div class="main">
        <div class="topbar">
            <div>
                <div class="topbar-title">@yield('title', 'Dashboard')</div>
                <div class="topbar-breadcrumb">Panel Manajemen › @yield('title', 'Dashboard')</div>
            </div>
        </div>

        <div class="content">
            @if(session('success'))
                <div class="alert alert-success">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/></svg>
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </div>
    </div>
    @stack('scripts')
</body>
</html>