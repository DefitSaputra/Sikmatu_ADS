<?php
require "../../Sikmatu_LoginSign/koneksi.php";
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../Sikmatu_LoginSign/koneksi.php");
    exit();
}

$userName = $_SESSION['username'];
$userRole = $_SESSION['role'];

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
    <title>Antrian Konseling - Admin</title>
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
            <h1>Antrian Konseling - Admin</h1>
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
                <a href="antrian.php">Lihat Detail →</a>
            </div>
            <div class="card green">
                <h2>Feedback</h2>
                <a href="../adminFeedback.php">Lihat Detail →</a> <!-- Mengarahkan ke bagian feedback -->
            </div>
        </section>
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
                    <a href="../dashboard_dosen.php" class="btn btn-secondary " style="color:white">Kembali</a>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    </main>
</body>
</html> 
