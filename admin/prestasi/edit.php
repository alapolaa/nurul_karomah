<?php
include '../../config/config.php';

$id = $_GET['id'];
$result = $conn->query("SELECT * FROM prestasi_lembaga WHERE prestasi_lembaga_id = $id");
$row = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama_prestasi'];
    $tingkat = $_POST['tingkat'];
    $tahun = $_POST['tahun'];
    $deskripsi = $_POST['deskripsi'];
    $foto = $row['foto']; // Default foto lama

    // Cek apakah pengguna mengupload foto baru
    if ($_FILES['foto']['name']) {
        $foto = $_FILES['foto']['name'];
        $target = "../../uploads/" . basename($foto);

        // Hapus foto lama jika ada
        if (file_exists("upload/" . $row['foto'])) {
            unlink("upload/" . $row['foto']);
        }

        move_uploaded_file($_FILES['foto']['tmp_name'], $target);
    }

    // Update data ke database
    $sql = "UPDATE prestasi_lembaga SET 
            nama_prestasi='$nama', 
            tingkat='$tingkat', 
            tahun='$tahun', 
            deskripsi='$deskripsi', 
            foto='$foto' 
            WHERE prestasi_lembaga_id=$id";

    if ($conn->query($sql) === TRUE) {
        header("Location: ../../admin/prestasi/prestasi.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Prestasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-4">
        <h2>Edit Prestasi</h2>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label>Nama Prestasi</label>
                <input type="text" name="nama_prestasi" class="form-control" value="<?= $row['nama_prestasi']; ?>" required>
            </div>
            <div class="mb-3">
                <label>Tingkat</label>
                <select name="tingkat" class="form-control" required>
                    <option value="Kabupaten" <?= ($row['tingkat'] == 'Kabupaten') ? 'selected' : ''; ?>>Kabupaten</option>
                    <option value="Provinsi" <?= ($row['tingkat'] == 'Provinsi') ? 'selected' : ''; ?>>Provinsi</option>
                    <option value="Nasional" <?= ($row['tingkat'] == 'Nasional') ? 'selected' : ''; ?>>Nasional</option>
                    <option value="Internasional" <?= ($row['tingkat'] == 'Internasional') ? 'selected' : ''; ?>>Internasional</option>
                </select>
            </div>
            <div class="mb-3">
                <label>Tahun</label>
                <input type="number" name="tahun" class="form-control" value="<?= $row['tahun']; ?>" required>
            </div>
            <div class="mb-3">
                <label>Deskripsi</label>
                <textarea name="deskripsi" class="form-control" required><?= $row['deskripsi']; ?></textarea>
            </div>
            <div class="mb-3">
                <label>Foto</label>
                <input type="file" name="foto" class="form-control">
                <small>Biarkan kosong jika tidak ingin mengganti foto</small><br>
                <img src="upload/<?= $row['foto']; ?>" width="100">
            </div>
            <button type="submit" class="btn btn-success">Simpan Perubahan</button>
            <a href="../../admin/prestasi/prestasi.php" class="btn btn-secondary">Kembali</a>

        </form>
    </div>
</body>

</html>