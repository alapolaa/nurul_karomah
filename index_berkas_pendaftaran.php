<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include 'config.php';

// Pastikan pendaftar_id ada di session
if (!isset($_SESSION['pendaftar_id'])) {
    header("Location: pendaftaran.php"); // Redirect jika pendaftar_id tidak ada
    exit();
}

$pendaftar_id = $_SESSION['pendaftar_id'];

// Fetch data from berkas_pendaftaran table
$sql = "SELECT bp.*, p.nama_lengkap FROM berkas_pendaftaran bp JOIN pendaftar p ON bp.pendaftar_id = p.pendaftar_id";
$result = $conn->query($sql);

if (!$result) {
    die("Query gagal: " . $conn->error);
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Berkas Pendaftaran CRUD</title>
</head>

<body>
    <h2>Daftar Berkas Pendaftaran</h2>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Pendaftar</th>
                <th>Pas Foto</th>
                <th>Ijazah Depan</th>
                <th>Ijazah Belakang</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["berkas_pendaftaran_id"] . "</td>";
                    echo "<td>" . $row["nama_lengkap"] . "</td>";
                    echo "<td><a href='" . $row["pas_foto"] . "' target='_blank'>Lihat</a></td>";
                    echo "<td><a href='" . $row["ijazah_depan"] . "' target='_blank'>Lihat</a></td>";
                    echo "<td><a href='" . $row["ijazah_belakang"] . "' target='_blank'>Lihat</a></td>";
                    echo "<td><a href='edit_berkas_pendaftaran.php?id=" . $row["berkas_pendaftaran_id"] . "'>Edit</a> | <a href='delete_berkas_pendaftaran.php?id=" . $row["berkas_pendaftaran_id"] . "'>Delete</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No records found</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <h2>Tambah Berkas Pendaftaran</h2>
    <form action="create_berkas_pendaftaran.php" method="post" enctype="multipart/form-data">
        <label>Pas Foto:</label>
        <input type="file" name="pas_foto" accept="image/*" required><br>
        <label>Ijazah Depan:</label>
        <input type="file" name="ijazah_depan" accept="image/*" required><br>
        <label>Ijazah Belakang:</label>
        <input type="file" name="ijazah_belakang" accept="image/*" required><br>
        <input type="hidden" name="pendaftar_id" value="<?php echo $pendaftar_id; ?>">
        <input type="submit" value="Tambah">
    </form>

</body>

</html>

<?php
$conn->close();
?>