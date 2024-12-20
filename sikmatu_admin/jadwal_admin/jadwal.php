<?php
require "../../Sikmatu_LoginSign/koneksi.php";
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../Sikmatu_LoginSign/koneksi.php");
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

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Konseling - Admin</title>
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
                        <li><i class="fa-regular fa-calendar"></i> <a href="../jadwal_admin/jadwal.php" class="link">Jadwal Konseling</a></li>
                        <li><i class="fa-solid fa-users"></i> <a href="../antrian_admin/antrian.php" class="link">Antrean Konseling</a></li>
                        <li><i class="fa-regular fa-comment"></i> <a href="../adminFeedback.php" class="link">Feedback</a></li>
                    </ul>
                </li>
                <li><i class="fa-solid fa-sign-out-alt"></i> <a href="../../Sikmatu_LoginSign/logout.php" class="link">Logout</a></li>
            </ul>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <header>
            <h1>Jadwal Konseling - Admin</h1>
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
                <a href="../jadwal_admin/jadwal.php">Lihat Detail →</a>
            </div>
            <div class="card yellow">
                <h2>Antrean Konseling</h2>
                <a href="../antrian_admin/antrian.php">Lihat Detail →</a>
            </div>
            <div class="card green">
                <h2>Feedback</h2>
                <a href="../adminFeedback.php">Lihat Detail →</a> <!-- Mengarahkan ke bagian feedback -->
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
                    <a href="../dashboard_dosen.php" class="btn btn-secondary " style="color:white">Kembali</a>

                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    </main>
</body>
</html> 
