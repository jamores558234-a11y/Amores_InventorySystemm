<<<<<<< HEAD
{{-- FILE PATH: resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') — StockVault IMS</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        *,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
        :root{
            --navy:#0f1d35;--navy2:#162540;--navy3:#1e3258;
            --gold:#c9a84c;--gold2:#e0be78;
            --white:#ffffff;--gray1:#f1f3f7;--gray2:#e4e8f0;--gray3:#b0b8cc;--gray4:#6b7694;
            --text:#1a2540;--text2:#4a5370;
            --green:#1a7f5a;--green2:#e8f7f2;
            --red:#c0392b;--red2:#fdf0ee;
            --amber:#c87800;--amber2:#fff8e8;
            --purple:#6366f1;--purple2:#eef2ff;
            --teal:#0d9488;--teal2:#f0fdfa;
            --sidebar-w:265px;--header-h:64px;--radius:8px;
            --shadow:0 2px 12px rgba(15,29,53,0.08);
        }
        body{font-family:'DM Sans',sans-serif;background:var(--gray1);color:var(--text);display:flex;min-height:100vh;}

        /* SIDEBAR */
        .sidebar{width:var(--sidebar-w);min-height:100vh;background:var(--navy);display:flex;flex-direction:column;position:fixed;top:0;left:0;bottom:0;z-index:100;}
        .sidebar-brand{padding:0 20px;height:var(--header-h);display:flex;align-items:center;gap:12px;border-bottom:1px solid rgba(255,255,255,0.07);}
        .logo-icon{width:36px;height:36px;background:var(--gold);border-radius:8px;display:flex;align-items:center;justify-content:center;color:var(--navy);font-size:16px;font-weight:700;flex-shrink:0;}
        .logo-text{font-size:15px;font-weight:700;color:var(--white);}
        .logo-sub{font-size:10px;color:var(--gold);letter-spacing:0.1em;text-transform:uppercase;}
        .role-card{margin:12px 14px;padding:10px 12px;border-radius:9px;display:flex;align-items:center;gap:10px;}
        .role-card.admin{background:rgba(201,168,76,0.1);border:1px solid rgba(201,168,76,0.22);}
        .role-card.manager{background:rgba(99,102,241,0.1);border:1px solid rgba(99,102,241,0.22);}
        .role-card.staff{background:rgba(20,184,166,0.1);border:1px solid rgba(20,184,166,0.22);}
        .role-avatar{width:32px;height:32px;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:13px;flex-shrink:0;}
        .role-avatar.admin{background:rgba(201,168,76,0.2);color:var(--gold);}
        .role-avatar.manager{background:rgba(99,102,241,0.2);color:#818cf8;}
        .role-avatar.staff{background:rgba(20,184,166,0.2);color:#2dd4bf;}
        .role-name{font-size:12px;font-weight:700;color:var(--white);}
        .role-title{font-size:10px;margin-top:1px;}
        .role-title.admin{color:var(--gold);}
        .role-title.manager{color:#818cf8;}
        .role-title.staff{color:#2dd4bf;}
        .sidebar-nav{flex:1;padding:8px 0;overflow-y:auto;}
        .nav-section-label{font-size:10px;font-weight:600;letter-spacing:0.12em;text-transform:uppercase;color:rgba(255,255,255,0.22);padding:10px 20px 4px;}
        .nav-item a{display:flex;align-items:center;gap:11px;padding:9px 20px;color:rgba(255,255,255,0.55);text-decoration:none;font-size:13px;font-weight:500;transition:all 0.15s;border-left:3px solid transparent;}
        .nav-item a:hover,.nav-item a.active{background:rgba(255,255,255,0.06);color:var(--white);border-left-color:var(--gold);}
        .nav-item a .nav-icon{width:18px;text-align:center;font-size:13px;}
        .nav-badge{margin-left:auto;background:var(--red);color:#fff;font-size:10px;font-weight:700;padding:1px 6px;border-radius:20px;}
        .sidebar-footer{padding:12px 18px;border-top:1px solid rgba(255,255,255,0.07);}
        .user-card{display:flex;align-items:center;gap:10px;}
        .user-avatar{width:32px;height:32px;border-radius:50%;background:var(--gold);display:flex;align-items:center;justify-content:center;font-weight:700;font-size:13px;color:var(--navy);flex-shrink:0;}
        .user-info .user-name{font-size:12px;color:var(--white);font-weight:600;}
        .user-info .user-role{font-size:10px;color:rgba(255,255,255,0.32);}
        .user-logout{margin-left:auto;color:rgba(255,255,255,0.28);font-size:14px;text-decoration:none;transition:color 0.15s;background:none;border:none;cursor:pointer;}
        .user-logout:hover{color:var(--gold);}

        /* MAIN */
        .main-wrapper{margin-left:var(--sidebar-w);flex:1;display:flex;flex-direction:column;min-height:100vh;}
        .topbar{height:var(--header-h);background:var(--white);border-bottom:1px solid var(--gray2);display:flex;align-items:center;padding:0 28px;gap:16px;position:sticky;top:0;z-index:90;}
        .topbar-title{font-size:17px;font-weight:700;color:var(--text);flex:1;}
        .topbar-subtitle{font-size:13px;color:var(--gray3);}
        .page-content{flex:1;padding:24px 28px;}

        /* ALERTS */
        .alert{padding:12px 16px;border-radius:var(--radius);margin-bottom:18px;font-size:14px;display:flex;align-items:center;gap:10px;font-weight:500;}
        .alert-success{background:var(--green2);color:var(--green);border:1px solid #a8e0cc;}
        .alert-danger{background:var(--red2);color:var(--red);border:1px solid #f0c4be;}
        .alert-info{background:var(--purple2);color:var(--purple);border:1px solid #c7d2fe;}

        /* CARDS */
        .card{background:var(--white);border-radius:10px;border:1px solid var(--gray2);box-shadow:var(--shadow);}
        .card-header{padding:16px 22px;border-bottom:1px solid var(--gray2);display:flex;align-items:center;justify-content:space-between;}
        .card-title{font-size:14px;font-weight:700;color:var(--text);}
        .card-body{padding:22px;}

        /* STATS */
        .stats-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:16px;}
        .stat-card{background:var(--white);border:1px solid var(--gray2);border-radius:10px;padding:18px 20px;display:flex;align-items:flex-start;gap:14px;box-shadow:var(--shadow);}
        .stat-icon{width:44px;height:44px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:17px;flex-shrink:0;}
        .stat-icon.navy{background:rgba(15,29,53,0.08);color:var(--navy2);}
        .stat-icon.gold{background:rgba(201,168,76,0.14);color:var(--gold);}
        .stat-icon.green{background:var(--green2);color:var(--green);}
        .stat-icon.red{background:var(--red2);color:var(--red);}
        .stat-icon.amber{background:var(--amber2);color:var(--amber);}
        .stat-icon.purple{background:var(--purple2);color:var(--purple);}
        .stat-icon.teal{background:var(--teal2);color:var(--teal);}
        .stat-label{font-size:11px;color:var(--gray4);font-weight:500;margin-bottom:3px;}
        .stat-value{font-size:24px;font-weight:700;color:var(--text);line-height:1;}
        .stat-sub{font-size:11px;color:var(--gray3);margin-top:3px;}

        /* TABLE */
        .table-container{overflow-x:auto;}
        table{width:100%;border-collapse:collapse;font-size:13.5px;}
        thead th{background:var(--gray1);color:var(--gray4);font-size:11px;font-weight:600;letter-spacing:0.06em;text-transform:uppercase;padding:10px 14px;text-align:left;border-bottom:1px solid var(--gray2);}
        tbody tr{border-bottom:1px solid var(--gray2);transition:background 0.12s;}
        tbody tr:last-child{border-bottom:none;}
        tbody tr:hover{background:var(--gray1);}
        tbody td{padding:12px 14px;color:var(--text2);vertical-align:middle;}
        tbody td strong{color:var(--text);font-weight:600;}

        /* BADGES */
        .badge{display:inline-flex;align-items:center;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:600;gap:4px;}
        .badge-green{background:var(--green2);color:var(--green);}
        .badge-amber{background:var(--amber2);color:var(--amber);}
        .badge-red{background:var(--red2);color:var(--red);}
        .badge-gray{background:var(--gray2);color:var(--gray4);}
        .badge-navy{background:rgba(15,29,53,0.08);color:var(--navy2);}
        .badge-purple{background:var(--purple2);color:var(--purple);}
        .badge-teal{background:var(--teal2);color:var(--teal);}
        .badge-gold{background:rgba(201,168,76,0.15);color:#9a7a20;}

        /* BUTTONS */
        .btn{display:inline-flex;align-items:center;gap:7px;padding:9px 16px;border-radius:var(--radius);font-size:13px;font-weight:600;cursor:pointer;border:none;text-decoration:none;transition:all 0.16s;font-family:'DM Sans',sans-serif;}
        .btn-primary{background:var(--navy);color:var(--white);}
        .btn-primary:hover{background:var(--navy3);color:var(--white);}
        .btn-gold{background:var(--gold);color:var(--navy);}
        .btn-gold:hover{background:var(--gold2);}
        .btn-success{background:var(--green);color:var(--white);}
        .btn-success:hover{opacity:0.88;}
        .btn-danger{background:var(--red);color:var(--white);}
        .btn-danger:hover{opacity:0.88;}
        .btn-purple{background:var(--purple);color:var(--white);}
        .btn-teal{background:var(--teal);color:var(--white);}
        .btn-outline{background:transparent;color:var(--text2);border:1px solid var(--gray2);}
        .btn-outline:hover{border-color:var(--gray3);background:var(--gray1);}
        .btn-sm{padding:6px 12px;font-size:12px;}
        .btn-icon{padding:6px 9px;}

        /* FORMS */
        .form-group{margin-bottom:18px;}
        .form-label{display:block;font-size:12px;font-weight:600;color:var(--text2);margin-bottom:6px;}
        .form-control,.form-select{width:100%;padding:10px 13px;border:1px solid var(--gray2);border-radius:var(--radius);font-size:13.5px;font-family:'DM Sans',sans-serif;color:var(--text);background:var(--white);transition:border-color 0.15s,box-shadow 0.15s;outline:none;}
        .form-control:focus,.form-select:focus{border-color:var(--navy);box-shadow:0 0 0 3px rgba(15,29,53,0.08);}
        textarea.form-control{resize:vertical;min-height:80px;}
        .form-grid-2{display:grid;grid-template-columns:1fr 1fr;gap:0 18px;}
        .form-grid-3{display:grid;grid-template-columns:1fr 1fr 1fr;gap:0 18px;}
        .invalid-feedback{color:var(--red);font-size:12px;margin-top:4px;display:block;}
        .is-invalid{border-color:var(--red)!important;}

        /* SEARCH */
        .search-form{display:flex;gap:10px;flex-wrap:wrap;align-items:center;}
        .search-input-wrap{position:relative;flex:1;min-width:200px;}
        .search-input-wrap .fa{position:absolute;left:12px;top:50%;transform:translateY(-50%);color:var(--gray3);font-size:13px;}
        .search-input-wrap input{padding-left:36px;}

        /* PAGINATION */
        .pagination-wrap{display:flex;align-items:center;justify-content:space-between;padding:14px 20px;border-top:1px solid var(--gray2);font-size:12px;color:var(--gray4);}
        .pagination{display:flex;gap:4px;}
        .pagination .page-item .page-link{padding:5px 10px;border:1px solid var(--gray2);border-radius:6px;color:var(--text2);text-decoration:none;font-size:12px;font-weight:500;transition:all 0.14s;}
        .pagination .page-item.active .page-link{background:var(--navy);border-color:var(--navy);color:var(--white);}

        /* MODAL */
        .modal-overlay{display:none;position:fixed;inset:0;background:rgba(15,29,53,0.45);z-index:200;align-items:center;justify-content:center;}
        .modal-overlay.show{display:flex;}
        .modal-box{background:var(--white);border-radius:12px;width:100%;max-width:460px;box-shadow:0 4px 24px rgba(15,29,53,0.13);animation:modal-in 0.2s ease;}
        @keyframes modal-in{from{opacity:0;transform:scale(0.95) translateY(-8px)}to{opacity:1;transform:scale(1) translateY(0)}}
        .modal-header{padding:16px 22px;border-bottom:1px solid var(--gray2);display:flex;align-items:center;justify-content:space-between;}
        .modal-title{font-size:14px;font-weight:700;}
        .modal-close{background:none;border:none;font-size:17px;color:var(--gray3);cursor:pointer;padding:2px 5px;border-radius:4px;}
        .modal-close:hover{color:var(--text);background:var(--gray1);}
        .modal-body{padding:20px 22px;}
        .modal-footer{padding:14px 22px;border-top:1px solid var(--gray2);display:flex;gap:10px;justify-content:flex-end;}

        /* MISC */
        .mono{font-family:'DM Mono',monospace;font-size:12px;}
        .text-muted{color:var(--gray4);}
        .fw-600{font-weight:600;}
        .mt-4{margin-top:16px;}
        .mb-4{margin-bottom:16px;}
        .empty-state{text-align:center;padding:50px 20px;color:var(--gray3);}
        .empty-state i{font-size:36px;margin-bottom:10px;display:block;}
        .breadcrumb{display:flex;align-items:center;gap:6px;font-size:12px;color:var(--gray4);margin-bottom:18px;}
        .breadcrumb a{color:var(--gray4);text-decoration:none;}
        .breadcrumb a:hover{color:var(--navy);}
        .breadcrumb .sep{color:var(--gray3);}
        .breadcrumb .current{color:var(--text);font-weight:600;}
        .page-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;}
        .page-header h1{font-size:21px;font-weight:700;color:var(--text);}
        .page-header p{font-size:13px;color:var(--gray4);margin-top:2px;}
    </style>
</head>
<body>

<aside class="sidebar">
    <div class="sidebar-brand">
        <div class="logo-icon">SV</div>
        <div>
            <div class="logo-text">StockVault</div>
            <div class="logo-sub">Inventory System</div>
        </div>
    </div>

    <div class="role-card {{ Auth::user()->role }}">
        <div class="role-avatar {{ Auth::user()->role }}">
            <i class="fas {{ Auth::user()->getRoleIcon() }}"></i>
        </div>
        <div>
            <div class="role-name">{{ Auth::user()->name }}</div>
            <div class="role-title {{ Auth::user()->role }}">{{ Auth::user()->getRoleLabel() }}</div>
        </div>
    </div>

    <nav class="sidebar-nav">

        {{-- COMMON --}}
        <div class="nav-section-label">General</div>
        <div class="nav-item">
            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fas fa-chart-pie"></i></span> Dashboard
            </a>
        </div>

        {{-- ── ADMIN ── --}}
        @if(Auth::user()->isAdmin())
        <div class="nav-section-label" style="margin-top:6px;">🛡️ Admin Controls</div>
        <div class="nav-item">
            <a href="{{ route('users.index') }}" class="{{ request()->routeIs('users.*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fas fa-users-cog"></i></span> Manage Users
            </a>
        </div>
        <div class="nav-item">
            <a href="{{ route('settings.index') }}" class="{{ request()->routeIs('settings.*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fas fa-sliders"></i></span> Configure System
            </a>
        </div>
        <div class="nav-section-label" style="margin-top:6px;">Inventory</div>
        <div class="nav-item">
            <a href="{{ route('products.index') }}" class="{{ request()->routeIs('products.*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fas fa-boxes-stacked"></i></span> View Inventory
                @php $alertCount = \App\Models\Product::whereColumn('quantity','<=','reorder_level')->count(); @endphp
                @if($alertCount > 0)<span class="nav-badge">{{ $alertCount }}</span>@endif
            </a>
        </div>
        <div class="nav-item">
            <a href="{{ route('products.index') }}?status=low">
                <span class="nav-icon"><i class="fas fa-triangle-exclamation"></i></span> Low Stock
            </a>
        </div>
        <div class="nav-item">
            <a href="{{ route('products.index') }}?status=out">
                <span class="nav-icon"><i class="fas fa-ban"></i></span> Out of Stock
            </a>
        </div>
        @endif

        {{-- ── INVENTORY MANAGER ── --}}
        @if(Auth::user()->isInventoryManager())
        <div class="nav-section-label" style="margin-top:6px;">📦 Inventory Manager</div>
        <div class="nav-item">
            <a href="{{ route('products.index') }}" class="{{ request()->routeIs('products.*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fas fa-boxes-stacked"></i></span> View Inventory
                @php $alertCount = \App\Models\Product::whereColumn('quantity','<=','reorder_level')->count(); @endphp
                @if($alertCount > 0)<span class="nav-badge">{{ $alertCount }}</span>@endif
            </a>
        </div>
        <div class="nav-item">
            <a href="{{ route('products.create') }}">
                <span class="nav-icon"><i class="fas fa-plus-circle"></i></span> Add Product
            </a>
        </div>
        <div class="nav-item">
            <a href="{{ route('products.index') }}">
                <span class="nav-icon"><i class="fas fa-pen-to-square"></i></span> Update Product
            </a>
        </div>
        <div class="nav-item">
            <a href="{{ route('products.index') }}?status=low">
                <span class="nav-icon"><i class="fas fa-triangle-exclamation"></i></span> Low Stock
            </a>
        </div>
        <div class="nav-section-label" style="margin-top:6px;">Transactions</div>
        <div class="nav-item">
            <a href="{{ route('products.index') }}">
                <span class="nav-icon"><i class="fas fa-arrow-up-from-bracket"></i></span> Request Item
            </a>
        </div>
        <div class="nav-item">
            <a href="{{ route('products.index') }}">
                <span class="nav-icon"><i class="fas fa-hand-holding-box"></i></span> Borrow Item
            </a>
        </div>
        <div class="nav-item">
            <a href="{{ route('products.index') }}">
                <span class="nav-icon"><i class="fas fa-rotate-left"></i></span> Return Item
            </a>
        </div>
        @endif

        {{-- ── STAFF ── --}}
        @if(Auth::user()->isStaff())
        <div class="nav-section-label" style="margin-top:6px;">👤 Staff Access</div>
        <div class="nav-item">
            <a href="{{ route('products.index') }}" class="{{ request()->routeIs('products.*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fas fa-list"></i></span> View Products
                @php $alertCount = \App\Models\Product::whereColumn('quantity','<=','reorder_level')->count(); @endphp
                @if($alertCount > 0)<span class="nav-badge">{{ $alertCount }}</span>@endif
            </a>
        </div>
        <div class="nav-item">
            <a href="{{ route('products.index') }}?status=low">
                <span class="nav-icon"><i class="fas fa-chart-bar"></i></span> Monitor Stock
            </a>
        </div>
        <div class="nav-item">
            <a href="{{ route('products.index') }}?status=out">
                <span class="nav-icon"><i class="fas fa-ban"></i></span> Out of Stock
            </a>
        </div>
        @endif

    </nav>

    <div class="sidebar-footer">
        <div class="user-card">
            <div class="user-avatar">{{ substr(Auth::user()->name,0,1) }}</div>
            <div class="user-info">
                <div class="user-name">{{ Str::limit(Auth::user()->name,16) }}</div>
                <div class="user-role">{{ Auth::user()->getRoleLabel() }}</div>
            </div>
            <form method="POST" action="{{ route('logout') }}" style="display:inline">
                @csrf
                <button type="submit" class="user-logout" title="Sign Out"><i class="fas fa-sign-out-alt"></i></button>
            </form>
        </div>
    </div>
</aside>

<div class="main-wrapper">
    <header class="topbar">
        <div style="flex:1;">
            <div class="topbar-title">
                @yield('page-title','Dashboard')
                <span class="topbar-subtitle"> — @yield('page-subtitle','Overview')</span>
            </div>
        </div>
        <div style="display:flex;align-items:center;gap:10px;">
            <span class="badge {{ Auth::user()->isAdmin() ? 'badge-gold' : (Auth::user()->isInventoryManager() ? 'badge-purple' : 'badge-teal') }}">
                <i class="fas {{ Auth::user()->getRoleIcon() }}"></i>
                {{ Auth::user()->getRoleLabel() }}
            </span>
            <span style="font-size:12px;color:var(--gray3);"><i class="far fa-calendar-alt"></i> {{ now()->format('M d, Y') }}</span>
        </div>
    </header>

    <main class="page-content">
        @if(session('success'))
            <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</div>
        @endif
        @if(session('info'))
            <div class="alert alert-info"><i class="fas fa-circle-info"></i> {{ session('info') }}</div>
        @endif
        @yield('content')
    </main>
</div>

@yield('scripts')
</body>
</html>
=======
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
>>>>>>> 65b51754ff66c222a1d9fdc027683d09d9afc9cc
