<?php
include '../../config/config.php';

$nama_mapel = $_POST['nama_mapel'];
$guru_id = $_POST['guru_id'];
$admin_id = $_POST['admin_id'];

$sql = "INSERT INTO mata_pelajaran (nama_mapel, guru_id, admin_id) VALUES ('$nama_mapel', $guru_id, $admin_id)";

if ($conn->query($sql) === TRUE) {
    header("Location: ../../admin/mapel/mapel.php");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
