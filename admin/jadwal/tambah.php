<!DOCTYPE html>
<html>

<head>
    <title>Tambah Jadwal</title>
</head>

<body>
    <h1>Tambah Jadwal Pendaftaran</h1>
    <form method="post" action="proses_tambah.php">
        <label>Jenjang:</label><br>
        <select name="jenjang">
            <option value="MI">MI</option>
            <option value="MTs">MTs</option>
            <option value="MA">MA</option>
        </select><br><br>
        <label>Tanggal Mulai:</label><br>
        <input type="date" name="tanggal_mulai"><br><br>
        <label>Tanggal Selesai:</label><br>
        <input type="date" name="tanggal_selesai"><br><br>
        <label>Tahun Ajaran:</label><br>
        <input type="text" name="tahun_ajaran"><br><br>
        <input type="submit" value="Simpan">
    </form>
</body>

</html>