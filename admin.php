<?php
session_start();
include 'config.php';

// Ambil data pendaftar
$pendaftarSql = "SELECT p.*, u.username FROM pendaftar p JOIN users u ON p.user_id = u.user_id";
$pendaftarResult = $conn->query($pendaftarSql);

if (!$pendaftarResult) {
    die("Query gagal: " . $conn->error);
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Dashboard Admin</title>
</head>

<body>
    <h2>Data Pendaftar</h2>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Nama Lengkap</th>
                <th>NISN</th>
                <th>NIK</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($pendaftarResult->num_rows > 0) {
                while ($row = $pendaftarResult->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["pendaftar_id"] . "</td>";
                    echo "<td>" . $row["username"] . "</td>";
                    echo "<td>" . $row["nama_lengkap"] . "</td>";
                    echo "<td>" . $row["nisn"] . "</td>";
                    echo "<td>" . $row["nik"] . "</td>";
                    echo "<td>" . $row["status"] . "</td>";
                    echo "<td>";
                    echo "<a href='terima_pendaftar.php?id=" . $row["pendaftar_id"] . "'>Terima</a> | ";
                    echo "<a href='tolak_pendaftar.php?id=" . $row["pendaftar_id"] . "'>Tolak</a>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>Tidak ada data pendaftar.</td></tr>";
            }
            ?>
        </tbody>
    </table>

</body>

</html>

<?php $conn->close(); ?>