<!DOCTYPE html>
<html>

<head>
    <title>Edit Fasilitas</title>
</head>

<body>
    <h1>Edit Fasilitas</h1>
    <?php
    include '../../config/config.php';
    $id = $_GET['id'];
    $sql = "SELECT * FROM fasilitas WHERE fasilitas_id=$id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    ?>
    <form action="../../admin/fasilitas/proses_edit.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $row['fasilitas_id']; ?>">
        <label>Gambar:</label><br>
        <input type="file" name="gambar"><br><br>
        <label>Nama Fasilitas:</label><br>
        <input type="text" name="nama_fasilitas" value="<?php echo $row['nama_fasilitas']; ?>" required><br><br>
        <label>Keterangan:</label><br>
        <textarea name="keterangan" required><?php echo $row['keterangan']; ?></textarea><br><br>

        <input type="submit" value="Simpan">
    </form>
</body>

</html>