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
</head>

<body>
    <h2>Edit Kegiatan</h2>
    <form action="" method="POST" enctype="multipart/form-data">
        <label>Nama Kegiatan:</label>
        <input type="text" name="nama_kegiatan" value="<?= $data['nama_kegiatan']; ?>" required>
        <label>Tanggal:</label>
        <input type="date" name="tanggal" value="<?= $data['tanggal']; ?>" required>
        <label>Deskripsi:</label>
        <textarea name="deskripsi" required><?= $data['deskripsi']; ?></textarea>
        <label>Foto:</label>
        <input type="file" name="foto">
        <button type="submit">Simpan</button>
        <a href="../../admin/kegiatan/kegiatan.php">kembali</a>
    </form>
</body>

</html>