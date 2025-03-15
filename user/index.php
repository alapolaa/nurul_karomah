<?php
session_start();
include '../config/config.php';

// Cek apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    // Jika belum login, arahkan ke halaman login
    header("Location: ../auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Ambil status pendaftaran dari database
$sql = "SELECT status FROM pendaftar WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $status = $row['status'];
} else {
    $status = ''; // Status kosong jika tidak ditemukan
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Halaman Utama - Pendaftaran Sekolah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="../user/dashboard.php">Dashboard</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">



                    <!-- Akademik -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="akademikDropdown" role="button" data-bs-toggle="dropdown">
                            Akademik
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="../user/jadwal/jadwal_pendaftaran.php">Jadwal</a></li>
                            <li><a class="dropdown-item" href="../user/guru/guru.php">Guru</a></li>
                            <li><a class="dropdown-item" href="../user/mapel/mapel.php">Mapel</a></li>
                        </ul>
                    </li>

                    <!-- Kegiatan & Prestasi -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="kegiatanDropdown" role="button" data-bs-toggle="dropdown">
                            Kegiatan & Prestasi
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="../user/kegiatan/kegiatan.php">Kegiatan</a></li>
                            <li><a class="dropdown-item" href="../user/prestasi/prestasi.php">Prestasi</a></li>
                        </ul>
                    </li>

                    <!-- Kontak -->
                    <li class="nav-item">
                        <a class="nav-link" href="../user/kontak/kontak.php">Kontak</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../auth/login.php">Profile</a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>

    <h1>Selamat Datang di Lembaga Sekolah</h1>

    <?php if ($status == 'Pending') : ?>
        <div class="status-message pending">
            <p>Pendaftaran Anda sedang kami proses.</p>
        </div>
    <?php elseif ($status == 'Diterima') : ?>
        <div class="status-message diterima">
            <p>Selamat! Pendaftaran Anda telah diterima.</p>
        </div>
        <div class="download-button">
            <a href="../download.php?status=<?php echo urlencode($status); ?>" target="_blank">
                <button>Unduh Biodata PDF</button>
            </a>
        </div>
    <?php elseif ($status == 'Ditolak') : ?>
        <div class="status-message ditolak">
            <p>Maaf, pendaftaran Anda ditolak.</p>
        </div>

    <?php endif; ?>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</html>