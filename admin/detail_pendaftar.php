<?php
session_start();
if (!isset($_SESSION['admin_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

include '../config/config.php';

if (isset($_GET['id'])) {
    $pendaftarId = $_GET['id'];

    $sql = "SELECT p.*, u.username AS nama_user FROM pendaftar p JOIN users u ON p.user_id = u.user_id WHERE p.pendaftar_id = $pendaftarId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <title>Detail Pendaftar</title>
        </head>

        <body>
            <h1>Detail Pendaftar</h1>
            <p><strong>Nama:</strong> <?php echo $row['nama_lengkap']; ?></p>
            <p><strong>NISN:</strong> <?php echo $row['nisn']; ?></p>
            <p><strong>NIK:</strong> <?php echo $row['nik']; ?></p>
            <p><strong>Jenis Kelamin:</strong> <?php echo $row['jenis_kelamin']; ?></p>
            <p><strong>Tempat Lahir:</strong> <?php echo $row['tempat_lahir']; ?></p>
            <p><strong>Tanggal Lahir:</strong> <?php echo $row['tanggal_lahir']; ?></p>
            <p><strong>Alamat:</strong> <?php echo $row['alamat_lengkap']; ?></p>
            <p><strong>Agama:</strong> <?php echo $row['agama']; ?></p>
            <p><strong>No. Telp:</strong> <?php echo $row['no_telp']; ?></p>

            <?php
            // Detail Asal Sekolah
            $asalSekolahSql = "SELECT * FROM asal_sekolah WHERE pendaftar_id = " . $row['pendaftar_id'];
            $asalSekolahResult = $conn->query($asalSekolahSql);
            if ($asalSekolahResult->num_rows > 0) {
                $asalSekolahRow = $asalSekolahResult->fetch_assoc();
                echo "<h2>Asal Sekolah</h2>";
                echo "<p><strong>NPSN:</strong> " . $asalSekolahRow['npsn'] . "</p>";
                echo "<p><strong>Nama Sekolah:</strong> " . $asalSekolahRow['nama_sekolah'] . "</p>";
            }

            // Detail Berkas Pendaftaran
            $berkasSql = "SELECT * FROM berkas_pendaftaran WHERE pendaftar_id = " . $row['pendaftar_id'];
            $berkasResult = $conn->query($berkasSql);
            if ($berkasResult->num_rows > 0) {
                $berkasRow = $berkasResult->fetch_assoc();
                echo "<h2>Berkas Pendaftaran</h2>";
                echo "<p><strong>Pas Foto:</strong> <a href='uploads/" . $berkasRow['pas_foto'] . "' target='_blank'>Lihat</a></p>";
                echo "<p><strong>Ijazah Depan:</strong> <a href='uploads/" . $berkasRow['ijazah_depan'] . "' target='_blank'>Lihat</a></p>";
                echo "<p><strong>Ijazah Belakang:</strong> <a href='uploads/" . $berkasRow['ijazah_belakang'] . "' target='_blank'>Lihat</a></p>";
            }

            // Detail Orang Tua/Wali
            $ortuSql = "SELECT * FROM orang_tua_wali WHERE pendaftar_id = " . $row['pendaftar_id'];
            $ortuResult = $conn->query($ortuSql);
            if ($ortuResult->num_rows > 0) {
                $ortuRow = $ortuResult->fetch_assoc();
                echo "<h2>Orang Tua/Wali</h2>";
                echo "<p><strong>NIK Ayah:</strong> " . $ortuRow['nik_ayah'] . "</p>";
                echo "<p><strong>Nama Ayah:</strong> " . $ortuRow['nama_ayah'] . "</p>";
                // ... tambahkan field lain dari tabel orang_tua_wali
            }
            ?>
        </body>

        </html>
<?php
    } else {
        echo "Data pendaftar tidak ditemukan.";
    }
} else {
    echo "ID pendaftar tidak valid.";
}
?>