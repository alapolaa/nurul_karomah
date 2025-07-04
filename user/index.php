<?php
session_start();
include '../config/config.php';

$user_id = $_SESSION['user_id'];

// Cek apakah pengguna sudah mendaftar
$sql_check = "SELECT COUNT(*) FROM pendaftar WHERE user_id = ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("i", $user_id);
$stmt_check->execute();
$stmt_check->bind_result($count);
$stmt_check->fetch();
$stmt_check->close();

$sudah_daftar = ($count > 0);

if ($sudah_daftar) {
    // Ambil status dan pendaftar_id dari database
    $sql = "SELECT status, pendaftar_id FROM pendaftar WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $status = $row['status'];
        $pendaftar_id = $row['pendaftar_id']; // Ambil pendaftar_id
    } else {
        $status = ''; // Status kosong jika tidak ditemukan
        $pendaftar_id = null; // pendaftar_id null jika tidak ditemukan
    }

    $stmt->close();
}

$conn->close();
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

    <link href="lib/flaticon/font/flaticon.flaticon.css" rel="stylesheet">

    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/lightbox/css/lightbox.min.css" rel="stylesheet">

    <link href="../css/style.css" rel="stylesheet">
</head>
<style>
    .alert-success {
        background-color: rgb(15, 243, 91) !important;
        color: white !important;
    }

    .alert-danger {
        background-color: #ff4d4d !important;
        color: white !important;
    }

    .fixed-image {
        width: 100%;
        height: 250px;
        object-fit: cover;
        border-top-left-radius: 8px;
        border-top-right-radius: 8px;
    }

    /* Custom style for the "Pendaftaran GRATIS" list item */
    .list-group-item.highlight-free {
        background-color: #d4edda;
        /* Light green background */
        color: #155724;
        /* Dark green text */
        font-weight: bold;
        font-size: 1.1rem;
        border-left: 5px solid #28a745;
        /* Green border on the left */
        padding: 15px 20px;
        transition: all 0.3s ease;
    }

    .list-group-item.highlight-free:hover {
        background-color: #c3e6cb;
        /* Slightly darker green on hover */
        transform: translateY(-2px);
        /* Slight lift effect */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
</style>

<body>
    <div class="container-fluid bg-light position-relative shadow">
        <nav class="navbar navbar-expand-lg bg-light navbar-light py-3 py-lg-0 px-0 px-lg-5">
            <a href="" class="navbar-brand font-weight-bold text-secondary" style="font-size: 50px; display: inline-flex; align-items: center;">
                <img src="../img/nurul.png" alt="Logo" style="height: 60px; margin-right: 10px;">
                <span class="text-primary">Nurul Karomah</span>
            </a>
            <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                <div class="navbar-nav font-weight-bold mx-auto py-0">
                    <a href="../user/index.php" class="nav-item nav-link active">Home</a>
                    <a href="../user/grafik.php" class="nav-item nav-link">Grafik Pendaftaran</a>
                    <a href="../user/jadwal/jadwal_pendaftaran.php" class="nav-item nav-link">Jadwal Pendaftaran</a>
                    <a href="../user/profile.php" class="nav-item nav-link">Profile</a>
                </div>
            </div>
        </nav>
    </div>
    <div class="container-fluid bg-primary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 400px">
            <a href="" class="navbar-brand font-weight-bold text-secondary" style="font-size: 60px; display: inline-flex; align-items: center;">
                <span class="text-white">Selamat Datang di PPDB Online</span>
            </a>
            <h4 class="text-white mb-4">Sistem Informasi Penerimaan Peserta Didik Baru Lembaga Nurul Karomah</h4>
        </div>
    </div>
    <div class="container-fluid pt-5">
        <div class="container pb-3">
            <div class="text-center pb-2">
                <div class="row">
                    <div class="col-md-8 mx-auto">
                        <div class="card shadow-sm">
                            <div class="card-header bg-primary text-white">
                                <h3 class="mb-0">Panduan Pendaftaran</h3>
                            </div>
                            <div class="card-body">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">1. Klik menu **Pendaftaran**</li>
                                    <li class="list-group-item">2. Isi seluruh formulir, pastikan tidak ada data yang salah.</li>
                                    <li class="list-group-item">3. Klik **Selanjutnya**, untuk mengisi form berikutnya.</li>
                                    <li class="list-group-item">4. Hasil pendaftaran akan ditampilkan di website dan bisa diunduh dalam format PDF.</li>
                                    <li class="list-group-item highlight-free">
                                        <i class=""></i> **Pendaftaran GRATIS!** <br>Tidak ada biaya pendaftaran.
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <section class="container text-center my-5">
        <?php if (isset($status) && $sudah_daftar) : ?>
            <div class="alert <?php echo ($status == 'Diterima') ? 'alert-success' : (($status == 'Ditolak') ? 'alert-danger' : 'alert-warning'); ?>">
                <h4 class="mb-0">
                    <?php
                    if ($status == 'Diterima') {
                        echo 'Selamat! Pendaftaran Anda diterima.';
                    } elseif ($status == 'Ditolak') {
                        echo 'Maaf, pendaftaran Anda ditolak.';
                    } else {
                        // Gunakan $pendaftar_id
                        echo 'Pendaftaran Anda sedang kami proses. <a href="detail_pendaftaran.php?id=' . $pendaftar_id . '" class="btn btn-sm btn-info">Detail</a>';
                    }
                    ?>
                </h4>
            </div>
            <?php if ($status == 'Diterima') : ?>
                <a href="../download.php?status=<?php echo urlencode($status); ?>" class="btn btn-success">Unduh Pendaftaran</a>
            <?php endif; ?>
        <?php endif; ?>
    </section>

    <?php include '../footer.html'; ?>
    <a href="#" class="btn btn-primary p-3 back-to-top"><i class="fa fa-angle-double-up"></i></a>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/isotope/isotope.pkgd.min.js"></script>
    <script src="lib/lightbox/js/lightbox.min.js"></script>

    <script src="mail/jqBootstrapValidation.min.js"></script>
    <script src="mail/contact.js"></script>

    <script src="js/main.js"></script>
</body>

</html>