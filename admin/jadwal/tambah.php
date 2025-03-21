<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Jadwal Pendaftaran</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header bg-primary text-white">
                Tambah Jadwal Pendaftaran
            </div>
            <div class="card-body">
                <form method="post" action="proses_tambah.php">
                    <div class="form-group">
                        <label for="jenjang">Jenjang:</label>
                        <select class="form-control" id="jenjang" name="jenjang">
                            <option value="MI">MI</option>
                            <option value="MTs">MTs</option>
                            <option value="MA">MA</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tanggal_mulai">Tanggal Mulai:</label>
                        <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai">
                    </div>
                    <div class="form-group">
                        <label for="tanggal_selesai">Tanggal Selesai:</label>
                        <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai">
                    </div>
                    <div class="form-group">
                        <label for="tahun_ajaran">Tahun Ajaran:</label>
                        <input type="text" class="form-control" id="tahun_ajaran" name="tahun_ajaran">
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