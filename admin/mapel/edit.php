<!DOCTYPE html>
<html>

<head>
    <title>Edit Mata Pelajaran</title>
</head>

<body>
    <h1>Edit Mata Pelajaran</h1>
    <?php
    include '../../config/config.php';
    $id = $_GET['id'];
    $sql = "SELECT * FROM mata_pelajaran WHERE mata_pelajaran_id=$id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    ?>
        <form action="../../admin/mapel/proses_edit.php" method="post">
            <input type="hidden" name="id" value="<?php echo $row['mata_pelajaran_id']; ?>">
            Nama Mata Pelajaran: <input type="text" name="nama_mapel" value="<?php echo $row['nama_mapel']; ?>"><br>
            Guru ID: <input type="number" name="guru_id" value="<?php echo $row['guru_id']; ?>"><br>

            <input type="submit" value="Simpan Perubahan">
        </form>
    <?php
    } else {
        echo "Data tidak ditemukan";
    }
    $conn->close();
    ?>
</body>

</html>