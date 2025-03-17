<?php
include '../../config/config.php';
$sql = "SELECT * FROM guru";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Guru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container mt-4">
    <h2 class="mb-3">Daftar Guru</h2>
    <a href="../../admin/guru/tambah.php" class="btn btn-primary mb-3">Tambah Guru</a>

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Jabatan</th>
                <th>Foto</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $result = $conn->query("SELECT * FROM guru");
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['guru_id']}</td>
                        <td>{$row['nama']}</td>
                        <td>{$row['jabatan']}</td>
                        <td><img src='../../uploads/{$row['foto']}' width='80'></td>
                        <td>
                            <a href='edit.php?id={$row['guru_id']}' class='btn btn-warning btn-sm'>Edit</a>
                            <a href='hapus.php?id={$row['guru_id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Yakin ingin menghapus?\")'>Hapus</a>
                        </td>
                    </tr>";
            }
            ?>
        </tbody>
    </table>
</body>

</html>