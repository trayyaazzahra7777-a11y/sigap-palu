<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Portal Informasi Warga | SIGAP-PALU</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-white p-4">
    <div class="container">
        <h3>Portal Kesiapsiagaan Warga Kota Palu</h3>
        <p class="text-secondary">Informasi gempa bumi resmi BMKG, jalur evakuasi, dan status siaga teluk.</p>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button class="btn btn-danger btn-sm">Keluar</button>
        </form>
    </div>
</body>
</html>