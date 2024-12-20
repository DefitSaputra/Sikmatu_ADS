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

// Fungsi untuk menyamarkan nama peserta
function samarkan_nama($nama) {
    $split = explode(" ", $nama);
    if (count($split) > 1) {
        // Hanya tampilkan inisial pertama dan nama belakang
        return substr($split[0], 0, 1) . ". " . $split[count($split) - 1];
    } else {
        // Jika hanya satu kata, tampilkan inisialnya saja
        return substr($split[0], 0, 1) . ".";
    }
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
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Peserta</th>
                    <th>Tanggal</th>
                    <th>Waktu</th>
                    <th>Konselor</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 1; 
                while ($row = mysqli_fetch_assoc($result)): 
                ?>
                    <tr>
                        <td><?= $no; ?></td>
                        <td><?= htmlspecialchars(samarkan_nama($row['nama_peserta'])); ?></td> <!-- Nama Peserta disamarkan -->
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
                        <td>
                            <?php if ($row['status'] == 'sedang_konsultasi'): ?>
                                <form method="POST" action="ubah_status_antrian.php">
                                    <input type="hidden" name="id" value="<?= $row['antrian_id']; ?>">
                                    <button type="submit" name="selesai" class="btn btn-success btn-sm">Selesaikan</button>
                                </form>
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

        <!-- Form Tambah Antrian -->
    <div class="card mt-4">
            <div class="card-header">Tambah Antrian</div>
            <div class="card-body">
                <form action="proses_tambah_antrian.php" method="POST">
                    <div class="mb-3">
                        <label for="jadwal_id" class="form-label">Pilih Jadwal</label>
                        <select class="form-select" id="jadwal_id" name="jadwal_id" required>
                            <?php
                            $jadwal_query = "SELECT id, tanggal, waktu, konselor FROM jadwal_konseling ORDER BY tanggal, waktu";
                            $jadwal_result = mysqli_query($conn, $jadwal_query);
                            while ($jadwal = mysqli_fetch_assoc($jadwal_result)):
                            ?>
                                <option value="<?= $jadwal['id']; ?>">
                                    <?= $jadwal['tanggal'] . " - " . $jadwal['waktu'] . " (Konselor: " . $jadwal['konselor'] . ")"; ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="nama_peserta" class="form-label">Nama Peserta</label>
                        <input type="text" class="form-control" id="nama_peserta" name="nama_peserta" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Tambah Antrian</button>
                    <a href="../dashboard_dosen.php" class="btn btn-secondary ">Kembali</a>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>
