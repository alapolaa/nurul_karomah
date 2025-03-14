<?php
session_start();
include 'config/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];


$sql = "SELECT status FROM pendaftar WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $status = $row['status'];
} else {
    $status = 'Pending';
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Unduh Biodata Pendaftaran</title>
</head>

<body>
    <h1>Unduh Biodata Pendaftaran Sekolah</h1>

    <?php if ($status == 'Pending') : ?>
        <p>Pendaftaran Anda sedang kami proses.</p>
    <?php elseif ($status == 'Diterima' || $status == 'Ditolak') : ?>
        <a href="download.php?status=<?php echo urlencode($status); ?>" target="_blank">
            <button>Unduh Biodata PDF</button>
        </a>
    <?php else : ?>
        <p>Status pendaftaran Anda: <?php echo $status; ?></p>
    <?php endif; ?>

    <a href="auth/login.php">logout</a>
</body>

</html>