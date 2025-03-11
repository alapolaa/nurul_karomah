<?php
include 'config.php';

// Fetch data from pendaftar table joined with jadwal_pendaftaran table
$sql = "SELECT p.*, u.username, pr.name as province_name, r.name as regency_name, d.name as district_name, v.name as village_name, j.jadwal_pendaftaran_id 
        FROM pendaftar p 
        JOIN users u ON p.user_id = u.user_id 
        JOIN provinces pr ON p.province_id = pr.id 
        JOIN regencies r ON p.regency_id = r.id 
        JOIN districts d ON p.district_id = d.id 
        JOIN villages v ON p.village_id = v.id
        LEFT JOIN jadwal_pendaftaran j ON p.jadwal_pendaftaran_id = j.jadwal_pendaftaran_id"; // left join digunakan agar data pendaftar tetap muncul walaupun jadwal_pendaftaran_id nya null.

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Pendaftar CRUD</title>
</head>

<body>
    <h2>Daftar Pendaftar</h2>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>NIK</th>
                <th>NISN</th>
                <th>Nama</th>
                <th>Provinsi</th>
                <th>Kabupaten/Kota</th>
                <th>Kecamatan</th>
                <th>Desa/Kelurahan</th>
                <th>Status</th>
                <th>ID Jadwal</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["pendaftar_id"] . "</td>";
                    echo "<td>" . $row["username"] . "</td>";
                    echo "<td>" . $row["nik"] . "</td>";
                    echo "<td>" . $row["nisn"] . "</td>";
                    echo "<td>" . $row["nama_lengkap"] . "</td>";
                    echo "<td>" . $row["province_name"] . "</td>";
                    echo "<td>" . $row["regency_name"] . "</td>";
                    echo "<td>" . $row["district_name"] . "</td>";
                    echo "<td>" . $row["village_name"] . "</td>";
                    echo "<td>" . $row["status"] . "</td>";
                    echo "<td>" . $row["jadwal_pendaftaran_id"] . "</td>";
                    echo "<td><a href='edit.php?id=" . $row["pendaftar_id"] . "'>Edit</a> | <a href='delete.php?id=" . $row["pendaftar_id"] . "'>Delete</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='10'>No records found</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <h2>Tambah Pendaftar</h2>
    <form action="create_pendaftaran.php" method="post">
        <label>User ID:</label>
        <input type="number" name="user_id" required><br>

        <label>NISN:</label>
        <input type="text" name="nisn" required><br>

        <label>NIK:</label>
        <input type="text" name="nik" required><br>

        <label>Nama Lengkap:</label>
        <input type="text" name="nama_lengkap" required><br>

        <label>Jenis Kelamin:</label>
        <select name="jenis_kelamin" required>
            <option value="Laki-laki">Laki-laki</option>
            <option value="Perempuan">Perempuan</option>
        </select><br>

        <label>Tempat Lahir:</label>
        <input type="text" name="tempat_lahir" required><br>

        <label>Tanggal Lahir:</label>
        <input type="date" name="tanggal_lahir" required><br>

        <label>Alamat Lengkap:</label>
        <textarea name="alamat_lengkap" required></textarea><br>

        <label>Agama:</label>
        <select name="agama" required>
            <option value="Islam">Islam</option>
            <option value="Kristen">Kristen</option>
            <option value="Katolik">Katolik</option>
            <option value="Hindu">Hindu</option>
            <option value="Buddha">Buddha</option>
            <option value="Konghucu">Konghucu</option>
        </select><br>

        <label>No. Telp:</label>
        <input type="text" name="no_telp" required><br>

        <label>Provinsi:</label>
        <select name="province_id" required>
            <?php
            $provinceSql = "SELECT id, name FROM provinces";
            $provinceResult = $conn->query($provinceSql);
            while ($provinceRow = $provinceResult->fetch_assoc()) {
                echo "<option value='" . $provinceRow["id"] . "'>" . $provinceRow["name"] . "</option>";
            }
            ?>
        </select><br>

        <label>Kabupaten/Kota:</label>
        <select name="regency_id" required>
            <?php
            $regencySql = "SELECT id, name FROM regencies";
            $regencyResult = $conn->query($regencySql);
            while ($regencyRow = $regencyResult->fetch_assoc()) {
                echo "<option value='" . $regencyRow["id"] . "'>" . $regencyRow["name"] . "</option>";
            }
            ?>
        </select><br>

        <label>Kecamatan:</label>
        <select name="district_id" required>
            <?php
            $districtSql = "SELECT id, name FROM districts";
            $districtResult = $conn->query($districtSql);
            while ($districtRow = $districtResult->fetch_assoc()) {
                echo "<option value='" . $districtRow["id"] . "'>" . $districtRow["name"] . "</option>";
            }
            ?>
        </select><br>

        <label>Desa/Kelurahan:</label>
        <select name="village_id" required>
            <?php
            $villageSql = "SELECT id, name FROM villages";
            $villageResult = $conn->query($villageSql);
            while ($villageRow = $villageResult->fetch_assoc()) {
                echo "<option value='" . $villageRow["id"] . "'>" . $villageRow["name"] . "</option>";
            }
            ?>
        </select><br>

        <label>ID Jadwal Pendaftaran:</label>
        <select name="jadwal_pendaftaran_id" required>
            <?php
            $jadwalSql = "SELECT jadwal_pendaftaran_id FROM jadwal_pendaftaran";
            $jadwalResult = $conn->query($jadwalSql);
            while ($jadwalRow = $jadwalResult->fetch_assoc()) {
                echo "<option value='" . $jadwalRow["jadwal_pendaftaran_id"] . "'>" . $jadwalRow["jadwal_pendaftaran_id"] . "</option>";
            }
            ?>
        </select><br>

        <input type="submit" value="Tambah">
    </form>

</body>

</html>

<?php
$conn->close();
?>