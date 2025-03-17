<?php
include '../../koneksi.php'; // Pastikan path ini benar

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $jabatan = $_POST['jabatan'];

    $foto = $_FILES['foto']['name'];
    $target = "../../uploads/" . basename($foto);

    if (move_uploaded_file($_FILES['foto']['tmp_name'], $target)) {
        // Gunakan $conn, bukan $koneksi
        $query = "INSERT INTO guru (nama, jabatan, foto) VALUES ('$nama', '$jabatan', '$foto')";

        if ($conn->query($query)) {
            header("Location: ../../admin/guru/guru.php");
            exit(); // Tambahkan exit() agar redirect berjalan dengan baik
        } else {
            echo "Gagal menambahkan data! Error: " . $conn->error;
        }
    } else {
        echo "Gagal mengupload foto!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <title>Tambah Guru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container mt-4">
    <h2>Tambah Guru</h2>
    <form action="" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label>Nama:</label>
            <input type="text" name="nama" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Jabatan:</label>
            <input type="text" name="jabatan" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Foto:</label>
            <input type="file" name="foto" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="../../admin/guru/guru.php" class="btn btn-secondary">Batal</a>
    </form>
</body>

</html>