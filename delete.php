<?php
include 'koneksi.php';

// hapus data
if (isset($_GET['delete'])) {
    $nim = mysqli_real_escape_string($conn, $_GET['delete']);
    
    // Jalankan Query Hapus
    $query = "DELETE FROM mahasiswa WHERE nim = '$nim'";
    
    if (mysqli_query($conn, $query)) {
        // kembali ke halaman admin
        header("Location: admin.php?pesan=hapus_berhasil");
        exit;
    }
}
?>