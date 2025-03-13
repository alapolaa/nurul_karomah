<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pendaftar_id = $_POST["pendaftar_id"];

    $uploadDir = "uploads/"; // Directory to store uploaded files
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true); // Create directory if it doesn't exist
    }

    $pas_foto_name = $uploadDir . basename($_FILES["pas_foto"]["name"]);
    $ijazah_depan_name = $uploadDir . basename($_FILES["ijazah_depan"]["name"]);
    $ijazah_belakang_name = $uploadDir . basename($_FILES["ijazah_belakang"]["name"]);

    move_uploaded_file($_FILES["pas_foto"]["tmp_name"], $pas_foto_name);
    move_uploaded_file($_FILES["ijazah_depan"]["tmp_name"], $ijazah_depan_name);
    move_uploaded_file($_FILES["ijazah_belakang"]["tmp_name"], $ijazah_belakang_name);

    $sql = "INSERT INTO berkas_pendaftaran (pendaftar_id, pas_foto, ijazah_depan, ijazah_belakang) VALUES ('$pendaftar_id', '$pas_foto_name', '$ijazah_depan_name', '$ijazah_belakang_name')";

    if ($conn->query($sql) === TRUE) {
        header("Location: siswa.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
