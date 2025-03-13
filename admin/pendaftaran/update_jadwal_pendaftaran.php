<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $jadwal_pendaftaran_id = $_POST["jadwal_pendaftaran_id"];
    $jenjang = $_POST["jenjang"];
    $tanggal_mulai = $_POST["tanggal_mulai"];
    $tanggal_selesai = $_POST["tanggal_selesai"];
    $jumlah_siswa = $_POST["jumlah_siswa"];

    $sql = "UPDATE jadwal_pendaftaran SET jenjang='$jenjang', tanggal_mulai='$tanggal_mulai', tanggal_selesai='$tanggal_selesai', jumlah_siswa='$jumlah_siswa' WHERE jadwal_pendaftaran_id='$jadwal_pendaftaran_id'";

    if ($conn->query($sql) === TRUE) {
        header("Location: index_jadwal_pendaftaran.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
