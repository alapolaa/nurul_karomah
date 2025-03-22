<?php

require_once('vendor/autoload.php');

session_start();
include 'config/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$status = isset($_GET['status']) ? $_GET['status'] : '';

$sql = "SELECT p.*, j.jenjang FROM pendaftar p JOIN jadwal_pendaftaran j ON p.jadwal_pendaftaran_id = j.jadwal_pendaftaran_id WHERE p.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $pendaftar = $result->fetch_assoc();

    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Nama Anda');
    $pdf->SetTitle('Biodata Pendaftaran Sekolah');
    $pdf->SetSubject('Biodata Pendaftaran');
    $pdf->SetKeywords('Biodata, Pendaftaran, Sekolah');
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
    $pdf->AddPage();

    if ($status == 'Diterima') {
        $html = '
            <h1>Biodata Pendaftaran Sekolah - Diterima</h1>
            <p>Selamat, pendaftaran Anda diterima!</p>
            <p>Nama Lengkap: ' . $pendaftar['nama_lengkap'] . '</p>
            <p>NISN: ' . $pendaftar['nisn'] . '</p>
            <p>NIK: ' . $pendaftar['nik'] . '</p>
            <p>Tempat, Tanggal Lahir: ' . $pendaftar['tempat_lahir'] . ', ' . $pendaftar['tanggal_lahir'] . '</p>
            <p>Alamat: ' . $pendaftar['alamat_lengkap'] . '</p>
            <p>Agama: ' . $pendaftar['agama'] . '</p>
            <p>No. Telp: ' . $pendaftar['no_telp'] . '</p>
            <p>Jenjang Pendaftaran: ' . $pendaftar['jenjang'] . '</p>
            <p>Status: Diterima</p>
        ';
    } elseif ($status == 'Ditolak') {
        $html = '
            <h1>Biodata Pendaftaran Sekolah - Ditolak</h1>
            <p>Mohon maaf, pendaftaran Anda ditolak.</p>
            <p>Nama Lengkap: ' . $pendaftar['nama_lengkap'] . '</p>
            <p>NISN: ' . $pendaftar['nisn'] . '</p>
            <p>NIK: ' . $pendaftar['nik'] . '</p>
            <p>Tempat, Tanggal Lahir: ' . $pendaftar['tempat_lahir'] . ', ' . $pendaftar['tanggal_lahir'] . '</p>
            <p>Alamat: ' . $pendaftar['alamat_lengkap'] . '</p>
            <p>Agama: ' . $pendaftar['agama'] . '</p>
            <p>No. Telp: ' . $pendaftar['no_telp'] . '</p>
            <p>Status: Ditolak</p>
            <p>Alasan: [Alasan Penolakan]</p>
        ';
    } else {
        echo "Status tidak valid.";
        exit();
    }

    $pdf->writeHTML($html, true, false, true, false, '');
    $pdf->Output('biodata_pendaftaran.pdf', 'D');
} else {
    echo "Data pendaftar tidak ditemukan.";
}

$stmt->close();
$conn->close();
