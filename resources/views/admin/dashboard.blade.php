<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin SIGAP-PALU</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-white p-4">
    <div class="container">
        <h3>Panel Super Admin SIGAP-PALU</h3>
        <p class="text-secondary">Kelola Akun Operator, Master Wilayah, dan Konfigurasi Sensor.</p>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button class="btn btn-danger btn-sm">Keluar</button>
        </form>
    </div>
</body>
</html>