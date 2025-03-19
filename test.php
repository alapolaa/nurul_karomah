<?php
session_start();
include 'koneksi.php';
include 'fungsi_wilayah.php';

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect ke halaman login jika belum login
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
                header("Location: orang_tua.php?pendaftar_id=" . $pendaftar_id);
                exit();
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Form Pendaftaran</title>
</head>

<body>
    <h2>Form Pendaftaran</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?jadwal_id=" . $jadwal_id; ?>">
        NISN: <input type="text" name="nisn" required><br><br>
        NIK: <input type="text" name="nik" required><br><br>
        Nama Lengkap: <input type="text" name="nama_lengkap" required><br><br>
        Jenis Kelamin:
        <select name="jenis_kelamin">
            <option value="Laki-laki">Laki-laki</option>
            <option value="Perempuan">Perempuan</option>
        </select><br><br>
        Tempat Lahir: <input type="text" name="tempat_lahir" required><br><br>
        Tanggal Lahir: <input type="date" name="tanggal_lahir" required><br><br>
        Alamat Lengkap: <textarea name="alamat_lengkap" required></textarea><br><br>
        Agama:
        <select name="agama">
            <option value="Islam">Islam</option>
            <option value="Kristen">Kristen</option>
            <option value="Katolik">Katolik</option>
            <option value="Hindu">Hindu</option>
            <option value="Buddha">Buddha</option>
            <option value="Konghucu">Konghucu</option>
        </select><br><br>
        No. Telp: <input type="text" name="no_telp" required><br><br>
        Provinsi:
        <select name="province_id" id="province">
            <option value="">Pilih Provinsi</option>
            <?php foreach ($provinces as $province): ?>
                <option value="<?php echo $province['id']; ?>"><?php echo $province['name']; ?></option>
            <?php endforeach; ?>
        </select><br><br>
        Kabupaten:
        <select name="regency_id" id="regency"></select><br><br>
        Kecamatan:
        <select name="district_id" id="district"></select><br><br>
        Desa:
        <select name="village_id" id="village"></select><br><br>
        <input type="submit" value="Daftar">
    </form>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Dropdown Kabupaten
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

            // Dropdown Kecamatan
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

            // Dropdown Desa
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