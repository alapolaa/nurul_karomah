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

$sql = "SELECT p.*, j.jenjang, a.nama_sekolah FROM pendaftar p JOIN jadwal_pendaftaran j ON p.jadwal_pendaftaran_id = j.jadwal_pendaftaran_id LEFT JOIN asal_sekolah a ON p.asal_sekolah_id = a.asal_sekolah_id WHERE p.user_id = ?";
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
    $pdf->SetMargins(PDF_MARGIN_LEFT, 10, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(0);
    $pdf->SetFooterMargin(0);
    $pdf->SetPrintHeader(false);
    $pdf->SetPrintFooter(false);
    $pdf->AddPage();

    $logoY = 20;
    $pdf->Image('img/nurul.png', 10, $logoY, 30, 30, 'PNG', '', '', true, 150, '', false, false, 0, false, false, false);

    if ($status == 'Diterima') {
        $html = '
            <div style="text-align: center;">
                <h1>PEMERINTAH KABUPATEN BANGKALAN</h1>
                <h2>DINAS PENDIDIKAN</h2>
                <h3>UPT SATUAN PENDIDIKAN ISLAM</h3>
                <p>Jalan Nandelem Kajan, Desa Nandelem Kajan, Kecamatan Blega, Bangkalan, Jawa Timur 69174</p>
            </div>
        ';

        $pdf->writeHTML($html, true, false, true, false, '');

        $garisY = $pdf->GetY() - 1;
        $pdf->Line(PDF_MARGIN_LEFT, $garisY, $pdf->GetPageWidth() - PDF_MARGIN_RIGHT, $garisY);
        $pdf->Line(PDF_MARGIN_LEFT, $garisY + 2, $pdf->GetPageWidth() - PDF_MARGIN_RIGHT, $garisY + 2);

        // Mendapatkan tanggal saat ini dalam format Indonesia yang benar
        setlocale(LC_TIME, 'id_ID');
        $tanggal_sekarang_indo = strftime("%d %B %Y");

        $html2 = '
            <div style="text-align: center;">
                <h2>PENGUMUMAN KELULUSAN</h2>
            </div>
            <div style="text-align: left">
                <p>Berdasarkan hasil seleksi penerimaan peserta didik baru, Kepala Sekolah Lembaga Nurul Karomah dengan ini menerangkan bahwa:</p>
                <table style="width: 100%;">
                    <tr>
                        <td style="width: 30%;">Nama</td>
                        <td style="width: 5%;">:</td>
                        <td style="width: 75%;">' . $pendaftar['nama_lengkap'] . '</td>
                    </tr>
                    <tr>
                        <td style="width: 30%;">NIK</td>
                        <td style="width: 5%;">:</td>
                        <td style="width: 75%;">' . $pendaftar['nik'] . '</td>
                    </tr>
                    <tr>
                        <td style="width: 30%;">Tempat, Tanggal Lahir</td>
                        <td style="width: 5%;">:</td>
                        <td style="width: 75%;">' . $pendaftar['tempat_lahir'] . ', ' . $pendaftar['tanggal_lahir'] . '</td>
                    </tr>
                    <tr>
                        <td style="width: 30%;">Alamat</td>
                        <td style="width: 5%;">:</td>
                        <td style="width: 75%;">' . $pendaftar['alamat_lengkap'] . '</td>
                    </tr>
                    <tr>
                        <td style="width: 30%;">Asal Sekolah</td>
                        <td style="width: 5%;">:</td>
                        <td style="width: 75%;">' . $pendaftar['nama_sekolah'] . '</td>
                    </tr>
                    <tr>
                        <td style="width: 30%;">NISN</td>
                        <td style="width: 5%;">:</td>
                        <td style="width: 75%;">' . $pendaftar['nisn'] . '</td>
                    </tr>
                    <tr>
                        <td style="width: 30%;">Jenjang</td>
                        <td style="width: 5%;">:</td>
                        <td style="width: 75%;">' . $pendaftar['jenjang'] . '</td>
                    </tr>
                </table>
                <p style="text-align: center;">Dinyatakan:</p>

                <div style="display: flex; justify-content: center; align-items: center; height: 100vh;">
                    <div style="font-size: 36px; font-weight: bold; padding: 20px; border: 2px solid black; width: 200px; text-align: center;">
                        LULUS
                    </div>
                </div>
                <p>Bangkalan, ' . $tanggal_sekarang_indo . '</p>
                <p>Kepala Lembaga Nurul Karomah</p>
                <br><br><br>
                <p>Muhammad Maulana Supriyadi, S.Pd.</p>
                <p>NIP. 8734695824785458</p>
            </div>
        ';

        $pdf->writeHTML($html2, true, false, true, false, '');
    } elseif ($status == 'Ditolak') {
        // ... (Kode untuk status ditolak)
    } else {
        echo "Status tidak valid.";
        exit();
    }

    $pdf->Output('biodata_pendaftaran.pdf', 'D');
} else {
    echo "Data pendaftar tidak ditemukan.";
}

$stmt->close();
$conn->close();
