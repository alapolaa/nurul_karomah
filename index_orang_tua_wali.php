<?php
include 'config.php';

// Fetch data from orang_tua_wali table
$sql = "SELECT ot.*, p.nama_lengkap FROM orang_tua_wali ot JOIN pendaftar p ON ot.pendaftar_id = p.pendaftar_id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Orang Tua/Wali CRUD</title>
</head>

<body>
    <h2>Daftar Orang Tua/Wali</h2>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Pendaftar</th>
                <th>NIK Ayah</th>
                <th>Nama Ayah</th>
                <th>NIK Ibu</th>
                <th>Nama Ibu</th>
                <th>NIK Wali</th>
                <th>Nama Wali</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["orang_tua_wali_id"] . "</td>";
                    echo "<td>" . $row["nama_lengkap"] . "</td>";
                    echo "<td>" . $row["nik_ayah"] . "</td>";
                    echo "<td>" . $row["nama_ayah"] . "</td>";
                    echo "<td>" . $row["nik_ibu"] . "</td>";
                    echo "<td>" . $row["nama_ibu"] . "</td>";
                    echo "<td>" . $row["nik_wali"] . "</td>";
                    echo "<td>" . $row["nama_wali"] . "</td>";
                    echo "<td><a href='edit_orang_tua_wali.php?id=" . $row["orang_tua_wali_id"] . "'>Edit</a> | <a href='delete_orang_tua_wali.php?id=" . $row["orang_tua_wali_id"] . "'>Delete</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='9'>No records found</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <h2>Tambah Orang Tua/Wali</h2>
    <form action="create_orang_tua_wali.php" method="post">
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
        <label>NIK Ayah:</label>
        <input type="text" name="nik_ayah" required><br>
        <label>Nama Ayah:</label>
        <input type="text" name="nama_ayah" required><br>
        <label>Pendidikan Ayah:</label>
        <input type="text" name="pendidikan_ayah"><br>
        <label>Pekerjaan Ayah:</label>
        <input type="text" name="pekerjaan_ayah"><br>
        <label>Penghasilan Ayah:</label>
        <input type="number" name="penghasilan_ayah" step="0.01"><br>
        <label>No. Telp Ayah:</label>
        <input type="text" name="no_telp_ayah"><br>
        <label>NIK Ibu:</label>
        <input type="text" name="nik_ibu" required><br>
        <label>Nama Ibu:</label>
        <input type="text" name="nama_ibu" required><br>
        <label>Pendidikan Ibu:</label>
        <input type="text" name="pendidikan_ibu"><br>
        <label>Pekerjaan Ibu:</label>
        <input type="text" name="pekerjaan_ibu"><br>
        <label>Penghasilan Ibu:</label>
        <input type="number" name="penghasilan_ibu" step="0.01"><br>
        <label>No. Telp Ibu:</label>
        <input type="text" name="no_telp_ibu"><br>
        <label>NIK Wali:</label>
        <input type="text" name="nik_wali"><br>
        <label>Nama Wali:</label>
        <input type="text" name="nama_wali"><br>
        <label>Pendidikan Wali:</label>
        <input type="text" name="pendidikan_wali"><br>
        <label>Pekerjaan Wali:</label>
        <input type="text" name="pekerjaan_wali"><br>
        <label>Penghasilan Wali:</label>
        <input type="number" name="penghasilan_wali" step="0.01"><br>
        <label>No. Telp Wali:</label>
        <input type="text" name="no_telp_wali"><br>
        <input type="submit" value="Tambah">
    </form>

</body>

</html>

<?php
$conn->close();
?>