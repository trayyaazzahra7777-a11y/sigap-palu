<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Beranda') | SIGAP-PALU</title>
    
    <!-- Typography & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- Leaflet GIS Map CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    
    <style>
        :root {
            --primary: #059669;
            --primary-dark: #047857;
            --primary-light: #ecfdf5;
            --secondary: #0f172a;
            --surface: #ffffff;
            --bg: #f8fafc;
            --border: #e2e8f0;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg);
            color: var(--secondary);
            margin: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Top Announcement Ticker */
        .emergency-ticker {
            background-color: #0f172a;
            color: #94a3b8;
            font-size: 0.8rem;
            padding: 8px 0;
            border-bottom: 1px solid #1e293b;
        }
        .emergency-ticker a {
            color: #38bdf8;
            text-decoration: none;
        }

        /* Main Navigation */
        .navbar-main {
            background: rgba(255, 255, 255, 0.96);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border);
            padding: 12px 0;
            transition: all 0.3s;
        }
        .navbar-brand {
            font-weight: 800;
            font-size: 1.25rem;
            color: var(--secondary);
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .brand-icon {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background-color: var(--primary-light);
            color: var(--primary);
            border: 1px solid #a7f3d0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.15rem;
        }
        .nav-link {
            font-weight: 500;
            color: #475569 !important;
            padding: 8px 14px !important;
            border-radius: 8px;
            transition: all 0.2s ease;
        }
        .nav-link:hover, .nav-link.active {
            color: var(--primary) !important;
            background-color: var(--primary-light);
        }
        .dropdown-menu {
            border: 1px solid var(--border);
            box-shadow: 0 10px 25px -5px rgba(0,0,0,0.08);
            border-radius: 12px;
            padding: 8px;
        }
        .dropdown-item {
            border-radius: 6px;
            font-size: 0.9rem;
            padding: 8px 14px;
            font-weight: 500;
        }
        .dropdown-item:hover {
            background-color: var(--primary-light);
            color: var(--primary);
        }

        /* Buttons */
        .btn-emerald {
            background-color: var(--primary);
            color: #ffffff !important;
            border: 1px solid var(--primary);
            font-weight: 600;
            border-radius: 8px;
            padding: 8px 18px;
            transition: all 0.2s ease;
        }
        .btn-emerald:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
        }
        .btn-outline-emerald {
            background-color: transparent;
            color: var(--primary) !important;
            border: 1px solid var(--primary);
            font-weight: 600;
            border-radius: 8px;
            padding: 8px 18px;
            transition: all 0.2s ease;
        }
        .btn-outline-emerald:hover {
            background-color: var(--primary-light);
        }

        /* Badges */
        .badge-actual {
            background-color: #ecfdf5;
            color: #065f46;
            border: 1px solid #a7f3d0;
            font-weight: 700;
            font-size: 0.72rem;
            letter-spacing: 0.05em;
            padding: 4px 10px;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        .badge-simulation {
            background-color: #fffbeb;
            color: #92400e;
            border: 1px solid #fde68a;
            font-weight: 700;
            font-size: 0.72rem;
            letter-spacing: 0.05em;
            padding: 4px 10px;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        /* Content & Footer */
        .main-wrapper {
            flex: 1 0 auto;
        }
        footer {
            background-color: #0f172a;
            color: #94a3b8;
            font-size: 0.88rem;
            padding: 50px 0 25px 0;
            border-top: 1px solid #1e293b;
            flex-shrink: 0;
        }
        footer a {
            color: #cbd5e1;
            text-decoration: none;
            transition: color 0.2s;
        }
        footer a:hover {
            color: #34d399;
        }
    </style>
    @stack('styles')
</head>
<body>

   <!-- TOP TICKER: LIVE CLOCK -->
    <div class="bg-dark text-white py-1 border-bottom border-secondary">
        <div class="container d-flex justify-content-end align-items-center small">
            <div class="fw-bold text-warning font-monospace" style="letter-spacing: 1px;">
                <i class="bi bi-clock me-1"></i> <span id="liveClock">--:--:-- WITA</span>
            </div>
        </div>
    </div>

    <!-- MAIN NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-main sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('landing') }}">
                <div class="brand-icon">
                    <i class="bi bi-shield-check"></i>
                </div>
                <span>SIGAP<span style="color: var(--primary);">-PALU</span></span>
            </a>

            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarPublic" aria-controls="navbarPublic" aria-expanded="false" aria-label="Toggle navigation">
                <i class="bi bi-list fs-2 text-dark"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarPublic">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0 gap-1">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('landing') ? 'active' : '' }}" href="{{ route('landing') }}">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('public.monitoring') ? 'active' : '' }}" href="{{ route('public.monitoring') }}">Monitoring</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('public.peta') ? 'active' : '' }}" href="{{ route('public.peta') }}">Peta Risiko</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('public.sejarah') ? 'active' : '' }}" href="{{ route('public.sejarah') }}">Sejarah & Riwayat</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->routeIs('public.edukasi*') ? 'active' : '' }}" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Edukasi
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('public.edukasi.detail', 'gempa') }}"><i class="bi bi-activity text-danger me-2"></i> Gempa Bumi</a></li>
                            <li><a class="dropdown-item" href="{{ route('public.edukasi.detail', 'tsunami') }}"><i class="bi bi-water text-primary me-2"></i> Tsunami Teluk Palu</a></li>
                            <li><a class="dropdown-item" href="{{ route('public.edukasi.detail', 'likuifaksi') }}"><i class="bi bi-layers text-warning me-2"></i> Likuifaksi Aluvial</a></li>
                            <li><a class="dropdown-item" href="{{ route('public.edukasi.detail', 'sesar') }}"><i class="bi bi-geo text-danger me-2"></i> Sesar Palu-Koro</a></li>
                            <li><hr class="dropdown-divider my-1"></li>
                            <li><a class="dropdown-item" href="{{ route('public.edukasi') }}"><i class="bi bi-journal-text me-2"></i> Semua Materi Edukasi</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('public.mitigasi') ? 'active' : '' }}" href="{{ route('public.mitigasi') }}">Mitigasi & Kesiapsiagaan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('public.tentang') ? 'active' : '' }}" href="{{ route('public.tentang') }}">Tentang</a>
                    </li>
                </ul>

                <div class="d-flex align-items-center gap-2">
                    @auth
                        @php
                            $dashRoute = match(Auth::user()->role) {
                                'admin' => route('admin.dashboard'),
                                'operator' => route('operator.dashboard'),
                                default => route('user.dashboard'),
                            };
                        @endphp
                        <a href="{{ $dashRoute }}" class="btn btn-emerald">
                            <i class="bi bi-speedometer2 me-1"></i> Buka Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-emerald">
                            <i class="bi bi-box-arrow-in-right me-1"></i> Masuk
                        </a>
                        <a href="{{ route('register') }}" class="btn btn-emerald">
                            <i class="bi bi-person-plus me-1"></i> Daftar
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- CONTENT WRAPPER -->
    <main class="main-wrapper">
        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer>
        <div class="container">
            <div class="row g-4 mb-4">
                <div class="col-lg-4">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <div class="brand-icon" style="background:#1e293b; border-color:#334155; color:#34d399;">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <span class="fs-5 fw-bold text-white">SIGAP<span style="color: #34d399;">-PALU</span></span>
                    </div>
                    <p class="small text-muted mb-3">
                        Sistem Informasi Monitoring Kesiapsiagaan dan Risiko Bencana Gempa Bumi dan Tsunami di Kota Palu. Dikembangkan untuk proyek tugas mata kuliah Kajian Lingkungan Hidup (KLH).
                    </p>
                    <div class="small text-muted">
                        <i class="bi bi-geo-alt me-1"></i> Kota Palu, Provinsi Sulawesi Tengah, Indonesia
                    </div>
                </div>

                <div class="col-6 col-lg-2">
                    <h6 class="text-white fw-bold mb-3 small text-uppercase" style="letter-spacing: 0.05em;">Navigasi Publik</h6>
                    <ul class="list-unstyled small d-flex flex-column gap-2 mb-0">
                        <li><a href="{{ route('landing') }}">Beranda</a></li>
                        <li><a href="{{ route('public.monitoring') }}">Monitoring Terpadu</a></li>
                        <li><a href="{{ route('public.peta') }}">Peta Risiko WebGIS</a></li>
                        <li><a href="{{ route('public.sejarah') }}">Riwayat Bencana 2018</a></li>
                        <li><a href="{{ route('public.mitigasi') }}">Panduan Mitigasi</a></li>
                    </ul>
                </div>

                <div class="col-6 col-lg-3">
                    <h6 class="text-white fw-bold mb-3 small text-uppercase" style="letter-spacing: 0.05em;">Pusat Pengetahuan</h6>
                    <ul class="list-unstyled small d-flex flex-column gap-2 mb-0">
                        <li><a href="{{ route('public.edukasi.detail', 'gempa') }}">Dinamika Gempa Bumi Tektonik</a></li>
                        <li><a href="{{ route('public.edukasi.detail', 'tsunami') }}">Mekanisme Tsunami Teluk Palu</a></li>
                        <li><a href="{{ route('public.edukasi.detail', 'likuifaksi') }}">Fenomena Likuifaksi Aluvial</a></li>
                        <li><a href="{{ route('public.edukasi.detail', 'sesar') }}">Trase Sesar Aktif Palu-Koro</a></li>
                        <li><a href="{{ route('public.tentang') }}">Identifikasi 10 Komponen KLH</a></li>
                    </ul>
                </div>

                <div class="col-lg-3">
                    <h6 class="text-white fw-bold mb-3 small text-uppercase" style="letter-spacing: 0.05em;">Sumber Data Resmi</h6>
                    <ul class="list-unstyled small d-flex flex-column gap-2 mb-3">
                        <li class="d-flex align-items-center gap-2">
                            <span class="badge bg-success-subtle text-success border border-success-subtle" style="font-size: 0.65rem;">AKTIF</span>
                            <span>BMKG (Seismisitas Terbuka)</span>
                        </li>
                        <li class="d-flex align-items-center gap-2">
                            <span class="badge bg-success-subtle text-success border border-success-subtle" style="font-size: 0.65rem;">AKTIF</span>
                            <span>BIG (Pasut Teluk Palu)</span>
                        </li>
                        <li class="d-flex align-items-center gap-2">
                            <span class="badge bg-success-subtle text-success border border-success-subtle" style="font-size: 0.65rem;">AKTIF</span>
                            <span>Badan Geologi ESDM (Likuifaksi)</span>
                        </li>
                        <li class="d-flex align-items-center gap-2">
                            <span class="badge bg-success-subtle text-success border border-success-subtle" style="font-size: 0.65rem;">AKTIF</span>
                            <span>PuSGeN (Sesar Palu-Koro)</span>
                        </li>
                    </ul>
                    <div class="p-2 rounded bg-dark border border-secondary border-opacity-25 small" style="font-size: 0.75rem;">
                        <i class="bi bi-info-circle me-1 text-info"></i> SIGAP-PALU mengintegrasikan data terbuka resmi dan bukan merupakan portal pengganti BMKG.
                    </div>
                </div>
            </div>

            <!-- Perbaikan Teks dan Kontras Warna pada Footer -->
<p class="small text-secondary mb-3" style="color: #94a3b8 !important; line-height: 1.6;">
    Sistem Informasi Monitoring Kesiapsiagaan dan Risiko Bencana Gempa Bumi dan Tsunami di Kota Palu. Dikembangkan sebagai platform analitis Kajian Risiko Bencana (BNPB).
</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Leaflet GIS JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    @stack('scripts')

    <script>
        function updateLiveClock() {
            const timeDisplay = document.getElementById('liveClock');
            if (!timeDisplay) return;
            
            const now = new Date();
            const options = { 
                timeZone: 'Asia/Makassar',
                hour: '2-digit', 
                minute: '2-digit', 
                second: '2-digit', 
                hour12: false 
            };
            const timeString = now.toLocaleTimeString('id-ID', options);
            timeDisplay.innerHTML = timeString + ' WITA';
        }
        setInterval(updateLiveClock, 1000);
        updateLiveClock();
    </script>
</body>
</html>
