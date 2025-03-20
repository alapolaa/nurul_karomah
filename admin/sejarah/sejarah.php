<?php
include '../../config/config.php';
// Query untuk mengambil data dari tabel sejarah
$sql = "SELECT * FROM sejarah";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Sejarah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-4">
        <h2>Data Sejarah</h2>
        <a href="../../admin/sejarah/tambah.php" class="btn btn-primary mb-3">Tambah Data</a>
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Gambar</th>
                    <th>Keterangan</th>

                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    $no = 1;
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $no++ . "</td>";
                        echo "<td><img src='../../uploads/" . $row['gambar'] . "' width='100'></td>";
                        echo "<td>" . $row['keterangan'] . "</td>";

                        echo "<td>
                                <a href='../../admin/sejarah/edit.php?id=" . $row['sejarah_id'] . "' class='btn btn-warning btn-sm'>Edit</a>
                                <a href='../../admin/sejarah/delete.php?id=" . $row['sejarah_id'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Yakin hapus?\")'>Hapus</a>
                            </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5' class='text-center'>Tidak ada data</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>