<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
include '../../config/config.php';

$id = $_POST['id'];
$nama_fasilitas = $_POST['nama_fasilitas'];
$keterangan = $_POST['keterangan'];


if ($_FILES['gambar']['name'] != "") {
    $gambar = $_FILES['gambar']['name'];
    $tmp = $_FILES['gambar']['tmp_name'];
    $path = "../../uploads/" . $gambar;
    move_uploaded_file($tmp, $path);
    $sql = "UPDATE fasilitas SET gambar='$path', nama_fasilitas='$nama_fasilitas', keterangan='$keterangan' WHERE fasilitas_id=$id";
} else {
    $sql = "UPDATE fasilitas SET nama_fasilitas='$nama_fasilitas', keterangan='$keterangan' WHERE fasilitas_id=$id";
}

if ($conn->query($sql) === TRUE) {
    header("Location: ../../admin/fasilitas/fasilitas.php");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
