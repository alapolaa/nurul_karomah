<?php
include 'config/config.php';

$sql_sejarah = "SELECT * FROM sejarah";
$result_sejarah = $conn->query($sql_sejarah);

$sql_fasilitas = "SELECT * FROM fasilitas";
$result_fasilitas = $conn->query($sql_fasilitas);

$sql_galeri = "SELECT * FROM galeri";
$result_galeri = $conn->query($sql_galeri);

$sql_visi = "SELECT * FROM visi";
$result_visi = $conn->query($sql_visi);

$sql_misi = "SELECT * FROM misi";
$result_misi = $conn->query($sql_misi);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Nurul Karomah</title>
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
                    <a href="index.php" class="nav-item nav-link active">Home</a>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Akademik</a>
                        <div class="dropdown-menu rounded-0 m-0">
                            <a href="jadwal.php" class="dropdown-item">Jadwal Pendaftaran</a>
                            <a href="mapel.php" class="dropdown-item">Mata Pelajaran</a>
                            <a href="guru.php" class="dropdown-item">Guru</a>
                        </div>
                    </div>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Informasi</a>
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
    <div class="container-fluid bg-primary px-0 px-md-5 mb-5">
        <div class="row align-items-center px-3">
            <div class="col-lg-6 text-center text-lg-left">
                <h1 class="display-3 font-weight-bold text-white">New Approach to Kids Education</h1>
                <p class="text-white mb-4">"Sea ipsum kasd eirmod kasd magna, est sea et diam ipsum est amet sed sit.
                    Ipsum dolor no justo dolor et, lorem ut dolor erat dolore sed ipsum at ipsum nonumy amet. Clita
                    lorem dolore sed stet et est justo doloreSea ipsum kasd eirmod kasd magna, est sea et diam ipsum est
                    amet sed sit.
                    Ipsum dolor no justo dolor et, lorem ut dolor erat dolore sed ipsum at ipsum nonumy amet. Clita
                    lorem dolore sed stet et est justo doloreSea ipsum kasd eirmod kasd magna, est sea et diam ipsum est
                    amet sed sit.
                    Ipsum dolor no justo dolor et, lorem ut dolor erat dolore sed ipsum at ipsum nonumy amet. Clita
                    lorem dolore sed stet et est justo dolore."</p>
            </div>
            <div class="col-lg-6 text-center text-lg-right">
                <img class="img-fluid mt-5" src="img/about-1.jpg" alt=""
                    style="border-radius: 50%; width: 550px; height: 550px; object-fit: cover; margin-bottom: 40px;">
            </div>
        </div>
    </div>
    <!-- Header End -->

    <div class="container-fluid pt-5">
        <div class="container pb-3">
            <div class="text-center pb-2">
                <h1>Sejarah</h1>
            </div>

            <div class="row justify-content-center">
                <?php
                if ($result_sejarah->num_rows > 0) {
                    while ($row = $result_sejarah->fetch_assoc()) {
                        echo "<div class='col-md-8 mb-4 text-center'>";
                        echo "<img src='uploads/" . $row["gambar"] . "' class='img-fluid mb-2' style='max-width: 100%; height: auto; border-radius: 10px; width: 700px; height: 400px; object-fit: cover;'>";
                        echo "<p class='mb-0'>" . $row["keterangan"] . "</p>";
                        echo "</div>";
                    }
                } else {
                    echo "<p>Tidak ada data sejarah.</p>";
                }
                ?>
            </div>
            <div class="text-center pb-2 mt-5">
                <h1>Visi</h1>
            </div>
            <div class="row justify-content-center">
                <?php
                if ($result_visi->num_rows > 0) {
                    while ($row = $result_visi->fetch_assoc()) {
                        echo "<div class='col-md-8 mb-4 text-center'>";
                        echo "<p>" . $row["deskripsi"] . "</p>";
                        echo "</div>";
                    }
                } else {
                    echo "<div class='col-12 text-center'><p>Tidak ada data visi.</p></div>";
                }
                ?>
            </div>

            <div class="text-center pb-2 mt-5">
                <h1>Misi</h1>
            </div>
            <div class="row justify-content-center">
                <?php
                if ($result_misi->num_rows > 0) {
                    while ($row = $result_misi->fetch_assoc()) {
                        echo "<div class='col-md-8 mb-4 text-center'>";
                        echo "<p>" . $row["deskripsi"] . "</p>";
                        echo "</div>";
                    }
                } else {
                    echo "<div class='col-12 text-center'><p>Tidak ada data misi.</p></div>";
                }
                ?>
            </div>

            <div class="text-center pb-2 mt-5">
                <h1>Fasilitas</h1>
            </div>
            <div class="row">
                <?php
                if ($result_fasilitas->num_rows > 0) {
                    $count = 0;
                    while ($row = $result_fasilitas->fetch_assoc()) {
                        if ($count % 2 == 0) {

                            echo '<div class="w-100"></div>';
                        }
                        echo "<div class='col-md-6 mb-4 text-center'>";
                        echo "<img src='uploads" . $row["gambar"] . "' class='img-fluid mb-2' style='max-width: 100%; height: auto; border-radius: 10px; width: 450px; height: 300px; object-fit: cover;'>";
                        echo "<h4>" . $row["nama_fasilitas"] . "</h4>";
                        echo "<p>" . $row["keterangan"] . "</p>";
                        echo "</div>";
                        $count++;
                    }
                } else {
                    echo "<div class='col-12 text-center'><p>Tidak ada data fasilitas.</p></div>";
                }
                ?>
            </div>

            <div class="text-center pb-2 mt-5">
                <h1>Galeri</h1>
            </div>
            <div class="row">
                <?php
                if ($result_galeri->num_rows > 0) {
                    while ($row = $result_galeri->fetch_assoc()) {
                        echo "<div class='col-md-3 mb-4'>";
                        echo "<img src='" . $row["gambar"] . "' class='img-fluid'>";
                        echo "</div>";
                    }
                } else {
                    echo "<p>Tidak ada data galeri.</p>";
                }
                ?>
            </div>
        </div>
    </div>


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