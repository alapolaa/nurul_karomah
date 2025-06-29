<?php

session_start();

include '../config/config.php';

if (isset($_GET['id'])) {
    $pendaftarId = $_GET['id'];

    // Ambil data pendaftar beserta jenjang pendaftaran
    $sql = "SELECT p.*, u.username AS nama_user, j.jenjang AS jenjang_pendaftaran
            FROM pendaftar p
            JOIN users u ON p.user_id = u.user_id
            LEFT JOIN jadwal_pendaftaran j ON p.jadwal_pendaftaran_id = j.jadwal_pendaftaran_id
            WHERE p.pendaftar_id = $pendaftarId";
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

                .separator {
                    border-top: 1px solid #eee;
                    margin: 15px 0;
                }
            </style>
        </head>

        <body>
            <div class="container mt-5">
                <div class="d-flex justify-content-between align-items-center">
                    <h1>Detail Pendaftar</h1>
                    <a href="../user/index.php" class="btn btn-sm btn-secondary">
                        <i class="fas fa-times"></i>
                    </a>
                </div>

                <div class="card mt-3">
                    <div class="card-header">
                        Informasi Pendaftaran
                    </div>
                    <div class="card-body">
                        <div class="detail-row">
                            <div class="detail-label">Jenjang:</div>
                            <div class="detail-value"><?php echo $row['jenjang_pendaftaran']; ?></div>
                        </div>
                    </div>
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
                        <?php
                        // --- Bagian Penting: Kondisi untuk menampilkan NISN ---
                        if (isset($row['jenjang_pendaftaran']) && ($row['jenjang_pendaftaran'] == 'MTs' || $row['jenjang_pendaftaran'] == 'MA')) {
                        ?>
                            <div class="detail-row">
                                <div class="detail-label">NISN:</div>
                                <div class="detail-value"><?php echo $row['nisn']; ?></div>
                            </div>
                        <?php
                        }
                        // --- Akhir Bagian Penting ---
                        ?>
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
                            <div class="detail-value"><?php echo $row['no_telpon']; ?></div>
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
                            echo "<div class='detail-row'><div class='detail-label'>NIK Ayah:</div><div class='detail-value'>" . htmlspecialchars($ortuRow['nik_ayah']) . "</div></div>";
                            echo "<div class='detail-row'><div class='detail-label'>Nama Ayah:</div><div class='detail-value'>" . htmlspecialchars($ortuRow['nama_ayah']) . "</div></div>";
                            echo "<div class='detail-row'><div class='detail-label'>Pendidikan Ayah:</div><div class='detail-value'>" . htmlspecialchars($ortuRow['pendidikan_ayah']) . "</div></div>";
                            echo "<div class='detail-row'><div class='detail-label'>Pekerjaan Ayah:</div><div class='detail-value'>" . htmlspecialchars($ortuRow['pekerjaan_ayah']) . "</div></div>";
                            echo "<div class='detail-row'><div class='detail-label'>Penghasilan Ayah:</div><div class='detail-value'>" . htmlspecialchars($ortuRow['penghasilan_ayah']) . "</div></div>";
                            echo "<div class='detail-row'><div class='detail-label'>No. Telp. Ayah:</div><div class='detail-value'>" . htmlspecialchars($ortuRow['no_telp_ayah']) . "</div></div>";
                            echo "<hr class='separator'>";
                            echo "<div class='detail-row'><div class='detail-label'>NIK Ibu:</div><div class='detail-value'>" . htmlspecialchars($ortuRow['nik_ibu']) . "</div></div>";
                            echo "<div class='detail-row'><div class='detail-label'>Nama Ibu:</div><div class='detail-value'>" . htmlspecialchars($ortuRow['nama_ibu']) . "</div></div>";
                            echo "<div class='detail-row'><div class='detail-label'>Pendidikan Ibu:</div><div class='detail-value'>" . htmlspecialchars($ortuRow['pendidikan_ibu']) . "</div></div>";
                            echo "<div class='detail-row'><div class='detail-label'>Pekerjaan Ibu:</div><div class='detail-value'>" . htmlspecialchars($ortuRow['pekerjaan_ibu']) . "</div></div>";
                            echo "<div class='detail-row'><div class='detail-label'>Penghasilan Ibu:</div><div class='detail-value'>" . htmlspecialchars($ortuRow['penghasilan_ibu']) . "</div></div>";
                            echo "<div class='detail-row'><div class='detail-label'>No. Telp. Ibu:</div><div class='detail-value'>" . htmlspecialchars($ortuRow['no_telp_ibu']) . "</div></div>";
                            echo "<hr class='separator'>";
                            echo "<div class='detail-row'><div class='detail-label'>NIK Wali:</div><div class='detail-value'>" . htmlspecialchars($ortuRow['nik_wali']) . "</div></div>";
                            echo "<div class='detail-row'><div class='detail-label'>Nama Wali:</div><div class='detail-value'>" . htmlspecialchars($ortuRow['nama_wali']) . "</div></div>";
                            echo "<div class='detail-row'><div class='detail-label'>Pendidikan Wali:</div><div class='detail-value'>" . htmlspecialchars($ortuRow['pendidikan_wali']) . "</div></div>";
                            echo "<div class='detail-row'><div class='detail-label'>Pekerjaan Wali:</div><div class='detail-value'>" . htmlspecialchars($ortuRow['pekerjaan_wali']) . "</div></div>";
                            echo "<div class='detail-row'><div class='detail-label'>Penghasilan Wali:</div><div class='detail-value'>" . htmlspecialchars($ortuRow['penghasilan_wali']) . "</div></div>";
                            echo "<div class='detail-row'><div class='detail-label'>No. Telp. Wali:</div><div class='detail-value'>" . htmlspecialchars($ortuRow['no_telp_wali']) . "</div></div>";
                        } else {
                            echo "<p>Data orang tua/wali belum tersedia.</p>";
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
                            echo "<div class='detail-row'><div class='detail-label'>NPSN:</div><div class='detail-value'>" . htmlspecialchars($asalSekolahRow['npsn']) . "</div></div>";
                            echo "<div class='detail-row'><div class='detail-label'>Nama Sekolah:</div><div class='detail-value'>" . htmlspecialchars($asalSekolahRow['nama_sekolah']) . "</div></div>";
                        } else {
                            echo "<p>Data asal sekolah belum tersedia.</p>";
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
                            // Pastikan 'uploads/' adalah path yang benar ke folder berkas Anda
                            echo "<div class='detail-row'><div class='detail-label'>Pas Foto:</div><div class='detail-value'><a href='uploads/" . htmlspecialchars($berkasRow['pas_foto']) . "' target='_blank'>Lihat</a></div></div>";
                            echo "<div class='detail-row'><div class='detail-label'>Ijazah Depan:</div><div class='detail-value'><a href='uploads/" . htmlspecialchars($berkasRow['ijazah_depan']) . "' target='_blank'>Lihat</a></div></div>";
                            echo "<div class='detail-row'><div class='detail-label'>Ijazah Belakang:</div><div class='detail-value'><a href='uploads/" . htmlspecialchars($berkasRow['ijazah_belakang']) . "' target='_blank'>Lihat</a></div></div>";
                        } else {
                            echo "<p>Berkas pendaftaran belum diunggah.</p>";
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
$conn->close(); // Tutup koneksi database
?>