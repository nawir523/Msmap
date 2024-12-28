<?php
include '../config/koneksi.php';

// Proses Tambah
if(isset($_POST['tambah'])){
    $nama_usaha = $_POST['nama_usaha'];
    $pemilik = $_POST['pemilik'];
    $alamat = $_POST['alamat'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $telepon = $_POST['telepon'];
    $jenis_produk = $_POST['jenis_produk'];

    $query = mysqli_query($koneksi, "INSERT INTO mebel (nama_usaha, pemilik, alamat, latitude, longitude, telepon, jenis_produk) 
                                    VALUES ('$nama_usaha', '$pemilik', '$alamat', '$latitude', '$longitude', '$telepon', '$jenis_produk')");

    if($query){
        header('location: ../data_mebel.php?pesan=tambah');
    }
}

// Proses Edit
if(isset($_POST['edit'])){
    $id = $_POST['id'];
    $nama_usaha = $_POST['nama_usaha'];
    $pemilik = $_POST['pemilik'];
    $alamat = $_POST['alamat'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $telepon = $_POST['telepon'];
    $jenis_produk = $_POST['jenis_produk'];

    $query = mysqli_query($koneksi, "UPDATE mebel SET 
                                    nama_usaha='$nama_usaha',
                                    pemilik='$pemilik',
                                    alamat='$alamat',
                                    latitude='$latitude',
                                    longitude='$longitude',
                                    telepon='$telepon',
                                    jenis_produk='$jenis_produk'
                                    WHERE id='$id'");

    if($query){
        echo "<script>
                alert('Data berhasil diupdate!');
                window.location.href='../data_mebel.php';
              </script>";
    } else {
        echo "<script>
                alert('Gagal mengupdate data!');
                window.location.href='../data_mebel.php';
              </script>";
    }
}
?> 