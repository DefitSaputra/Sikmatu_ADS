<?php
require "../Sikmatu_LoginSign/koneksi.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tanggal = $_POST['tanggal'];
    $waktu = $_POST['waktu'];
    $konselor = $_POST['konselor'];
    $keterangan = $_POST['keterangan'];

    $query = "INSERT INTO jadwal_konseling (tanggal, waktu, konselor, keterangan) 
              VALUES ('$tanggal', '$waktu', '$konselor', '$keterangan')";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Jadwal berhasil ditambahkan!'); window.location.href='jadwal.php';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan jadwal: " . mysqli_error($conn) . "'); window.history.back();</script>";
    }
}
?>
