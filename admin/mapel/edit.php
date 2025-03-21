<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Mata Pelajaran</title>
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
                <h1>Edit Mata Pelajaran</h1>
                <?php
                include '../../config/config.php';
                $id = $_GET['id'];
                $sql = "SELECT * FROM mata_pelajaran WHERE mata_pelajaran_id=$id";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                ?>
                    <form action="../../admin/mapel/proses_edit.php" method="post" class="p-3">
                        <input type="hidden" name="id" value="<?php echo $row['mata_pelajaran_id']; ?>">
                        <div class="form-group">
                            <label for="nama_mapel">Nama Mata Pelajaran:</label>
                            <input type="text" class="form-control" id="nama_mapel" name="nama_mapel" value="<?php echo $row['nama_mapel']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="guru_id">Guru:</label>
                            <select class="form-control" id="guru_id" name="guru_id" required>
                                <option value="">Pilih Guru</option>
                                <?php
                                // Query untuk mengambil data guru
                                $sql_guru = "SELECT guru_id, nama FROM guru";
                                $result_guru = $conn->query($sql_guru);

                                // Loop untuk menampilkan data guru dalam dropdown
                                if ($result_guru->num_rows > 0) {
                                    while ($guru_row = $result_guru->fetch_assoc()) {
                                        $selected = ($guru_row['guru_id'] == $row['guru_id']) ? 'selected' : '';
                                        echo '<option value="' . $guru_row['guru_id'] . '" ' . $selected . '>' . $guru_row['nama'] . '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        <a href="../../admin/mapel/mapel.php" class="btn btn-secondary">Kembali</a>
                    </form>
                <?php
                } else {
                    echo "Data tidak ditemukan";
                }
                $conn->close();
                ?>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>