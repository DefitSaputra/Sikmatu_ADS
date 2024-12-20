<?php
require "../Sikmatu_LoginSign/koneksi.php";
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../Sikmatu_LoginSign/koneksi.php");
    exit();
}

$userName = $_SESSION['username'];
$userRole = $_SESSION['role'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../DashboardSikmatu/css/style.css">
    <script src="../DashboardSikmatu/js/script.js" defer></script>
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
            <a href="home.php" class="logo-link">
            <img src="../img/unsoed-logo.png" alt="Unsoed Logo" class="logo-img">
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
                        <li><i class="fa-regular fa-calendar"></i> <a href="jadwal.php" class="link">Jadwal Konseling</a></li>
                        <li><i class="fa-solid fa-users"></i> <a href="antrian.php" class="link">Antrean Konseling</a></li>
                        <li><i class="fa-regular fa-comment"></i> <a href="adminFeedback.php" class="link">Feedback</a></li>
                    </ul>
                </li>
                <li><i class="fa-solid fa-sign-out-alt"></i> <a href="logout.php" class="link">Logout</a></li>
            </ul>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <header>
            <h1>Dashboard</h1>
            <div class="profile">
                <img src="../img/6522516.png" alt="profile">
                <div class="dropdown">
                    <ul>
                        <li><a href="logout.php">Logout</a></li>
                    </ul>
                </div>
            </div>
        </header>

        <!-- Selamat Datang -->
        <div class="welcome-message">
            <h2>Halo, selamat Datang di Sikmatu, <?php echo htmlspecialchars($userName); ?>!</h2>
            <p>Anda login sebagai <?php echo htmlspecialchars($userRole); ?>.</p>
        </div>

        <!-- Dashboard Cards -->
        <section class="cards">
            <div class="card blue">
                <h2>Jadwal Konseling</h2>
                <a href="#">Lihat Detail →</a>
            </div>
            <div class="card yellow">
                <h2>Antrean Konseling</h2>
                <a href="#">Lihat Detail →</a>
            </div>
            <div class="card green">
                <h2>Feedback</h2>
                <a href="adminFeedback.php">Lihat Detail →</a> <!-- Mengarahkan ke bagian feedback -->
            </div>
        </section>

        <!-- Visi dan Misi -->
        <section class="vision-mission">
            <div class="vision">
                <h2>VISI</h2>
                <p>"Tim Bimbingan dan Konseling Unsoed mampu menyediakan layanan bimbingan dan konseling yang berkualitas bagi mahasiswa, turut mendukung UNSOED agar diakui dunia sebagai pusat pengembangan sumber daya pedesaan dan kearifan lokal."</p>
            </div>
            <div class="mission">
                <h2>MISI</h2>
                <ul>
                    <li>Menyediakan layanan bimbingan dan konseling yang berkualitas untuk mahasiswa.</li>
                    <li>Mempersiapkan mental mahasiswa dalam proses pendidikan sehingga dapat menyelesaikan studi secara tepat waktu.</li>
                    <li>Menyiapkan lulusan Unsoed yang berkarakter Jenderal Soedirman.</li>
                </ul>
            </div>
        </section>
        <!-- Cara Kerja -->
        <section class="workflow">
            <h2>PSOSEDUR KONSELING SIKMATU</h2>
            <div class="workflow-container">
                <div class="workflow-step">
                    <div class="icon">1</div>
                    <h3>Mahasiswa melihat jadwal dosen yang tersedia.</h3>
                </div>
                <div class="workflow-step">
                    <div class="icon">2</div>
                    <h3>Mahasiswa melakukan pengajuan konseling melalui form yang disediakan.</h3>
                </div>
                <div class="workflow-step">
                    <div class="icon">3</div>
                    <h3>Mahasiswa mengisi feedback setelah melakukan konseling.</h3>
                </div>
            </div>
        </section>
    </main>
</body>
</html> 
