<?php
session_start();
include '../../config/config.php';

$gambar = $_FILES['gambar']['name'];
$tmp = $_FILES['gambar']['tmp_name'];
$keterangan = $_POST['keterangan'];

// Ambil admin_id dari session, pastikan session sudah dimulai
$admin_id = $_SESSION['admin_id'] ?? NULL;

// Pindahkan file ke folder uploads
move_uploaded_file($tmp, "../../uploads/" . $gambar);

// Simpan ke database
$sql = "INSERT INTO sejarah (gambar, keterangan, admin_id) VALUES ('$gambar', '$keterangan', '$admin_id')";
$conn->query($sql);

header("Location: ../../admin/sejarah/sejarah.php");
