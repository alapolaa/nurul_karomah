<?php
include '../../koneksi.php';
$result = $conn->query("SELECT * FROM prestasi_lembaga");
?>

<!DOCTYPE html>
<html>

<head>
    <title>Prestasi Lembaga</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-4">
        <h2>Data Prestasi Lembaga</h2>
        <a href="tambah.php" class="btn btn-primary mb-3">Tambah Prestasi</a>
        <table class="table table-bordered">
            <tr>
                <th>No</th>
                <th>Nama Prestasi</th>
                <th>Tingkat</th>
                <th>Tahun</th>
                <th>Deskripsi</th>
                <th>Foto</th>
                <th>Aksi</th>
            </tr>
            <?php $no = 1;
            while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $row['nama_prestasi']; ?></td>
                    <td><?= $row['tingkat']; ?></td>
                    <td><?= $row['tahun']; ?></td>
                    <td><?= $row['deskripsi']; ?></td>
                    <td><img src="../../uploads/<?= $row['foto']; ?>" width="100"></td>
                    <td>
                        <a href="edit.php?id=<?= $row['prestasi_lembaga_id']; ?>" class="btn btn-warning">Edit</a>
                        <a href="hapus.php?id=<?= $row['prestasi_lembaga_id']; ?>" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>

</html>