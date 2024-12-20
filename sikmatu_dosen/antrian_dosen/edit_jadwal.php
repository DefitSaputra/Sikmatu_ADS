<?php
require "../Sikmatu_LoginSign/koneksi.php";
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../DashboardSikmatu/sikmatuLog.php");
    exit();
}

// Ambil ID dari parameter URL
$id = $_GET['id'];

// Query untuk mendapatkan data jadwal berdasarkan ID
$query = "SELECT * FROM jadwal_konseling WHERE id = '$id'";
$result = mysqli_query($conn, $query);

// Cek jika data ditemukan
if (!$result || mysqli_num_rows($result) == 0) {
    die("Data tidak ditemukan atau query gagal: " . mysqli_error($conn));
}

// Ambil data jadwal
$data = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Jadwal Konseling</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-5">
        <h1>Edit Jadwal Konseling</h1>
        <form action="proses_edit_jadwal.php" method="POST">
            <!-- Field ID (readonly) -->
            <div class="mb-3">
                <label for="id" class="form-label">ID</label>
                <input type="text" class="form-control" id="id" name="id" value="<?= $data['id']; ?>" readonly>
            </div>

            <!-- Field Tanggal -->
            <div class="mb-3">
                <label for="tanggal" class="form-label">Tanggal</label>
                <input type="date" class="form-control" id="tanggal" name="tanggal" value="<?= $data['tanggal']; ?>" required>
            </div>

            <!-- Field Waktu -->
            <div class="mb-3">
                <label for="waktu" class="form-label">Waktu</label>
                <input type="time" class="form-control" id="waktu" name="waktu" value="<?= $data['waktu']; ?>" required>
            </div>

            <!-- Field Konselor -->
            <div class="mb-3">
                <label for="konselor" class="form-label">Konselor</label>
                <input type="text" class="form-control" id="konselor" name="konselor" value="<?= $data['konselor']; ?>" required>
            </div>

            <!-- Field Keterangan -->
            <div class="mb-3">
                <label for="keterangan" class="form-label">Keterangan</label>
                <textarea class="form-control" id="keterangan" name="keterangan" rows="3" required><?= $data['keterangan']; ?></textarea>
            </div>

            <!-- Tombol Simpan -->
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="jadwal.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>
