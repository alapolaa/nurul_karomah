<?php
include '../config/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pendaftarId = $_POST['pendaftar_id'];
    $status = $_POST['status'];

    // Ambil jadwal_pendaftaran_id dari tabel pendaftar
    $jadwalSql = "SELECT jadwal_pendaftaran_id FROM pendaftar WHERE pendaftar_id = ?";
    $jadwalStmt = $conn->prepare($jadwalSql);
    $jadwalStmt->bind_param("i", $pendaftarId);
    $jadwalStmt->execute();
    $jadwalResult = $jadwalStmt->get_result();
    $jadwalRow = $jadwalResult->fetch_assoc();
    $jadwalId = $jadwalRow['jadwal_pendaftaran_id'];
    $jadwalStmt->close();

    $sql = "UPDATE pendaftar SET status = ? WHERE pendaftar_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $status, $pendaftarId);

    if ($stmt->execute()) {
        // Update jumlah_diterima atau jumlah_ditolak
        if ($status === 'Diterima') {
            $updateJadwalSql = "UPDATE jadwal_pendaftaran SET jumlah_diterima = jumlah_diterima + 1 WHERE jadwal_pendaftaran_id = ?";
        } elseif ($status === 'Ditolak') {
            $updateJadwalSql = "UPDATE jadwal_pendaftaran SET jumlah_ditolak = jumlah_ditolak + 1 WHERE jadwal_pendaftaran_id = ?";
        }

        if (isset($updateJadwalSql)) {
            $updateJadwalStmt = $conn->prepare($updateJadwalSql);
            $updateJadwalStmt->bind_param("i", $jadwalId);
            $updateJadwalStmt->execute();
            $updateJadwalStmt->close();
        }
        echo 'success';
    } else {
        echo 'error';
    }

    $stmt->close();
    $conn->close();
}
