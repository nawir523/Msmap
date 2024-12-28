<?php
include '../config/koneksi.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Mebel</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        #map-picker {
            height: 400px;
            width: 100%;
            border-radius: 5px;
            margin-bottom: 10px;
        }
        .desa-marker {
            background: white;
            padding: 5px 10px;
            border-radius: 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            display: flex;
            align-items: center;
            gap: 5px;
        }
        .desa-marker i {
            color: #FF4444;
        }
        .desa-marker span {
            font-weight: bold;
            color: #333;
        }
    </style>
</head>
<body>
    <!-- Bagian navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="../index.php">SIG Mebel Sukosono</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="../index.php">Peta</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../data_mebel.php">Data Mebel</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Bagian form -->
    <div class="container mt-5">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Tambah Data Mebel</h5>
                <div>
                    <a href="../data_mebel.php" class="btn btn-secondary">Kembali ke Data</a>
                </div>
            </div>
            <div class="card-body">
                <form action="proses.php" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Nama Usaha</label>
                        <input type="text" class="form-control" name="nama_usaha" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Pemilik</label>
                        <input type="text" class="form-control" name="pemilik" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <textarea class="form-control" name="alamat" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Pilih Lokasi di Peta</label>
                        <div id="map-picker"></div>
                        <small class="text-muted">Klik pada peta untuk memilih lokasi</small>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Latitude</label>
                                <input type="text" class="form-control" name="latitude" id="latitude" required readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Longitude</label>
                                <input type="text" class="form-control" name="longitude" id="longitude" required readonly>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Telepon</label>
                        <input type="text" class="form-control" name="telepon" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jenis Produk</label>
                        <textarea class="form-control" name="jenis_produk" required></textarea>
                    </div>
                    <div class="mt-4">
                        <button type="submit" name="tambah" class="btn btn-primary">Simpan Data</button>
                        <a href="../data_mebel.php" class="btn btn-danger">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <!-- Map Script -->
    <script>
        // Koordinat pusat Desa Sukosono yang tepat
        var center = [-6.645804316662123, 110.67801079740568];
        
        // Inisialisasi peta dengan koordinat dan zoom yang tepat
        var mapPicker = L.map('map-picker', {
            center: center,
            zoom: 15,
            minZoom: 14,
            maxZoom: 20
        });

        // Tambahkan layer satelit sebagai default
        var googleSat = L.tileLayer('http://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}',{
            maxZoom: 20,
            subdomains:['mt0','mt1','mt2','mt3']
        }).addTo(mapPicker);

        // Layer OpenStreetMap sebagai alternatif
        var osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png');

        // Layer control
        var baseMaps = {
            "Satelit": googleSat,
            "OpenStreetMap": osm
        };

        L.control.layers(baseMaps).addTo(mapPicker);

        // Membuat batas area bundar
        var radius = 800; // radius dalam meter, sama dengan halaman awal
        var circle = L.circle(center, {
            radius: radius,
            color: '#FF4444',
            weight: 2,
            fillColor: '#FF4444',
            fillOpacity: 0.1
        }).addTo(mapPicker);

        // Menambahkan marker dengan ikon untuk nama desa
        var desaIcon = L.divIcon({
            className: 'desa-label',
            html: `<div class="desa-marker">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>Desa Sukosono</span>
                   </div>`,
            iconSize: [150, 35]
        });

        L.marker(center, {
            icon: desaIcon
        }).addTo(mapPicker);

        // Batasan area pan
        mapPicker.setMaxBounds([
            [-6.653804, 110.66901], // Batas barat daya
            [-6.637804, 110.68701]  // Batas timur laut
        ]);

        // Variabel untuk marker lokasi yang dipilih
        var selectedMarker;

        // Event ketika peta diklik
        mapPicker.on('click', function(e) {
            if (selectedMarker) {
                selectedMarker.remove();
            }
            selectedMarker = L.marker(e.latlng, {
                icon: L.divIcon({
                    className: 'selected-marker',
                    html: '<i class="fas fa-map-pin" style="color: #FF4444; font-size: 20px;"></i>',
                    iconSize: [20, 20],
                    iconAnchor: [10, 20]
                })
            }).addTo(mapPicker);
            document.getElementById('latitude').value = e.latlng.lat.toFixed(6);
            document.getElementById('longitude').value = e.latlng.lng.toFixed(6);
        });
    </script>
</body>
</html> 