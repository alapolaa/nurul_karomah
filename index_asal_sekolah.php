<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'config.php';

// Fetch data from asal_sekolah table
$sql = "SELECT a.*, p.nama_lengkap FROM asal_sekolah a JOIN pendaftar p ON a.pendaftar_id = p.pendaftar_id";
$result = $conn->query($sql);

if (!$result) {
    die("Query gagal: " . $conn->error);
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Asal Sekolah CRUD</title>
</head>

<body>
    <h2>Daftar Asal Sekolah</h2>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Pendaftar</th>
                <th>NPSN</th>
                <th>Nama Sekolah</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["asal_sekolah_id"] . "</td>";
                    echo "<td>" . $row["nama_lengkap"] . "</td>";
                    echo "<td>" . $row["npsn"] . "</td>";
                    echo "<td>" . $row["nama_sekolah"] . "</td>";
                    echo "<td><a href='edit_asal_sekolah.php?id=" . $row["asal_sekolah_id"] . "'>Edit</a> | <a href='delete_asal_sekolah.php?id=" . $row["asal_sekolah_id"] . "'>Delete</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No records found</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <h2>Tambah Asal Sekolah</h2>
    <form action="create_asal_sekolah.php" method="post">
        <label>Pendaftar ID:</label>
        <select name="pendaftar_id" required>
            <?php
            $pendaftarSql = "SELECT pendaftar_id, nama_lengkap FROM pendaftar";
            $pendaftarResult = $conn->query($pendaftarSql);
            while ($pendaftarRow = $pendaftarResult->fetch_assoc()) {
                echo "<option value='" . $pendaftarRow["pendaftar_id"] . "'>" . $pendaftarRow["nama_lengkap"] . "</option>";
            }
            ?>
        </select><br>
        <label>NPSN:</label>
        <input type="text" name="npsn" required><br>
        <label>Nama Sekolah:</label>
        <input type="text" name="nama_sekolah" required><br>
        <input type="submit" value="Tambah">
    </form>

</body>

</html>

<?php
$conn->close();
?>