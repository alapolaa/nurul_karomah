<?php
include '../config/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    $sql = "INSERT INTO users (username, password, email) VALUES ('$username', '$password', '$email')";

    if ($conn->query($sql) === TRUE) {
        echo "Registrasi berhasil!";
        header("Location: ../auth/login.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
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
            text-align: center;
        }

        .form-container img {
            max-width: 100px;
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
            border-color: #007bff;
            width: 100%;
            margin-top: 10px;
        }

        .login-link {
            margin-top: 20px;
            text-align: center;
        }

        .login-link a {
            color: #007bff;
            /* Warna tautan */
            text-decoration: none;
            /* Menghilangkan garis bawah */
        }

        .login-link a:hover {
            text-decoration: underline;
            /* Garis bawah saat hover */
        }
    </style>
</head>


<body>
    <div class="form-container">
        <img src="../img/nurul.png" alt="Logo MTS Nurul Karomah">
        <h2>Selamat Datang di Lembaga Nurul Karomah</h2>
        <p>Silakan daftar untuk mengakses sistem</p>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="mb-3">
                <label for="username" class="form-label">Username:</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <button type="submit" class="btn btn-primary">Daftar</button>
        </form>

        <div class="login-link">
            <p>Sudah punya akun? <a href="login.php">Login di sini</a></p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>