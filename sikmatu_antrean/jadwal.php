<?php
require "../Sikmatu_LoginSign/koneksi.php";
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
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?= $row['id']; ?></td>
                        <td><?= $row['tanggal']; ?></td>
                        <td><?= $row['waktu']; ?></td>
                        <td><?= $row['konselor']; ?></td>
                        <td><?= $row['keterangan']; ?></td>
                        <td>
                            <!-- Tombol Update -->
                            <a href="edit_jadwal.php?id=<?= $row['id']; ?>" class="btn btn-warning btn-sm">Update</a>

                            <!-- Tombol Silang -->
                            <a href="hapus_jadwal.php?id=<?= $row['id']; ?>" class="btn btn-danger btn-sm" 
                            onclick="return confirm('Yakin ingin menghapus jadwal ini?')">Silang</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <!-- Form Tambah Jadwal -->
        <div class="card mt-4">
            <div class="card-header">
                Tambah Jadwal Konseling
            </div>
            <div class="card-body">
                <form action="proses_tambah_jadwal.php" method="POST">
                    <div class="mb-3">
                        <label for="tanggal" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                    </div>
                    <div class="mb-3">
                        <label for="waktu" class="form-label">Waktu</label>
                        <input type="time" class="form-control" id="waktu" name="waktu" required>
                    </div>
                    <div class="mb-3">
                        <label for="konselor" class="form-label">Konselor</label>
                        <input type="text" class="form-control" id="konselor" name="konselor" required>
                    </div>
                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea class="form-control" id="keterangan" name="keterangan" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Tambah Jadwal</button>
                    <a href="home.php" class="btn btn-secondary ">Kembali</a>

                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>
