<?php
session_start();
include '../config/config.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Cek di tabel users
    $stmt = $conn->prepare("SELECT user_id, username, password FROM users WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result_user = $stmt->get_result();

    if ($result_user->num_rows > 0) {
        $row = $result_user->fetch_assoc();
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['role'] = 'user';
        header("Location: ../user/dashboard.php");
        exit();
    }


    $stmt = $conn->prepare("SELECT admin_id, nama, password FROM admin WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result_admin = $stmt->get_result();

    if ($result_admin->num_rows > 0) {
        $row = $result_admin->fetch_assoc();
        $_SESSION['admin_id'] = $row['admin_id'];
        $_SESSION['nama'] = $row['nama'];
        $_SESSION['role'] = 'admin';
        header("Location: ../admin.php");
        exit();
    }

    $error = "Email atau password salah!";
}

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            /* Warna latar belakang halaman */
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .form-container {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 450px;
            /* Lebar form */
            text-align: center;
        }

        .form-container img {
            max-width: 100px;
            /* Ukuran logo */
            margin-bottom: 20px;
        }

        .form-container h2 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .form-container .form-label {
            text-align: left;
            display: block;
            margin-bottom: 5px;
        }

        .form-container .btn-primary {
            background-color: #007bff;
            /* Warna tombol Masuk */
            border-color: #007bff;
            width: 100%;
            margin-top: 10px;
        }

        .form-container .btn-info {
            background-color: #17a2b8;
            /* Warna tombol Daftar */
            border-color: #17a2b8;
            width: 100%;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="form-container">
        <img src="../img/nurul.png" alt="Logo MTS Nurul Karomah">
        <h2>Selamat Datang di Lembaga Nurul Karomah</h2>
        <p>Silakan login untuk mengakses sistem</p>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST" action="login.php">
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Masuk</button>
        </form>
        <a href="../auth/register.php" class="btn btn-info">Daftar</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>