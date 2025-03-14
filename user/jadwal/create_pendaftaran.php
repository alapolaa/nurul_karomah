<?php
session_start();
include '../../config/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$jadwal_id = $_POST['jadwal_id'];

$nisn = $_POST['nisn'];
$nik = $_POST['nik'];
$nama_lengkap = $_POST['nama_lengkap'];
$jenis_kelamin = $_POST['jenis_kelamin'];
$tempat_lahir = $_POST['tempat_lahir'];
$tanggal_lahir = $_POST['tanggal_lahir'];
$alamat_lengkap = $_POST['alamat_lengkap'];
$agama = $_POST['agama'];
$no_telp = $_POST['no_telp'];
$province_id = $_POST['province_id'];
$regency_id = $_POST['regency_id'];
$district_id = $_POST['district_id'];
$village_id = $_POST['village_id'];

function updateJadwalPendaftaran($conn, $jadwal_id)
{
    $jumlah_pendaftar_sql = "SELECT COUNT(*) as total FROM pendaftar WHERE jadwal_pendaftaran_id = $jadwal_id";
    $jumlah_diterima_sql = "SELECT COUNT(*) as total FROM pendaftar WHERE jadwal_pendaftaran_id = $jadwal_id AND status = 'Diterima'";
    $jumlah_ditolak_sql = "SELECT COUNT(*) as total FROM pendaftar WHERE jadwal_pendaftaran_id = $jadwal_id AND status = 'Ditolak'";

    $jumlah_pendaftar_result = $conn->query($jumlah_pendaftar_sql);
    $jumlah_diterima_result = $conn->query($jumlah_diterima_sql);
    $jumlah_ditolak_result = $conn->query($jumlah_ditolak_sql);

    $jumlah_pendaftar = $jumlah_pendaftar_result->fetch_assoc()['total'];
    $jumlah_diterima = $jumlah_diterima_result->fetch_assoc()['total'];
    $jumlah_ditolak = $jumlah_ditolak_result->fetch_assoc()['total'];

    $update_sql = "UPDATE jadwal_pendaftaran SET jumlah_pendaftar = $jumlah_pendaftar, jumlah_diterima = $jumlah_diterima, jumlah_ditolak = $jumlah_ditolak WHERE jadwal_pendaftaran_id = $jadwal_id";
    $conn->query($update_sql);
}

$sql = "INSERT INTO pendaftar (user_id, nisn, nik, nama_lengkap, jenis_kelamin, tempat_lahir, tanggal_lahir, alamat_lengkap, agama, no_telp, province_id, regency_id, district_id, village_id, jadwal_pendaftaran_id) VALUES ('$user_id', '$nisn', '$nik', '$nama_lengkap', '$jenis_kelamin', '$tempat_lahir', '$tanggal_lahir', '$alamat_lengkap', '$agama', '$no_telp', '$province_id', '$regency_id', '$district_id', '$village_id', '$jadwal_id')";

if ($conn->query($sql) === TRUE) {
    updateJadwalPendaftaran($conn, $jadwal_id); // Panggil fungsi update

    header("Location: ../../user/pendaftaran/pendaftaran_success.php");
    exit();
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
