<?php
require "../config/koneksi.php";

// Validasi input dari form
if (isset($_POST['jadwal_id'], $_POST['nama_peserta'])) {
    $jadwal_id = mysqli_real_escape_string($conn, $_POST['jadwal_id']);
    $nama_peserta = mysqli_real_escape_string($conn, $_POST['nama_peserta']);

    // Validasi apakah jadwal_id benar-benar ada di tabel jadwal_konseling
    $query_check_jadwal = "SELECT id FROM jadwal_konseling WHERE id = '$jadwal_id' LIMIT 1";
    $result_check_jadwal = mysqli_query($conn, $query_check_jadwal);

    if (mysqli_num_rows($result_check_jadwal) > 0) {
        // Query untuk menambahkan data ke tabel antrian
        $query_insert = "INSERT INTO antrian (jadwal_id, nama_peserta) VALUES ('$jadwal_id', '$nama_peserta')";
        
        if (mysqli_query($conn, $query_insert)) {
            // Redirect ke halaman antrian dengan pesan sukses
            header("Location: antrian.php?success=1");
            exit();
        } else {
            // Tampilkan pesan error jika query gagal
            echo "Error saat menyimpan data: " . mysqli_error($conn);
        }
    } else {
        echo "Jadwal yang dipilih tidak valid.";
    }
} else {
    echo "Data yang diperlukan tidak lengkap.";
}
?>
