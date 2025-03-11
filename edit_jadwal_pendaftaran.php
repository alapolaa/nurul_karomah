<?php
include 'config.php';

$jadwal_pendaftaran_id = $_GET["id"];
$sql = "SELECT * FROM jadwal_pendaftaran WHERE jadwal_pendaftaran_id = '$jadwal_pendaftaran_id'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Jadwal Pendaftaran</title>
</head>

<body>
    <h2>Edit Jadwal Pendaftaran</h2>
    <form action="update_jadwal_pendaftaran.php" method="post">
        <input type="hidden" name="jadwal_pendaftaran_id" value="<?php echo $row['jadwal_pendaftaran_id']; ?>">
        <label>Jenjang:</label>
        <select name="jenjang" required>
            <option value="MI" <?php if ($row['jenjang'] == 'MI') echo 'selected'; ?>>MI</option>
            <option value="MTs" <?php if ($row['jenjang'] == 'MTs') echo 'selected'; ?>>MTs</option>
            <option value="MA" <?php if ($row['jenjang'] == 'MA') echo 'selected'; ?>>MA</option>
        </select><br>
        <label>Tanggal Mulai:</label>
        <input type="date" name="tanggal_mulai" value="<?php echo $row['tanggal_mulai']; ?>" required><br>
        <label>Tanggal Selesai:</label>
        <input type="date" name="tanggal_selesai" value="<?php echo $row['tanggal_selesai']; ?>" required><br>
        <label>Jumlah Siswa:</label>
        <input type="number" name="jumlah_siswa" value="<?php echo $row['jumlah_siswa']; ?>" required><br>
        <input type="submit" value="Update">
    </form>
</body>

</html>

<?php
$conn->close();
?>