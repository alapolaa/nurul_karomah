<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Mata Pelajaran</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .form-group {
            margin-bottom: 10px;
        }

        .form-control {
            padding: 8px;
            height: 35px;
            font-size: 14px;
        }

        .btn {
            font-size: 14px;
            padding: 8px 16px;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h1>Tambah Mata Pelajaran</h1>
                <form action="proses_tambah.php" method="post" class="p-3">
                    <div class="form-group">
                        <label for="nama_mapel">Nama Mata Pelajaran:</label>
                        <input type="text" class="form-control" id="nama_mapel" name="nama_mapel" required>
                    </div>
                    <div class="form-group">
                        <label for="guru_id">Guru:</label>
                        <select class="form-control" id="guru_id" name="guru_id" required>
                            <option value="">Pilih Guru</option>
                            <?php
                            // Sertakan file koneksi database Anda
                            include '../../config/config.php';

                            // Query untuk mengambil data guru
                            $sql = "SELECT guru_id, nama FROM guru";
                            $result = $conn->query($sql);

                            // Loop untuk menampilkan data guru dalam dropdown
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo '<option value="' . $row['guru_id'] . '">' . $row['nama'] . '</option>';
                                }
                            }

                            // Tutup koneksi database
                            $conn->close();
                            ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="../../admin/mapel/mapel.php" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>