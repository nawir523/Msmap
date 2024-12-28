<?php
include 'config/koneksi.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peta Usaha Mebel Sukosono</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">SIG Mebel Sukosono</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Peta</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="data_mebel.php">Data Mebel</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid mt-3">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Peta Persebaran Usaha Mebel Desa Sukosono</h5>
                    </div>
                    <div class="card-body">
                        <div id="map" style="height: 500px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script>
        // Koordinat yang tepat untuk Desa Sukosono, Kec. Kedung, Jepara
        var map = L.map('map').setView([-6.645804316662123, 110.67801079740568], 16);

        // Layer Satelit Google
        var googleSat = L.tileLayer('http://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}',{
            maxZoom: 20,
            subdomains:['mt0','mt1','mt2','mt3'],
            attribution: '© Google Satellite'
        }).addTo(map);

        // Layer Control
        var baseMaps = {
            "Satelit": googleSat,
            "OpenStreetMap": L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            })
        };

        L.control.layers(baseMaps).addTo(map);

        // Membuat batas area bundar
        var center = [-6.645804316662123, 110.67801079740568];
        var radius = 800; // radius dalam meter
        var circle = L.circle(center, {
            radius: radius,
            color: '#FF4444',
            weight: 2,
            fillColor: '#FF4444',
            fillOpacity: 0.1
        }).addTo(map);

        // Menambahkan marker dengan ikon kustom untuk nama desa
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
        }).addTo(map);

        // Batasan area pan dan zoom
        map.setMaxBounds([
            [-6.649804, 110.67301], // Batas barat daya
            [-6.641804, 110.68301]  // Batas timur laut
        ]);
        map.setMinZoom(14);
        map.setMaxZoom(20);

        // Marker untuk lokasi mebel
        <?php
        $query = mysqli_query($koneksi, "SELECT * FROM mebel");
        while($data = mysqli_fetch_array($query)){
        ?>
            L.marker([<?php echo $data['latitude']; ?>, <?php echo $data['longitude']; ?>])
            .bindPopup(`
                <div class="popup-content">
                    <h6><?php echo $data['nama_usaha']; ?></h6>
                    <p><strong>Pemilik:</strong> <?php echo $data['pemilik']; ?></p>
                    <p><strong>Telepon:</strong> <?php echo $data['telepon']; ?></p>
                    <p><strong>Alamat:</strong> <?php echo $data['alamat']; ?></p>
                    <p><strong>Jenis Produk:</strong> <?php echo $data['jenis_produk']; ?></p>
                </div>
            `)
            .addTo(map);
        <?php } ?>
    </script>
</body>
</html>