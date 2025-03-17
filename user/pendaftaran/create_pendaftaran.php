<?php
session_start();
include '../../config/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST["user_id"];
    $jadwal_id = $_POST["jadwal_id"];

    // Periksa apakah pendaftar dengan user_id ini sudah ada
    $checkSql = "SELECT pendaftar_id FROM pendaftar WHERE user_id = ?";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bind_param("i", $user_id);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows > 0) {
        echo "Anda sudah terdaftar. Tidak dapat melakukan pendaftaran lagi.";
        $checkStmt->close();
        $conn->close();
        exit();
    }

    $checkStmt->close();

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

    $sql = "INSERT INTO pendaftar (user_id, nisn, nik, nama_lengkap, jenis_kelamin, tempat_lahir, tanggal_lahir, alamat_lengkap, agama, no_telp, province_id, regency_id, district_id, village_id, jadwal_pendaftaran_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssssssssiiiii", $user_id, $nisn, $nik, $nama_lengkap, $jenis_kelamin, $tempat_lahir, $tanggal_lahir, $alamat_lengkap, $agama, $no_telp, $province_id, $regency_id, $district_id, $village_id, $jadwal_id);

    if ($stmt->execute()) {
        $pendaftar_id = $stmt->insert_id;
        $_SESSION['pendaftar_id'] = $pendaftar_id;

        // Update jumlah pendaftar di tabel jadwal_pendaftaran
        $updateSql = "UPDATE jadwal_pendaftaran SET jumlah_pendaftar = jumlah_pendaftar + 1 WHERE jadwal_pendaftaran_id = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("i", $jadwal_id);
        $updateStmt->execute();
        $updateStmt->close();

        header("Location: ../../user/pendaftaran/data_orang_tua/data_orang_tua.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $stmt->close();
}

$conn->close();
