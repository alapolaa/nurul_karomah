<?php
include '../../config/config.php';

$id = $_POST['id'];
$keterangan = $_POST['keterangan'];
$gambar = $_FILES['gambar']['name'];

if ($gambar) {
    move_uploaded_file($_FILES['gambar']['tmp_name'], "../../uploads/" . $gambar);
    $conn->query("UPDATE sejarah SET gambar='$gambar', keterangan='$keterangan' WHERE sejarah_id=$id");
} else {
    $conn->query("UPDATE sejarah SET keterangan='$keterangan' WHERE sejarah_id=$id");
}

header("Location: ../../admin/sejarah/sejarah.php");
