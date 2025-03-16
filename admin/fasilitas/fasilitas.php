<!DOCTYPE html>
<html>

<head>
    <title>Daftar Fasilitas</title>
</head>

<body>
    <h1>Daftar Fasilitas</h1>
    <a href="../../admin/fasilitas/tambah.php">Tambah Fasilitas</a>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Gambar</th>
            <th>Nama Fasilitas</th>
            <th>Keterangan</th>
            <th>Admin ID</th>
            <th>Aksi</th>
        </tr>
        <?php
        include '../../koneksi.php';
        $sql = "SELECT * FROM fasilitas";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['fasilitas_id'] . "</td>";
                echo "<td><img src='" . $row['gambar'] . "' width='100'></td>";
                echo "<td>" . $row['nama_fasilitas'] . "</td>";
                echo "<td>" . $row['keterangan'] . "</td>";
                echo "<td>" . $row['admin_id'] . "</td>";
                echo "<td>
                        <a href='../../admin/fasilitas/edit.php?id=" . $row['fasilitas_id'] . "'>Edit</a> | 
                        <a href='../../admin/fasilitas/hapus.php?id=" . $row['fasilitas_id'] . "' onclick='return confirm(\"Apakah Anda yakin?\")'>Hapus</a>
                      </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>Tidak ada data</td></tr>";
        }
        $conn->close();
        ?>
    </table>
</body>

</html>