<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pendaftar_id = $_POST["pendaftar_id"];
    $nik_ayah = $_POST["nik_ayah"];
    $nama_ayah = $_POST["nama_ayah"];
    $pendidikan_ayah = $_POST["pendidikan_ayah"];
    $pekerjaan_ayah = $_POST["pekerjaan_ayah"];
    $penghasilan_ayah = $_POST["penghasilan_ayah"];
    $no_telp_ayah = $_POST["no_telp_ayah"];
    $nik_ibu = $_POST["nik_ibu"];
    $nama_ibu = $_POST["nama_ibu"];
    $pendidikan_ibu = $_POST["pendidikan_ibu"];
    $pekerjaan_ibu = $_POST["pekerjaan_ibu"];
    $penghasilan_ibu = $_POST["penghasilan_ibu"];
    $no_telp_ibu = $_POST["no_telp_ibu"];
    $nik_wali = $_POST["nik_wali"];
    $nama_wali = $_POST["nama_wali"];
    $pendidikan_wali = $_POST["pendidikan_wali"];
    $pekerjaan_wali = $_POST["pekerjaan_wali"];
    $penghasilan_wali = $_POST["penghasilan_wali"];
    $no_telp_wali = $_POST["no_telp_wali"];

    $sql = "INSERT INTO orang_tua_wali (pendaftar_id, nik_ayah, nama_ayah, pendidikan_ayah, pekerjaan_ayah, penghasilan_ayah, no_telp_ayah, nik_ibu, nama_ibu, pendidikan_ibu, pekerjaan_ibu, penghasilan_ibu, no_telp_ibu, nik_wali, nama_wali, pendidikan_wali, pekerjaan_wali, penghasilan_wali, no_telp_wali) VALUES ('$pendaftar_id', '$nik_ayah', '$nama_ayah', '$pendidikan_ayah', '$pekerjaan_ayah', '$penghasilan_ayah', '$no_telp_ayah', '$nik_ibu', '$nama_ibu', '$pendidikan_ibu', '$pekerjaan_ibu', '$penghasilan_ibu', '$no_telp_ibu', '$nik_wali', '$nama_wali', '$pendidikan_wali', '$pekerjaan_wali', '$penghasilan_wali', '$no_telp_wali')";

    if ($conn->query($sql) === TRUE) {
        header("Location: index_asal_sekolah.php"); // Redirect back to index.php
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
