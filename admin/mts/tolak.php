<?php
// Koneksi Database
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "coba";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Pencarian dan Filter
$cari = isset($_GET['cari']) ? $_GET['cari'] : '';
$tahun = isset($_GET['tahun']) ? $_GET['tahun'] : '';
$jenjang = 'MTs';
$status = 'Ditolak';

$sql = "SELECT 
            p.nama_lengkap, 
            p.tempat_lahir, 
            p.tanggal_lahir, 
            p.nik, 
            p.alamat_lengkap, 
            p.nisn, 
            a.nama_sekolah
        FROM 
            pendaftar p
        JOIN 
            jadwal_pendaftaran j ON p.jadwal_pendaftaran_id = j.jadwal_pendaftaran_id
        LEFT JOIN 
            asal_sekolah a ON p.asal_sekolah_id = a.asal_sekolah_id
        WHERE 
             j.jenjang = '$jenjang' AND p.status = '$status'";

if (!empty($cari)) {
    $sql .= " AND (p.nama_lengkap LIKE '%$cari%' OR p.nisn LIKE '%$cari%')";
}

if (!empty($tahun)) {
    $sql .= " AND j.tahun_ajaran = '$tahun'";
}

$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Halaman Admin</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <link href="img/favicon.ico" rel="icon">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Handlee&family=Nunito&display=swap" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <link href="lib/flaticon/font/flaticon.css" rel="stylesheet">

    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/lightbox/css/lightbox.min.css" rel="stylesheet">

    <link href="../../css/style.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<style>
    table {
        width: 100%;
        border-collapse: collapse;
    }

    th,
    td {
        border: 1px solid black;
        padding: 8px;
        text-align: left;
    }

    .hidden {
        display: none;
    }

    .fixed-image {
        width: 100%;
        /* Sesuaikan dengan lebar card */
        height: 250px;
        /* Atur tinggi gambar agar seragam */
        object-fit: cover;
        /* Pangkas gambar agar tetap proporsional */
        border-top-left-radius: 8px;
        /* Bikin sudut atas gambar melengkung sesuai card */
        border-top-right-radius: 8px;
    }
</style>

