<?php
session_start();
include '../../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $deskripsi = $_POST['deskripsi'];
    $admin_id = $_SESSION['admin_id'] ?? null;

    $stmt = $conn->prepare("INSERT INTO misi (deskripsi, admin_id) VALUES (?, ?)");
    $stmt->bind_param("si", $deskripsi, $admin_id);
    $stmt->execute();

    header("Location: ../../admin/visi_misi/visi_misi.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <title>Tambah Misi</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h2 class="mt-4">Tambah Misi</h2>
        <form method="post" class="mt-3">
            <div class="form-group">
                <label for="deskripsi">Deskripsi:</label>
                <textarea name="deskripsi" id="deskripsi" class="form-control" rows="5" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="visi_misi.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>