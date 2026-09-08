<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Masuk | SIGAP-PALU</title>
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

        body { 
            background: 
                radial-gradient(circle at 50% 15%, rgba(16, 185, 129, 0.08) 0%, transparent 50%),
                linear-gradient(rgba(248, 250, 252, 0.92), rgba(241, 245, 249, 0.95)),
                url("https://images.unsplash.com/photo-1524661135-423995f22d0b?auto=format&fit=crop&w=1920&q=80") center/cover fixed;
            color: #0f172a; 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            min-height: 100vh;
            margin: 0;
            padding: 25px 15px;
            position: relative;
        }

        body::before {
            content: "";
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background-image: 
                radial-gradient(rgba(5, 150, 105, 0.18) 1px, transparent 1px),
                linear-gradient(rgba(148, 163, 184, 0.08) 1px, transparent 1px),
                linear-gradient(90deg, rgba(148, 163, 184, 0.08) 1px, transparent 1px);
            background-size: 24px 24px, 48px 48px, 48px 48px;
            pointer-events: none;
            z-index: 1;
        }

        .card-auth { 
            position: relative;
            z-index: 10;
            background: #ffffff;
            border: 1px solid #e2e8f0; 
            border-radius: 20px; 
            width: 100%; 
            max-width: 420px;
            box-shadow: 0 20px 40px -15px rgba(15, 23, 42, 0.08), 0 0 1px 1px rgba(0,0,0,0.02);
        }

        .icon-circle {
            width: 58px;
            height: 58px;
            background: #ecfdf5;
            color: var(--emerald);
            border: 1px solid #a7f3d0;
            border-radius: 14px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .form-label {
            color: #334155;
            font-weight: 600;
        }

        .form-control {
            background-color: #f8fafc !important;
            border: 1px solid #cbd5e1 !important;
            color: #0f172a !important;
            padding: 11px 14px;
            border-radius: 10px;
            font-weight: 500;
        }

        .form-control::placeholder {
            color: #94a3b8 !important;
            font-weight: 400;
        }

        .form-control:focus {
            background-color: #ffffff !important;
            border-color: #059669 !important;
            box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.15) !important;
        }

        .input-group .btn-toggle-eye {
            background-color: #f8fafc;
            border: 1px solid #cbd5e1;
            border-left: none;
            color: #64748b;
            border-top-right-radius: 10px !important;
            border-bottom-right-radius: 10px !important;
        }

        .input-group .btn-toggle-eye:hover {
            color: #0f172a;
            background-color: #f1f5f9;
        }

        .input-group .form-control.border-eye {
            border-right: none !important;
            border-top-right-radius: 0 !important;
            border-bottom-right-radius: 0 !important;
        }

        .btn-emerald {
            background-color: var(--emerald);
            border: none;
            color: #ffffff;
            font-weight: 600;
            padding: 12px;
            border-radius: 10px;
            transition: all 0.2s ease;
            box-shadow: 0 4px 12px rgba(5, 150, 105, 0.25);
        }

        .btn-emerald:hover {
            background-color: var(--emerald-hover);
            color: #ffffff;
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(5, 150, 105, 0.35);
        }
    </style>
</head>
<body>
    <div class="card-auth p-4 p-sm-5">
        <div class="text-center mb-4">
            <div class="icon-circle mb-3">
                <i class="bi bi-shield-lock fs-3"></i>
            </div>
            <h4 class="fw-bold text-dark mb-1">SIGAP<span style="color: #059669;">-PALU</span></h4>
            <p class="text-muted small mb-0">Masuk untuk mengakses sistem informasi</p>
        </div>

        <form action="/login" method="POST" novalidate>
            @csrf
            
            <div class="mb-3">
                <label class="form-label small">Alamat Email</label>
                <input type="email" 
                       name="email" 
                       value="{{ old('email') }}" 
                       class="form-control @error('email') is-invalid @enderror" 
                       placeholder="nama@email.com" 
                       required 
                       autofocus>
                @error('email')
                    <div class="invalid-feedback d-block text-danger small mt-1">
                        <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-4">
                <label class="form-label small">Kata Sandi</label>
                <div class="input-group">
                    <input type="password" 
                           id="loginPasswordInput"
                           name="password" 
                           class="form-control border-eye @error('password') is-invalid @enderror" 
                           placeholder="••••••••" 
                           required>
                    <button class="btn btn-toggle-eye" type="button" onclick="toggleVisibility('loginPasswordInput', 'eyeIconLogin')">
                        <i class="bi bi-eye" id="eyeIconLogin"></i>
                    </button>
                </div>
                @error('password')
                    <div class="invalid-feedback d-block text-danger small mt-1">
                        <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                    </div>
                @enderror
            </div>

            <button type="submit" class="btn btn-emerald w-100">Masuk</button>
        </form>

        <div class="text-center mt-4 pt-3 border-top border-light-subtle">
            <span class="text-muted small">Belum punya akun?</span>
            <a href="/register" class="text-decoration-none small fw-semibold ms-1" style="color: #059669;">Daftar sekarang</a>
        </div>
    </div>

    <script>
        function toggleVisibility(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove("bi-eye");
                icon.classList.add("bi-eye-slash");
            } else {
                input.type = "password";
                icon.classList.remove("bi-eye-slash");
                icon.classList.add("bi-eye");
            }
        }
    </script>
</body>
</html>