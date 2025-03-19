<?php
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
    // Tangani unggahan file pas foto
    $pas_foto_name = $_FILES['pas_foto']['name'];
    $pas_foto_tmp = $_FILES['pas_foto']['tmp_name'];
    $pas_foto_path = "../../uploads/" . $pas_foto_name; // Direktori tujuan

    move_uploaded_file($pas_foto_tmp, $pas_foto_path);

    // Tangani unggahan file ijazah depan
    $ijazah_depan_name = $_FILES['ijazah_depan']['name'];
    $ijazah_depan_tmp = $_FILES['ijazah_depan']['tmp_name'];
    $ijazah_depan_path = "../../uploads/" . $ijazah_depan_name; // Direktori tujuan

    move_uploaded_file($ijazah_depan_tmp, $ijazah_depan_path);

    // Tangani unggahan file ijazah belakang
    $ijazah_belakang_name = $_FILES['ijazah_belakang']['name'];
    $ijazah_belakang_tmp = $_FILES['ijazah_belakang']['tmp_name'];
    $ijazah_belakang_path = "../../uploads/" . $ijazah_belakang_name; // Direktori tujuan

    move_uploaded_file($ijazah_belakang_tmp, $ijazah_belakang_path);

    // Query untuk insert data ke tabel berkas_pendaftaran
    $sql = "INSERT INTO berkas_pendaftaran (pendaftar_id, pas_foto, ijazah_depan, ijazah_belakang) VALUES ('$pendaftar_id', '$pas_foto_path', '$ijazah_depan_path', '$ijazah_belakang_path')";

    if ($conn->query($sql) === TRUE) {
        $berkas_pendaftaran_id = $conn->insert_id;
        $update_sql = "UPDATE pendaftar SET berkas_pendaftaran_id = $berkas_pendaftaran_id WHERE pendaftar_id = $pendaftar_id";
        $conn->query($update_sql);

        header("Location: ../../user/index.php");
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
    <title>Form Berkas Pendaftaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function showAccountUsedAlert(event) {
            event.preventDefault();
            Swal.fire({
                icon: 'success',
                title: 'Pendaftaran berhasil',
                confirmButtonText: 'Okey'
            }).then((result) => {
                if (result.isConfirmed) {
                    event.target.submit();
                }
            });
        }
    </script>
</head>

<body>
    <div class="container mt-5" style="max-width: 500px;">
        <h2 class="text-center">Berkas Pendaftaran</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?pendaftar_id=" . $pendaftar_id; ?>" enctype="multipart/form-data" onsubmit="showAccountUsedAlert(event)">
            <div class="mb-3">
                <label class="form-label">Pas Foto</label>
                <input type="file" name="pas_foto" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Ijazah Depan</label>
                <input type="file" name="ijazah_depan" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Ijazah Belakang</label>
                <input type="file" name="ijazah_belakang" class="form-control" required>
            </div>
            <div class="text-center d-grid gap-2">
                <button type="submit" class="btn btn-primary btn-lg">Simpan</button>
                <a href="javascript:history.back()" class="btn btn-secondary btn-lg">Kembali</a>
            </div>
        </form>
    </div>
</body>

</html>




<?php
$conn->close();
?>