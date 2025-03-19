<?php
session_start();
include 'koneksi.php';

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
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
    // Tangani unggahan file pas foto
    $pas_foto_name = $_FILES['pas_foto']['name'];
    $pas_foto_tmp = $_FILES['pas_foto']['tmp_name'];
    $pas_foto_path = "uploads/" . $pas_foto_name; // Direktori tujuan

    move_uploaded_file($pas_foto_tmp, $pas_foto_path);

    // Tangani unggahan file ijazah depan
    $ijazah_depan_name = $_FILES['ijazah_depan']['name'];
    $ijazah_depan_tmp = $_FILES['ijazah_depan']['tmp_name'];
    $ijazah_depan_path = "uploads/" . $ijazah_depan_name; // Direktori tujuan

    move_uploaded_file($ijazah_depan_tmp, $ijazah_depan_path);

    // Tangani unggahan file ijazah belakang
    $ijazah_belakang_name = $_FILES['ijazah_belakang']['name'];
    $ijazah_belakang_tmp = $_FILES['ijazah_belakang']['tmp_name'];
    $ijazah_belakang_path = "uploads/" . $ijazah_belakang_name; // Direktori tujuan

    move_uploaded_file($ijazah_belakang_tmp, $ijazah_belakang_path);

    // Query untuk insert data ke tabel berkas_pendaftaran
    $sql = "INSERT INTO berkas_pendaftaran (pendaftar_id, pas_foto, ijazah_depan, ijazah_belakang) VALUES ('$pendaftar_id', '$pas_foto_path', '$ijazah_depan_path', '$ijazah_belakang_path')";

    if ($conn->query($sql) === TRUE) {
        $berkas_pendaftaran_id = $conn->insert_id;
        $update_sql = "UPDATE pendaftar SET berkas_pendaftaran_id = $berkas_pendaftaran_id WHERE pendaftar_id = $pendaftar_id";
        $conn->query($update_sql);

        header("Location: user/index.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Form Berkas Pendaftaran</title>
</head>

<body>
    <h2>Form Berkas Pendaftaran</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?pendaftar_id=" . $pendaftar_id; ?>" enctype="multipart/form-data">
        Pas Foto: <input type="file" name="pas_foto" required><br>
        Ijazah Depan: <input type="file" name="ijazah_depan" required><br>
        Ijazah Belakang: <input type="file" name="ijazah_belakang" required><br>
        <input type="submit" value="Simpan">
    </form>
</body>

</html>

<?php
$conn->close();
?>