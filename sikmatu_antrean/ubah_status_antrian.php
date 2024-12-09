<?php
require "../Sikmatu_LoginSign/koneksi.php";

// Ambil ID antrian
$id = $_GET['id'];

// Query untuk mengubah status antrian
$query = "UPDATE antrian SET status = 'selesai' WHERE id = '$id'";

if (mysqli_query($conn, $query)) {
    // Redirect ke halaman antrian
    header("Location: antrian.php");
    exit();
} else {
    echo "Error: " . mysqli_error($conn);
}
?>
