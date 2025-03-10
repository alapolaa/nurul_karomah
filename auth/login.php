<?php
session_start();
include '../config/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $queryAdmin = "SELECT * FROM admin WHERE email = '$email' AND password = '$password'";
    $resultAdmin = $conn->query($queryAdmin);

    if ($resultAdmin->num_rows > 0) {
        $admin = $resultAdmin->fetch_assoc();
        $_SESSION['admin_id'] = $admin['admin_id'];
        $_SESSION['role'] = "admin";
        header("Location: ../admin/index.php");
        exit;
    }


    $queryUser = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
    $resultUser = $conn->query($queryUser);

    if ($resultUser->num_rows > 0) {
        $user = $resultUser->fetch_assoc();
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['role'] = "user";
        header("Location: ../user/index.php");
        exit;
    }


    echo "Email atau password salah!";
}
