<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Jadwal Pendaftaran</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header bg-primary text-white">
                Edit Jadwal Pendaftaran
            </div>
            <div class="card-body">
                <?php
                include '../../config/config.php';

                $id = $_GET['id'];
                $sql = "SELECT * FROM jadwal_pendaftaran WHERE jadwal_pendaftaran_id = $id";
                $result = $conn->query($sql);
                $row = $result->fetch_assoc();
                ?>
                <form method="post" action="../../admin/jadwal/proses_edit.php">
                    <input type="hidden" name="id" value="<?php echo $row['jadwal_pendaftaran_id']; ?>">
                    <div class="form-group">
                        <label for="jenjang">Jenjang:</label>
                        <select class="form-control" id="jenjang" name="jenjang">
                            <option value="MI" <?php if ($row['jenjang'] == 'MI') echo 'selected'; ?>>MI</option>
                            <option value="MTs" <?php if ($row['jenjang'] == 'MTs') echo 'selected'; ?>>MTs</option>
                            <option value="MA" <?php if ($row['jenjang'] == 'MA') echo 'selected'; ?>>MA</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tanggal_mulai">Tanggal Mulai:</label>
                        <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" value="<?php echo $row['tanggal_mulai']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="tanggal_selesai">Tanggal Selesai:</label>
                        <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai" value="<?php echo $row['tanggal_selesai']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="tahun_ajaran">Tahun Ajaran:</label>
                        <input type="text" class="form-control" id="tahun_ajaran" name="tahun_ajaran" value="<?php echo $row['tahun_ajaran']; ?>">
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="../../admin/jadwal/jadwal.php" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>