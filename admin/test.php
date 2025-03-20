<?php
session_start();
if (!isset($_SESSION['admin_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

include '../config/config.php'; // Sesuaikan dengan path config.php Anda

// Ambil data pendaftaran yang statusnya 'Pending'
$sql = "SELECT p.*, u.username AS nama_user FROM pendaftar p JOIN users u ON p.user_id = u.user_id WHERE p.status = 'Pending'";
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
                    <a href="../../user/dashboard.php" class="nav-item nav-link">Home</a>
                    <a href="../../user/jadwal/jadwal_pendaftaran.php" class="nav-item nav-link active">Pendaftaran</a>
                    <a href="../../user/profile.php" class="nav-item nav-link ">Profile</a>
                </div>
            </div>
        </nav>
    </div>
    <div class="container-fluid bg-primary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
            <a href="" class="navbar-brand font-weight-bold text-secondary" style="font-size: 60px; display: inline-flex; align-items: center;">
                <span class="text-white">Halaaman admin</span>
            </a>
            <br>
            <h4>ini adalah halaman admin</h4>
        </div>
    </div>
    <div class="container-fluid pt-5">
        <div class="container pb-3">
            <div class="text-center pb-2">
                <div class="row">
                    <div class="col-md-8 mx-auto">
                        <div class="card shadow-sm">
                            <h3>Data Pendaftaran Pending</h3>
                            <table>
                                <thead>
                                    <tr>
                                        <th>Nama Pendaftar</th>
                                        <th>NISN</th>
                                        <th>NIK</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Tempat Lahir</th>
                                        <th>Tanggal Lahir</th>
                                        <th>Alamat</th>
                                        <th>Agama</th>
                                        <th>No. Telp</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<tr id='row_" . $row['pendaftar_id'] . "'>";
                                            echo "<td>" . $row['nama_user'] . "</td>";
                                            echo "<td>" . $row['nisn'] . "</td>";
                                            echo "<td>" . $row['nik'] . "</td>";
                                            echo "<td>" . $row['jenis_kelamin'] . "</td>";
                                            echo "<td>" . $row['tempat_lahir'] . "</td>";
                                            echo "<td>" . $row['tanggal_lahir'] . "</td>";
                                            echo "<td>" . $row['alamat_lengkap'] . "</td>";
                                            echo "<td>" . $row['agama'] . "</td>";
                                            echo "<td>" . $row['no_telp'] . "</td>";
                                            echo "<td>
                            <button onclick='terimaPendaftaran(" . $row['pendaftar_id'] . ")'>Terima</button>
                            <button onclick='tolakPendaftaran(" . $row['pendaftar_id'] . ")'>Tolak</button>
                          </td>";
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='10'>Tidak ada data pendaftaran pending.</td></tr>";
                                    }
                                    $conn->close();
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
        function terimaPendaftaran(pendaftarId) {
            updateStatus(pendaftarId, 'Diterima');
        }

        function tolakPendaftaran(pendaftarId) {
            updateStatus(pendaftarId, 'Ditolak');
        }

        function updateStatus(pendaftarId, status) {
            fetch('update_status.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'pendaftar_id=' + pendaftarId + '&status=' + status,
                })
                .then(response => {
                    if (response.ok) {
                        document.getElementById('row_' + pendaftarId).classList.add('hidden');
                    } else {
                        alert('Gagal memperbarui status.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan.');
                });
        }
    </script>
</body>

</html>