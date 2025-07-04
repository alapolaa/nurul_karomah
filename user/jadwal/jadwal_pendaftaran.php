<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include '../../config/config.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

function getStatusPendaftaran($tanggal_selesai)
{
    $tanggal_sekarang = date("Y-m-d");
    if ($tanggal_sekarang <= $tanggal_selesai) {
        return "Buka";
    } else {
        return "Tutup";
    }
}

function updateJadwalPendaftaran($conn, $jadwal_id)
{
    $jumlah_pendaftar_sql = "SELECT COUNT(*) as total FROM pendaftar WHERE jadwal_pendaftaran_id = $jadwal_id";
    $jumlah_diterima_sql = "SELECT COUNT(*) as total FROM pendaftar WHERE jadwal_pendaftaran_id = $jadwal_id AND status = 'Diterima'";
    $jumlah_ditolak_sql = "SELECT COUNT(*) as total FROM pendaftar WHERE jadwal_pendaftaran_id = $jadwal_id AND status = 'Ditolak'";

    $jumlah_pendaftar_result = $conn->query($jumlah_pendaftar_sql);
    $jumlah_diterima_result = $conn->query($jumlah_diterima_sql);
    $jumlah_ditolak_result = $conn->query($jumlah_ditolak_sql);

    $jumlah_pendaftar = $jumlah_pendaftar_result->fetch_assoc()['total'];
    $jumlah_diterima = $jumlah_diterima_result->fetch_assoc()['total'];
    $jumlah_ditolak = $jumlah_ditolak_result->fetch_assoc()['total'];

    $update_sql = "UPDATE jadwal_pendaftaran SET jumlah_pendaftar = $jumlah_pendaftar, jumlah_diterima = $jumlah_diterima, jumlah_ditolak = $jumlah_ditolak WHERE jadwal_pendaftaran_id = $jadwal_id";
    $conn->query($update_sql);
}

$sql = "SELECT * FROM jadwal_pendaftaran ORDER BY jadwal_pendaftaran_id DESC";

$result = $conn->query($sql);

if (!$result) {
    die("Query gagal: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Jadwal Pendaftaran</title>
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
                    <a href="../../user/index.php" class="nav-item nav-link">Home</a>
                    <a href="../../user/grafik.php" class="nav-item nav-link">Grafik Pendaftaran</a>
                    <a href="../../user/jadwal/jadwal_pendaftaran.php" class="nav-item nav-link active">Jadwal Pendaftaran</a>
                    <a href="../../user/profile.php" class="nav-item nav-link">Profile</a>
                </div>
            </div>
        </nav>
    </div>
    <div class="container-fluid bg-primary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
            <a href="" class="navbar-brand font-weight-bold text-secondary" style="font-size: 60px; display: inline-flex; align-items: center;">
                <span class="text-white">Jadwal Pendaftaran</span>
            </a>
            <br>
            <h4>Silahkan pilih pendaftaran yang anda inginkan</h4>
        </div>
    </div>
    <div class="container-fluid pt-5">
        <div class="container pb-3">
            <div class="text-center pb-2">
                <div class="row">
                    <div class="col-md-8 mx-auto">
                        <div class="card shadow-sm">
                            <table class="table table-bordered table-striped text-center">
                                <thead class="table-dark">
                                    <tr>
                                        <th>No.</th>
                                        <th>Jenjang</th>
                                        <th>Tanggal Mulai</th>
                                        <th>Tanggal Selesai</th>
                                        <th>Tahun Ajaran</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($result->num_rows > 0) {
                                        $no = 1; // Inisialisasi nomor urut
                                        while ($row = $result->fetch_assoc()) {
                                            $status = getStatusPendaftaran($row["tanggal_selesai"]);
                                            $jadwal_id = $row["jadwal_pendaftaran_id"];
                                            updateJadwalPendaftaran($conn, $jadwal_id);

                                            $jumlah_pendaftar_sql = "SELECT COUNT(*) as total FROM pendaftar WHERE jadwal_pendaftaran_id = $jadwal_id";
                                            $jumlah_diterima_sql = "SELECT COUNT(*) as total FROM pendaftar WHERE jadwal_pendaftaran_id = $jadwal_id AND status = 'Diterima'";
                                            $jumlah_ditolak_sql = "SELECT COUNT(*) as total FROM pendaftar WHERE jadwal_pendaftaran_id = $jadwal_id AND status = 'Ditolak'";

                                            $jumlah_pendaftar_result = $conn->query($jumlah_pendaftar_sql);
                                            $jumlah_diterima_result = $conn->query($jumlah_diterima_sql);
                                            $jumlah_ditolak_result = $conn->query($jumlah_ditolak_sql);

                                            $jumlah_pendaftar = $jumlah_pendaftar_result->fetch_assoc()['total'];
                                            $jumlah_diterima = $jumlah_diterima_result->fetch_assoc()['total'];
                                            $jumlah_ditolak = $jumlah_ditolak_result->fetch_assoc()['total'];

                                            echo "<tr>";
                                            echo "<td>" . $no++ . "</td>";
                                            echo "<td>" . $row["jenjang"] . "</td>";
                                            echo "<td>" . date('d-m-Y', strtotime($row['tanggal_mulai'])) . "</td>";
                                            echo "<td>" . date('d-m-Y', strtotime($row['tanggal_selesai'])) . "</td>";

                                            echo "<td>" . $row["tahun_ajaran"] . "</td>";

                                            echo "<td>";
                                            if ($status == "Buka") {
                                                $user_id = $_SESSION['user_id'];
                                                $cek_pendaftaran_sql = "SELECT COUNT(*) as total FROM pendaftar WHERE user_id = $user_id AND jadwal_pendaftaran_id = $jadwal_id";
                                                $cek_pendaftaran_result = $conn->query($cek_pendaftaran_sql);
                                                $cek_pendaftaran = $cek_pendaftaran_result->fetch_assoc()['total'];
                                                $cek_pendaftaran_lain_sql = "SELECT COUNT(*) as total FROM pendaftar WHERE user_id = $user_id";
                                                $cek_pendaftaran_lain_result = $conn->query($cek_pendaftaran_lain_sql);
                                                $cek_pendaftaran_lain = $cek_pendaftaran_lain_result->fetch_assoc()['total'];

                                                if ($cek_pendaftaran == 0 && $cek_pendaftaran_lain == 0) {
                                                    echo "<a href='../../user/pendaftaran/daftar.php?jadwal_id=" . $row["jadwal_pendaftaran_id"] . "' class='btn btn-success btn-sm'>Daftar</a>";
                                                } else {
                                                    echo "<button class='btn btn-secondary btn-sm' onclick='showAccountUsedAlert(); return false;'>Buka</button>";
                                                }
                                            } else {
                                                echo "<span class='badge bg-danger'>" . $status . "</span>";
                                            }
                                            echo "</td>";
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='6' class='text-center'>No records found</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <?php include '../../footer.html'; ?>

    <script>
        function showAccountUsedAlert() {
            Swal.fire({
                icon: 'error',
                title: 'Akun anda sudah digunakan',
                confirmButtonText: 'Tutup'
            });
        }
    </script>
</body>

</html>