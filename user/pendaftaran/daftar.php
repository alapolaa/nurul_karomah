<?php
session_start();

// Pastikan pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$jadwal_pendaftaran_id = null;

// Cek apakah jadwal_id diterima dari URL
if (isset($_GET['jadwal_id']) && !empty($_GET['jadwal_id']) && !isset($_GET['id'])) {
    $jadwal_pendaftaran_id = $_GET['jadwal_id'];
} elseif (isset($_GET['jadwal_id']) && empty($_GET['jadwal_id']) && !isset($_GET['id'])) {
    echo '<div class="error-message">ID Jadwal Pendaftaran tidak valid.</div>';
    exit();
}
// Bagian ini menangani AJAX request untuk dropdown wilayah, jadi tidak perlu diexit jika ada jadwal_id dan id
// elseif (isset($_GET['jadwal_id']) && isset($_GET['id'])) {
// } elseif (!isset($_GET['jadwal_id']) && !isset($_GET['id'])) {
// }


// Konfigurasi database
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = 'root';
$dbname = 'ppdb';
$dbdsn = "mysql:dbname={$dbname};host={$dbhost}";
$db = null; // Inisialisasi $db sebagai null
try {
    $db = new PDO($dbdsn, $dbuser, $dbpass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo '<div class="error-message">Koneksi database gagal: ' . $e->getMessage() . '</div>';
    die();
}

$success_message = "";
$error_message = "";

// --- Bagian Penting: Mengambil Jenjang dari Database ---
$jenjang = null;
if ($jadwal_pendaftaran_id) {
    try {
        // PERHATIAN: Pastikan nama kolom di database adalah 'jadwal_pendaftaran_id'
        $stmt_jenjang = $db->prepare("SELECT jenjang FROM jadwal_pendaftaran WHERE jadwal_pendaftaran_id = ?");
        $stmt_jenjang->execute([$jadwal_pendaftaran_id]);
        $result_jenjang = $stmt_jenjang->fetch(PDO::FETCH_ASSOC);
        if ($result_jenjang) {
            $jenjang = $result_jenjang['jenjang'];
        } else {
            $error_message = "<div class='error-message'>Jadwal Pendaftaran tidak ditemukan.</div>";
        }
    } catch (PDOException $e) {
        $error_message = "<div class='error-message'>Error saat mengambil data jenjang: " . $e->getMessage() . "</div>";
    }
} else {
    // Jika jadwal_id tidak ada, mungkin perlu penanganan khusus atau redirect
    // Misalnya: header("Location: ../jadwal/jadwal_pendaftaran.php"); exit();
    // Untuk saat ini, kita biarkan saja agar halaman bisa diakses tanpa jadwal_id untuk AJAX wilayah
}
// --- Akhir Bagian Penting ---

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $nisn = $_POST["nisn"];
    $nik = $_POST["nik"];
    $nama_lengkap = $_POST["nama_lengkap"];
    $jenis_kelamin = $_POST["jenis_kelamin"];
    $tempat_lahir = $_POST["tempat_lahir"];
    $tanggal_lahir = $_POST["tanggal_lahir"];
    $alamat_lengkap = $_POST["alamat_lengkap"];
    $agama = $_POST["agama"];
    $no_telpon = $_POST["no_telpon"];
    $wilayah_provinsi_kode = $_POST["wilayah_provinsi_kode"];
    $wilayah_kabupaten_kode = $_POST["wilayah_kabupaten_kode"];
    $wilayah_kecamatan_kode = $_POST["wilayah_kecamatan_kode"];
    $wilayah_dusun_kode = $_POST["wilayah_dusun_kode"];

    // --- LOGIKA PENTING UNTUK NISN ---
    // Jika jenjang bukan MTS atau MA DAN NISN yang diterima kosong, set NISN menjadi NULL
    if (empty($nisn) && ($jenjang !== 'MTS' && $jenjang !== 'MA')) {
        $nisn = null; // Ini akan disimpan sebagai NULL di database
    } elseif (empty($nisn) && ($jenjang === 'MTS' || $jenjang === 'MA')) {
        // Ini adalah kasus di mana NISN seharusnya diisi tapi kosong
        $error_message = "<div class='error-message'>NISN wajib diisi untuk jenjang MTS dan MA.</div>";
        // Anda bisa menambahkan 'exit()' di sini jika ingin menghentikan proses jika NISN kosong untuk MTS/MA
        // atau biarkan kode berlanjut dan error akan ditangkap oleh database (jika NISN NOT NULL)
    }
    // --- AKHIR LOGIKA NISN ---

    // Ambil nama wilayah berdasarkan kode
    $wilayah_provinsi_nama = "";
    if (!empty($wilayah_provinsi_kode)) {
        $stmt_provinsi = $db->prepare("SELECT nama FROM wilayah WHERE kode = ?");
        $stmt_provinsi->execute([$wilayah_provinsi_kode]);
        $provinsi = $stmt_provinsi->fetch(PDO::FETCH_ASSOC);
        if ($provinsi) {
            $wilayah_provinsi_nama = $provinsi['nama'];
        }
    }

    $wilayah_kabupaten_nama = "";
    if (!empty($wilayah_kabupaten_kode)) {
        $stmt_kabupaten = $db->prepare("SELECT nama FROM wilayah WHERE kode = ?");
        $stmt_kabupaten->execute([$wilayah_kabupaten_kode]);
        $kabupaten = $stmt_kabupaten->fetch(PDO::FETCH_ASSOC);
        if ($kabupaten) {
            $wilayah_kabupaten_nama = $kabupaten['nama'];
        }
    }

    $wilayah_kecamatan_nama = "";
    if (!empty($wilayah_kecamatan_kode)) {
        $stmt_kecamatan = $db->prepare("SELECT nama FROM wilayah WHERE kode = ?");
        $stmt_kecamatan->execute([$wilayah_kecamatan_kode]);
        $kecamatan = $stmt_kecamatan->fetch(PDO::FETCH_ASSOC);
        if ($kecamatan) {
            $wilayah_kecamatan_nama = $kecamatan['nama'];
        }
    }

    $wilayah_dusun_nama = "";
    if (!empty($wilayah_dusun_kode)) {
        $stmt_dusun = $db->prepare("SELECT nama FROM wilayah WHERE kode = ?");
        $stmt_dusun->execute([$wilayah_dusun_kode]);
        $dusun = $stmt_dusun->fetch(PDO::FETCH_ASSOC);
        if ($dusun) {
            $wilayah_dusun_nama = $dusun['nama'];
        }
    }

    // Hanya lanjutkan penyimpanan jika tidak ada error NISN
    if (empty($error_message)) {
        // Query untuk menyimpan data pendaftar
        $sql = "INSERT INTO pendaftar (user_id, nisn, nik, nama_lengkap, jenis_kelamin, tempat_lahir, tanggal_lahir, alamat_lengkap, agama, no_telpon, wilayah_provinsi_kode, wilayah_provinsi_nama, wilayah_kabupaten_kode, wilayah_kabupaten_nama, wilayah_kecamatan_kode, wilayah_kecamatan_nama, wilayah_dusun_kode, wilayah_dusun_nama, jadwal_pendaftaran_id)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        try {
            $stmt = $db->prepare($sql);
            $stmt->bindParam(1, $user_id);
            // Gunakan PDO::PARAM_STR agar PDO otomatis menangani NULL dengan benar
            $stmt->bindParam(2, $nisn, PDO::PARAM_STR);
            $stmt->bindParam(3, $nik);
            $stmt->bindParam(4, $nama_lengkap);
            $stmt->bindParam(5, $jenis_kelamin);
            $stmt->bindParam(6, $tempat_lahir);
            $stmt->bindParam(7, $tanggal_lahir);
            $stmt->bindParam(8, $alamat_lengkap);
            $stmt->bindParam(9, $agama);
            $stmt->bindParam(10, $no_telpon);
            $stmt->bindParam(11, $wilayah_provinsi_kode);
            $stmt->bindParam(12, $wilayah_provinsi_nama);
            $stmt->bindParam(13, $wilayah_kabupaten_kode);
            $stmt->bindParam(14, $wilayah_kabupaten_nama);
            $stmt->bindParam(15, $wilayah_kecamatan_kode);
            $stmt->bindParam(16, $wilayah_kecamatan_nama);
            $stmt->bindParam(17, $wilayah_dusun_kode);
            $stmt->bindParam(18, $wilayah_dusun_nama);
            $stmt->bindParam(19, $jadwal_pendaftaran_id);
            $stmt->execute();

            $pendaftar_id = $db->lastInsertId();

            // Redirect ke halaman selanjutnya
            header("Location: ../../user/pendaftaran/orang_tua.php?pendaftar_id=" . $pendaftar_id);
            exit();
        } catch (PDOException $e) {
            $error_message = "<div class='error-message'>Error saat menyimpan data: " . $e->getMessage() . "</div>";
        }
    }
}

