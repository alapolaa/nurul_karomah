<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
include '../koneksi.php';

// Pastikan user_id ada dalam sesi
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Query untuk mengambil data pengguna
    $sql = "SELECT username, email FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $username = $row['username'];
        $email = $row['email'];
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

            <link href="../css/style.css" rel="stylesheet">

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
                        <img src="../img/nurul.png" alt="Logo" style="height: 60px; margin-right: 10px;">
                        <span class="text-primary">Nurul Karomah</span>
                    </a>
                    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                        <div class="navbar-nav font-weight-bold mx-auto py-0">
                            <a href="../user/dashboard.php" class="nav-item nav-link">Home</a>
                            <a href="../user/jadwal/jadwal_pendaftaran.php" class="nav-item nav-link ">Pendaftaran</a>
                            <a href="../auth/login.php" class="nav-item nav-link active">Profile</a>
                        </div>
                    </div>
                </nav>
            </div>
            <div class="container-fluid bg-primary mb-5">
                <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
                    <a href="" class="navbar-brand font-weight-bold text-secondary" style="font-size: 60px; display: inline-flex; align-items: center;">
                        <span class="text-white">Profile</span>
                    </a>

                </div>
            </div>
            <div class="container mt-5">
                <div class="card">
                    <div class="card-header">
                        <h1>Profil Pengguna</h1>
                    </div>
                    <div class="card-body">
                        <p><strong>Username:</strong> <?php echo htmlspecialchars($username); ?></p>
                        <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
                        <a href="../auth/login.php" class="btn btn-danger">Logout</a>
                    </div>
                </div>
            </div>


            <?php include '../footer.html'; ?>

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        </body>

        </html>
<?php
    } else {
        echo "<p>Pengguna tidak ditemukan.</p>";
    }
    $stmt->close();
} else {
    echo "<p>Anda belum login.</p>";
}

$conn->close();
?>