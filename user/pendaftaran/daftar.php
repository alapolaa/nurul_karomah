<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include '../../config/config.php';
include '../../user/pendaftaran/fungsi_wilayah.php';

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../auth/login.php"); // Redirect ke halaman login jika belum login
    exit();
}

$user_id = $_SESSION['user_id'];

// Ambil jadwal_id dari parameter URL
if (isset($_GET['jadwal_id'])) {
    $jadwal_id = $_GET['jadwal_id'];
} else {
    // Jika jadwal_id tidak ada, redirect atau tampilkan pesan error
    echo "jadwal_id tidak ditemukan.";
    exit;
}

// Ambil data wilayah
$provinces = getProvinces($conn);

// Proses form jika disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $nisn = $_POST['nisn'];
    $nik = $_POST['nik'];
    $nama_lengkap = $_POST['nama_lengkap'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $tempat_lahir = $_POST['tempat_lahir'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $alamat_lengkap = $_POST['alamat_lengkap'];
    $agama = $_POST['agama'];
    $no_telp = $_POST['no_telp'];
    $province_id = $_POST['province_id'];
    $regency_id = $_POST['regency_id'];
    $district_id = $_POST['district_id'];
    $village_id = $_POST['village_id'];

    // Validasi NISN
    $sql_cek_nisn = "SELECT nisn FROM pendaftar WHERE nisn = '$nisn'";
    $result_nisn = $conn->query($sql_cek_nisn);

    if ($result_nisn->num_rows > 0) {
        echo "<script>alert('NISN sudah digunakan.');</script>";
    } else {
        // Validasi NIK
        $sql_cek_nik = "SELECT nik FROM pendaftar WHERE nik = '$nik'";
        $result_nik = $conn->query($sql_cek_nik);

        if ($result_nik->num_rows > 0) {
            echo "<script>alert('NIK sudah digunakan.');</script>";
        } else {
            // Query untuk insert data ke tabel pendaftar
            $sql = "INSERT INTO pendaftar (user_id, nisn, nik, nama_lengkap, jenis_kelamin, tempat_lahir, tanggal_lahir, alamat_lengkap, agama, no_telp, province_id, regency_id, district_id, village_id, jadwal_pendaftaran_id) VALUES ('$user_id', '$nisn', '$nik', '$nama_lengkap', '$jenis_kelamin', '$tempat_lahir', '$tanggal_lahir', '$alamat_lengkap', '$agama', '$no_telp', '$province_id', '$regency_id', '$district_id', '$village_id','$jadwal_id')";

            if ($conn->query($sql) === TRUE) {
                // Ambil pendaftar_id yang baru saja dibuat
                $pendaftar_id = $conn->insert_id;

                // Redirect ke halaman orang_tua.php dengan pendaftar_id
                header("Location: ../../user/pendaftaran/orang_tua.php?pendaftar_id=" . $pendaftar_id);
                exit();
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pendaftaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg">
                    <div class="card-header bg-primary text-white text-center">
                        <h3 class="mb-0">Form Pendaftaran</h3>
                    </div>
                    <div class="card-body">
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?jadwal_id=" . $jadwal_id; ?>">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nisn" class="form-label">NISN:</label>
                                    <input type="text" class="form-control" id="nisn" name="nisn" placeholder="Masukkan NISN" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="nik" class="form-label">NIK:</label>
                                    <input type="text" class="form-control" id="nik" name="nik" placeholder="Masukkan NIK" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="nama_lengkap" class="form-label">Nama Lengkap:</label>
                                <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" placeholder="Masukkan Nama Lengkap" required>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin:</label>
                                    <select class="form-select" id="jenis_kelamin" name="jenis_kelamin">
                                        <option value="Laki-laki">Laki-laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="agama" class="form-label">Agama:</label>
                                    <select class="form-select" id="agama" name="agama">
                                        <option value="Islam">Islam</option>
                                        <option value="Kristen">Kristen</option>
                                        <option value="Katolik">Katolik</option>
                                        <option value="Hindu">Hindu</option>
                                        <option value="Buddha">Buddha</option>
                                        <option value="Konghucu">Konghucu</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="tempat_lahir" class="form-label">Tempat Lahir:</label>
                                    <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" placeholder="Masukkan Tempat Lahir" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="tanggal_lahir" class="form-label">Tanggal Lahir:</label>
                                    <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="alamat_lengkap" class="form-label">Alamat Lengkap:</label>
                                <textarea class="form-control" id="alamat_lengkap" name="alamat_lengkap" placeholder="Masukkan Alamat Lengkap" rows="3" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="no_telp" class="form-label">No. Telp:</label>
                                <input type="text" class="form-control" id="no_telp" name="no_telp" placeholder="Masukkan No. Telepon" required>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="province" class="form-label">Provinsi:</label>
                                    <select class="form-select" id="province" name="province_id">
                                        <option value="">Pilih Provinsi</option>
                                        <?php foreach ($provinces as $province) : ?>
                                            <option value="<?php echo $province['id']; ?>"><?php echo $province['name']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="regency" class="form-label">Kabupaten:</label>
                                    <select class="form-select" id="regency" name="regency_id"></select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="district" class="form-label">Kecamatan:</label>
                                    <select class="form-select" id="district" name="district_id"></select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="village" class="form-label">Desa:</label>
                                    <select class="form-select" id="village" name="village_id"></select>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-send"></i> Selanjutnya
                                </button>
                                <a href="../../user/jadwal/jadwal_pendaftaran.php" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left"></i> Kembali
                                </a>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tambahkan Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#province').change(function() {
                var province_id = $(this).val();
                $.ajax({
                    url: 'get_regencies.php',
                    type: 'POST',
                    data: {
                        province_id: province_id
                    },
                    success: function(data) {
                        $('#regency').html(data);
                        $('#district').html('<option value="">Pilih Kecamatan</option>');
                        $('#village').html('<option value="">Pilih Desa</option>');
                    }
                });
            });

            $('#regency').change(function() {
                var regency_id = $(this).val();
                $.ajax({
                    url: 'get_districts.php',
                    type: 'POST',
                    data: {
                        regency_id: regency_id
                    },
                    success: function(data) {
                        $('#district').html(data);
                        $('#village').html('<option value="">Pilih Desa</option>');
                    }
                });
            });

            $('#district').change(function() {
                var district_id = $(this).val();
                $.ajax({
                    url: 'get_villages.php',
                    type: 'POST',
                    data: {
                        district_id: district_id
                    },
                    success: function(data) {
                        $('#village').html(data);
                    }
                });
            });
        });
    </script>
</body>

</html>
<?php
$conn->close();
?>