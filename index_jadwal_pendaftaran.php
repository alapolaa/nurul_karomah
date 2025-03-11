<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'config.php';

// Fungsi untuk menentukan status pendaftaran
function getStatusPendaftaran($tanggal_selesai)
{
    $tanggal_sekarang = date("Y-m-d");
    if ($tanggal_sekarang <= $tanggal_selesai) {
        return "Buka";
    } else {
        return "Tutup";
    }
}

// Fetch data from jadwal_pendaftaran table
$sql = "SELECT * FROM jadwal_pendaftaran";
$result = $conn->query($sql);

if (!$result) {
    die("Query gagal: " . $conn->error);
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Jadwal Pendaftaran CRUD</title>
</head>

<body>
    <h2>Daftar Jadwal Pendaftaran</h2>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Jenjang</th>
                <th>Tanggal Mulai</th>
                <th>Tanggal Selesai</th>
                <th>Jumlah Siswa</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $status = getStatusPendaftaran($row["tanggal_selesai"]);
                    echo "<tr>";
                    echo "<td>" . $row["jadwal_pendaftaran_id"] . "</td>";
                    echo "<td>" . $row["jenjang"] . "</td>";
                    echo "<td>" . $row["tanggal_mulai"] . "</td>";
                    echo "<td>" . $row["tanggal_selesai"] . "</td>";
                    echo "<td>" . $row["jumlah_siswa"] . "</td>";
                    echo "<td>";
                    if ($status == "Buka") {
                        echo "<a href='daftar.php?id=" . $row["jadwal_pendaftaran_id"] . "'>" . $status . "</a>";
                    } else {
                        echo $status;
                    }
                    echo "</td>";
                    echo "<td>";
                    echo "<a href='edit_jadwal_pendaftaran.php?id=" . $row["jadwal_pendaftaran_id"] . "'>Edit</a> | <a href='delete_jadwal_pendaftaran.php?id=" . $row["jadwal_pendaftaran_id"] . "'>Delete</a>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No records found</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <h2>Tambah Jadwal Pendaftaran</h2>
    <form action="create_jadwal_pendaftaran.php" method="post">
        <label>Jenjang:</label>
        <select name="jenjang" required>
            <option value="MI">MI</option>
            <option value="MTs">MTs</option>
            <option value="MA">MA</option>
        </select><br>
        <label>Tanggal Mulai:</label>
        <input type="date" name="tanggal_mulai" required><br>
        <label>Tanggal Selesai:</label>
        <input type="date" name="tanggal_selesai" required><br>
        <label>Jumlah Siswa:</label>
        <input type="number" name="jumlah_siswa" required><br>
        <input type="submit" value="Tambah">
    </form>

</body>

</html>

<?php
$conn->close();
?>