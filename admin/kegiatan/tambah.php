<?php
session_start(); // Pastikan sesi dimulai
include '../../config/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_kegiatan = $_POST['nama_kegiatan'];
    $tanggal = $_POST['tanggal'];
    $deskripsi = $_POST['deskripsi'];
    $admin_id = $_SESSION['admin_id'] ?? NULL; // Ambil admin_id dari sesi

    // Upload foto
    $foto = $_FILES['foto']['name'];
    $target = "../../uploads/" . basename($foto);
    move_uploaded_file($_FILES['foto']['tmp_name'], $target);

    // Gunakan prepared statements untuk mencegah SQL injection
    $stmt = $conn->prepare("INSERT INTO kegiatan_lembaga (nama_kegiatan, tanggal, deskripsi, foto, admin_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssi", $nama_kegiatan, $tanggal, $deskripsi, $foto, $admin_id); // "ssssi" berarti string, string, string, string, integer

    if ($stmt->execute()) {
        header("Location: ../../admin/kegiatan/kegiatan.php");
        exit();
    } else {
        echo "Gagal menambah data: " . $stmt->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Tambah Kegiatan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-4">
        <h2>Tambah Kegiatan</h2>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label>Nama Kegiatan:</label>
                <input type="text" name="nama_kegiatan" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Tanggal:</label>
                <input type="date" name="tanggal" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Deskripsi:</label>
                <textarea name="deskripsi" class="form-control" required></textarea>
            </div>
            <div class="mb-3">
                <label>Foto:</label>
                <input type="file" name="foto" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="../../admin/kegiatan/kegiatan.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</body>

</html>