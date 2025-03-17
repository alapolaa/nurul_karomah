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
<style>
    .fixed-image {
        width: 100%;
        /* Agar gambar menyesuaikan dengan lebar kartu */
        height: 250px;
        /* Tinggi tetap agar semua gambar seragam */
        object-fit: cover;
        /* Pangkas gambar agar tetap proporsional */
        border-top-left-radius: 8px;
        /* Sudut atas melengkung */
        border-top-right-radius: 8px;
    }

    .gallery-image {
        width: 100%;
        height: 200px;
        object-fit: cover;
        cursor: pointer;
    }

    #fullscreen-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.9);
        z-index: 1000;
    }

    #fullscreen-image {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        max-width: 90%;
        max-height: 90%;
    }

    #close-fullscreen {
        position: absolute;
        top: 20px;
        right: 20px;
        background: none;
        border: none;
        color: white;
        font-size: 24px;
        cursor: pointer;
    }

    #image-details {
        position: absolute;
        bottom: 20px;
        width: 100%;
        text-align: center;
        color: white;
    }

    .fixed-sejarah {
        width: 100%;
        /* Agar gambar menyesuaikan dengan lebar kartu */
        height: 400px;
        /* Tinggi tetap agar semua gambar seragam */
        object-fit: cover;
        /* Pangkas gambar agar tetap proporsional */
        border-top-left-radius: 8px;
        /* Sudut atas melengkung */
        border-top-right-radius: 8px;
    }
</style>

<body>
    <!-- Navbar Start -->
    <div class="container-fluid bg-light position-relative shadow">
        <nav class="navbar navbar-expand-lg bg-light navbar-light py-3 py-lg-0 px-0 px-lg-5">
            <a href="" class="navbar-brand font-weight-bold text-secondary" style="font-size: 50px; display: inline-flex; align-items: center;">
                <img src="img/nurul.png" alt="Logo" style="height: 60px; margin-right: 10px;">
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
                <h1 class="display-3 font-weight-bold text-white">Pendekatan Baru dalam Pendidikan Anak</h1>
                <p class="text-white mb-4">"Selamat datang di Lembaga Nurul Karomah. Kami berkomitmen untuk memberikan pendidikan terbaik bagi anak-anak dengan pendekatan yang inovatif dan berbasis nilai-nilai moral. Dengan lingkungan yang nyaman dan metode pembelajaran yang menyenangkan, kami berharap dapat membentuk generasi yang cerdas, berakhlak, dan siap menghadapi masa depan."</p>
            </div>
            <div class="col-lg-6 text-center text-lg-right">
                <img class="img-fluid mt-5" src="img/kepala.png" alt=""
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
                        echo "<div class='col-md-8 mb-4'>";
                        echo "<div class='p-3 border rounded shadow-sm text-center'>"; // Border & shadow ringan agar tetap rapi
                        echo "<img src='uploads/" . $row["gambar"] . "' class='img-fluid fixed-sejarah mb-3' alt='Sejarah'>"; // Gambar tetap responsif
                        echo "<p class='text-muted'>" . $row["keterangan"] . "</p>"; // Keterangan dengan warna lebih soft
                        echo "</div>";
                        echo "</div>";
                    }
                } else {
                    echo "<div class='col-12 text-center'><p class='text-muted'>Tidak ada data sejarah.</p></div>";
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
                    while ($row = $result_fasilitas->fetch_assoc()) {
                        echo "<div class='col-md-6 mb-4'>";
                        echo "<div class='card shadow-sm border-0 h-100 text-center'>"; // Card dengan shadow dan tinggi seragam
                        echo "<img src='uploads" . $row["gambar"] . "' class='card-img-top img-fasilitas' alt='Fasilitas'>";
                        echo "<div class='card-body'>";
                        echo "<h4 class='card-title fw-bold'>" . $row["nama_fasilitas"] . "</h4>"; // Nama lebih tegas
                        echo "<p class='card-text text-muted'>" . $row["keterangan"] . "</p>"; // Keterangan lebih soft
                        echo "</div>"; // card-body
                        echo "</div>"; // card
                        echo "</div>"; // col-md-6
                    }
                } else {
                    echo "<div class='col-12 text-center'><p class='text-muted'>Tidak ada data fasilitas.</p></div>";
                }
                ?>
            </div>

            <style>
                .img-fasilitas {
                    height: 300px;
                    /* Ukuran gambar seragam */
                    object-fit: cover;
                    /* Gambar tidak terdistorsi */
                    border-top-left-radius: 10px;
                    /* Membuat sudut lebih halus */
                    border-top-right-radius: 10px;
                }

                .card {
                    transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
                    border-radius: 10px;
                }

                .card:hover {
                    transform: scale(1.10);
                    /* Efek membesar saat hover */
                    box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.2);
                    /* Bayangan lebih jelas */
                }
            </style>



            <div class="text-center pb-2 mt-5">
                <h1>Galeri</h1>
            </div>
            <div class="row">
                <?php
                if ($result_galeri->num_rows > 0) {
                    while ($row = $result_galeri->fetch_assoc()) {
                        echo "<div class='col-md-3 mb-4'>";
                        echo "<img src='uploads/" . $row["gambar"] . "' class='img-fluid gallery-image' data-gambar='" . $row["gambar"] . "'>";
                        echo "</div>";
                    }
                } else {
                    echo "<p>Tidak ada data galeri.</p>";
                }
                ?>
            </div>
            <style>
                .gallery-image {
                    width: 100%;
                    height: 200px;
                    /* Menyamakan ukuran gambar */
                    object-fit: cover;
                    border-radius: 10px;
                    cursor: pointer;
                    transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
                }

                .gallery-image:hover {
                    transform: scale(1.15);
                    box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
                }
            </style>


            <div id="fullscreen-overlay">
                <img id="fullscreen-image" src="">
                <button id="close-fullscreen">&times;</button>
                <div id="image-details"></div>
            </div>
        </div>
    </div>


    <!-- Footer Start -->
    <?php include 'footer.html'; ?>
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-primary p-3 back-to-top"><i class="fa fa-angle-double-up"></i></a>


    <!-- JavaScript Libraries -->
    <script>
        const galleryImages = document.querySelectorAll('.gallery-image');
        const fullscreenOverlay = document.getElementById('fullscreen-overlay');
        const fullscreenImage = document.getElementById('fullscreen-image');
        const closeFullscreen = document.getElementById('close-fullscreen');
        const imageDetails = document.getElementById('image-details');

        galleryImages.forEach(image => {
            image.addEventListener('click', () => {
                const imageName = image.getAttribute('data-gambar');
                fullscreenImage.src = 'uploads/' + imageName;
                imageDetails.textContent = imageName;
                fullscreenOverlay.style.display = 'block';
            });
        });

        closeFullscreen.addEventListener('click', () => {
            fullscreenOverlay.style.display = 'none';
        });
    </script>
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