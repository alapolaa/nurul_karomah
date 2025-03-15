<?php
include '../../config/config.php';

$gambar = $_FILES['gambar']['name'];
$tmp = $_FILES['gambar']['tmp_name'];
$keterangan = $_POST['keterangan'];
$admin_id = $_POST['admin_id'] ?? NULL;

// Pindahkan file ke folder uploads
move_uploaded_file($tmp, "../../uploads/" . $gambar);

// Simpan ke database
$sql = "INSERT INTO sejarah (gambar, keterangan, admin_id) VALUES ('$gambar', '$keterangan', '$admin_id')";
$conn->query($sql);

header("Location: ../../admin/sejarah/sejarah.php");
