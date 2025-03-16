<?php
include '../../koneksi.php';
$id = $_GET['id'];
$data = $conn->query("SELECT * FROM misi WHERE misi_id='$id'")->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $deskripsi = $_POST['deskripsi'];
    $conn->query("UPDATE misi SET deskripsi='$deskripsi' WHERE misi_id='$id'");
    header("Location: ../../admin/visi_misi/visi_misi.php");
}
?>

<form method="post">
    <label>Deskripsi:</label><br>
    <textarea name="deskripsi" required><?= $data['deskripsi'] ?></textarea><br>
    <button type="submit">Update</button>
</form>