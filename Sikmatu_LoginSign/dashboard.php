<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: sikmatuLog.php");
    exit();
}

echo "Selamat datang, " . $_SESSION['username'] . "!<br>";
echo "Anda login sebagai " . $_SESSION['role'] . ".<br>";
?>

<a href="logout.php">Logout</a>
