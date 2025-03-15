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
    <title>Halaman Utama - Pendaftaran Sekolah Nurul Karomah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .navbar {
            background-color: #007bff;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            color: white !important;
        }

        .navbar-brand img {
            height: 40px;
            margin-right: 10px;
        }

        .navbar-nav .nav-link {
            color: white !important;
        }

        .navbar-nav .nav-link:hover {
            color: #add8e6 !important;
        }

        .container {
            padding: 20px;
            text-align: center;
        }

        h1 {
            color: #007bff;
            margin-top: 30px;
        }

        .status-message {
            margin-top: 20px;
            padding: 15px;
            border-radius: 5px;
            font-weight: bold;
        }

        .pending {
            background-color: #f0f8ff;
            border: 1px solid #add8e6;
            color: #00008b;
        }

        .diterima {
            background-color: #e6ffe6;
            border: 1px solid #aaffaa;
            color: #006400;
        }

        .ditolak {
            background-color: #ffe6e6;
            border: 1px solid #ffaaaa;
            color: #8b0000;
        }

        .download-button {
            margin-top: 20px;
        }

        button {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        .logout-link {
            margin-top: 30px;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="../user/dashboard.php">
                <img src="../assets/images/karomah.png" alt="Logo Nurul Karomah" width="200px" height="350px">
                Nurul Karomah
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="profilDropdown" role="button" data-bs-toggle="dropdown">
                            Profile Sekolah
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="../user/sejarah/sejarah.php">Sejarah</a></li>
                            <li><a class="dropdown-item" href="../user/visimisi/visimisi.php">Visi Misi</a></li>
                        </ul>
                    </li>
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
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="kegiatanDropdown" role="button" data-bs-toggle="dropdown">
                            Kegiatan & Prestasi
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="../user/kegiatan/kegiatan.php">Kegiatan</a></li>
                            <li><a class="dropdown-item" href="../user/prestasi/prestasi.php">Prestasi</a></li>
                        </ul>
                    </li>
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

    <div class="container">
        <h1>Selamat Datang di Lembaga Sekolah Nurul Karomah</h1>

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
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>