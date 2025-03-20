<?php
session_start(); // Pastikan sesi dimulai
include '../../config/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama_prestasi'];
    $tingkat = $_POST['tingkat'];
    $tahun = $_POST['tahun'];
    $deskripsi = $_POST['deskripsi'];
    $admin_id = $_SESSION['admin_id'] ?? NULL; // Ambil admin_id dari sesi

    // Upload foto
    $foto = $_FILES['foto']['name'];
    $target = "../../uploads/" . basename($foto);

    if (move_uploaded_file($_FILES['foto']['tmp_name'], $target)) {
        // Gunakan prepared statements untuk mencegah SQL injection
        $stmt = $conn->prepare("INSERT INTO prestasi_lembaga (nama_prestasi, tingkat, tahun, deskripsi, foto, admin_id) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssissi", $nama, $tingkat, $tahun, $deskripsi, $foto, $admin_id); // "ssissi" berarti string, string, integer, string, string, integer

        if ($stmt->execute()) {
            header("Location: ../../admin/prestasi/prestasi.php");
            exit(); // Penting untuk menghentikan eksekusi skrip setelah pengalihan
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Gagal mengupload gambar!";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Tambah Prestasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-4">
        <h2>Tambah Prestasi</h2>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label>Nama Prestasi</label>
                <input type="text" name="nama_prestasi" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Tingkat</label>
                <select name="tingkat" class="form-control" required>
                    <option value="Kabupaten">Kabupaten</option>
                    <option value="Provinsi">Provinsi</option>
                    <option value="Nasional">Nasional</option>
                    <option value="Internasional">Internasional</option>
                </select>
            </div>
            <div class="mb-3">
                <label>Tahun</label>
                <input type="number" name="tahun" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Deskripsi</label>
                <textarea name="deskripsi" class="form-control" required></textarea>
            </div>
            <div class="mb-3">
                <label>Foto</label>
                <input type="file" name="foto" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="../../admin/prestasi/prestasi.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</body>

</html>