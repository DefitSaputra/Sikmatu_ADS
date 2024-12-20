<?php
require "../Sikmatu_LoginSign/koneksi.php";
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../DashboardSikmatu/sikmatuLog.php");
    exit();
}

$userName = $_SESSION['username'];
$userRole = $_SESSION['role'];

$result = $conn->query("SELECT * FROM feedback ORDER BY created_at ASC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback - Konselor</title>
    <link rel="stylesheet" href="../sikmatu_feedback/style.css">
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
                        <li><i class="fa-regular fa-calendar"></i> <a href="jadwal_dosen/jadwal.php" class="link">Jadwal Konseling</a></li>
                        <li><i class="fa-solid fa-users"></i> <a href="antrian_dosen/antrian.php" class="link">Antrean Konseling</a></li>
                        <li><i class="fa-regular fa-comment"></i> <a href="dosenFeedback.php" class="link">Feedback</a></li>
                    </ul>
                </li>
                <li><i class="fa-solid fa-sign-out-alt"></i> <a href="../Sikmatu_LoginSign/logout.php" class="link">Logout</a></li>
            </ul>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <header>
            <h1>Halaman Feedback - Konselor</h1>
            <div class="profile">
                <img src="../img/6522516.png" alt="profile">
                <div class="dropdown">
                    <ul>
                        <li><a href="../Sikmatu_LoginSign/logout.php">Logout</a></li>
                    </ul>
                </div>
            </div>
        </header>

        <!-- Dashboard Cards -->
        <section class="cards">
            <div class="card blue">
                <h2>Jadwal Konseling</h2>
                <a href="jadwal_dosen/jadwal.php">Lihat Detail →</a>
            </div>
            <div class="card yellow">
                <h2>Antrean Konseling</h2>
                <a href="antrian_dosen/antrian.php">Lihat Detail →</a>
            </div>
            <div class="card green">
                <h2>Feedback</h2>
                <a href="dosenFeedback.php">Lihat Detail →</a> <!-- Mengarahkan ke bagian feedback -->
            </div>
        </section>

        <div class="container">
        <h1>Feedback Table</h1>
        <table>
            <thead>
                <tr>
                    <th>Email</th>
                    <th>Stars</th>
                    <th>Message</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars($row['stars']); ?></td>
                    <td><?php echo htmlspecialchars($row['message']); ?></td>
                    <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>


    </main>
</body>
</html> 
