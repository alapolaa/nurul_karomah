<?php
session_start(); // Pastikan sesi dimulai
include '../../config/config.php';

$nama_mapel = $_POST['nama_mapel'];
$guru_id = $_POST['guru_id'];
$admin_id = $_SESSION['admin_id'] ?? NULL; // Ambil admin_id dari sesi

// Gunakan prepared statements untuk mencegah SQL injection
$stmt = $conn->prepare("INSERT INTO mata_pelajaran (nama_mapel, guru_id, admin_id) VALUES (?, ?, ?)");
$stmt->bind_param("sii", $nama_mapel, $guru_id, $admin_id); // "sii" berarti string, integer, integer

if ($stmt->execute()) {
    header("Location: ../../admin/mapel/mapel.php");
    exit(); // Penting untuk menghentikan eksekusi skrip setelah pengalihan
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
