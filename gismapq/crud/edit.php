<?php
include '../config/koneksi.php';

// Ambil data mebel berdasarkan ID
$id = $_GET['id'];
$query = mysqli_query($koneksi, "SELECT * FROM mebel WHERE id='$id'");
$data = mysqli_fetch_array($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Mebel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        #map-picker { height: 400px; width: 100%; border-radius: 5px; margin-bottom: 10px; }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Edit Data Mebel</h5>
                <a href="../data_mebel.php" class="btn btn-secondary">Kembali ke Data</a>
            </div>
            <div class="card-body">
                <form action="proses.php" method="POST">
                    <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
                    
                    <div class="mb-3">
                        <label class="form-label">Nama Usaha</label>
                        <input type="text" class="form-control" name="nama_usaha" value="<?php echo $data['nama_usaha']; ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Pemilik</label>
                        <input type="text" class="form-control" name="pemilik" value="<?php echo $data['pemilik']; ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <textarea class="form-control" name="alamat" required><?php echo $data['alamat']; ?></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Pilih Lokasi di Peta</label>
                        <div id="map-picker"></div>
                        <small class="text-muted">Klik pada peta untuk mengubah lokasi</small>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Latitude</label>
                                <input type="text" class="form-control" name="latitude" id="latitude" value="<?php echo $data['latitude']; ?>" required readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Longitude</label>
                                <input type="text" class="form-control" name="longitude" id="longitude" value="<?php echo $data['longitude']; ?>" required readonly>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Telepon</label>
                        <input type="text" class="form-control" name="telepon" value="<?php echo $data['telepon']; ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Jenis Produk</label>
                        <textarea class="form-control" name="jenis_produk" required><?php echo $data['jenis_produk']; ?></textarea>
                    </div>
                    
                    <div class="mt-4">
                        <button type="submit" name="edit" class="btn btn-primary">Update Data</button>
                        <a href="../data_mebel.php" class="btn btn-danger">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script>
        var center = [-6.645804316662123, 110.67801079740568];
        var mapPicker = L.map('map-picker', {
            center: center,
            zoom: 15,
            minZoom: 14,
            maxZoom: 20
        });

        var googleSat = L.tileLayer('http://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}',{
            maxZoom: 20,
            subdomains:['mt0','mt1','mt2','mt3']
        }).addTo(mapPicker);

        var radius = 800;
        var circle = L.circle(center, {
            radius: radius,
            color: '#FF4444',
            weight: 2,
            fillColor: '#FF4444',
            fillOpacity: 0.1
        }).addTo(mapPicker);

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

        // Menampilkan marker lokasi saat ini
        var currentLocation = [<?php echo $data['latitude']; ?>, <?php echo $data['longitude']; ?>];
        var selectedMarker = L.marker(currentLocation, {
            icon: L.divIcon({
                className: 'selected-marker',
                html: '<i class="fas fa-map-pin" style="color: #FF4444; font-size: 20px;"></i>',
                iconSize: [20, 20],
                iconAnchor: [10, 20]
            })
        }).addTo(mapPicker);

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
