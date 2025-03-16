<?php
include '../../config/config.php';



$jenjang = $_POST['jenjang'];
$tanggal_mulai = $_POST['tanggal_mulai'];
$tanggal_selesai = $_POST['tanggal_selesai'];
$tahun_ajaran = $_POST['tahun_ajaran'];

$sql = "INSERT INTO jadwal_pendaftaran (jenjang, tanggal_mulai, tanggal_selesai, tahun_ajaran) VALUES ('$jenjang', '$tanggal_mulai', '$tanggal_selesai', '$tahun_ajaran')";

if ($conn->query($sql) === TRUE) {
    header("Location: ../../admin/jadwal/jadwal.php");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
