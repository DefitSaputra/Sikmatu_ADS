<?php
require "../config/koneksi.php";

// Ambil ID dari URL
$id = $_GET['id'];

// Hapus data terkait di tabel antrian
$query1 = "DELETE FROM antrian WHERE jadwal_id = $id";
mysqli_query($conn, $query1);

// Hapus data dari tabel jadwal_konseling
$query2 = "DELETE FROM jadwal_konseling WHERE id = $id";
mysqli_query($conn, $query2);

// Redirect kembali ke halaman jadwal
header("Location: jadwal.php");
exit();
?>
