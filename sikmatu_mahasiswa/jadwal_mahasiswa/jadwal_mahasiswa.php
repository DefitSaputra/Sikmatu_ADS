<?php
require "../config/koneksi.php";
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../DashboardSikmatu/sikmatuLog.php");
    exit();
}

// Query ke database
$query = "SELECT * FROM jadwal_konseling";
$result = mysqli_query($conn, $query);

// Cek jika query berhasil
if (!$result) {
    die("Query gagal: " . mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Konseling</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-5">
        <h1>Jadwal Konseling</h1>
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tanggal</th>
                    <th>Waktu</th>
                    <th>Konselor</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['id']); ?></td>
                        <td><?= htmlspecialchars($row['tanggal']); ?></td>
                        <td><?= htmlspecialchars($row['waktu']); ?></td>
                        <td><?= htmlspecialchars($row['konselor']); ?></td>
                        <td><?= htmlspecialchars($row['keterangan']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <div class="container mt-5">
        <h1>Tambah Antrian Konseling</h1>

        <div class="card mt-4">
            <div class="card-header">Form Tambah Antrian</div>
            <div class="card-body">
                <form action="proses_mahasiswa_antrian.php" method="POST">
                    <div class="mb-3">
                        <label for="jadwal_id" class="form-label">Pilih Jadwal</label>
                        <select class="form-select" id="jadwal_id" name="jadwal_id" required>
                            <?php
                            $jadwal_query = "SELECT id, tanggal, waktu, konselor FROM jadwal_konseling ORDER BY tanggal, waktu";
                            $jadwal_result = mysqli_query($conn, $jadwal_query);
                            while ($jadwal = mysqli_fetch_assoc($jadwal_result)):
                            ?>
                                <option value="<?= htmlspecialchars($jadwal['id']); ?>">
                                    <?= htmlspecialchars($jadwal['tanggal'] . " - " . $jadwal['waktu'] . " (Konselor: " . $jadwal['konselor'] . ")"); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="nama_peserta" class="form-label">Nama Peserta</label>
                        <input type="text" class="form-control" id="nama_peserta" name="nama_peserta" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Tambah Antrian</button>
                    <a href="../dashboard_mahasiswa.php" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>
