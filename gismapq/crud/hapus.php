<?php
include '../config/koneksi.php';

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Hapus data
    $query = mysqli_query($koneksi, "DELETE FROM mebel WHERE id='$id'");
    
    if($query) {
        echo "<script>
                alert('Data berhasil dihapus!');
                window.location.href='../data_mebel.php';
              </script>";
    } else {
        echo "<script>
                alert('Gagal menghapus data!');
                window.location.href='../data_mebel.php';
              </script>";
    }
} else {
    header('location: ../data_mebel.php');
}
?>
