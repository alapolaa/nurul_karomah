<?php
session_start();
include '../../config/config.php';

// Cek apakah admin sudah login
if (!isset($_SESSION['admin_id'])) {
    header("Location: auth/login.php"); // Redirect ke halaman login jika belum login
    exit();
}

$admin_id = $_SESSION['admin_id'];

// Ambil data admin dari database
$stmt = $conn->prepare("SELECT admin_id, nama, email FROM admin WHERE admin_id = ?");
$stmt->bind_param("i", $admin_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $admin = $result->fetch_assoc();
} else {
    // Handle jika admin tidak ditemukan (misalnya, redirect ke halaman error)
    echo "Admin tidak ditemukan.";
    exit();
}

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
    .profile-card {
        max-width: 500px;
        margin: 20px auto;
    }

    .profile-list-item strong {
        width: 100px;
        display: inline-block;
    }

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
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Akademik</a>
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
                    <a href="../../admin/kotak_masuk/kotak_masuk.php" class="nav-item nav-link ">Kotak Masuk</a>
                    <!-- <a href="../../admin/profile.php" class="nav-item nav-link">Profile</a> -->
                    <a href="../../admin/profile/profile.php" class="nav-item nav-link active">Profile</a>
                </div>

            </div>
        </nav>
    </div>
    <!-- Navbar End -->
    <div class="container-fluid bg-primary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 250px">
            <a href="" class="navbar-brand font-weight-bold text-secondary" style="font-size: 60px; display: inline-flex; align-items: center;">
                <span class="text-white">Profile</span>
            </a>

        </div>
    </div>
    <div class="container mt-5">
        <div class="card profile-card">

            <ul class="list-group list-group-flush">
                <li class="list-group-item profile-list-item">
                    <strong>Nama:</strong> <span><?php echo htmlspecialchars($admin['nama']); ?></span>
                </li>
                <li class="list-group-item profile-list-item">
                    <strong>Email:</strong> <span><?php echo htmlspecialchars($admin['email']); ?></span>
                </li>
            </ul>
            <div class="card-body text-center">
                <a href="../../admin/profile/edit_profile.php" class="btn btn-primary">
                    <i class="fas fa-edit"></i> Edit Profil
                </a>
                <a href="../../index.php" class="btn btn-secondary">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </div>
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