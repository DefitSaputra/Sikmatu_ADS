<?php
$servername = "localhost"; // Default untuk XAMPP
$username = "root";        // Default user XAMPP
$password = "";            // Password kosong (default)
$dbname = "sikmatu_user";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
