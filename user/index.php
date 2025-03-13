<?php
session_start();
include '../config/config.php';

// Pastikan pendaftar_id ada di session
if (!isset($_SESSION['pendaftar_id'])) {
    header("Location: pendaftaran.php"); // Redirect jika pendaftar_id tidak ada
    exit();
}

$pendaftar_id = $_SESSION['pendaftar_id'];

// Ambil data pendaftar
$pendaftarSql = "SELECT * FROM pendaftar WHERE pendaftar_id = '$pendaftar_id'";
$pendaftarResult = $conn->query($pendaftarSql);
$pendaftar = $pendaftarResult->fetch_assoc();

// Ambil data orang tua/wali
$ortuSql = "SELECT * FROM orang_tua_wali WHERE pendaftar_id = '$pendaftar_id'";
$ortuResult = $conn->query($ortuSql);
$ortu = $ortuResult->fetch_assoc();

// Ambil data asal sekolah
$asalSekolahSql = "SELECT * FROM asal_sekolah WHERE pendaftar_id = '$pendaftar_id'";
$asalSekolahResult = $conn->query($asalSekolahSql);
$asalSekolah = $asalSekolahResult->fetch_assoc();

// Ambil data berkas pendaftaran
$berkasSql = "SELECT * FROM berkas_pendaftaran WHERE pendaftar_id = '$pendaftar_id'";
$berkasResult = $conn->query($berkasSql);
$berkas = $berkasResult->fetch_assoc();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Data Siswa</title>
</head>

<body>
    <h2>Data Pendaftar</h2>
    <p>Nama: <?php echo $pendaftar['nama_lengkap']; ?></p>
    <p>NISN: <?php echo $pendaftar['nisn']; ?></p>
    <p>NIK: <?php echo $pendaftar['nik']; ?></p>
    <p>Jenis Kelamin: <?php echo $pendaftar['jenis_kelamin']; ?></p>
    <p>Tempat Lahir: <?php echo $pendaftar['tempat_lahir']; ?></p>
    <p>Tanggal Lahir: <?php echo $pendaftar['tanggal_lahir']; ?></p>
    <p>Alamat: <?php echo $pendaftar['alamat_lengkap']; ?></p>
    <p>Agama: <?php echo $pendaftar['agama']; ?></p>
    <p>Nomor Telpon: <?php echo $pendaftar['no_telp']; ?></p>
    <p>Status: <?php echo $pendaftar['status']; ?></p>
    <p>NIK: <?php echo $pendaftar['nik']; ?></p>
    <p>Provinsi: <?php echo $pendaftar['province_id']; ?></p>
    <p>Kabupaten/Kota: <?php echo $pendaftar['regency_id']; ?></p>
    <p>Kecamatan: <?php echo $pendaftar['district_id']; ?></p>
    <p>Keluarah/Desa: <?php echo $pendaftar['village_id']; ?></p>
    <p>...</p>

    <h2>Data Orang Tua/Wali</h2>
    <p>Nama Ayah: <?php echo $ortu['nama_ayah']; ?></p>
    <p>NIK Ayah: <?php echo $ortu['nik_ayah']; ?></p>
    <p>Nama Ibu: <?php echo $ortu['nama_ibu']; ?></p>
    <p>NIK Ibu: <?php echo $ortu['nik_ibu']; ?></p>
    <p>...</p>

    <h2>Data Asal Sekolah</h2>
    <p>NPSN: <?php echo $asalSekolah['npsn']; ?></p>
    <p>Nama Sekolah: <?php echo $asalSekolah['nama_sekolah']; ?></p>
    <p>...</p>

    <h2>Data Berkas Pendaftaran</h2>
    <p>Pas Foto: <a href="../user/pendaftaran/berkas/<?php echo $berkas['pas_foto']; ?>" target="_blank">Lihat</a></p>
    <p>Ijazah Depan: <a href="../user/pendaftaran/berkas/<?php echo $berkas['ijazah_depan']; ?>" target="_blank">Lihat</a></p>
    <p>Ijazah Belakang: <a href="../user/pendaftaran/berkas/<?php echo $berkas['ijazah_belakang']; ?>" target="_blank">Lihat</a></p>
    <p>...</p>
    <a href="../auth/login.php">logout</a>

</body>

</html>

<?php $conn->close(); ?>