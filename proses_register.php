<?php
include 'config.php';

$username = $_POST['username'];
$password = $_POST['password'];
$email = $_POST['email'];

$sql = "INSERT INTO users (username, password, email) VALUES ('$username', '$password', '$email')";

if ($conn->query($sql) === TRUE) {
    echo "Registrasi berhasil!";
    header("Location: login.php"); // Redirect ke halaman login
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
