<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include '../../../config/config.php';

// Pastikan pendaftar_id ada di session
if (!isset($_SESSION['pendaftar_id'])) {
    header("Location: pendaftaran.php"); // Redirect jika pendaftar_id tidak ada
    exit();
}

$pendaftar_id = $_SESSION['pendaftar_id'];

// Fetch data from asal_sekolah table
$sql = "SELECT a.*, p.nama_lengkap FROM asal_sekolah a JOIN pendaftar p ON a.pendaftar_id = p.pendaftar_id";
$result = $conn->query($sql);

if (!$result) {
    die("Query gagal: " . $conn->error);
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Asal Sekolah CRUD</title>
</head>

<body>


    <h2>Tambah Asal Sekolah</h2>
    <form action="../../../user/pendaftaran/sekolah/create_asal_sekolah.php" method="post">
        <label>NPSN:</label>
        <input type="text" name="npsn" required><br>
        <label>Nama Sekolah:</label>
        <input type="text" name="nama_sekolah" required><br>
        <input type="hidden" name="pendaftar_id" value="<?php echo $pendaftar_id; ?>">
        <input type="submit" value="Tambah">
    </form>

</body>

</html>

<?php
$conn->close();
?>