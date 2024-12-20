<?php
require "../config/koneksi.php";

// Ambil ID dari URL
$id = $_GET['id'];

// Query Hapus
$query = "DELETE FROM jadwal_konseling WHERE id = $id";
mysqli_query($conn, $query);

// Redirect kembali ke halaman jadwal
header("Location: jadwal.php");
exit();
?>
