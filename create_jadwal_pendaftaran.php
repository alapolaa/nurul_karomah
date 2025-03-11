<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $jenjang = $_POST["jenjang"];
    $tanggal_mulai = $_POST["tanggal_mulai"];
    $tanggal_selesai = $_POST["tanggal_selesai"];
    $jumlah_siswa = $_POST["jumlah_siswa"];

    $sql = "INSERT INTO jadwal_pendaftaran (jenjang, tanggal_mulai, tanggal_selesai, jumlah_siswa) VALUES ('$jenjang', '$tanggal_mulai', '$tanggal_selesai', '$jumlah_siswa')";

    if ($conn->query($sql) === TRUE) {
        header("Location: index_jadwal_pendaftaran.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
