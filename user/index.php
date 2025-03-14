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
    <style>
        body {
            font-family: sans-serif;
            margin: 20px;
            text-align: center;
        }

        h1 {
            color: #007bff;
        }

        .status-message {
            margin-top: 20px;
            padding: 15px;
            border-radius: 5px;
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
    <h1>Selamat Datang di Lembaga Sekolah</h1>
    <a href="../user/jadwal/jadwal_pendaftaran.php">Lihat jadwal pendaftaran</a>
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

    <div class="logout-link">
        <a href="../auth/login.php">Logout</a>
    </div>
</body>

</html>