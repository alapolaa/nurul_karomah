<?php
include '../../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $deskripsi = $_POST['deskripsi'];
    $conn->query("INSERT INTO misi (deskripsi) VALUES ('$deskripsi')");
    header("Location: ../../admin/visi_misi/visi_misi.php");
}

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <title>Tambah Misi</title>
</head>

<body>
    <h2>Tambah Misi</h2>
    <form method="post">
        <label>Deskripsi:</label><br>
        <textarea name="deskripsi" required></textarea><br>
        <button type="submit">Simpan</button>
        <a href="visi_misi.php">Batal</a>
    </form>
</body>

</html>