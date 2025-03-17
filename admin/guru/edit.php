<?php
include '../../koneksi.php';

$id = $_GET['id'];
$result = $conn->query("SELECT * FROM guru WHERE guru_id = $id");
$data = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $jabatan = $_POST['jabatan'];

    if (!empty($_FILES['foto']['name'])) {
        $foto = $_FILES['foto']['name'];
        $target = "../../uploads/" . basename($foto);
        move_uploaded_file($_FILES['foto']['tmp_name'], $target);
        $query = "UPDATE guru SET nama='$nama', jabatan='$jabatan', foto='$foto' WHERE guru_id=$id";
    } else {
        $query = "UPDATE guru SET nama='$nama', jabatan='$jabatan' WHERE guru_id=$id";
    }

    if ($conn->query($query)) {
        header("Location: ../../admin/guru/guru.php");
    } else {
        echo "Gagal memperbarui data!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <title>Edit Guru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container mt-4">
    <h2>Edit Guru</h2>
    <form action="" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label>Nama:</label>
            <input type="text" name="nama" class="form-control" value="<?= $data['nama']; ?>" required>
        </div>
        <div class="mb-3">
            <label>Jabatan:</label>
            <input type="text" name="jabatan" class="form-control" value="<?= $data['jabatan']; ?>" required>
        </div>
        <div class="mb-3">
            <label>Foto Lama:</label><br>
            <img src="upload/<?= $data['foto']; ?>" width="100"><br>
            <label>Ganti Foto:</label>
            <input type="file" name="foto" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="../../admin/guru/guru.php" class="btn btn-secondary">Batal</a>
    </form>
</body>

</html>