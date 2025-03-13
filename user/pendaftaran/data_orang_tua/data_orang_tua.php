<?php
session_start();

// Pastikan pendaftar_id ada di session
if (!isset($_SESSION['pendaftar_id'])) {
    header("Location: pendaftaran.php"); // Redirect jika pendaftar_id tidak ada
    exit();
}

$pendaftar_id = $_SESSION['pendaftar_id'];

?>

<!DOCTYPE html>
<html>

<head>
    <title>Data Orang Tua/Wali</title>
</head>

<body>
    <h2>Form Data Orang Tua/Wali</h2>

    <form action="../../../user/pendaftaran/data_orang_tua/create_data_orang_tua.php" method="post">
        <input type="hidden" name="pendaftar_id" value="<?php echo $pendaftar_id; ?>">

        <label>NIK Ayah:</label>
        <input type="text" name="nik_ayah" required><br>

        <label>Nama Ayah:</label>
        <input type="text" name="nama_ayah" required><br>

        <label>Pendidikan Ayah:</label>
        <input type="text" name="pendidikan_ayah"><br>

        <label>Pekerjaan Ayah:</label>
        <input type="text" name="pekerjaan_ayah"><br>

        <label>Penghasilan Ayah:</label>
        <input type="number" name="penghasilan_ayah"><br>

        <label>No. Telp Ayah:</label>
        <input type="text" name="no_telp_ayah"><br>

        <label>NIK Ibu:</label>
        <input type="text" name="nik_ibu" required><br>

        <label>Nama Ibu:</label>
        <input type="text" name="nama_ibu" required><br>

        <label>Pendidikan Ibu:</label>
        <input type="text" name="pendidikan_ibu"><br>

        <label>Pekerjaan Ibu:</label>
        <input type="text" name="pekerjaan_ibu"><br>

        <label>Penghasilan Ibu:</label>
        <input type="number" name="penghasilan_ibu"><br>

        <label>No. Telp Ibu:</label>
        <input type="text" name="no_telp_ibu"><br>

        <label>NIK Wali:</label>
        <input type="text" name="nik_wali"><br>

        <label>Nama Wali:</label>
        <input type="text" name="nama_wali"><br>

        <label>Pendidikan Wali:</label>
        <input type="text" name="pendidikan_wali"><br>

        <label>Pekerjaan Wali:</label>
        <input type="text" name="pekerjaan_wali"><br>

        <label>Penghasilan Wali:</label>
        <input type="number" name="penghasilan_wali"><br>

        <label>No. Telp Wali:</label>
        <input type="text" name="no_telp_wali"><br>

        <input type="submit" value="Simpan Data Orang Tua/Wali">
    </form>
</body>

</html>