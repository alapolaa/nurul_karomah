<?php
include '../../config/config.php';

$query = "SELECT * FROM kegiatan_lembaga";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Kegiatan Lembaga</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-4">
        <h2>Data Kegiatan Lembaga</h2>
        <a href="../../admin/kegiatan/tambah.php" class="btn btn-primary mb-3">Tambah Kegiatan</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Kegiatan</th>
                    <th>Tanggal</th>
                    <th>Deskripsi</th>
                    <th>Foto</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1;
                while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= $row['nama_kegiatan']; ?></td>
                        <td><?= $row['tanggal']; ?></td>
                        <td><?= $row['deskripsi']; ?></td>
                        <td><img src="../../uploads/<?= $row['foto']; ?>" width="100"></td>
                        <td>
                            <a href="../../admin/kegiatan/edit.php?id=<?= $row['kegiatan_lembaga_id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="../../admin/kegiatan/hapus.php?id=<?= $row['kegiatan_lembaga_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>

</html>