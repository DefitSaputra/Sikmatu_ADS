<?php
require "../config/koneksi.php";

// Ambil data dari form
$jadwal_id = $_POST['jadwal_id'];
$nama_peserta = $_POST['nama_peserta'];

// Query untuk menambahkan data ke tabel antrian
$query = "INSERT INTO antrian (jadwal_id, nama_peserta) VALUES ('$jadwal_id', '$nama_peserta')";

if (mysqli_query($conn, $query)) {
    // Redirect ke halaman antrian
    header("Location: jadwal_mahasiswa.php");
    exit();
} else {
    echo "Error: " . mysqli_error($conn);
}
?>
