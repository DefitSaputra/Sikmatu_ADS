<?php
require "../Sikmatu_LoginSign/koneksi.php"; // Pastikan file koneksi tersedia
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: ../DashboardSikmatu/sikmatuLog.php");
    exit();
}

// Proses data ketika form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = htmlspecialchars($_POST['nama']);
    $email = htmlspecialchars($_POST['email']);
    $jadwal = htmlspecialchars($_POST['jadwal']);
    $keluhan = htmlspecialchars($_POST['keluhan']);
    $kontak = htmlspecialchars($_POST['kontak']); // Tambahan kontak

    // Validasi koneksi ke database
    if (!$conn) {
        die("Koneksi database gagal: " . mysqli_connect_error());
    }

    // Query untuk menyimpan data antrean
    $query = "INSERT INTO antrean_konseling (nama, email, jadwal, keluhan, kontak) VALUES ('$nama', '$email', '$jadwal', '$keluhan', '$kontak')";
    
    if (mysqli_query($conn, $query)) {
        $successMessage = "Antrean berhasil ditambahkan! Kontak Anda: $kontak.";
    } else {
        $errorMessage = "Error: " . $query . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Antrean</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Form Antrean Konseling</h2>
        <?php if (isset($successMessage)): ?>
            <div class="alert alert-success" role="alert">
                <?= $successMessage; ?>
            </div>
        <?php endif; ?>
        <?php if (isset($errorMessage)): ?>
            <div class="alert alert-danger" role="alert">
                <?= $errorMessage; ?>
            </div>
        <?php endif; ?>
        <form action="" method="POST">
            <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" class="form-control" id="nama" name="nama" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="jadwal" class="form-label">Jadwal Konseling</label>
                <input type="date" class="form-control" id="jadwal" name="jadwal" required>
            </div>
            <div class="mb-3">
                <label for="keluhan" class="form-label">Keluhan</label>
                <textarea class="form-control" id="keluhan" name="keluhan" rows="4" required></textarea>
            </div>
            <div class="mb-3">
                <label for="kontak" class="form-label">Kontak (No. Telepon)</label>
                <input type="text" class="form-control" id="kontak" name="kontak" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</body>
</html>
