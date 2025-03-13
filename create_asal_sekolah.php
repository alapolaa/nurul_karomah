<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pendaftar_id = $_POST["pendaftar_id"];
    $npsn = $_POST["npsn"];
    $nama_sekolah = $_POST["nama_sekolah"];

    $sql = "INSERT INTO asal_sekolah (pendaftar_id, npsn, nama_sekolah) VALUES ('$pendaftar_id', '$npsn', '$nama_sekolah')";

    if ($conn->query($sql) === TRUE) {
        header("Location: index_berkas_pendaftaran.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
