<!DOCTYPE html>
<html>

<head>
    <title>Daftar Mata Pelajaran</title>
</head>

<body>
    <h1>Daftar Mata Pelajaran</h1>
    <a href="../../admin/mapel/tambah.php">Tambah Mata Pelajaran</a>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nama Mata Pelajaran</th>
            <th>Guru ID</th>
            <th>Admin ID</th>
            <th>Aksi</th>
        </tr>
        <?php
        include '../../config/config.php';
        $sql = "SELECT * FROM mata_pelajaran";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["mata_pelajaran_id"] . "</td>";
                echo "<td>" . $row["nama_mapel"] . "</td>";
                echo "<td>" . $row["guru_id"] . "</td>";
                echo "<td>" . $row["admin_id"] . "</td>";
                echo "<td><a href='edit.php?id=" . $row["mata_pelajaran_id"] . "'>Edit</a> | <a href='hapus.php?id=" . $row["mata_pelajaran_id"] . "'>Hapus</a></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>Tidak ada data</td></tr>";
        }
        $conn->close();
        ?>
    </table>
</body>

</html>