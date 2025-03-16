<!DOCTYPE html>
<html>

<head>
    <title>Edit Jadwal</title>
</head>

<body>
    <h1>Edit Jadwal Pendaftaran</h1>
    <?php
    include '../../config/config.php';

    $id = $_GET['id'];
    $sql = "SELECT * FROM jadwal_pendaftaran WHERE jadwal_pendaftaran_id = $id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    ?>
    <form method="post" action="../../admin/jadwal/proses_edit.php">
        <input type="hidden" name="id" value="<?php echo $row['jadwal_pendaftaran_id']; ?>">
        <label>Jenjang:</label><br>
        <select name="jenjang">
            <option value="MI" <?php if ($row['jenjang'] == 'MI') echo 'selected'; ?>>MI</option>
            <option value="MTs" <?php if ($row['jenjang'] == 'MTs') echo 'selected'; ?>>MTs</option>
            <option value="MA" <?php if ($row['jenjang'] == 'MA') echo 'selected'; ?>>MA</option>
        </select><br><br>
        <label>Tanggal Mulai:</label><br>
        <input type="date" name="tanggal_mulai" value="<?php echo $row['tanggal_mulai']; ?>"><br><br>
        <label>Tanggal Selesai:</label><br>
        <input type="date" name="tanggal_selesai" value="<?php echo $row['tanggal_selesai']; ?>"><br><br>
        <label>Tahun Ajaran:</label><br>
        <input type="text" name="tahun_ajaran" value="<?php echo $row['tahun_ajaran']; ?>"><br><br>
        <input type="submit" value="Simpan">
    </form>
</body>

</html>