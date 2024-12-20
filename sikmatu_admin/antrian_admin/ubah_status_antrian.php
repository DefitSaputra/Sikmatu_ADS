<?php
require "../config/koneksi.php";

if (isset($_POST['selesai'])) {
    $id = $_POST['id'];

    // Tandai peserta sebagai selesai
    $query_update_selesai = "UPDATE antrian SET status = 'selesai' WHERE id = '$id'";
    mysqli_query($conn, $query_update_selesai);

    // Pindahkan peserta berikutnya menjadi "sedang_konsultasi"
    $query_update_berikutnya = "UPDATE antrian SET status = 'sedang_konsultasi', waktu_mulai = NOW() 
                                WHERE status = 'menunggu' ORDER BY id ASC LIMIT 1";
    mysqli_query($conn, $query_update_berikutnya);

    header("Location: antrian.php");
}
?>
