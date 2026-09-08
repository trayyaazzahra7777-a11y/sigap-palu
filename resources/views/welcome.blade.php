<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIGAP-PALU | Monitoring & Tren Risiko Bencana</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        #map { height: 380px; border-radius: 8px; }
        .card-stat { border: none; border-radius: 10px; color: white; }
    </style>
</head>
<body class="bg-light">

    <!-- Header / Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4 shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="#">🚨 SIGAP-PALU</a>
            <span class="navbar-text text-white d-none d-md-block">
                Sistem Informasi Monitoring Risiko & Kesiapsiagaan Bencana (2023 - 2026)
            </span>
            <button class="btn btn-primary btn-sm fw-bold" data-bs-toggle="modal" data-bs-target="#modalInput">
                + Input Data Berkala
            </button>
        </div>
    </nav>

    <div class="container-fluid py-4 px-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Panel Filter Interaktif -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body bg-white rounded">
                <div class="row g-3 align-items-center">
                    <div class="col-md-3">
                        <label class="form-label fw-bold mb-1">📅 Periode Tahun:</label>
                        <select id="filterTahun" class="form-select form-select-sm" onchange="filterData()">
                            <option value="2026" selected>Tahun 2026 (Terkini)</option>
                            <option value="2025">Tahun 2025</option>
                            <option value="2024">Tahun 2024</option>
                            <option value="2023">Tahun 2023</option>
                            <option value="all">Semua Tahun (Riwayat)</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold mb-1">📍 Wilayah / Kecamatan:</label>
                        <select id="filterKecamatan" class="form-select form-select-sm" onchange="filterData()">
                            <option value="all" selected>Semua Wilayah</option>
                            <option value="Palu Selatan">Palu Selatan</option>
                            <option value="Mantikulore">Mantikulore</option>
                            <option value="Palu Barat">Palu Barat</option>
                            <option value="Tawaeli">Tawaeli</option>
                        </select>
                    </div>
                    <div class="col-md-6 text-md-end mt-4">
                        <span class="badge bg-secondary p-2" id="infoPenyaringan">Menampilkan data tahun 2026</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- 1. Ringkasan Kartu Metrik Dinamis -->
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card card-stat bg-primary p-3 shadow-sm">
                    <h6>TITIK PANTAU AKTIF</h6>
                    <h2 class="fw-bold mb-0" id="statTitik">0</h2>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-stat bg-danger p-3 shadow-sm">
                    <h6>RISIKO TINGGI</h6>
                    <h2 class="fw-bold mb-0" id="statTinggi">0</h2>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-stat bg-warning p-3 shadow-sm">
                    <h6>RISIKO SEDANG</h6>
                    <h2 class="fw-bold mb-0" id="statSedang">0</h2>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-stat bg-success p-3 shadow-sm">
                    <h6>STATUS SIAP</h6>
                    <h2 class="fw-bold mb-0" id="statSiap">0</h2>
                </div>
            </div>
        </div>

        <!-- 2. Peta dan Grafik -->
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <div class="card shadow-sm border-0 p-3 h-100">
                    <h5 class="fw-bold mb-3">📍 Peta Sebaran Risiko Wilayah</h5>
                    <div id="map"></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card shadow-sm border-0 p-3 mb-3">
                    <h6 class="fw-bold mb-2">📊 Perbandingan Skor Risiko per Titik</h6>
                    <canvas id="chartBar" height="120"></canvas>
                </div>
                <div class="card shadow-sm border-0 p-3">
                    <h6 class="fw-bold mb-2">📈 Tren Perubahan Risiko Tahunan (2023 - 2026)</h6>
                    <canvas id="chartLine" height="120"></canvas>
                </div>
            </div>
        </div>

        <!-- 3. Tabel Data Monitoring -->
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0">📋 Rekap Data Pemantauan Berkala</h5>
                <input type="text" id="searchTable" class="form-control form-control-sm w-25" placeholder="Cari kelurahan/bencana..." onkeyup="searchTableRow()">
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped mb-0" id="dataTable">
                        <thead class="table-dark">
                            <tr>
                                <th>Tahun</th>
                                <th>Wilayah</th>
                                <th>Kecamatan</th>
                                <th>Potensi Bencana</th>
                                <th>Ancaman</th>
                                <th>Kapasitas</th>
                                <th>Skor Risiko</th>
                                <th>Status Risiko</th>
                                <th>Kesiapsiagaan</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Input Data Baru -->
    <div class="modal fade" id="modalInput" tabindex="-1">
        <div class="modal-dialog">
            <form action="{{ route('monitoring.store') }}" method="POST" class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Tambah Data Pemantauan Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col-4">
                            <label class="form-label">Tahun</label>
                            <input type="number" name="tahun" class="form-control" value="2026" required>
                        </div>
                        <div class="col-8">
                            <label class="form-label">Nama Wilayah / Kelurahan</label>
                            <input type="text" name="wilayah" class="form-control" placeholder="Contoh: Lere" required>
                        </div>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Kecamatan</label>
                        <select name="kecamatan" class="form-select" required>
                            <option value="Palu Barat">Palu Barat</option>
                            <option value="Palu Selatan">Palu Selatan</option>
                            <option value="Palu Timur">Palu Timur</option>
                            <option value="Palu Utara">Palu Utara</option>
                            <option value="Mantikulore">Mantikulore</option>
                            <option value="Tatanga">Tatanga</option>
                            <option value="Ulujadi">Ulujadi</option>
                            <option value="Tawaeli">Tawaeli</option>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Potensi Bencana</label>
                        <input type="text" name="bencana" class="form-control" placeholder="Contoh: Banjir & Longsor" required>
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <label class="form-label">Latitude</label>
                            <input type="number" step="any" name="lat" class="form-control" value="-0.8950" required>
                        </div>
                        <div class="col">
                            <label class="form-label">Longitude</label>
                            <input type="number" step="any" name="lng" class="form-control" value="119.8600" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label class="form-label">Ancaman (0-100)</label>
                            <input type="number" name="ancaman" class="form-control" min="0" max="100" required>
                        </div>
                        <div class="col">
                            <label class="form-label">Kerentanan (0-100)</label>
                            <input type="number" name="kerentanan" class="form-control" min="0" max="100" required>
                        </div>
                        <div class="col">
                            <label class="form-label">Kapasitas (0-100)</label>
                            <input type="number" name="kapasitas" class="form-control" min="0" max="100" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Hitung & Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Dependencies JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        const rawDataset = @json($allData);

        // Inisialisasi Peta
        const map = L.map('map').setView([-0.8917, 119.8707], 12);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        let markersLayer = L.layerGroup().addTo(map);

        // Inisialisasi Grafik Batang
        let barChart;
        const ctxBar = document.getElementById('chartBar').getContext('2d');
        barChart = new Chart(ctxBar, {
            type: 'bar',
            data: { labels: [], datasets: [{ label: 'Skor Risiko', data: [], backgroundColor: [] }] },
            options: { responsive: true, scales: { y: { beginAtZero: true, max: 100 } } }
        });

        // Inisialisasi Grafik Garis Tren Historis (2023 - 2026)
        const ctxLine = document.getElementById('chartLine').getContext('2d');
        const years = [2023, 2024, 2025, 2026];
        const lineChart = new Chart(ctxLine, {
            type: 'line',
            data: {
                labels: years,
                datasets: [
                    {
                        label: 'Petobo',
                        data: years.map(y => (rawDataset.find(d => d.tahun === y && d.wilayah === 'Petobo') || {}).risiko || null),
                        borderColor: '#dc3545',
                        tension: 0.3
                    },
                    {
                        label: 'Talise',
                        data: years.map(y => (rawDataset.find(d => d.tahun === y && d.wilayah === 'Talise') || {}).risiko || null),
                        borderColor: '#0d6efd',
                        tension: 0.3
                    },
                    {
                        label: 'Balaroa',
                        data: years.map(y => (rawDataset.find(d => d.tahun === y && d.wilayah === 'Balaroa') || {}).risiko || null),
                        borderColor: '#ffc107',
                        tension: 0.3
                    }
                ]
            },
            options: { responsive: true, scales: { y: { beginAtZero: true, max: 100 } } }
        });

        // Fungsi Filter Interaktif
        function filterData() {
            const thn = document.getElementById('filterTahun').value;
            const kec = document.getElementById('filterKecamatan').value;

            let filtered = rawDataset;
            if (thn !== 'all') {
                filtered = filtered.filter(item => item.tahun == thn);
            }
            if (kec !== 'all') {
                filtered = filtered.filter(item => item.kecamatan == kec);
            }

            document.getElementById('infoPenyaringan').innerText = `Menampilkan ${filtered.length} data (${thn === 'all' ? 'Semua Tahun' : 'Tahun ' + thn})`;

            // Perbarui Statistik Angka
            document.getElementById('statTitik').innerText = filtered.length;
            document.getElementById('statTinggi').innerText = filtered.filter(i => i.status_risiko === 'Tinggi').length;
            document.getElementById('statSedang').innerText = filtered.filter(i => i.status_risiko === 'Sedang').length;
            document.getElementById('statSiap').innerText = filtered.filter(i => i.kesiapsiagaan === 'Siap').length;

            // Perbarui Marker Peta
            markersLayer.clearLayers();
            filtered.forEach(item => {
                L.marker([item.lat, item.lng]).addTo(markersLayer)
                    .bindPopup(`<b>${item.wilayah}</b> (${item.tahun})<br>Kecamatan: ${item.kecamatan}<br>Potensi: ${item.bencana}<br>Skor Risiko: <b>${item.risiko}</b> (${item.status_risiko})`);
            });

            // Perbarui Bar Chart
            barChart.data.labels = filtered.map(i => `${i.wilayah} (${i.tahun})`);
            barChart.data.datasets[0].data = filtered.map(i => i.risiko);
            barChart.data.datasets[0].backgroundColor = filtered.map(i => i.status_risiko === 'Tinggi' ? '#dc3545' : (i.status_risiko === 'Sedang' ? '#ffc107' : '#198754'));
            barChart.update();

            // Perbarui Tabel
            renderTable(filtered);
        }

        function renderTable(data) {
            const tbody = document.getElementById('tableBody');
            tbody.innerHTML = '';
            data.forEach(item => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td><strong>${item.tahun}</strong></td>
                    <td>${item.wilayah}</td>
                    <td>${item.kecamatan}</td>
                    <td>${item.bencana}</td>
                    <td>${item.ancaman}</td>
                    <td>${item.kapasitas}</td>
                    <td><strong>${item.risiko}</strong></td>
                    <td><span class="badge ${item.status_risiko === 'Tinggi' ? 'bg-danger' : (item.status_risiko === 'Sedang' ? 'bg-warning text-dark' : 'bg-success')}">${item.status_risiko}</span></td>
                    <td><span class="badge ${item.kesiapsiagaan === 'Siap' ? 'bg-success' : (item.kesiapsiagaan === 'Cukup Siap' ? 'bg-warning text-dark' : 'bg-danger')}">${item.kesiapsiagaan}</span></td>
                `;
                tbody.appendChild(tr);
            });
        }

        function searchTableRow() {
            const input = document.getElementById("searchTable").value.toLowerCase();
            const rows = document.querySelectorAll("#tableBody tr");
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(input) ? "" : "none";
            });
        }

        // Render Awal saat Halaman Dimuat
        filterData();
    </script>
</body>
</html>