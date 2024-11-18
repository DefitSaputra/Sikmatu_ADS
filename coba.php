<?php
// PHP code for logic or conditions
$alertMessage = "Selamat Datang di website kami!";
$alertTitle = "Pemberitahuan";

// Jika kondisi tertentu terpenuhi, tampilkan SweetAlert
$showAlert = true; // Anda bisa mengubah kondisi ini sesuai kebutuhan, misalnya berdasarkan input atau session

if ($showAlert) {
    echo "<script>
            Swal.fire({
                title: '$alertTitle',
                text: '$alertMessage',
                icon: 'success',
                confirmButtonText: 'Oke'
            });
          </script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SweetAlert2 di dalam PHP</title>
    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.8/dist/sweetalert2.min.css" rel="stylesheet">
</head>
<body>

    <h1>Contoh SweetAlert2 dalam PHP</h1>

    <!-- Tombol untuk memicu SweetAlert -->
    <button id="showAlertBtn">Tampilkan Alert</button>

    <!-- SweetAlert2 Script -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.8/dist/sweetalert2.all.min.js"></script>

    <script>
    </script>

</body>
</html>
