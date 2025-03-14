<?php
require_once('vendor/autoload.php');


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

$html = '
<h1>Biodata Pendaftaran Sekolah</h1>
<p>Nama Lengkap: John Doe</p>
<p>Tempat, Tanggal Lahir: Jakarta, 1 Januari 2000</p>
<p>Alamat: Jl. Contoh No. 123</p>
<p>Nomor Telepon: 081234567890</p>
<p>Asal Sekolah: SMA Contoh</p>
';

$pdf->writeHTML($html, true, false, true, false, '');

$pdf->Output('biodata_pendaftaran.pdf', 'D');
