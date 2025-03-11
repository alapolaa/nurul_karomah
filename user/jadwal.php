<!DOCTYPE html>
<html>

<head>
    <title>Halaman Jadwal Pendaftaran</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>

    <div id="jadwal">
        <h2>Selamat datang, User</h2>
        <p>Ini adalah halaman Jadwal Pendaftaran.</p>
        <?php
        include '../config/koneksi.php';

        $sql = "SELECT * FROM jadwal_pendaftaran";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<table>";
            echo "<tr><th>ID</th><th>Jenjang</th><th>Tanggal Mulai</th><th>Tanggal Selesai</th><th>Daya Tampung</th><th>Tahun Ajaran</th><th>Status</th></tr>";
            while ($row = $result->fetch_assoc()) {
                $tanggal_selesai = strtotime($row["tanggal_selesai"]);
                $tanggal_sekarang = time();
                $status = ($tanggal_sekarang <= $tanggal_selesai) ? "<a href='../daftar.php'>Daftar</a>" : "Tutup";

                echo "<tr>
                        <td>" . $row["jadwal_pendaftaran_id"] . "</td>
                        <td>" . $row["jenjang"] . "</td>
                        <td>" . $row["tanggal_mulai"] . "</td>
                        <td>" . $row["tanggal_selesai"] . "</td>
                        <td>" . $row["jumlah_siswa"] . "</td>
                        <td>" . $row["tahun_ajaran"] . "</td>
                        <td>" . $status . "</td>
                      </tr>";
            }
            echo "</table>";
        } else {
            echo "0 hasil";
        }
        $conn->close();
        ?>
    </div>

</body>

</html>