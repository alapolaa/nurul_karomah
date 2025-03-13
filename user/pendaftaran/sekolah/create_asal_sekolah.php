<?php
include '../../../config/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pendaftar_id = $_POST["pendaftar_id"];

    // Periksa apakah data asal sekolah dengan pendaftar_id ini sudah ada
    $checkSql = "SELECT asal_sekolah_id FROM asal_sekolah WHERE pendaftar_id = ?";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bind_param("i", $pendaftar_id);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows > 0) {
        echo "Data asal sekolah untuk pendaftar ini sudah ada. Tidak dapat menambahkan data lagi.";
        $checkStmt->close();
        $conn->close();
        exit();
    }

    $checkStmt->close();

    $npsn = $_POST["npsn"];
    $nama_sekolah = $_POST["nama_sekolah"];

    $sql = "INSERT INTO asal_sekolah (pendaftar_id, npsn, nama_sekolah) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $pendaftar_id, $npsn, $nama_sekolah);

    if ($stmt->execute()) {
        header("Location: ../../../user/pendaftaran/berkas/berkas_pendaftaran.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $stmt->close();
}

$conn->close();
