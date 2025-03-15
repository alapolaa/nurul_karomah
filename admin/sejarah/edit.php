<?php
include '../../config/config.php';

$id = $_GET['id'];
$data = $conn->query("SELECT * FROM sejarah WHERE sejarah_id = $id")->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <title>Edit Sejarah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-4">
        <h2>Edit Sejarah</h2>
        <form action="proses_edit.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $data['sejarah_id'] ?>">
            <div class="mb-3">
                <label>Gambar:</label>
                <input type="file" name="gambar" class="form-control">
            </div>
            <div class="mb-3">
                <label>Keterangan:</label>
                <textarea name="keterangan" class="form-control"><?= $data['keterangan'] ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="../../admin/sejarah/sejarah.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</body>

</html>