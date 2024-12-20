<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validasi input untuk menghindari input kosong atau tidak sesuai
    $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
    $stars = filter_var($_POST['stars'], FILTER_VALIDATE_INT, [
        'options' => ['min_range' => 1, 'max_range' => 5]
    ]);
    $message = htmlspecialchars(trim($_POST['message']));

    // Periksa apakah semua input valid
    if (!$email || !$stars || empty($message)) {
        echo "Data tidak valid! Silakan isi semua kolom dengan benar. <a href='feedback.php'>Kembali</a>";
        exit();
    }

    // Siapkan dan eksekusi query
    $stmt = $conn->prepare("INSERT INTO feedback (email, stars, message) VALUES (?, ?, ?)");
    $stmt->bind_param("sis", $email, $stars, $message);

    if ($stmt->execute()) {
        echo "Feedback berhasil disimpan! <a href='feedback.php'>Kembali</a>";
    } else {
        echo "Terjadi kesalahan: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Metode request tidak valid.";
}
?>