<body>
    <!-- Navbar Start -->
    <div class="container-fluid bg-light position-relative shadow">
        <nav class="navbar navbar-expand-lg bg-light navbar-light py-3 py-lg-0 px-0 px-lg-5">
            <a href="" class="navbar-brand font-weight-bold text-secondary" style="font-size: 50px; display: inline-flex; align-items: center;">
                <img src="../../img/nurul.png" alt="Logo" style="height: 60px; margin-right: 10px;">
                <span class="text-primary">Nurul Karomah</span>
            </a>
            <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                <div class="navbar-nav font-weight-bold mx-auto py-0">
                    <a href="../../admin/dashboard.php" class="nav-item nav-link ">Home</a>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle " data-toggle="dropdown">Profile Lembaga</a>
                        <div class="dropdown-menu rounded-0 m-0">
                            <a href="../../admin/sejarah/sejarah.php" class="dropdown-item">Sejarah</a>
                            <a href="../../admin/visi_misi/visi_misi.php" class="dropdown-item">Visi Misi</a>
                            <a href="../../admin/fasilitas/fasilitas.php" class="dropdown-item">Fasilitas</a>
                            <a href="../../admin/prestasi/prestasi.php" class="dropdown-item">Prestasi</a>
                        </div>
                    </div>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle active" data-toggle="dropdown">Akademik</a>
                        <div class="dropdown-menu rounded-0 m-0">
                            <a href="../../admin/mi/mi.php" class="dropdown-item">MI</a>
                            <a href="../../admin/mts/mts.php" class="dropdown-item">MTS</a>
                            <a href="../../admin/ma/ma.php" class="dropdown-item">MA</a>
                        </div>
                    </div>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle " data-toggle="dropdown">Informasi</a>
                        <div class="dropdown-menu rounded-0 m-0">
                            <a href="../../admin/jadwal/jadwal.php" class="dropdown-item">Jadwal Pendaftaran</a>
                            <a href="../../admin/mapel/mapel.php" class="dropdown-item">Mata Pelajaran</a>
                            <a href="../../admin/guru/guru.php" class="dropdown-item">Guru</a>
                            <a href="../../admin/kegiatan/kegiatan.php" class="dropdown-item">Kegiatan</a>
                            <a href="../../admin/galeri/galeri.php" class="dropdown-item">Galeri</a>
                        </div>
                    </div>
                    <a href="../../admin/kelola_admin.php" class="nav-item nav-link">Kelola Admin</a>
                    <a href="../../admin/kotak_masuk/kotak_masuk.php" class="nav-item nav-link">Kotak Masuk</a>
                    <!-- <a href="../../admin/profile.php" class="nav-item nav-link">Profile</a> -->
                    <a href="../../admin/profile/profile.php" class="nav-item nav-link">Profile</a>
                </div>

            </div>
        </nav>
    </div>
    <!-- Navbar End -->
    <div class="container-fluid bg-primary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 250px">
            <a href="" class="navbar-brand font-weight-bold text-secondary" style="font-size: 60px; display: inline-flex; align-items: center;">
                <span class="text-white">Data Pendaftar MTs Ditolak</span>
            </a>

        </div>
    </div>
    <div class="container mt-5">
        <form method="GET" style="margin-bottom: 20px;">
            <fieldset style="border: 1px solid #ccc; padding: 20px; border-radius: 5px;">
                <legend style="font-weight: bold;">Filter Data</legend>
                <div style="margin-bottom: 10px;">
                    <label for="cari" style="display: block; margin-bottom: 5px;">Cari Nama atau NISN:</label>
                    <input type="text" name="cari" id="cari" placeholder="Cari nama atau NISN" value="<?php echo $cari; ?>" style="width: 100%; padding: 8px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px;">
                </div>
                <div style="margin-bottom: 10px;">
                    <label for="tahun" style="display: block; margin-bottom: 5px;">Tahun Ajaran:</label>
                    <select name="tahun" id="tahun" style="width: 100%; padding: 8px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px;">
                        <option value="">Semua Tahun</option>
                        <?php
                        $tahun_sql = "SELECT DISTINCT j.tahun_ajaran FROM jadwal_pendaftaran j";
                        $tahun_result = $conn->query($tahun_sql);
                        if ($tahun_result->num_rows > 0) {
                            while ($tahun_row = $tahun_result->fetch_assoc()) {
                                $selected = ($tahun == $tahun_row["tahun_ajaran"]) ? "selected" : "";
                                echo "<option value='" . $tahun_row["tahun_ajaran"] . "' " . $selected . ">" . $tahun_row["tahun_ajaran"] . "</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <button type="submit" style="background-color: #4CAF50; color: white; padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer;">Filter</button>
            </fieldset>
        </form>

        <div style="display: flex; gap: 10px; margin-bottom: 20px;">
            <form method="POST" action="../../export_pdf.php?jenjang=MI">
                <button type="submit" style="background-color: #008CBA; color: white; padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer;">Ekspor PDF</button>
            </form>
            <form method="GET" action="../../admin/mts/mts.php">
                <button type="submit" style="background-color:rgb(46, 160, 80); color: white; padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer;">Siswa Diterima</button>
            </form>
        </div>

        <table border="1" style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background-color: #f2f2f2;">
                    <th style="padding: 8px; text-align: left;">No.</th>
                    <th style="padding: 8px; text-align: left;">Nama Lengkap</th>
                    <th style="padding: 8px; text-align: left;">Tempat, Tanggal Lahir</th>
                    <th style="padding: 8px; text-align: left;">NIK</th>
                    <th style="padding: 8px; text-align: left;">Alamat</th>
                    <th style="padding: 8px; text-align: left;">NISN</th>
                    <th style="padding: 8px; text-align: left;">Asal Sekolah</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    $nomor = 1;
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td style='padding: 8px;'>" . $nomor . "</td>";
                        echo "<td style='padding: 8px;'>" . $row["nama_lengkap"] . "</td>";
                        echo "<td style='padding: 8px;'>" . $row["tempat_lahir"] . ", " . $row["tanggal_lahir"] . "</td>";
                        echo "<td style='padding: 8px;'>" . $row["nik"] . "</td>";
                        echo "<td style='padding: 8px;'>" . $row["alamat_lengkap"] . "</td>";
                        echo "<td style='padding: 8px;'>" . $row["nisn"] . "</td>";
                        echo "<td style='padding: 8px;'>" . $row["nama_sekolah"] . "</td>";
                        echo "</tr>";
                        $nomor++;
                    }
                } else {
                    echo "<tr><td colspan='7' style='padding: 8px; text-align: center;'>Tidak ada data pendaftar untuk jenjang MTs.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>



    <?php include '../../footer.html'; ?>


    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/isotope/isotope.pkgd.min.js"></script>
    <script src="lib/lightbox/js/lightbox.min.js"></script>

    <!-- Contact Javascript File -->
    <script src="../../mail/jqBootstrapValidation.min.js"></script>
    <script src="../../mail/contact.js"></script>

    <!-- Template Javascript -->
    <script src="../../js/main.js"></script>
</body>

</html>