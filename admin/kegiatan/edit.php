<?php
include '../../config/config.php';

$id = $_GET['id'];
$query = "SELECT * FROM kegiatan_lembaga WHERE kegiatan_lembaga_id = $id";
$result = $conn->query($query);
$data = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_kegiatan = $_POST['nama_kegiatan'];
    $tanggal = $_POST['tanggal'];
    $deskripsi = $_POST['deskripsi'];

    if ($_FILES['foto']['name']) {
        $foto = $_FILES['foto']['name'];
        $target = "../../uploads/" . basename($foto);
        move_uploaded_file($_FILES['foto']['tmp_name'], $target);
        $query = "UPDATE kegiatan_lembaga SET nama_kegiatan='$nama_kegiatan', tanggal='$tanggal', deskripsi='$deskripsi', foto='$foto' WHERE kegiatan_lembaga_id=$id";
    } else {
        $query = "UPDATE kegiatan_lembaga SET nama_kegiatan='$nama_kegiatan', tanggal='$tanggal', deskripsi='$deskripsi' WHERE kegiatan_lembaga_id=$id";
    }

    if ($conn->query($query)) {
        header("Location: ../../admin/kegiatan/kegiatan.php");
        exit();
    } else {
        echo "Gagal mengedit data: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Edit Kegiatan</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h2>Edit Kegiatan</h2>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>Nama Kegiatan:</label>
                <input type="text" name="nama_kegiatan" value="<?= $data['nama_kegiatan']; ?>" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Tanggal:</label>
                <input type="date" name="tanggal" value="<?= $data['tanggal']; ?>" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Deskripsi:</label>
                <textarea name="deskripsi" class="form-control" required><?= $data['deskripsi']; ?></textarea>
            </div>
            <div class="form-group">
                <label>Foto:</label>
                <input type="file" name="foto" class="form-control-file">
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="../../admin/kegiatan/kegiatan.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>