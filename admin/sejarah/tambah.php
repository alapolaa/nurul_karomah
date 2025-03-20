<?php
session_start(); // Pastikan sesi dimulai
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Sejarah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-4">
        <h2>Tambah Sejarah</h2>
        <form action="../../admin/sejarah/proses_tambah.php" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label>Gambar:</label>
                <input type="file" name="gambar" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Keterangan:</label>
                <textarea name="keterangan" class="form-control" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="../../admin/sejarah/sejarah.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</body>

</html>