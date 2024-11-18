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
    
    // Hash password untuk keamanan
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    
    // Masukkan data ke database
    $stmt = $conn->prepare("INSERT INTO user_data (email, username, password, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $email, $username, $hashedPassword, $role);
    
    if ($stmt->execute()) {
        // Redireksi ke halaman sukses
        header("Location: sikmatuSign.php?status=success");
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
    <title>Sign Up - SIKMATU</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: url('../img/teknikUnsoed.jpeg') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .form-container {
            background: rgba(255, 255, 255, 0.8);
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            text-align: center;
            max-width: 400px;
            width: 100%;
        }
        .form-container h2 {
            margin-bottom: 1rem;
            color: #003399;
        }
        .form-container select,
        .form-container input[type="email"],
        .form-container input[type="text"],
        .form-container input[type="password"],
        .form-container button {
            width: 100%;
            margin: 10px 0;
            padding: 10px;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
        }
        select, input {
            background: rgba(255, 255, 255, 0.6);
        }
        button {
            background: linear-gradient(90deg, #003399, #FFD700);
            color: white;
            cursor: pointer;
        }
        button:hover {
            background: linear-gradient(90deg, #FFD700, #003399);
        }
        .link {
            color: #003399;
            text-decoration: none;
        }
        .link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Sign Up</h2>
        <form action="sikmatuSign.php" method="post">
            <label for="role">Role:</label>
            <select name="role" id="role" required>
                <option value="" disabled selected>Pilih Role</option>
                <option value="dosen">Dosen</option>
                <option value="mahasiswa">Mahasiswa</option>
            </select>
            
            <input type="email" name="email" placeholder="Email (@mhs.unsoed.ac.id / @dos.unsoed.ac.id)" 
                pattern=".+@(mhs\.unsoed\.ac\.id|dos\.unsoed\.ac\.id)" required>
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="confirm-password" placeholder="Konfirmasi Password" required>
            <button type="submit">Sign Up</button>
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
