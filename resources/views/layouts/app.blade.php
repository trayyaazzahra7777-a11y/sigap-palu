<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') | SIGAP-PALU</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8fafc; }
        .sidebar { width: 280px; background: #ffffff; border-right: 1px solid #e2e8f0; position: fixed; top: 0; bottom: 0; left: 0; z-index: 100; transition: all 0.3s; }
        .main-content { margin-left: 280px; min-height: 100vh; display: flex; flex-direction: column; }
        .navbar-top { background: #ffffff; border-bottom: 1px solid #e2e8f0; height: 70px; }
        .nav-link { color: #475569; font-weight: 500; border-radius: 8px; margin-bottom: 4px; padding: 10px 16px; transition: all 0.2s; }
        .nav-link:hover { background-color: #f1f5f9; color: #059669; }
        .nav-link.active { background-color: #ecfdf5; color: #059669; font-weight: 600; }
        .brand-logo { font-size: 1.25rem; font-weight: 700; color: #0f172a; text-decoration: none; display: flex; align-items: center; gap: 10px; padding: 24px 20px; border-bottom: 1px solid #f1f5f9; }
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .main-content { margin-left: 0; }
        }
    </style>
</head>
<body>

    <!-- SIDEBAR -->
    <div class="sidebar d-flex flex-column">
        <a href="{{ route('landing') }}" class="brand-logo">
            <div style="width: 36px; height: 36px; background: #ecfdf5; color: #059669; border-radius: 8px; display: flex; align-items: center; justify-content: center; border: 1px solid #a7f3d0;">
                <i class="bi bi-shield-check"></i>
            </div>
            <span>SIGAP<span style="color: #059669;">-PALU</span></span>
        </a>

        <div class="p-3 flex-grow-1 overflow-auto">
            <small class="text-uppercase text-muted fw-bold px-3 mb-2 d-block" style="font-size: 0.7rem;">Menu Utama</small>
            <ul class="nav flex-column gap-1">
                @if(Auth::user()->role === 'admin')
                    <li><a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><i class="bi bi-speedometer2 me-2"></i> Dashboard Admin</a></li>
                    <li><a href="{{ route('admin.users') }}" class="nav-link {{ request()->routeIs('admin.users') ? 'active' : '' }}"><i class="bi bi-people me-2"></i> Manajemen Pengguna</a></li>
                   <a href="{{ route('admin.indikator') }}" class="nav-link {{ request()->routeIs('admin.indikator') ? 'active' : '' }}">
    <i class="bi bi-sliders me-2"></i> Indikator Risiko
</a>
                    <li><a href="{{ route('admin.logs') }}" class="nav-link {{ request()->routeIs('admin.logs') ? 'active' : '' }}"><i class="bi bi-clock-history me-2"></i> Audit Trail &amp; Log</a></li>
                @elseif(Auth::user()->role === 'operator')
                    <li><a href="{{ route('operator.dashboard') }}" class="nav-link {{ request()->routeIs('operator.dashboard') ? 'active' : '' }}"><i class="bi bi-speedometer2 me-2"></i> Posko Operator</a></li>
                    <li><a href="{{ route('operator.peringatan') }}" class="nav-link {{ request()->routeIs('operator.peringatan*') ? 'active' : '' }}"><i class="bi bi-bell-fill me-2 text-warning"></i> Siaran Peringatan Dini</a></li>
                    <li><a href="{{ route('operator.kejadian') }}" class="nav-link {{ request()->routeIs('operator.kejadian*') ? 'active' : '' }}"><i class="bi bi-shield-exclamation me-2 text-danger"></i> Kejadian Bencana</a></li>
                    <li><a href="{{ route('operator.muka-laut') }}" class="nav-link {{ request()->routeIs('operator.muka-laut*') ? 'active' : '' }}"><i class="bi bi-water me-2 text-info"></i> Input Pasang Surut</a></li>
                @else
                    <li><a href="{{ route('user.dashboard') }}" class="nav-link {{ request()->routeIs('user.dashboard') ? 'active' : '' }}"><i class="bi bi-speedometer2 me-2"></i> Dashboard Warga</a></li>
                    <li><a href="{{ route('user.simulasi') }}" class="nav-link {{ request()->routeIs('user.simulasi*') ? 'active' : '' }}"><i class="bi bi-cpu me-2 text-primary"></i> Simulasi Bencana</a></li>
                    <li><a href="{{ route('user.unduh-kajian') }}" class="nav-link {{ request()->routeIs('user.unduh-kajian') ? 'active' : '' }}"><i class="bi bi-file-earmark-text me-2 text-success"></i> Unduh Kajian Wilayah</a></li>
                @endif
                
                <li class="border-top my-2 pt-2">
                    <small class="text-uppercase text-muted fw-bold px-3 mb-2 d-block" style="font-size: 0.7rem;">Navigasi Publik</small>
                </li>
                <li><a href="{{ route('public.peta') }}" class="nav-link" target="_blank"><i class="bi bi-map me-2 text-emerald"></i> WebGIS Terbuka</a></li>
                <li><a href="{{ route('landing') }}" class="nav-link" target="_blank"><i class="bi bi-globe me-2"></i> Beranda Publik</a></li>
            </ul>
        </div>

        <!-- USER INFO DI BAWAH SIDEBAR -->
        <div class="p-3 border-top bg-light">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <div>
                    <h6 class="mb-0 fw-bold text-dark" style="font-size: 0.9rem;">{{ Auth::user()->name }}</h6>
                    <span class="badge bg-success text-uppercase" style="font-size: 0.65rem;">{{ Auth::user()->role }}</span>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-outline-danger btn-sm w-100 mt-2 rounded-2"><i class="bi bi-box-arrow-right me-1"></i> Keluar</button>
            </form>
        </div>
    </div>

    <!-- MAIN CONTENT AREA -->
    <div class="main-content">
        <!-- TOPBAR -->
        <nav class="navbar navbar-top px-4 d-flex justify-content-between align-items-center">
            <h5 class="fw-bold mb-0 text-dark">@yield('header-title', 'Dashboard')</h5>
            <div class="text-muted small">
                <i class="bi bi-calendar-event me-1"></i> {{ date('d M Y') }}
            </div>
        </nav>

        <!-- KONTEN UTAMA -->
        <div class="p-4 flex-grow-1">
            @yield('content')
        </div>

        <!-- FOOTER -->
        <footer class="text-center py-3 text-muted small border-top bg-white">
            &copy; {{ date('Y') }} SIGAP-PALU &bull; Pusat Mitigasi Bencana Kota Palu
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>