<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar | SIGAP-PALU</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f1f5f9; }
        .auth-card { background: #ffffff; border: 1px solid #e2e8f0; border-radius: 20px; box-shadow: 0 20px 25px -5px rgba(15, 23, 42, 0.05); padding: 40px; }
        .btn-emerald { background-color: #059669; border-color: #059669; color: #fff; font-weight: 600; padding: 12px; border-radius: 10px; transition: all 0.2s; }
        .btn-emerald:hover { background-color: #047857; color: #fff; transform: translateY(-1px); }
        .form-control { padding: 12px 16px; border-radius: 10px; border: 1px solid #cbd5e1; }
        .form-control:focus { border-color: #059669; box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.1); z-index: 1;}
        .input-group-text-btn { border-radius: 0 10px 10px 0; border: 1px solid #cbd5e1; background: #fff; border-left: none; color: #64748b;}
        .form-control-password { border-radius: 10px 0 0 10px; border-right: none; }
        .form-control-password:focus + .input-group-text-btn { border-color: #059669; }
        .brand-icon { width: 48px; height: 48px; background-color: #ecfdf5; color: #059669; border-radius: 12px; display: inline-flex; align-items: center; justify-content: center; font-size: 1.5rem; border: 1px solid #a7f3d0; mb-3; }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center min-vh-100 py-5">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                
                <div class="text-center mb-4">
                    <a href="{{ route('landing') }}" class="text-decoration-none text-dark">
                        <div class="brand-icon mx-auto mb-3"><i class="bi bi-shield-check"></i></div>
                        <h4 class="fw-bold mb-0">SIGAP<span style="color: #059669;">-PALU</span></h4>
                    </a>
                </div>

                <div class="auth-card">
                    <h5 class="fw-bold mb-4 text-center">Buat Akun Baru</h5>

                    <form action="{{ route('register.post') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Nama Lengkap</label>
                            <!-- Validasi HTML5 ditambahkan di sini: pattern, minlength, maxlength -->
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Misal: Trayya Azzahra" pattern="^[a-zA-Z\s\.\']+$" title="Nama hanya boleh berisi huruf dan spasi." minlength="3" maxlength="100" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Alamat Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="contoh@email.com" required>
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Kata Sandi</label>
                            <div class="input-group">
                                <input type="password" name="password" id="password" class="form-control form-control-password @error('password') is-invalid @enderror" placeholder="Minimal 8 karakter" minlength="8" required>
                                <button class="btn input-group-text-btn" type="button" id="togglePassword">
                                    <i class="bi bi-eye" id="eyeIcon"></i>
                                </button>
                            </div>
                            @error('password') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold small">Konfirmasi Kata Sandi</label>
                            <div class="input-group">
                                <input type="password" name="password_confirmation" id="passwordConfirm" class="form-control form-control-password" placeholder="Ulangi kata sandi" minlength="8" required>
                                <button class="btn input-group-text-btn" type="button" id="togglePasswordConfirm">
                                    <i class="bi bi-eye" id="eyeIconConfirm"></i>
                                </button>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-emerald w-100 mb-3">Daftar Sekarang <i class="bi bi-person-plus ms-1"></i></button>
                    </form>

                    <div class="text-center mt-3">
                        <span class="text-muted small">Sudah punya akun?</span>
                        <a href="{{ route('login') }}" class="text-decoration-none fw-semibold small" style="color: #059669;">Masuk di sini</a>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        // Toggle Password Utama
        document.querySelector('#togglePassword').addEventListener('click', function () {
            const password = document.querySelector('#password');
            const icon = document.querySelector('#eyeIcon');
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            icon.classList.toggle('bi-eye');
            icon.classList.toggle('bi-eye-slash');
        });

        // Toggle Konfirmasi Password
        document.querySelector('#togglePasswordConfirm').addEventListener('click', function () {
            const passwordConfirm = document.querySelector('#passwordConfirm');
            const iconConfirm = document.querySelector('#eyeIconConfirm');
            const type = passwordConfirm.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordConfirm.setAttribute('type', type);
            iconConfirm.classList.toggle('bi-eye');
            iconConfirm.classList.toggle('bi-eye-slash');
        });
    </script>
</body>
</html>