<?php
session_start();
if (!isset($_SESSION['admin_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
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
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
            <style>
                .detail-row {
                    display: flex;
                    justify-content: space-between;
                }

                .detail-label {
                    font-weight: bold;
                    width: 30%;
                }

                .detail-value {
                    width: 70%;
                }

                /* Tambahkan style untuk memperkecil lebar */
                .container {
                    max-width: 800px;
                    /* Sesuaikan lebar maksimum */
                    margin: auto;
                    /* Agar container berada di tengah */
                }
            </style>
        </head>

        <body>
            <div class="container mt-5">
                <div class="d-flex justify-content-between align-items-center">
                    <h1>Detail Pendaftar</h1>
                    <a href="../admin/dashboard.php" class="btn btn-sm btn-secondary">
                        <i class="fas fa-times"></i>
                    </a>
                </div>

                <div class="card mt-3">
                    <div class="card-header">
                        Informasi Pribadi
                    </div>
                    <div class="card-body">
                        <div class="detail-row">
                            <div class="detail-label">Nama:</div>
                            <div class="detail-value"><?php echo $row['nama_lengkap']; ?></div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">NISN:</div>
                            <div class="detail-value"><?php echo $row['nisn']; ?></div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">NIK:</div>
                            <div class="detail-value"><?php echo $row['nik']; ?></div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">Jenis Kelamin:</div>
                            <div class="detail-value"><?php echo $row['jenis_kelamin']; ?></div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">Tempat Lahir:</div>
                            <div class="detail-value"><?php echo $row['tempat_lahir']; ?></div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">Tanggal Lahir:</div>
                            <div class="detail-value"><?php echo $row['tanggal_lahir']; ?></div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">Alamat:</div>
                            <div class="detail-value"><?php echo $row['alamat_lengkap']; ?></div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">Agama:</div>
                            <div class="detail-value"><?php echo $row['agama']; ?></div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">No. Telp:</div>
                            <div class="detail-value"><?php echo $row['no_telp']; ?></div>
                        </div>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-header">
                        Orang Tua/Wali
                    </div>
                    <div class="card-body">
                        <?php
                        // Detail Orang Tua/Wali
                        $ortuSql = "SELECT * FROM orang_tua_wali WHERE pendaftar_id = " . $row['pendaftar_id'];
                        $ortuResult = $conn->query($ortuSql);
                        if ($ortuResult->num_rows > 0) {
                            $ortuRow = $ortuResult->fetch_assoc();
                            echo "<div class='detail-row'><div class='detail-label'>NIK Ayah:</div><div class='detail-value'>" . $ortuRow['nik_ayah'] . "</div></div>";
                            echo "<div class='detail-row'><div class='detail-label'>Nama Ayah:</div><div class='detail-value'>" . $ortuRow['nama_ayah'] . "</div></div>";
                            echo "<div class='detail-row'><div class='detail-label'>Pendidikan Ayah:</div><div class='detail-value'>" . $ortuRow['pendidikan_ayah'] . "</div></div>";
                            echo "<div class='detail-row'><div class='detail-label'>Pekerjaan Ayah:</div><div class='detail-value'>" . $ortuRow['pekerjaan_ayah'] . "</div></div>";
                            echo "<div class='detail-row'><div class='detail-label'>Penghasilan Ayah:</div><div class='detail-value'>" . $ortuRow['penghasilan_ayah'] . "</div></div>";
                            echo "<div class='detail-row'><div class='detail-label'>No. Telp. Ayah:</div><div class='detail-value'>" . $ortuRow['no_telp_ayah'] . "</div></div>";
                            echo "<hr class='separator'>";
                            echo "<div class='detail-row'><div class='detail-label'>NIK Ibu:</div><div class='detail-value'>" . $ortuRow['nik_ibu'] . "</div></div>";
                            echo "<div class='detail-row'><div class='detail-label'>Nama Ibu:</div><div class='detail-value'>" . $ortuRow['nama_ibu'] . "</div></div>";
                            echo "<div class='detail-row'><div class='detail-label'>Pendidikan ibu:</div><div class='detail-value'>" . $ortuRow['pendidikan_ibu'] . "</div></div>";
                            echo "<div class='detail-row'><div class='detail-label'>Pekerjaan ibu:</div><div class='detail-value'>" . $ortuRow['pekerjaan_ibu'] . "</div></div>";
                            echo "<div class='detail-row'><div class='detail-label'>Penghasilan ibu:</div><div class='detail-value'>" . $ortuRow['penghasilan_ibu'] . "</div></div>";
                            echo "<div class='detail-row'><div class='detail-label'>No. Telp. ibu:</div><div class='detail-value'>" . $ortuRow['no_telp_ibu'] . "</div></div>";
                            echo "<hr class='separator'>";
                            echo "<div class='detail-row'><div class='detail-label'>NIK wali:</div><div class='detail-value'>" . $ortuRow['nik_wali'] . "</div></div>";
                            echo "<div class='detail-row'><div class='detail-label'>Nama wali:</div><div class='detail-value'>" . $ortuRow['nama_wali'] . "</div></div>";
                            echo "<div class='detail-row'><div class='detail-label'>Pendidikan wali:</div><div class='detail-value'>" . $ortuRow['pendidikan_wali'] . "</div></div>";
                            echo "<div class='detail-row'><div class='detail-label'>Pekerjaan wali:</div><div class='detail-value'>" . $ortuRow['pekerjaan_wali'] . "</div></div>";
                            echo "<div class='detail-row'><div class='detail-label'>Penghasilan wali:</div><div class='detail-value'>" . $ortuRow['penghasilan_wali'] . "</div></div>";
                            echo "<div class='detail-row'><div class='detail-label'>No. Telp. wali:</div><div class='detail-value'>" . $ortuRow['no_telp_wali'] . "</div></div>";
                        }
                        ?>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-header">
                        Informasi Sekolah
                    </div>
                    <div class="card-body">
                        <?php
                        // Detail Asal Sekolah
                        $asalSekolahSql = "SELECT * FROM asal_sekolah WHERE pendaftar_id = " . $row['pendaftar_id'];
                        $asalSekolahResult = $conn->query($asalSekolahSql);
                        if ($asalSekolahResult->num_rows > 0) {
                            $asalSekolahRow = $asalSekolahResult->fetch_assoc();
                            echo "<div class='detail-row'><div class='detail-label'>NPSN:</div><div class='detail-value'>" . $asalSekolahRow['npsn'] . "</div></div>";
                            echo "<div class='detail-row'><div class='detail-label'>Nama Sekolah:</div><div class='detail-value'>" . $asalSekolahRow['nama_sekolah'] . "</div></div>";
                        }
                        ?>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-header">
                        Berkas Pendaftaran
                    </div>
                    <div class="card-body">
                        <?php
                        // Detail Berkas Pendaftaran
                        $berkasSql = "SELECT * FROM berkas_pendaftaran WHERE pendaftar_id = " . $row['pendaftar_id'];
                        $berkasResult = $conn->query($berkasSql);
                        if ($berkasResult->num_rows > 0) {
                            $berkasRow = $berkasResult->fetch_assoc();
                            echo "<div class='detail-row'><div class='detail-label'>Pas Foto:</div><div class='detail-value'><a href='uploads/" . $berkasRow['pas_foto'] . "' target='_blank'>Lihat</a></div></div>";
                            echo "<div class='detail-row'><div class='detail-label'>Ijazah Depan:</div><div class='detail-value'><a href='uploads/" . $berkasRow['ijazah_depan'] . "' target='_blank'>Lihat</a></div></div>";
                            echo "<div class='detail-row'><div class='detail-label'>Ijazah Belakang:</div><div class='detail-value'><a href='uploads/" . $berkasRow['ijazah_belakang'] . "' target='_blank'>Lihat</a></div></div>";
                        }
                        ?>
                    </div>
                </div>

            </div>
            <br>
            <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        </body>

        </html>
<?php
    } else {
        echo "<div class='alert alert-danger'>Data pendaftar tidak ditemukan.</div>";
    }
} else {
    echo "<div class='alert alert-danger'>ID pendaftar tidak valid.</div>";
}
?>