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
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Asal Sekolah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5" style="max-width: 500px;">
        <h2 class="text-center">Asal Sekolah</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?pendaftar_id=" . $pendaftar_id; ?>">
            <div class="card p-3 mb-3">
                <div class="mb-2">
                    <label class="form-label">NPSN</label>
                    <input type="text" name="npsn" class="form-control" required>
                </div>
                <div class="mb-2">
                    <label class="form-label">Nama Sekolah</label>
                    <input type="text" name="nama_sekolah" class="form-control" required>
                </div>
            </div>
            <div class="text-center d-grid gap-2">
                <button type="submit" class="btn btn-primary btn-lg">Selanjutnya</button>
                <a href="javascript:history.back()" class="btn btn-secondary btn-lg">Kembali</a>
            </div>
        </form>
    </div>
</body>

</html>

<?php
$conn->close();
?>