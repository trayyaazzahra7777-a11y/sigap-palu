<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>SIGAP-PALU | Sistem Informasi Kebencanaan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root {
            --emerald: #059669;
            --emerald-hover: #047857;
        }

        * {
            box-sizing: border-box;
        }

        body { 
            background-color: #f8fafc;
            background-image: 
                radial-gradient(#cbd5e1 1.2px, transparent 1.2px),
                linear-gradient(rgba(241, 245, 249, 0.90), rgba(241, 245, 249, 0.96)),
                url("https://images.unsplash.com/photo-1524661135-423995f22d0b?auto=format&fit=crop&w=1920&q=80");
            background-size: 28px 28px, cover, cover;
            background-position: center;
            color: #0f172a; 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            min-height: 100vh;
            margin: 0;
            display: flex;
            flex-direction: column;
        }

        .top-nav {
            padding: 16px 36px;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #ffffff;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.03);
            position: relative;
            z-index: 1000;
        }

        .brand-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background-color: #ecfdf5;
            color: var(--emerald);
            border: 1px solid #a7f3d0;
        }

        .main-content {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 40px 20px;
            position: relative;
            z-index: 1000;
        }

        .hero-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 24px;
            padding: 48px 40px;
            box-shadow: 0 20px 45px -15px rgba(15, 23, 42, 0.08), 0 0 1px 1px rgba(0, 0, 0, 0.02);
            max-width: 820px;
            width: 100%;
        }

        .hero-title {
            font-weight: 800;
            line-height: 1.3;
            color: #0f172a;
            font-size: clamp(2rem, 3.8vw, 2.7rem);
            margin-bottom: 18px;
        }

        .hero-desc {
            color: #475569;
            font-size: 1.05rem;
            line-height: 1.7;
            max-width: 660px;
            margin: 0 auto 34px auto;
        }

        /* Pastikan link tampil sebagai tombol dan bisa diklik */
        a.btn-emerald {
            background-color: var(--emerald);
            border: 1px solid var(--emerald);
            color: #ffffff !important;
            font-weight: 600;
            font-size: 0.95rem;
            padding: 13px 32px;
            border-radius: 12px;
            transition: all 0.2s ease;
            box-shadow: 0 4px 14px rgba(5, 150, 105, 0.25);
            display: inline-flex;
            align-items: center;
            text-decoration: none !important;
            cursor: pointer !important;
            pointer-events: auto !important;
        }

        a.btn-emerald:hover {
            background-color: var(--emerald-hover);
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(5, 150, 105, 0.35);
        }

        a.btn-outline-custom {
            border: 1px solid #cbd5e1;
            color: #334155 !important;
            background: #ffffff;
            font-weight: 600;
            font-size: 0.95rem;
            padding: 13px 32px;
            border-radius: 12px;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            text-decoration: none !important;
            cursor: pointer !important;
            pointer-events: auto !important;
            box-shadow: 0 2px 4px rgba(0,0,0,0.03);
        }

        a.btn-outline-custom:hover {
            border-color: #94a3b8;
            color: #0f172a !important;
            background: #f8fafc;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>

    <header class="top-nav">
        <a href="/" class="text-dark text-decoration-none fw-bold fs-5 d-flex align-items-center gap-2">
            <span class="brand-badge"><i class="bi bi-shield-check fs-5"></i></span>
            <span>SIGAP<span style="color: #059669;">-PALU</span></span>
        </a>
        <div class="d-flex gap-2">
            <a href="/login" class="btn btn-outline-custom py-2 px-4" style="font-size: 0.9rem;">Masuk</a>
            <a href="/register" class="btn btn-emerald py-2 px-4" style="font-size: 0.9rem;">Daftar</a>
        </div>
    </header>

    <main class="main-content">
        <div class="hero-card">
            <h1 class="hero-title">Sistem Informasi Monitoring Kesiapsiagaan dan Risiko Bencana Alam di Kota Palu</h1>
            <p class="hero-desc">
                Pusat pemantauan data gempa bumi real-time, telemetri pasang surut Teluk Palu, serta pemetaan jalur rawan bencana terpadu.
            </p>
            <div class="d-flex justify-content-center gap-3 flex-wrap">
                <a href="/login" class="btn-emerald">
                    <i class="bi bi-box-arrow-in-right me-2"></i>Masuk ke Sistem
                </a>
                <a href="/register" class="btn-outline-custom">
                    <i class="bi bi-person-plus me-2"></i>Daftar Akun Baru
                </a>
            </div>
        </div>
    </main>

</body>
</html>