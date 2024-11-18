<?php
include 'koneksi.php';

// Ambil data dari form
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

        // Verifikasi password
        if (password_verify($password, $user['password'])) {
            // Login berhasil
            session_start();
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            header("Location: dashboard.php");
        } else {
            echo "Password salah.";
        }
    } else {
        echo "Username atau Role tidak ditemukan.";
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
    <title>Login - SIKMATU</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: url('img/teknikUnsoed.jpeg') no-repeat center center fixed;
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
        <h2>Login</h2>
        <form action="sikmatuLog.php" method="post">
            <label for="role">Role:</label>
            <select name="role" id="role" required>
                <option value="" disabled selected>Pilih Role</option>
                <option value="admin">Admin</option>
                <option value="dosen">Dosen</option>
                <option value="mahasiswa">Mahasiswa</option>
            </select>

            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>

        <p>Belum punya akun? <a href="sikmatuSign.php" class="link">Sign Up</a></p>
    </div>
</body>
</html>
