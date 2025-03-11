<?php
include 'config.php';

$berkas_pendaftaran_id = $_GET["id"];
$sql = "SELECT * FROM berkas_pendaftaran WHERE berkas_pendaftaran_id = '$berkas_pendaftaran_id'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Berkas Pendaftaran</title>
</head>

<body>
    <h2>Edit Berkas Pendaftaran</h2>
    <form action="update_berkas_pendaftaran.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="berkas_pendaftaran_id" value="<?php echo $row['berkas_pendaftaran_id']; ?>">
        <label>Pendaftar ID:</label>
        <select name="pendaftar_id" required>
            <?php
            $pendaftarSql = "SELECT pendaftar_id, nama_lengkap FROM pendaftar";
            $pendaftarResult = $conn->query($pendaftarSql);
            while ($pendaftarRow = $pendaftarResult->fetch_assoc()) {
                $selected = ($row['pendaftar_id'] == $pendaftarRow['pendaftar_id']) ? 'selected' : '';
                echo "<option value='" . $pendaftarRow["pendaftar_id"] . "' " . $selected . ">" . $pendaftarRow["nama_lengkap"] . "</option>";
            }
            ?>
        </select><br>
        <label>Pas Foto:</label>
        <input type="file" name="pas_foto" accept="image/*"><br>
        <label>Ijazah Depan:</label>
        <input type="file" name="ijazah_depan" accept="image/*"><br>
        <label>Ijazah Belakang:</label>
        <input type="file" name="ijazah_belakang" accept="image/*"><br>
        <input type="submit" value="Update">
    </form>
</body>

</html>

<?php
$conn->close();
?>