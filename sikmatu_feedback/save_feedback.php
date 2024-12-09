<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $stars = $_POST['stars'];
    $message = $_POST['message'];

    $stmt = $conn->prepare("INSERT INTO feedback (email, stars, message) VALUES (?, ?, ?)");
    $stmt->bind_param("sis", $email, $stars, $message);

    if ($stmt->execute()) {
        echo "Feedback berhasil disimpan! <a href='index.html'>Kembali</a>";
    } else {
        echo "Terjadi kesalahan: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>
