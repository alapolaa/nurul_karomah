<?php
session_start();
include '../../config/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST["user_id"];
    $nisn = $_POST["nisn"];
    $nik = $_POST["nik"];
    $nama_lengkap = $_POST["nama_lengkap"];
    $jenis_kelamin = $_POST["jenis_kelamin"];
    $tempat_lahir = $_POST["tempat_lahir"];
    $tanggal_lahir = $_POST["tanggal_lahir"];
    $alamat_lengkap = $_POST["alamat_lengkap"];
    $agama = $_POST["agama"];
    $no_telp = $_POST["no_telp"];
    $province_id = $_POST["province_id"];
    $regency_id = $_POST["regency_id"];
    $district_id = $_POST["district_id"];
    $village_id = $_POST["village_id"];

    $sql = "INSERT INTO pendaftar (user_id, nisn, nik, nama_lengkap, jenis_kelamin, tempat_lahir, tanggal_lahir, alamat_lengkap, agama, no_telp, province_id, regency_id, district_id, village_id) VALUES ('$user_id', '$nisn', '$nik', '$nama_lengkap', '$jenis_kelamin', '$tempat_lahir', '$tanggal_lahir', '$alamat_lengkap', '$agama', '$no_telp', '$province_id', '$regency_id', '$district_id', '$village_id')";

    if ($conn->query($sql) === TRUE) {
        $pendaftar_id = $conn->insert_id;
        $_SESSION['pendaftar_id'] = $pendaftar_id;
        header("Location: ../../user/pendaftaran/data_orang_tua/data_orang_tua.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
