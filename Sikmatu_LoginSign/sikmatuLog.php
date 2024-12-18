<?php
include 'koneksi.php';
session_start();

$response = [
    'status' => '',
    'message' => ''
];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Cek data di database
    $stmt = $conn->prepare("SELECT * FROM user_data WHERE username = ? AND role = ?");
    $stmt->bind_param("ss", $username, $role);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verifikasi password tanpa hash
        if ($password === $user['password']) {
            // Login berhasil
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            $response['status'] = 'success';
            $response['message'] = 'Login berhasil!';
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Password salah.';
        }
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Username atau Role tidak ditemukan.';
    }

    $stmt->close();
    $conn->close();

    echo json_encode($response);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="sikmatuLog.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Login - SIKMATU</title>
</head>
<body>

<header>
    <a href="sikmatuLog.php" class="logo">
        <img src="../img/unsoed-logo.png" alt="Logo Unsoed">
        <span>Sikmatu</span>
    </a>
    
    <div class="navbar">
        <a href="sikmatuLog.php"><button class="btn-login">Login</button></a>
        <a href="sikmatuSign.php"><button class="btn-signup">Sign Up</button></a>
    </div>
</header>

<div class="form-container">
        <h2>Login</h2>
        <form id="loginForm">
            <label for="role">Role:</label>
            <select name="role" id="role" required>
                <option value="" disabled selected>Pilih Role</option>
                <option value="admin">Admin</option>
                <option value="dosen">Dosen</option>
                <option value="mahasiswa">Mahasiswa</option>
            </select>
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" id="loginSubmit">Login</button>
        </form>
        <p>Belum punya akun? <a href="sikmatuSign.php" class="link">Sign Up</a></p>
    </div>

    <script>
        document.getElementById('loginForm').addEventListener('submit', async function (e) {
            e.preventDefault(); // Cegah submit form default
            
            const formData = new FormData(this);
            const response = await fetch('sikmatuLog.php', {
                method: 'POST',
                body: formData
            });
            const result = await response.json();

            if (result.status === 'success') {
                Swal.fire({
                    title: 'Berhasil!',
                    text: result.message,
                    icon: 'success',
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    window.location.href = '../DashboardSikmatu/home.php'; // Redirect setelah berhasil login
                });
            } else {
                Swal.fire({
                    title: 'Error!',
                    text: result.message,
                    icon: 'error',
                    timer: 3000,
                    showConfirmButton: false
                });
            }
        });
    </script>
</body>
</html>
