<?php
include '../../config/config.php';

$id = $_POST['id'];
$nama_fasilitas = $_POST['nama_fasilitas'];
$keterangan = $_POST['keterangan'];
$admin_id = $_POST['admin_id'];

if ($_FILES['gambar']['name'] != "") {
    $gambar = $_FILES['gambar']['name'];
    $tmp = $_FILES['gambar']['tmp_name'];
    $path = "../../uploads/" . $gambar;
    move_uploaded_file($tmp, $path);
    $sql = "UPDATE fasilitas SET gambar='$path', nama_fasilitas='$nama_fasilitas', keterangan='$keterangan', admin_id='$admin_id' WHERE fasilitas_id=$id";
} else {
    $sql = "UPDATE fasilitas SET nama_fasilitas='$nama_fasilitas', keterangan='$keterangan', admin_id='$admin_id' WHERE fasilitas_id=$id";
}

if ($conn->query($sql) === TRUE) {
    header("Location: ../../admin/fasilitas/fasilitas.php");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