// Konfigurasi untuk dropdown wilayah dinamis (tidak diubah)
$wil = array(
    2 => array(5, 'Kota/Kabupaten', 'kab'),
    5 => array(8, 'Kecamatan', 'kec'),
    8 => array(13, 'Kelurahan/Dusun', 'kel')
);

// Bagian ini hanya dieksekusi jika ada request AJAX untuk wilayah
if (isset($_GET['id']) && !empty($_GET['id']) && isset($_GET['target'])) {
    $n = strlen($_GET['id']);
    if (isset($wil[$n])) {
        $query = $db->prepare("SELECT kode, nama FROM wilayah WHERE LEFT(kode,:n)=:id AND CHAR_LENGTH(kode)=:m ORDER BY nama");
        $query->execute(array(':n' => $n, ':id' => $_GET['id'], ':m' => $wil[$n][0]));
        echo "<option value=''>Pilih {$wil[$n][1]}</option>";
        while ($d = $query->fetchObject()) {
            echo "<option value='{$d->kode}'>{$d->nama}</option>";
        }
    }
    die(); // Penting untuk menghentikan eksekusi setelah melayani AJAX request
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pendaftaran</title>
    <style>
        body {
            font-family: sans-serif;
            margin: 20px;
        }

        form {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="date"],
        input[type="tel"],
        select,
        textarea {
            width: calc(100% - 12px);
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 3px;
            box-sizing: border-box;
        }

        input[type="radio"] {
            margin-right: 5px;
        }

        button[type="submit"] {
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            display: block;
            width: calc(100% - 12px);
            box-sizing: border-box;
            margin-bottom: 10px;
        }

        button[type="submit"]:hover {
            background-color: #0056b3;
        }

        .kembali-button {
            background-color: #6c757d;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            text-decoration: none;
            display: flex;
            justify-content: center;
            align-items: center;
            width: calc(100% - 12px);
            box-sizing: border-box;
        }

        .kembali-button:hover {
            background-color: #5a6268;
        }

        .success-message {
            color: green;
            margin-top: 10px;
            font-weight: bold;
        }

        .error-message {
            color: red;
            margin-top: 10px;
            font-weight: bold;
        }
    </style>
    <script>
        var my_ajax = do_ajax();
        var ids;
        var wil_lengths = {
            'prov': 2,
            'kab': 5,
            'kec': 8,
            'kel': 13
        };
        var wil_names = {
            2: ['Kota/Kabupaten', 'kab'],
            5: ['Kecamatan', 'kec'],
            8: ['Kelurahan/Dusun', 'kel']
        };

        function ajax(id, target_id) {
            if (id.length < 13) {
                ids = id;
                // Pastikan jadwal_id ikut terkirim di URL AJAX jika diperlukan untuk konteks
                var jadwalId = new URLSearchParams(window.location.search).get('jadwal_id');
                var url = "?id=" + id + "&target=" + target_id + "&sid=" + Math.random();
                if (jadwalId) {
                    url += "&jadwal_id=" + jadwalId; // Tambahkan jadwal_id ke URL AJAX
                }

                my_ajax.onreadystatechange = function() {
                    stateChanged(target_id);
                };
                my_ajax.open("GET", url, true);
                my_ajax.send(null);
            }
        }

        function do_ajax() {
            if (window.XMLHttpRequest) return new XMLHttpRequest();
            if (window.ActiveXObject) return new ActiveXObject("Microsoft.XMLHTTP");
            return null;
        }

        function stateChanged(target_id) {
            if (my_ajax.readyState == 4) {
                var data = my_ajax.responseText;
                document.getElementById(target_id).innerHTML = data.length >= 0 ? data : "<option value=''>Pilih</option>";
            }
        }

        // Fungsi ini tidak melakukan apa-apa di kode Anda, bisa dihapus atau diisi jika ada inisialisasi dropdown awal
        function loadInitialDropdowns() {
            // Contoh: Jika Anda ingin memuat provinsi secara otomatis saat halaman pertama kali dimuat
            // ajax('', 'prov');
        }

        window.onload = loadInitialDropdowns;
    </script>
</head>

<body>
    <h1 style="text-align: center;">Form Pendaftaran</h1>

    <?php echo $success_message; ?>
    <?php echo $error_message; ?>

    <form method="POST">
        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
        <input type="hidden" name="jadwal_pendaftaran_id" value="<?php echo htmlspecialchars($jadwal_pendaftaran_id); ?>">

        <?php if ($jenjang == 'MTS' || $jenjang == 'MA') : ?>
            <div>
                <label for="nisn">NISN:</label>
                <input type="text" id="nisn" name="nisn" required>
            </div>
        <?php else : ?>
            <input type="hidden" name="nisn" value="">
        <?php endif; ?>
        <div>
            <label for="nik">NIK:</label>
            <input type="text" id="nik" name="nik" required>
        </div>
        <div>
            <label for="nama_lengkap">Nama Lengkap:</label>
            <input type="text" id="nama_lengkap" name="nama_lengkap" required>
        </div>
        <div>
            <label>Jenis Kelamin:</label><br>
            <input type="radio" id="laki-laki" name="jenis_kelamin" value="Laki-laki" required>
            <label for="laki-laki">Laki-laki</label>
            <input type="radio" id="perempuan" name="jenis_kelamin" value="Perempuan" required>
            <label for="perempuan">Perempuan</label>
        </div>
        <div>
            <label for="tempat_lahir">Tempat Lahir:</label>
            <input type="text" id="tempat_lahir" name="tempat_lahir">
        </div>
        <div>
            <label for="tanggal_lahir">Tanggal Lahir:</label>
            <input type="date" id="tanggal_lahir" name="tanggal_lahir">
        </div>
        <div>
            <label for="alamat_lengkap">Alamat Lengkap:</label>
            <textarea id="alamat_lengkap" name="alamat_lengkap"></textarea>
        </div>
        <div>
            <label for="agama">Agama:</label>
            <select id="agama" name="agama">
                <option value="">Pilih Agama</option>
                <option value="Islam">Islam</option>
                <option value="Kristen">Kristen</option>
                <option value="Katolik">Katolik</option>
                <option value="Hindu">Hindu</option>
                <option value="Buddha">Buddha</option>
                <option value="Konghucu">Konghucu</option>
                <option value="Lain-lain">Lain-lain</option>
            </select>
        </div>
        <div>
            <label for="no_telpon">No. Telpon:</label>
            <input type="tel" id="no_telpon" name="no_telpon">
        </div>
        <div>
            <label for="wilayah_provinsi">Provinsi:</label>
            <select id="prov" name="wilayah_provinsi_kode" onchange="ajax(this.value, 'kab')">
                <option value="">Pilih Provinsi</option>
                <?php
                // Query untuk mengambil data provinsi
                $query_provinsi = $db->prepare("SELECT kode,nama FROM wilayah WHERE CHAR_LENGTH(kode)=2 ORDER BY nama");
                $query_provinsi->execute();
                while ($data_provinsi = $query_provinsi->fetchObject()) {
                    echo '<option value="' . $data_provinsi->kode . '">' . $data_provinsi->nama . '</option>';
                }
                ?>
            </select>
        </div>
        <div>
            <label for="wilayah_kabupaten">Kota/Kabupaten:</label>
            <select id="kab" name="wilayah_kabupaten_kode" onchange="ajax(this.value, 'kec')">
                <option value="">Pilih Kota/Kabupaten</option>
            </select>
        </div>
        <div>
            <label for="wilayah_kecamatan">Kecamatan:</label>
            <select id="kec" name="wilayah_kecamatan_kode" onchange="ajax(this.value, 'kel')">
                <option value="">Pilih Kecamatan</option>
            </select>
        </div>
        <div>
            <label for="wilayah_dusun">Kelurahan/Dusun:</label>
            <select id="kel" name="wilayah_dusun_kode">
                <option value="">Pilih Kelurahan/Dusun</option>
            </select>
        </div>
        <br>
        <button type="submit">Daftar</button>
        <a href="javascript:history.back()" class="kembali-button">Kembali</a>
    </form>

    <?php
    // Tutup koneksi database
    $db = null;
    ?>
</body>

</html>