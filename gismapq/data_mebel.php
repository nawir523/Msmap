<?php
include 'config/koneksi.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Usaha Mebel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <!-- Navbar sama seperti index.php -->
    
    <div class="container mt-3">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Data Usaha Mebel</h5>
                <div>
                    <a href="index.php" class="btn btn-info me-2">Kembali ke Peta</a>
                    <a href="crud/tambah.php" class="btn btn-primary">Tambah Data</a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Usaha</th>
                                <th>Pemilik</th>
                                <th>Alamat</th>
                                <th>Telepon</th>
                                <th>Koordinat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $query = mysqli_query($koneksi, "SELECT * FROM mebel ORDER BY id DESC");
                            while($data = mysqli_fetch_array($query)){
                            ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td><?php echo $data['nama_usaha']; ?></td>
                                <td><?php echo $data['pemilik']; ?></td>
                                <td><?php echo $data['alamat']; ?></td>
                                <td><?php echo $data['telepon']; ?></td>
                                <td><?php echo $data['latitude'].', '.$data['longitude']; ?></td>
                                <td>
                                    <a href="crud/edit.php?id=<?php echo $data['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                    <a href="crud/hapus.php?id=<?php echo $data['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html> 