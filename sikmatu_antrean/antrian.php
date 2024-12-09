<?php
require "../Sikmatu_LoginSign/koneksi.php";
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../DashboardSikmatu/sikmatuLog.php");
    exit();
}

// Ambil semua data antrian dengan join jadwal
$query = "SELECT a.id AS antrian_id, a.nama_peserta, a.status, j.tanggal, j.waktu, j.konselor 
          FROM antrian a 
          JOIN jadwal_konseling j ON a.jadwal_id = j.id 
          ORDER BY j.tanggal, j.waktu, a.id";
$result = mysqli_query($conn, $query);
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
                <?php $no = 1; ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= $row['nama_peserta']; ?></td>
                        <td><?= $row['tanggal']; ?></td>
                        <td><?= $row['waktu']; ?></td>
                        <td><?= $row['konselor']; ?></td>
                        <td>
                            <?php if ($row['status'] == 'menunggu'): ?>
                                <span class="badge bg-warning">Menunggu</span>
                            <?php else: ?>
                                <span class="badge bg-success">Selesai</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <!-- Tombol Ubah Status -->
                            <a href="ubah_status_antrian.php?id=<?= $row['antrian_id']; ?>" class="btn btn-primary btn-sm">Ubah Status</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

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
                    <a href="jadwal.php" class="btn btn-secondary ">Kembali</a>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>
