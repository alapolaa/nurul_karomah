<?php
session_start(); // Pastikan sesi dimulai
include '../../config/config.php';

$gambar = $_FILES['gambar']['name'];
$tmp = $_FILES['gambar']['tmp_name'];
$path = "../../uploads/" . $gambar;

move_uploaded_file($tmp, $path);

$nama_fasilitas = $_POST['nama_fasilitas'];
$keterangan = $_POST['keterangan'];
$admin_id = $_SESSION['admin_id'] ?? NULL; // Ambil admin_id dari sesi

// Gunakan prepared statements untuk mencegah SQL injection
$stmt = $conn->prepare("INSERT INTO fasilitas (gambar, nama_fasilitas, keterangan, admin_id) VALUES (?, ?, ?, ?)");
$stmt->bind_param("sssi", $path, $nama_fasilitas, $keterangan, $admin_id); // "sssi" berarti string, string, string, integer

if ($stmt->execute()) {
    header("Location: ../../admin/fasilitas/fasilitas.php");
    exit(); // Penting untuk menghentikan eksekusi skrip setelah pengalihan
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
