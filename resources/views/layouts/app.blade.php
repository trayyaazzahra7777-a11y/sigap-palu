<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') | SIGAP-PALU</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        :root {
            --sigap-teal: #0f766e;
            --sigap-light-bg: #f8fafc;
            --sigap-navy: #0f172a;
            --sigap-border: #e2e8f0;
        }
        * { box-sizing: border-box; }
        html, body {
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
            overflow-x: hidden; /* Menghilangkan geser kanan/kiri */
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--sigap-light-bg);
            color: var(--sigap-navy);
        }
        .sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background: #ffffff;
            border-right: 1px solid var(--sigap-border);
            z-index: 1050;
            display: flex;
            flex-direction: column;
        }
        .sidebar-brand {
            padding: 18px 20px;
            font-weight: 800;
            font-size: 1.15rem;
            color: var(--sigap-navy);
            display: flex;
            align-items: center;
            gap: 10px;
            border-bottom: 1px solid var(--sigap-border);
        }
        .brand-icon {
            width: 32px;
            height: 32px;
            background: #ccfbf1;
            color: var(--sigap-teal);
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .nav-link-custom {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 14px;
            color: #475569;
            text-decoration: none;
            font-size: 0.84rem;
            font-weight: 600;
            border-radius: 8px;
            margin: 2px 10px;
            transition: all 0.2s ease;
        }
        .nav-link-custom:hover, .nav-link-custom.active {
            background-color: #f0fdfa;
            color: var(--sigap-teal);
        }
        .main-wrapper {
            margin-left: 250px; /* Lebar pas berdampingan dengan sidebar */
            min-height: 100vh;
            width: calc(100% - 250px);
            display: flex;
            flex-direction: column;
            background-color: var(--sigap-light-bg);
        }
        .topbar {
            background: #ffffff;
            border-bottom: 1px solid var(--sigap-border);
            padding: 12px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .status-pill {
            background: #ecfdf5;
            color: #047857;
            font-size: 0.75rem;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 99px;
            border: 1px solid #a7f3d0;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .status-dot {
            width: 8px;
            height: 8px;
            background: #10b981;
            border-radius: 50%;
        }
        .card-custom {
            background: #ffffff;
            border: 1px solid var(--sigap-border);
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.02);
        }
        .badge-rendah { background-color: #ecfdf5; color: #047857; border: 1px solid #a7f3d0; }
        .badge-sedang { background-color: #fefce8; color: #a16207; border: 1px solid #fef08a; }
        .badge-tinggi { background-color: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; }
    </style>
</head>
<body>

    <!-- SIDEBAR TETAP DI KIRI -->
    <aside class="sidebar">
        <div class="sidebar-brand">
            <span class="brand-icon"><i class="bi bi-shield-check fs-5"></i></span>
            <span>SIGAP<span style="color: var(--sigap-teal);">-PALU</span></span>
        </div>
        <div class="py-2 flex-grow-1 overflow-y-auto">
            <div class="px-3 pb-2 text-uppercase text-muted" style="font-size: 0.68rem; font-weight: 700;">Monitoring Operasional</div>
            <a href="{{ route('dashboard') }}" class="nav-link-custom {{ request()->routeIs('dashboard') || request()->routeIs('portal') ? 'active' : '' }}"><i class="bi bi-grid-1x2"></i> Dashboard</a>
            <a href="{{ route('peta.risiko') }}" class="nav-link-custom {{ request()->routeIs('peta.risiko') ? 'active' : '' }}"><i class="bi bi-geo-alt"></i> Peta Risiko</a>
            <a href="{{ route('monitoring.index') }}" class="nav-link-custom {{ request()->routeIs('monitoring.index') ? 'active' : '' }}"><i class="bi bi-activity"></i> Monitoring Risiko</a>
            <a href="{{ route('monitoring.gempa') }}" class="nav-link-custom {{ request()->routeIs('monitoring.gempa') ? 'active' : '' }}"><i class="bi bi-broadcast-pin"></i> Data Gempa (BMKG)</a>
            <a href="{{ route('monitoring.laut') }}" class="nav-link-custom {{ request()->routeIs('monitoring.laut') ? 'active' : '' }}"><i class="bi bi-water"></i> Muka Laut (Simulasi)</a>
            <a href="{{ route('kesiapsiagaan') }}" class="nav-link-custom {{ request()->routeIs('kesiapsiagaan') ? 'active' : '' }}"><i class="bi bi-shield-shaded"></i> Kesiapsiagaan</a>
            <a href="{{ route('analisis') }}" class="nav-link-custom {{ request()->routeIs('analisis') ? 'active' : '' }}"><i class="bi bi-graph-up-arrow"></i> Analisis Potensi</a>
            <a href="{{ route('peringatan') }}" class="nav-link-custom {{ request()->routeIs('peringatan') ? 'active' : '' }}"><i class="bi bi-bell"></i> Peringatan Kondisi</a>
            <a href="{{ route('kejadian') }}" class="nav-link-custom {{ request()->routeIs('kejadian') ? 'active' : '' }}"><i class="bi bi-journal-text"></i> Kejadian Bencana</a>

            {{-- MENU OPERATOR & ADMIN --}}
            @if(in_array(auth()->user()->role ?? '', ['operator', 'admin']))
            <div class="px-3 pt-3 pb-2 text-uppercase text-muted" style="font-size: 0.68rem; font-weight: 700;">Akses Posko & Teknis</div>
            <a href="{{ route('indikator.index') }}" class="nav-link-custom {{ request()->routeIs('indikator.*') ? 'active' : '' }}"><i class="bi bi-sliders"></i> Manajemen Indikator</a>
            @endif

            {{-- MENU ADMIN --}}
            @if((auth()->user()->role ?? '') === 'admin')
            <div class="px-3 pt-3 pb-2 text-uppercase text-muted" style="font-size: 0.68rem; font-weight: 700;">Kendali Sistem</div>
            <a href="{{ route('admin.pengguna') }}" class="nav-link-custom {{ request()->routeIs('admin.pengguna') ? 'active' : '' }}"><i class="bi bi-people"></i> Manajemen Pengguna</a>
            <a href="{{ route('admin.log') }}" class="nav-link-custom {{ request()->routeIs('admin.log') ? 'active' : '' }}"><i class="bi bi-hdd-network"></i> Log Sumber Data</a>
            @endif
        </div>

        <div class="p-3 border-top bg-white">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="fw-bold small">{{ auth()->user()->name ?? 'Pengguna' }}</div>
                    @if((auth()->user()->role ?? '') === 'admin')
                        <span class="badge bg-dark text-white" style="font-size: 0.68rem;">ADMINISTRATOR</span>
                    @elseif((auth()->user()->role ?? '') === 'operator')
                        <span class="badge bg-primary text-white" style="font-size: 0.68rem;">OPERATOR POSKO</span>
                    @else
                        <span class="badge bg-secondary text-white" style="font-size: 0.68rem;">USER / WARGA</span>
                    @endif
                </div>
                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-light border text-danger" title="Keluar"><i class="bi bi-box-arrow-right"></i></button>
                </form>
            </div>
        </div>
    </aside>

    <!-- AREA KONTEN UTAMA BERDAMPINGAN -->
    <div class="main-wrapper">
        <header class="topbar">
            <div>
                <h6 class="mb-0 fw-bold">Monitoring Kesiapsiagaan & Risiko Bencana Kota Palu</h6>
                <small class="text-muted">Pusat Data Terpadu Kebencanaan Lembah & Teluk Palu</small>
            </div>
            <div class="d-flex align-items-center gap-3">
                <span class="status-pill"><span class="status-dot"></span> SISTEM TERHUBUNG</span>
                <span class="text-muted small">Data: {{ date('d M Y, H:i') }} WITA</span>
            </div>
        </header>

        <main class="p-3 flex-grow-1">
            @yield('content')
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @stack('scripts')
</body>
</html>