<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Fasilitas</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header bg-primary text-white">
                Edit Fasilitas
            </div>
            <div class="card-body">
                <?php
                include '../../config/config.php';
                $id = $_GET['id'];
                $sql = "SELECT * FROM fasilitas WHERE fasilitas_id=$id";
                $result = $conn->query($sql);
                $row = $result->fetch_assoc();
                ?>
                <form action="../../admin/fasilitas/proses_edit.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo $row['fasilitas_id']; ?>">
                    <div class="form-group">
                        <label for="gambar">Gambar:</label>
                        <input type="file" class="form-control-file" id="gambar" name="gambar">
                        <small class="form-text text-muted">Biarkan kosong jika tidak ingin mengubah gambar.</small>
                    </div>
                    <div class="form-group">
                        <label for="nama_fasilitas">Nama Fasilitas:</label>
                        <input type="text" class="form-control" id="nama_fasilitas" name="nama_fasilitas" value="<?php echo $row['nama_fasilitas']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="keterangan">Keterangan:</label>
                        <textarea class="form-control" id="keterangan" name="keterangan" required><?php echo $row['keterangan']; ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="../../admin/fasilitas/fasilitas.php" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>