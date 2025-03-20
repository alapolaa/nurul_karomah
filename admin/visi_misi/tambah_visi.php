<?php
session_start(); // Pastikan sesi dimulai
include '../../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $deskripsi = $_POST['deskripsi'];
    $admin_id = $_SESSION['admin_id'] ?? NULL; // Ambil admin_id dari sesi

    $stmt = $conn->prepare("INSERT INTO visi (deskripsi, admin_id) VALUES (?, ?)");
    $stmt->bind_param("si", $deskripsi, $admin_id); // "si" berarti string dan integer
    $stmt->execute();

    header("Location: ../../admin/visi_misi/visi_misi.php");
    exit(); // Penting untuk menghentikan eksekusi skrip setelah pengalihan
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <title>Tambah Visi</title>
</head>

<body>
    <h2>Tambah Visi</h2>
    <form method="post">
        <label>Deskripsi:</label><br>
        <textarea name="deskripsi" required></textarea><br>
        <button type="submit">Simpan</button>
        <a href="visi_misi.php">Batal</a>
    </form>
</body>

</html>