<?php
require "../config/koneksi.php";

if (isset($_POST['selesai'])) {
    $id = intval($_POST['id']); // Validasi input angka

    // Tandai peserta yang sedang konsultasi menjadi selesai
    $query_update_selesai = "UPDATE antrian SET status = 'selesai' WHERE id = '$id'";
    if (!mysqli_query($conn, $query_update_selesai)) {
        die("Error: " . mysqli_error($conn));
    }

    // Pindahkan peserta berikutnya menjadi "sedang_konsultasi"
    $query_update_berikutnya = "UPDATE antrian 
                                SET status = 'sedang_konsultasi', waktu_mulai = NOW() 
                                WHERE status = 'menunggu' 
                                ORDER BY id ASC 
                                LIMIT 1";
    if (!mysqli_query($conn, $query_update_berikutnya)) {
        die("Error: " . mysqli_error($conn));
    }

    // Redirect kembali ke halaman antrian
    header("Location: antrian.php");
    exit();
}
?>
