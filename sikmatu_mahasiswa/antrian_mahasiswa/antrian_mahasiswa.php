<?php
require "../config/koneksi.php";
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../DashboardSikmatu/sikmatuLog.php");
    exit();
}

// Logika untuk memperbarui status secara otomatis
$query_sedang_konsultasi = "SELECT id, waktu_mulai FROM antrian WHERE status = 'sedang_konsultasi' LIMIT 1";
$result_sedang_konsultasi = mysqli_query($conn, $query_sedang_konsultasi);
$sedang_konsultasi = mysqli_fetch_assoc($result_sedang_konsultasi);

if (!$sedang_konsultasi) {
    // Jika tidak ada peserta sedang konsultasi, pilih peserta pertama dalam status menunggu
    $query_update_sedang_konsultasi = "UPDATE antrian SET status = 'sedang_konsultasi', waktu_mulai = NOW() 
                                       WHERE status = 'menunggu' ORDER BY id ASC LIMIT 1";
    mysqli_query($conn, $query_update_sedang_konsultasi);
} else {
    // Periksa apakah konsultasi sudah selesai berdasarkan durasi (misal 30 menit)
    $waktu_mulai = $sedang_konsultasi['waktu_mulai'];
    $id_sedang_konsultasi = $sedang_konsultasi['id'];
    $durasi_konsultasi = 30; // dalam menit

    $query_durasi = "SELECT TIMESTAMPDIFF(MINUTE, '$waktu_mulai', NOW()) AS durasi";
    $result_durasi = mysqli_query($conn, $query_durasi);
    $durasi = mysqli_fetch_assoc($result_durasi);

    if ($durasi['durasi'] >= $durasi_konsultasi) {
        // Tandai peserta sebagai selesai
        $query_update_selesai = "UPDATE antrian SET status = 'selesai' WHERE id = '$id_sedang_konsultasi'";
        mysqli_query($conn, $query_update_selesai);

        // Pindahkan peserta berikutnya menjadi "sedang_konsultasi"
        $query_update_berikutnya = "UPDATE antrian SET status = 'sedang_konsultasi', waktu_mulai = NOW() 
                                    WHERE status = 'menunggu' ORDER BY id ASC LIMIT 1";
        mysqli_query($conn, $query_update_berikutnya);
    }
}

// Ambil semua data antrian dengan join jadwal
$query = "SELECT a.id AS antrian_id, a.nama_peserta, a.status, j.tanggal, j.waktu, j.konselor 
          FROM antrian a 
          JOIN jadwal_konseling j ON a.jadwal_id = j.id 
          ORDER BY j.tanggal, j.waktu, a.id";
$result = mysqli_query($conn, $query);

// Fungsi untuk mengganti nama peserta dengan format Peserta X
function samarkan_nama($no) {
    return "Peserta " . $no;  // Format nama peserta seperti Peserta 1, Peserta 2, dst.
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Antrian Konseling</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-5">
        <h1>Antrian Konseling</h1>
        <a href="../jadwal_mahasiswa/jadwal_mahasiswa.php" class="btn btn-secondary">Kembali ke Dashboard</a>
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Peserta</th>
                    <th>Tanggal</th>
                    <th>Waktu</th>
                    <th>Konselor</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 1; 
                while ($row = mysqli_fetch_assoc($result)): 
                ?>
                    <tr>
                        <td><?= $no; ?></td>
                        <td><?= htmlspecialchars(samarkan_nama($no)); ?></td> <!-- Nama Peserta diganti dengan "Peserta X" -->
                        <td><?= htmlspecialchars($row['tanggal']); ?></td>
                        <td><?= htmlspecialchars($row['waktu']); ?></td>
                        <td><?= htmlspecialchars($row['konselor']); ?></td>
                        <td>
                            <?php if ($row['status'] == 'menunggu'): ?>
                                <span class="badge bg-warning">Menunggu</span>
                            <?php elseif ($row['status'] == 'sedang_konsultasi'): ?>
                                <span class="badge bg-primary">Sedang Konsultasi</span>
                            <?php else: ?>
                                <span class="badge bg-success">Selesai</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php 
                $no++;
                endwhile; 
                ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>
