<?php
include '../../config/config.php';

$id = $_POST['id'];
$jenjang = $_POST['jenjang'];
$tanggal_mulai = $_POST['tanggal_mulai'];
$tanggal_selesai = $_POST['tanggal_selesai'];
$tahun_ajaran = $_POST['tahun_ajaran'];

$sql = "UPDATE jadwal_pendaftaran SET jenjang = '$jenjang', tanggal_mulai = '$tanggal_mulai', tanggal_selesai = '$tanggal_selesai', tahun_ajaran = '$tahun_ajaran' WHERE jadwal_pendaftaran_id = $id";

if ($conn->query($sql) === TRUE) {
    header("Location: ../../admin/jadwal/jadwal.php");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
