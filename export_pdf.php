<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

require_once('vendor/autoload.php');

// Koneksi Database (sesuaikan dengan konfigurasi Anda)
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "coba";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$jenjang = $_GET['jenjang'];

$sql = "SELECT 
            p.nama_lengkap, 
            p.tempat_lahir, 
            p.tanggal_lahir, 
            p.nik, 
            p.alamat_lengkap, 
            p.nisn, 
            a.nama_sekolah
        FROM 
            pendaftar p
        JOIN 
            jadwal_pendaftaran j ON p.jadwal_pendaftaran_id = j.jadwal_pendaftaran_id
        LEFT JOIN 
            asal_sekolah a ON p.asal_sekolah_id = a.asal_sekolah_id
        WHERE 
            j.jenjang = '$jenjang'";

$result = $conn->query($sql);

$pdf = new TCPDF();
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 12);

$html = '<h2>Data Pendaftar Jenjang ' . $jenjang . '</h2>';
$html .= '<table border="1">
            <tr>
                <th>No.</th>
                <th>Nama Lengkap</th>
                <th>Tempat, Tanggal Lahir</th>
                <th>NIK</th>
                <th>Alamat</th>
                <th>NISN</th>
                <th>Asal Sekolah</th>
            </tr>';

$nomor = 1;
while ($row = $result->fetch_assoc()) {
    $html .= '<tr>
                <td>' . $nomor . '</td>
                <td>' . $row["nama_lengkap"] . '</td>
                <td>' . $row["tempat_lahir"] . ', ' . $row["tanggal_lahir"] . '</td>
                <td>' . $row["nik"] . '</td>
                <td>' . $row["alamat_lengkap"] . '</td>
                <td>' . $row["nisn"] . '</td>
                <td>' . $row["nama_sekolah"] . '</td>
            </tr>';
    $nomor++;
}

$html .= '</table>';

$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output('data_pendaftar_' . $jenjang . '.pdf', 'D');

$conn->close();
