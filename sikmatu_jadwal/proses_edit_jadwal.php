<?php
require "../Sikmatu_LoginSign/koneksi.php";

// Ambil data dari form
$id = $_POST['id'];
$tanggal = $_POST['tanggal'];
$waktu = $_POST['waktu'];
$konselor = $_POST['konselor'];
$keterangan = $_POST['keterangan'];

// Query untuk update data ke database
$query = "UPDATE jadwal_konseling 
          SET tanggal = '$tanggal', 
              waktu = '$waktu', 
              konselor = '$konselor', 
              keterangan = '$keterangan' 
          WHERE id = '$id'";

// Eksekusi query
if (mysqli_query($conn, $query)) {
    // Redirect ke halaman jadwal setelah update berhasil
    header("Location: jadwal.php");
    exit();
} else {
    // Tampilkan error jika gagal
    echo "Error: " . mysqli_error($conn);
}
?>
