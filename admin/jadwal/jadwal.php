<!DOCTYPE html>
<html>

<head>
    <title>Jadwal Pendaftaran</title>
</head>

<body>
    <h1>Jadwal Pendaftaran</h1>
    <a href="tambah.php">Tambah Jadwal</a>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Jenjang</th>
            <th>Tanggal Mulai</th>
            <th>Tanggal Selesai</th>
            <th>Tahun Ajaran</th>
            <th>Jumlah Pendaftar</th>
            <th>Jumlah Diterima</th>
            <th>Jumlah Ditolak</th>
            <th>Aksi</th>
        </tr>
        <?php
        include '../../config/config.php';

        $sql = "SELECT * FROM jadwal_pendaftaran";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['jadwal_pendaftaran_id'] . "</td>";
                echo "<td>" . $row['jenjang'] . "</td>";
                echo "<td>" . $row['tanggal_mulai'] . "</td>";
                echo "<td>" . $row['tanggal_selesai'] . "</td>";
                echo "<td>" . $row['tahun_ajaran'] . "</td>";
                echo "<td>" . $row['jumlah_pendaftar'] . "</td>";
                echo "<td>" . $row['jumlah_diterima'] . "</td>";
                echo "<td>" . $row['jumlah_ditolak'] . "</td>";
                echo "<td><a href='edit.php?id=" . $row['jadwal_pendaftaran_id'] . "'>Edit</a> | <a href='hapus.php?id=" . $row['jadwal_pendaftaran_id'] . "'>Hapus</a></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='9'>Tidak ada data</td></tr>";
        }

        $conn->close();
        ?>
    </table>
</body>

</html>