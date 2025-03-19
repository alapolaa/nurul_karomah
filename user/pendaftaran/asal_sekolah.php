<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
include '../../koneksi.php';

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../auth/login.php");
    exit();
}

// Ambil pendaftar_id dari parameter URL
if (isset($_GET['pendaftar_id'])) {
    $pendaftar_id = $_GET['pendaftar_id'];
} else {
    echo "pendaftar_id tidak ditemukan.";
    exit;
}

// Proses form jika disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $npsn = $_POST['npsn'];
    $nama_sekolah = $_POST['nama_sekolah'];

    // Query untuk insert data ke tabel asal_sekolah
    $sql = "INSERT INTO asal_sekolah (pendaftar_id, npsn, nama_sekolah) VALUES ('$pendaftar_id', '$npsn', '$nama_sekolah')";

    if ($conn->query($sql) === TRUE) {
        $asal_sekolah_id = $conn->insert_id;
        $update_sql = "UPDATE pendaftar SET asal_sekolah_id = $asal_sekolah_id WHERE pendaftar_id = $pendaftar_id";
        $conn->query($update_sql);

        header("Location: ../../user/pendaftaran/berkas_pendaftaran.php?pendaftar_id=" . $pendaftar_id);
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Form Asal Sekolah</title>
</head>

<body>
    <h2>Form Asal Sekolah</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?pendaftar_id=" . $pendaftar_id; ?>">
        NPSN: <input type="text" name="npsn" required><br>
        Nama Sekolah: <input type="text" name="nama_sekolah" required><br>
        <input type="submit" value="Simpan">
    </form>
</body>

</html>

<?php
$conn->close();
?>