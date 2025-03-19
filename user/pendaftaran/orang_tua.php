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
    $nik_ayah = $_POST['nik_ayah'];
    $nama_ayah = $_POST['nama_ayah'];
    $pendidikan_ayah = $_POST['pendidikan_ayah'];
    $pekerjaan_ayah = $_POST['pekerjaan_ayah'];
    $penghasilan_ayah = $_POST['penghasilan_ayah'];
    $no_telp_ayah = $_POST['no_telp_ayah'];

    $nik_ibu = $_POST['nik_ibu'];
    $nama_ibu = $_POST['nama_ibu'];
    $pendidikan_ibu = $_POST['pendidikan_ibu'];
    $pekerjaan_ibu = $_POST['pekerjaan_ibu'];
    $penghasilan_ibu = $_POST['penghasilan_ibu'];
    $no_telp_ibu = $_POST['no_telp_ibu'];

    $nik_wali = $_POST['nik_wali'];
    $nama_wali = $_POST['nama_wali'];
    $pendidikan_wali = $_POST['pendidikan_wali'];
    $pekerjaan_wali = $_POST['pekerjaan_wali'];
    $penghasilan_wali = $_POST['penghasilan_wali'];
    $no_telp_wali = $_POST['no_telp_wali'];

    // Query untuk insert data ke tabel orang_tua_wali
    $sql = "INSERT INTO orang_tua_wali (pendaftar_id, nik_ayah, nama_ayah, pendidikan_ayah, pekerjaan_ayah, penghasilan_ayah, no_telp_ayah, nik_ibu, nama_ibu, pendidikan_ibu, pekerjaan_ibu, penghasilan_ibu, no_telp_ibu, nik_wali, nama_wali, pendidikan_wali, pekerjaan_wali, penghasilan_wali, no_telp_wali) VALUES ('$pendaftar_id', '$nik_ayah', '$nama_ayah', '$pendidikan_ayah', '$pekerjaan_ayah', '$penghasilan_ayah', '$no_telp_ayah', '$nik_ibu', '$nama_ibu', '$pendidikan_ibu', '$pekerjaan_ibu', '$penghasilan_ibu', '$no_telp_ibu', '$nik_wali', '$nama_wali', '$pendidikan_wali', '$pekerjaan_wali', '$penghasilan_wali', '$no_telp_wali')";

    if ($conn->query($sql) === TRUE) {
        $orang_tua_wali_id = $conn->insert_id;
        $update_sql = "UPDATE pendaftar SET orang_tua_wali_id = $orang_tua_wali_id WHERE pendaftar_id = $pendaftar_id";
        $conn->query($update_sql);

        header("Location: ../../user/pendaftaran/asal_sekolah.php?pendaftar_id=" . $pendaftar_id);
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Form Orang Tua/Wali</title>
</head>

<body>
    <h2>Form Orang Tua/Wali</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?pendaftar_id=" . $pendaftar_id; ?>">
        <h3>Data Ayah</h3>
        NIK Ayah: <input type="text" name="nik_ayah" required><br>
        Nama Ayah: <input type="text" name="nama_ayah" required><br>
        Pendidikan Ayah: <input type="text" name="pendidikan_ayah"><br>
        Pekerjaan Ayah: <input type="text" name="pekerjaan_ayah"><br>
        Penghasilan Ayah: <input type="number" name="penghasilan_ayah" step="0.01"><br>
        No. Telp Ayah: <input type="text" name="no_telp_ayah"><br>

        <h3>Data Ibu</h3>
        NIK Ibu: <input type="text" name="nik_ibu" required><br>
        Nama Ibu: <input type="text" name="nama_ibu" required><br>
        Pendidikan Ibu: <input type="text" name="pendidikan_ibu"><br>
        Pekerjaan Ibu: <input type="text" name="pekerjaan_ibu"><br>
        Penghasilan Ibu: <input type="number" name="penghasilan_ibu" step="0.01"><br>
        No. Telp Ibu: <input type="text" name="no_telp_ibu"><br>

        <h3>Data Wali (Opsional)</h3>
        NIK Wali: <input type="text" name="nik_wali"><br>
        Nama Wali: <input type="text" name="nama_wali"><br>
        Pendidikan Wali: <input type="text" name="pendidikan_wali"><br>
        Pekerjaan Wali: <input type="text" name="pekerjaan_wali"><br>
        Penghasilan Wali: <input type="number" name="penghasilan_wali" step="0.01"><br>
        No. Telp Wali: <input type="text" name="no_telp_wali"><br>

        <input type="submit" value="Simpan">
    </form>
</body>

</html>

<?php
$conn->close();
?>