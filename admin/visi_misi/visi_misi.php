<?php
include '../../koneksi.php';
?>


<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Visi & Misi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container mt-5">
        <h2 class="mb-4">Data Visi & Misi</h2>

        <a href="../../admin/visi_misi/tambah_visi.php" class="btn btn-primary">Tambah Visi</a>
        <a href="tambah_misi.php" class="btn btn-primary">Tambah Misi</a>

        <h3 class="mt-4">Visi</h3>
        <table class="table table-bordered">
            <tr>
                <th>No</th>
                <th>Deskripsi</th>
                <th>Aksi</th>
            </tr>
            <?php
            $result = $conn->query("SELECT * FROM visi");
            $no = 1;
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                <td>{$no}</td>
                <td>{$row['deskripsi']}</td>
                <td>
                    <a href='edit_visi.php?id={$row['visi_id']}' class='btn btn-warning btn-sm'>Edit</a>
                    <a href='hapus_visi.php?id={$row['visi_id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Yakin ingin menghapus?\")'>Hapus</a>
                </td>
            </tr>";
                $no++;
            }
            ?>
        </table>

        <h3 class="mt-4">Misi</h3>
        <table class="table table-bordered">
            <tr>
                <th>No</th>
                <th>Deskripsi</th>
                <th>Aksi</th>
            </tr>
            <?php
            $result = $conn->query("SELECT * FROM misi");
            $no = 1;
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                <td>{$no}</td>
                <td>{$row['deskripsi']}</td>
                <td>
                    <a href='edit_misi.php?id={$row['misi_id']}' class='btn btn-warning btn-sm'>Edit</a>
                    <a href='hapus_misi.php?id={$row['misi_id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Yakin ingin menghapus?\")'>Hapus</a>
                </td>
            </tr>";
                $no++;
            }
            ?>
        </table>

    </div>

</body>

</html>