<?php
include 'config/config.php';

$sql = "SELECT * FROM prestasi_lembaga ORDER BY tahun DESC"; // Mengurutkan berdasarkan tahun terbaru
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Jadwal Pendaftaran</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Handlee&family=Nunito&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Flaticon Font -->
    <link href="lib/flaticon/font/flaticon.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/lightbox/css/lightbox.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>
<style>
    .img-prestasi {
        height: 200px;
        /* Atur tinggi gambar */
        object-fit: cover;
        /* Memastikan gambar tetap proporsional */
        border-top-left-radius: 10px;
        /* Menghaluskan sudut atas */
        border-top-right-radius: 10px;
    }

    .card {
        transition: transform 0.3s ease-in-out;
        border-radius: 10px;
    }

    .card:hover {
        transform: scale(1.15);
        /* Efek membesar saat hover */
    }
</style>

<body>
    <!-- Navbar Start -->
    <div class="container-fluid bg-light position-relative shadow">
        <nav class="navbar navbar-expand-lg bg-light navbar-light py-3 py-lg-0 px-0 px-lg-5">
            <a href="" class="navbar-brand font-weight-bold text-secondary" style="font-size: 50px;">
                <i class="flaticon-043-teddy-bear"></i>
                <span class="text-primary">Nurul Karomah</span>
            </a>
            <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                <div class="navbar-nav font-weight-bold mx-auto py-0">
                    <a href="index.php" class="nav-item nav-link ">Home</a>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Akademik</a>
                        <div class="dropdown-menu rounded-0 m-0">
                            <a href="jadwal.php" class="dropdown-item">Jadwal Pendaftaran</a>
                            <a href="mapel.php" class="dropdown-item">Mata Pelajaran</a>
                            <a href="guru.php" class="dropdown-item">Guru</a>
                        </div>
                    </div>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle active" data-toggle="dropdown">Informasi</a>
                        <div class="dropdown-menu rounded-0 m-0">
                            <a href="kegiatan.php" class="dropdown-item">Kegiatan</a>
                            <a href="prestasi.php" class="dropdown-item">Prestasi</a>
                        </div>
                    </div>
                    <a href="kontak.php" class="nav-item nav-link">Kontak</a>
                </div>
                <a href="auth/login.php" class="btn btn-primary px-4">Login</a>
            </div>
        </nav>
    </div>
    <!-- Navbar End -->


    <!-- Header Start -->
    <div class="container-fluid bg-primary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 400px">
            <h3 class="display-3 font-weight-bold text-white">Prestasi</h3>
        </div>
    </div>
    <!-- Header End -->


    <!-- About Start -->
    <div class="container-fluid pt-5">
        <div class="container pb-3">
            <div class="text-center pb-2">
                <h1>Prestasi Lembaga</h1>
            </div>
            <div class="row">
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<div class='col-md-4 mb-4'>";
                        echo "<div class='card shadow-sm border-0 h-100'>"; // Card dengan shadow
                        echo "<img src='uploads/" . $row["foto"] . "' class='card-img-top img-prestasi' alt='Foto Prestasi'>";
                        echo "<div class='card-body'>";
                        echo "<h5 class='card-title'>" . $row["nama_prestasi"] . "</h5>";
                        echo "<p class='card-text'><strong>Tingkat :</strong> " . $row["tingkat"] . "</p>";
                        echo "<p class='card-text'><strong>Tahun :</strong> " . $row["tahun"] . "</p>";
                        echo "<p class='card-text'>" . $row["deskripsi"] . "</p>";
                        echo "</div>";
                        echo "</div>";
                        echo "</div>";
                    }
                } else {
                    echo "<div class='col-12'><p class='text-center'>Tidak ada data prestasi lembaga.</p></div>";
                }
                ?>
            </div>
        </div>
    </div>
    </div>
    <!-- About End -->
    <!-- Footer Start -->
    <?php include 'footer.html'; ?>
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-primary p-3 back-to-top"><i class="fa fa-angle-double-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/isotope/isotope.pkgd.min.js"></script>
    <script src="lib/lightbox/js/lightbox.min.js"></script>

    <!-- Contact Javascript File -->
    <script src="mail/jqBootstrapValidation.min.js"></script>
    <script src="mail/contact.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>