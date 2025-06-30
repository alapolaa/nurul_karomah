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
    // Pesan ini akan ditampilkan sebagai div, tapi kita juga akan menampilkannya di modal nanti
    echo '<div class="error-message">ID Jadwal Pendaftaran tidak valid.</div>';
    exit();
}

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
$error_message = ""; // Akan berisi string pesan untuk modal

// --- Bagian Penting: Mengambil Jenjang dari Database ---
$jenjang = null;
if ($jadwal_pendaftaran_id) {
    try {
        $stmt_jenjang = $db->prepare("SELECT jenjang FROM jadwal_pendaftaran WHERE jadwal_pendaftaran_id = ?");
        $stmt_jenjang->execute([$jadwal_pendaftaran_id]);
        $result_jenjang = $stmt_jenjang->fetch(PDO::FETCH_ASSOC);
        if ($result_jenjang) {
            $jenjang = $result_jenjang['jenjang'];
        } else {
            $error_message = "Jadwal Pendaftaran tidak ditemukan."; // Pesan untuk modal
        }
    } catch (PDOException $e) {
        $error_message = "Error saat mengambil data jenjang: " . $e->getMessage(); // Pesan untuk modal
    }
}
// --- Akhir Bagian Penting ---

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $nisn = isset($_POST["nisn"]) ? $_POST["nisn"] : ''; // Tangani jika nisn tidak dikirim
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

    // --- LOGIKA PENTING UNTUK VALIDASI NISN (SERVER-SIDE) ---
    $nisn = trim($nisn); // Hapus spasi di awal/akhir
    if ($jenjang === 'MTs' || $jenjang === 'MA') {
        if (empty($nisn)) {
            $error_message = "NISN wajib diisi untuk jenjang MTs dan MA.";
        } elseif (!preg_match('/^\d{10}$/', $nisn)) {
            $error_message = "NISN harus berupa 10 digit angka.";
        }
    } else {
        // Jika NISN tidak wajib (termasuk MI), pastikan NISN adalah NULL
        $nisn = null;
    }
    // --- AKHIR LOGIKA NISN ---

    // --- LOGIKA PENTING UNTUK VALIDASI NIK (SERVER-SIDE) ---
    // Pastikan tidak ada error sebelumnya agar pesan tidak tertimpa
    if (empty($error_message)) {
        $nik = trim($nik); // Hapus spasi di awal/akhir
        if (empty($nik)) {
            $error_message = "NIK wajib diisi.";
        } elseif (!preg_match('/^\d{16}$/', $nik)) {
            $error_message = "NIK harus berupa 16 digit angka.";
        }
    }
    // --- AKHIR LOGIKA NIK ---

    // --- PEMERIKSAAN DUPLIKAT NISN DAN NIK ---
    if (empty($error_message)) { // Hanya lanjutkan jika tidak ada error sebelumnya
        try {
            // Cek duplikat NIK
            $stmt_check_nik = $db->prepare("SELECT COUNT(*) FROM pendaftar WHERE nik = ?");
            $stmt_check_nik->execute([$nik]);
            if ($stmt_check_nik->fetchColumn() > 0) {
                $error_message = "NIK sudah digunakan.";
            }

            // Cek duplikat NISN, hanya jika NISN tidak NULL dan belum ada error NIK
            if ($nisn !== null && empty($error_message)) {
                $stmt_check_nisn = $db->prepare("SELECT COUNT(*) FROM pendaftar WHERE nisn = ?");
                $stmt_check_nisn->execute([$nisn]);
                if ($stmt_check_nisn->fetchColumn() > 0) {
                    $error_message = "NISN sudah digunakan.";
                }
            }
        } catch (PDOException $e) {
            $error_message = "Error saat memeriksa duplikat data: " . $e->getMessage();
        }
    }
    // --- AKHIR PEMERIKSAAN DUPLIKAT ---

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

    // Hanya lanjutkan penyimpanan jika tidak ada error
    if (empty($error_message)) {
        // Query untuk menyimpan data pendaftar
        $sql = "INSERT INTO pendaftar (user_id, nisn, nik, nama_lengkap, jenis_kelamin, tempat_lahir, tanggal_lahir, alamat_lengkap, agama, no_telpon, wilayah_provinsi_kode, wilayah_provinsi_nama, wilayah_kabupaten_kode, wilayah_kabupaten_nama, wilayah_kecamatan_kode, wilayah_kecamatan_nama, wilayah_dusun_kode, wilayah_dusun_nama, jadwal_pendaftaran_id)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        try {
            $stmt = $db->prepare($sql);
            $stmt->bindParam(1, $user_id);
            $stmt->bindParam(2, $nisn, PDO::PARAM_STR); // Menggunakan PARAM_STR karena NISN bisa null
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
            $error_message = "Error saat menyimpan data: " . $e->getMessage(); // Pesan untuk modal
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

        /* --- MODAL STYLES --- */
        .modal {
            display: none;
            /* Hidden by default */
            position: fixed;
            /* Stay in place */
            z-index: 1000;
            /* Sit on top, ensure it's above other elements */
            left: 0;
            top: 0;
            width: 100%;
            /* Full width */
            height: 100%;
            /* Full height */
            overflow: auto;
            /* Enable scroll if needed */
            background-color: rgba(0, 0, 0, 0.4);
            /* Black w/ opacity */
            justify-content: center;
            /* Center horizontally */
            align-items: center;
            /* Center vertically */
        }

        .modal-content {
            background-color: #fefefe;
            margin: auto;
            /* Center vertically and horizontally */
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            /* Could be more or less, depending on screen size */
            max-width: 400px;
            /* Max width for larger screens */
            border-radius: 8px;
            position: relative;
            text-align: center;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
            animation-name: animatetop;
            animation-duration: 0.4s
        }

        /* Add Animation */
        @keyframes animatetop {
            from {
                top: -300px;
                opacity: 0
            }

            to {
                top: 0;
                opacity: 1
            }
        }

        .close-button {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            position: absolute;
            top: 5px;
            right: 10px;
            cursor: pointer;
        }

        .close-button:hover,
        .close-button:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        /* Styles for inline error messages */
        .error-input {
            border: 1px solid red !important;
        }

        .error-message-inline {
            color: red;
            font-size: 0.85em;
            margin-top: -8px;
            /* Mengurangi jarak dengan input di atasnya */
            margin-bottom: 10px;
            display: block;
            /* Memastikan pesan error berada di baris baru */
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
                var jadwalId = new URLSearchParams(window.location.search).get('jadwal_id');
                var url = "?id=" + id + "&target=" + target_id + "&sid=" + Math.random();
                if (jadwalId) {
                    url += "&jadwal_id=" + jadwalId;
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

        // Fungsi untuk menampilkan modal error
        function showModal(message) {
            var modal = document.getElementById("myModal");
            var modalMessage = document.getElementById("modal-message");
            modalMessage.innerHTML = message;
            modal.style.display = "flex"; // Gunakan flex untuk memusatkan konten modal

            var span = document.getElementsByClassName("close-button")[0];
            span.onclick = function() {
                modal.style.display = "none";
            }

            // Saat pengguna mengklik di luar modal, tutup modal
            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            var form = document.querySelector('form');
            var nisnInput = document.getElementById('nisn');
            var nikInput = document.getElementById('nik');
            // Dapatkan jenjang dari PHP, karena validasi NISN bergantung padanya
            var jenjang = "<?php echo $jenjang; ?>";

            // Fungsi untuk validasi NIK
            function validateNik() {
                var nik = nikInput.value.trim();
                var nikError = document.getElementById('nik-error');
                if (nik.length === 0) {
                    nikInput.classList.add('error-input');
                    nikError.textContent = "NIK wajib diisi.";
                    return false;
                } else if (!/^\d{16}$/.test(nik)) {
                    nikInput.classList.add('error-input');
                    nikError.textContent = "NIK harus berupa 16 digit angka.";
                    return false;
                } else {
                    nikInput.classList.remove('error-input');
                    nikError.textContent = "";
                    return true;
                }
            }

            // Fungsi untuk validasi NISN
            function validateNisn() {
                // Periksa apakah elemen nisnInput ada di DOM
                if (!nisnInput) {
                    return true; // Jika bidang NISN tidak ada, anggap valid (tidak ada yang perlu divalidasi)
                }

                var nisn = nisnInput.value.trim();
                var nisnError = document.getElementById('nisn-error');

                if (jenjang === 'MTs' || jenjang === 'MA') {
                    // NISN wajib untuk jenjang MTs dan MA
                    if (nisn.length === 0) {
                        nisnInput.classList.add('error-input');
                        nisnError.textContent = "NISN wajib diisi untuk jenjang MTs dan MA.";
                        return false;
                    } else if (!/^\d{10}$/.test(nisn)) {
                        nisnInput.classList.add('error-input');
                        nisnError.textContent = "NISN harus berupa 10 digit angka.";
                        return false;
                    } else {
                        nisnInput.classList.remove('error-input');
                        nisnError.textContent = "";
                        return true;
                    }
                } else {
                    // Untuk jenjang selain MTs dan MA (termasuk MI), NISN tidak akan ditampilkan,
                    // sehingga validasi ini tidak akan pernah terpanggil untuk input field NISN
                    // jika elemennya tidak ada. Namun, jika ada kasus di mana input disembunyikan
                    // tapi masih ada di DOM dan diisi secara programatis (misal untuk testing),
                    // validasi ini tetap memastikan input yang tidak diharapkan tidak lewat.
                    if (nisn.length > 0) { // Jika ada nilai meskipun seharusnya tidak ditampilkan
                        nisnInput.classList.add('error-input');
                        nisnError.textContent = "NISN tidak diperlukan untuk jenjang ini.";
                        return false;
                    }
                    return true;
                }
            }

            // Tambahkan event listener untuk validasi real-time saat mengetik
            // Cek keberadaan nisnInput sebelum menambahkan event listener
            if (nisnInput) {
                nisnInput.addEventListener('input', validateNisn);
            }
            nikInput.addEventListener('input', validateNik);

            // Tambahkan event listener untuk validasi saat submit form
            form.addEventListener('submit', function(event) {
                var isNisnValid = true; // Default true jika bidang NISN tidak ada
                if (nisnInput) { // Hanya validasi jika elemen NISN ada
                    isNisnValid = validateNisn();
                } else {
                    // Jika NISN input tidak ada (misal jenjang MI), pastikan tidak ada data NISN yang dikirim
                    // atau anggap sudah valid karena tidak ada fieldnya.
                    isNisnValid = true;
                }

                var isNikValid = validateNik();

                if (!isNisnValid || !isNikValid) {
                    event.preventDefault(); // Mencegah pengiriman formulir
                    showModal("Mohon perbaiki kesalahan pada formulir sebelum melanjutkan.");
                }
            });

            // Tampilkan modal jika ada pesan error dari PHP saat halaman dimuat
            <?php if (!empty($error_message)) : ?>
                showModal("<?php echo htmlspecialchars($error_message, ENT_QUOTES, 'UTF-8'); ?>");
            <?php endif; ?>
        });
    </script>
</head>

<body>
    <h1 style="text-align: center;">Form Pendaftaran</h1>

    <form method="POST">
        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
        <input type="hidden" name="jadwal_pendaftaran_id" value="<?php echo htmlspecialchars($jadwal_pendaftaran_id); ?>">

        <?php if ($jenjang == 'MTs' || $jenjang == 'MA') : ?>
            <div>
                <label for="nisn">NISN:</label>
                <input type="text" id="nisn" name="nisn" inputmode="numeric" pattern="\d{10}" title="NISN harus 10 digit angka" maxlength="10">
                <span id="nisn-error" class="error-message-inline"></span>
            </div>
            <?php
            // Untuk jenjang MI, NISN tidak ditampilkan, dan juga tidak ada hidden input untuk NISN
            // karena kita ingin nilai NISN menjadi NULL di database jika tidak diperlukan
            // Biarkan kosong saja di sini
            ?>
        <?php endif; ?>
        <div>
            <label for="nik">NIK:</label>
            <input type="text" id="nik" name="nik" inputmode="numeric" pattern="\d{16}" title="NIK harus 16 digit angka" maxlength="16" required>
            <span id="nik-error" class="error-message-inline"></span>
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

    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close-button">&times;</span>
            <p id="modal-message"></p>
        </div>
    </div>

    <?php
    // Tutup koneksi database
    $db = null;
    ?>
</body>

</html>