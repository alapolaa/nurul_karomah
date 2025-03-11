<?php
session_start();
include 'config.php';

// Cek apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect ke halaman login jika belum login
    exit();
}

// Ambil user_id dan jadwal_pendaftaran_id dari session
$user_id = $_SESSION['user_id'];
$jadwal_pendaftaran_id = isset($_GET['id']) ? $_GET['id'] : (isset($_SESSION['jadwal_pendaftaran_id']) ? $_SESSION['jadwal_pendaftaran_id'] : null);

// Fetch data provinsi, kabupaten/kota, kecamatan, desa/kelurahan
$provinceSql = "SELECT id, name FROM provinces";
$provinceResult = $conn->query($provinceSql);

$regencySql = "SELECT id, name FROM regencies";
$regencyResult = $conn->query($regencySql);

$districtSql = "SELECT id, name FROM districts";
$districtResult = $conn->query($districtSql);

$villageSql = "SELECT id, name FROM villages";
$villageResult = $conn->query($villageSql);

// Fetch data jadwal pendaftaran
$jadwalSql = "SELECT jadwal_pendaftaran_id FROM jadwal_pendaftaran";
$jadwalResult = $conn->query($jadwalSql);

?>

<!DOCTYPE html>
<html>

<head>
    <title>Pendaftaran</title>
</head>

<body>
    <h2>Form Pendaftaran</h2>
    <form action="create_pendaftaran.php" method="post">
        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
        <input type="hidden" name="jadwal_pendaftaran_id" value="<?php echo $jadwal_pendaftaran_id; ?>">

        <label>NISN:</label>
        <input type="text" name="nisn" required><br>

        <label>NIK:</label>
        <input type="text" name="nik" required><br>

        <label>Nama Lengkap:</label>
        <input type="text" name="nama_lengkap" required><br>

        <label>Jenis Kelamin:</label>
        <select name="jenis_kelamin" required>
            <option value="Laki-laki">Laki-laki</option>
            <option value="Perempuan">Perempuan</option>
        </select><br>

        <label>Tempat Lahir:</label>
        <input type="text" name="tempat_lahir" required><br>

        <label>Tanggal Lahir:</label>
        <input type="date" name="tanggal_lahir" required><br>

        <label>Alamat Lengkap:</label>
        <textarea name="alamat_lengkap" required></textarea><br>

        <label>Agama:</label>
        <select name="agama" required>
            <option value="Islam">Islam</option>
            <option value="Kristen">Kristen</option>
            <option value="Katolik">Katolik</option>
            <option value="Hindu">Hindu</option>
            <option value="Buddha">Buddha</option>
            <option value="Konghucu">Konghucu</option>
        </select><br>

        <label>No. Telp:</label>
        <input type="text" name="no_telp" required><br>

        <label>Provinsi:</label>
        <select name="province_id" required>
            <?php while ($provinceRow = $provinceResult->fetch_assoc()) { ?>
                <option value="<?php echo $provinceRow["id"]; ?>"><?php echo $provinceRow["name"]; ?></option>
            <?php } ?>
        </select><br>

        <label>Kabupaten/Kota:</label>
        <select name="regency_id" required>
            <?php while ($regencyRow = $regencyResult->fetch_assoc()) { ?>
                <option value="<?php echo $regencyRow["id"]; ?>"><?php echo $regencyRow["name"]; ?></option>
            <?php } ?>
        </select><br>

        <label>Kecamatan:</label>
        <select name="district_id" required>
            <?php while ($districtRow = $districtResult->fetch_assoc()) { ?>
                <option value="<?php echo $districtRow["id"]; ?>"><?php echo $districtRow["name"]; ?></option>
            <?php } ?>
        </select><br>

        <label>Desa/Kelurahan:</label>
        <select name="village_id" required>
            <?php while ($villageRow = $villageResult->fetch_assoc()) { ?>
                <option value="<?php echo $villageRow["id"]; ?>"><?php echo $villageRow["name"]; ?></option>
            <?php } ?>
        </select><br>

        <input type="submit" value="Daftar">
    </form>
</body>

</html>

<?php $conn->close(); ?>