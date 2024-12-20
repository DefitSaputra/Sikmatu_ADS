<?php
include 'koneksi.php';

// Ambil data dari form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $role = $_POST['role'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm-password'];

    if ($password !== $confirmPassword) {
        // Validasi password tidak cocok
        header("Location: sikmatuSign.php?status=password_mismatch");
        exit();
    }
    
    // Masukkan data ke database tanpa hash password
    $stmt = $conn->prepare("INSERT INTO user_data (email, username, password, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $email, $username, $password, $role);
    
    if ($stmt->execute()) {
        // Redireksi ke halaman sukses
        header("Location: sikmatuLog.php?status=success");
    } else {
        // Redireksi ke halaman error
        header("Location: sikmatuSign.php?status=error&error_message=" . urlencode($stmt->error));
    }    
    
    $stmt->close();
}
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="sikmatuSign.css">
    <title>Sign Up - SIKMATU</title>
</head>
<body>
    <header>
        <a href="sikmatuSign.php" class="logo">
            <img src="../img/unsoed-logo.png" alt="Logo Unsoed">
            <span>Sikmatu</span>
        </a>
        
        <div class="navbar">
            <a href="sikmatuLog.php"><button class="btn-login">Login</button></a>
            <a href="sikmatuSign.php"><button class="btn-signup">Sign Up</button></a>
        </div>
    </header>

    <div class="form-container">
        <h2>Sign Up</h2>
        <form action="sikmatuSign.php" method="post">
            <label for="role">Role:</label>
            <select name="role" id="role" required>
                <option value="" disabled selected>Pilih Role</option>
                <option value="konselor">Konselor</option>
                <option value="mahasiswa">Mahasiswa</option>
            </select>
            
            <input type="email" name="email" placeholder="Email (@mhs.unsoed.ac.id / @dos.unsoed.ac.id)" 
                pattern=".+@(mhs\.unsoed\.ac\.id|dos\.unsoed\.ac\.id)" required>
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="confirm-password" placeholder="Konfirmasi Password" required>
            <button type="submit" id="signSubmit">Sign Up</button>
        </form>
        <p>Sudah punya akun? <a href="sikmatuLog.php" class="link">Login</a></p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Ambil status dari URL
        const urlParams = new URLSearchParams(window.location.search);
        const status = urlParams.get('status');
        const errorMessage = urlParams.get('error_message');

        if (status === 'password_mismatch') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Password dan Konfirmasi Password tidak cocok!',
            });
        } else if (status === 'success') {
            Swal.fire({
                icon: 'success',
                title: 'Selamat!',
                text: 'Akun Anda berhasil dibuat!',
            }).then(() => {
                window.location.href = 'sikmatuLog.php'; // Redireksi setelah alert
            });
        } else if (status === 'error') {
            Swal.fire({
                icon: 'error',
                title: 'Terjadi kesalahan!',
                text: 'Error: ' + errorMessage,
            }).then(() => {
                window.location.href = 'sikmatuSign.php'; // Redireksi kembali ke form
            });
        }
    </script>
</body>
</html>
