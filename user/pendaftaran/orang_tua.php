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
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Orang Tua/Wali</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5" style="max-width: 500px;">
        <h2 class="text-center">Form Orang Tua/Wali</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?pendaftar_id=" . $pendaftar_id; ?>">
            <div class="card p-3 mb-3">
                <h4>Data Ayah</h4>
                <div class="mb-2">
                    <label class="form-label">NIK Ayah</label>
                    <input type="text" name="nik_ayah" class="form-control" required>
                </div>
                <div class="mb-2">
                    <label class="form-label">Nama Ayah</label>
                    <input type="text" name="nama_ayah" class="form-control" required>
                </div>
                <div class="mb-2">
                    <label class="form-label">Pendidikan Ayah</label>
                    <input type="text" name="pendidikan_ayah" class="form-control">
                </div>
                <div class="mb-2">
                    <label class="form-label">Pekerjaan Ayah</label>
                    <input type="text" name="pekerjaan_ayah" class="form-control">
                </div>
                <div class="mb-2">
                    <label class="form-label">Penghasilan Ayah</label>
                    <input type="text" name="penghasilan_ayah" class="form-control">
                </div>
                <div class="mb-2">
                    <label class="form-label">No. Telp Ayah</label>
                    <input type="text" name="no_telp_ayah" class="form-control">
                </div>
            </div>

            <div class="card p-3 mb-3">
                <h4>Data Ibu</h4>
                <div class="mb-2">
                    <label class="form-label">NIK Ibu</label>
                    <input type="text" name="nik_ibu" class="form-control" required>
                </div>
                <div class="mb-2">
                    <label class="form-label">Nama Ibu</label>
                    <input type="text" name="nama_ibu" class="form-control" required>
                </div>
                <div class="mb-2">
                    <label class="form-label">Pendidikan Ibu</label>
                    <input type="text" name="pendidikan_ibu" class="form-control">
                </div>
                <div class="mb-2">
                    <label class="form-label">Pekerjaan Ibu</label>
                    <input type="text" name="pekerjaan_ibu" class="form-control">
                </div>
                <div class="mb-2">
                    <label class="form-label">Penghasilan Ibu</label>
                    <input type="text" name="penghasilan_ibu" class="form-control">
                </div>
                <div class="mb-2">
                    <label class="form-label">No. Telp Ibu</label>
                    <input type="text" name="no_telp_ibu" class="form-control">
                </div>
            </div>

            <div class="card p-3 mb-3">
                <h4>Data Wali (Opsional)</h4>
                <div class="mb-2">
                    <label class="form-label">NIK Wali</label>
                    <input type="text" name="nik_wali" class="form-control">
                </div>
                <div class="mb-2">
                    <label class="form-label">Nama Wali</label>
                    <input type="text" name="nama_wali" class="form-control">
                </div>
                <div class="mb-2">
                    <label class="form-label">Pendidikan Wali</label>
                    <input type="text" name="pendidikan_wali" class="form-control">
                </div>
                <div class="mb-2">
                    <label class="form-label">Pekerjaan Wali</label>
                    <input type="text" name="pekerjaan_wali" class="form-control">
                </div>
                <div class="mb-2">
                    <label class="form-label">Penghasilan Wali</label>
                    <input type="text" name="penghasilan_wali" class="form-control">
                </div>
                <div class="mb-2">
                    <label class="form-label">No. Telp Wali</label>
                    <input type="text" name="no_telp_wali" class="form-control">
                </div>
            </div>

            <div class="text-center d-grid gap-2">
                <button type="submit" class="btn btn-primary btn-lg">Selanjutnya</button>
                <!-- <a href="javascript:history.back()" class="btn btn-secondary btn-lg">Kembali</a> -->
                <br>
            </div>
        </form>
    </div>
</body>

</html>


<?php
$conn->close();
?>