<?php
include '../../config/config.php';

$sql = "SELECT galeri_gambar_id, gambar, admin_id FROM galeri";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Galeri Gambar</title>
</head>

<body>
    <h1>Galeri Gambar</h1>
    <a href="../../admin/galeri/tambah_galeri.php">Tambah Gambar</a>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Gambar</th>
            <th>Admin ID</th>
            <th>Aksi</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['galeri_gambar_id'] . "</td>";
                echo "<td><img src='../../uploads/" . $row['gambar'] . "' width='100'></td>";
                echo "<td>" . $row['admin_id'] . "</td>";
                echo "<td><a href='edit_galeri.php?id=" . $row['galeri_gambar_id'] . "'>Edit</a> | <a href='hapus_galeri.php?id=" . $row['galeri_gambar_id'] . "'>Hapus</a></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>Tidak ada gambar di galeri.</td></tr>";
        }
        ?>
    </table>
</body>

</html>

<?php
$conn->close();
?>