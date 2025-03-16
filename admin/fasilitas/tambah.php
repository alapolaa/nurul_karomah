<!DOCTYPE html>
<html>

<head>
    <title>Tambah Fasilitas</title>
</head>

<body>
    <h1>Tambah Fasilitas</h1>
    <form action="../../admin/fasilitas/proses_tambah.php" method="post" enctype="multipart/form-data">
        <label>Gambar:</label><br>
        <input type="file" name="gambar" required><br><br>
        <label>Nama Fasilitas:</label><br>
        <input type="text" name="nama_fasilitas" required><br><br>
        <label>Keterangan:</label><br>
        <textarea name="keterangan" required></textarea><br><br>
        <label>Admin ID:</label><br>
        <input type="number" name="admin_id"><br><br>
        <input type="submit" value="Simpan">
    </form>
</body>

</html>