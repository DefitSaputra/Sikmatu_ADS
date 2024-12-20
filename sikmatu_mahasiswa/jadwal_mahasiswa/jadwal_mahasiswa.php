<?php
require "../../Sikmatu_LoginSign/koneksi.php";
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../DashboardSikmatu/sikmatuLog.php");
    exit();
}
$userName = $_SESSION['username'];
$userRole = $_SESSION['role'];

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
    <title>Jadwal Konseling - Mahasiswa</title>
    <link rel="stylesheet" href="../../DashboardSikmatu/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <script src="../../DashboardSikmatu/js/script.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
    <!-- Toggle Button -->
    <button id="sidebarToggle" class="toggle-btn">
        <i class="fa-solid fa-bars"></i>
    </button>

    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="logo">
            <a href="../home.php" class="logo-link">
            <img src="../../img/unsoed-logo.png" alt="Unsoed Logo" class="logo-img">
            SIKMATU
            </a>
        </div>
        <nav>
            <ul>
            <li class="active"><i class="fa-solid fa-globe"></i><a href="home.php" class="link"> Dashboard</a></li>
                <li class="has-submenu">
                    <i class="fa-solid fa-book"></i> Pages
                    <i class="fa-solid fa-chevron-down"></i>
                    <ul class="submenu">
                        <li><i class="fa-regular fa-calendar"></i> <a href="jadwal_mahasiswa.php" class="link">Jadwal Konseling</a></li>
                        <li><i class="fa-solid fa-users"></i> <a href="../antrian_mahasiswa/antrian_mahasiswa.php" class="link">Antrean Konseling</a></li>
                        <li><i class="fa-regular fa-comment"></i> <a href="../feedback.php" class="link">Feedback</a></li>
                    </ul>
                </li>
                <li><i class="fa-solid fa-sign-out-alt"></i> <a href="../../Sikmatu_LoginSign/logout.php" class="link">Logout</a></li>
            </ul>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <header>
            <h1>Jadwal Konseling - Mahasiswa</h1>
            <div class="profile">
                <img src="../../img/6522516.png" alt="profile">
                <div class="dropdown">
                    <ul>
                        <li><a href="../../Sikmatu_LoginSign/logout.php">Logout</a></li>
                    </ul>
                </div>
            </div>
        </header>

        <!-- Dashboard Cards -->
        <section class="cards">
            <div class="card blue">
                <h2>Jadwal Konseling</h2>
                <a href="jadwal_mahasiswa.php">Lihat Detail →</a>
            </div>
            <div class="card yellow">
                <h2>Antrean Konseling</h2>
                <a href="../antrian_mahasiswa/antrian_mahasiswa.php">Lihat Detail →</a>
            </div>
            <div class="card green">
                <h2>Feedback</h2>
                <a href="../feedback.php">Lihat Detail →</a> <!-- Mengarahkan ke bagian feedback -->
            </div>
        </section>

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
                    <a href="../home.php" class="btn btn-secondary" style="color:white">Kembali</a>
                </form>
            </div>
        </div>
    </div>

    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</html> 
