<?php
include '../../config/config.php';

$gambar = $_FILES['gambar']['name'];
$tmp = $_FILES['gambar']['tmp_name'];
$path = "../../uploads/" . $gambar;

move_uploaded_file($tmp, $path);

$nama_fasilitas = $_POST['nama_fasilitas'];
$keterangan = $_POST['keterangan'];
$admin_id = $_POST['admin_id'];

$sql = "INSERT INTO fasilitas (gambar, nama_fasilitas, keterangan, admin_id) VALUES ('$path', '$nama_fasilitas', '$keterangan', '$admin_id')";

if ($conn->query($sql) === TRUE) {
    header("Location: ../../admin/fasilitas/fasilitas.php");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
