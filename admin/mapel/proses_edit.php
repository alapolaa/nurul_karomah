<?php
include '../../config/config.php';

$id = $_POST['id'];
$nama_mapel = $_POST['nama_mapel'];
$guru_id = $_POST['guru_id'];
$admin_id = $_POST['admin_id'];

$sql = "UPDATE mata_pelajaran SET nama_mapel='$nama_mapel', guru_id=$guru_id, admin_id=$admin_id WHERE mata_pelajaran_id=$id";

if ($conn->query($sql) === TRUE) {
    header("Location: ../../admin/mapel/mapel.php");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
