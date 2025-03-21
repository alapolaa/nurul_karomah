<?php
include '../../koneksi.php';
$id = $_GET['id'];
$data = $conn->query("SELECT * FROM misi WHERE misi_id='$id'")->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $deskripsi = $_POST['deskripsi'];
    $conn->query("UPDATE misi SET deskripsi='$deskripsi' WHERE misi_id='$id'");
    header("Location: ../../admin/visi_misi/visi_misi.php");
    exit(); // Penting untuk menghentikan eksekusi skrip setelah pengalihan
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <title>Edit Misi</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h2 class="mt-4">Edit Misi</h2>
        <form method="post" class="mt-3">
            <div class="form-group">
                <label for="deskripsi">Deskripsi:</label>
                <textarea name="deskripsi" id="deskripsi" class="form-control" rows="5" required><?= $data['deskripsi'] ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="../../admin/visi_misi/visi_misi.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>