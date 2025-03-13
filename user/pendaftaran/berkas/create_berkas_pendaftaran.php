<?php
include '../../../config/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pendaftar_id = $_POST["pendaftar_id"];

    // Periksa apakah data berkas pendaftaran dengan pendaftar_id ini sudah ada
    $checkSql = "SELECT berkas_pendaftaran_id FROM berkas_pendaftaran WHERE pendaftar_id = ?";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bind_param("i", $pendaftar_id);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows > 0) {
        echo "Data berkas pendaftaran untuk pendaftar ini sudah ada. Tidak dapat menambahkan data lagi.";
        $checkStmt->close();
        $conn->close();
        exit();
    }

    $checkStmt->close();

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

    $sql = "INSERT INTO berkas_pendaftaran (pendaftar_id, pas_foto, ijazah_depan, ijazah_belakang) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isss", $pendaftar_id, $pas_foto_name, $ijazah_depan_name, $ijazah_belakang_name);

    if ($stmt->execute()) {
        header("Location: ../../../user/index.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $stmt->close();
}

$conn->close();
