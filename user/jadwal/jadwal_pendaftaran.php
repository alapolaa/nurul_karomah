<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include '../../config/config.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

function getStatusPendaftaran($tanggal_selesai)
{
    $tanggal_sekarang = date("Y-m-d");
    if ($tanggal_sekarang <= $tanggal_selesai) {
        return "Buka";
    } else {
        return "Tutup";
    }
}

function updateJadwalPendaftaran($conn, $jadwal_id)
{
    $jumlah_pendaftar_sql = "SELECT COUNT(*) as total FROM pendaftar WHERE jadwal_pendaftaran_id = $jadwal_id";
    $jumlah_diterima_sql = "SELECT COUNT(*) as total FROM pendaftar WHERE jadwal_pendaftaran_id = $jadwal_id AND status = 'Diterima'";
    $jumlah_ditolak_sql = "SELECT COUNT(*) as total FROM pendaftar WHERE jadwal_pendaftaran_id = $jadwal_id AND status = 'Ditolak'";

    $jumlah_pendaftar_result = $conn->query($jumlah_pendaftar_sql);
    $jumlah_diterima_result = $conn->query($jumlah_diterima_sql);
    $jumlah_ditolak_result = $conn->query($jumlah_ditolak_sql);

    $jumlah_pendaftar = $jumlah_pendaftar_result->fetch_assoc()['total'];
    $jumlah_diterima = $jumlah_diterima_result->fetch_assoc()['total'];
    $jumlah_ditolak = $jumlah_ditolak_result->fetch_assoc()['total'];

    $update_sql = "UPDATE jadwal_pendaftaran SET jumlah_pendaftar = $jumlah_pendaftar, jumlah_diterima = $jumlah_diterima, jumlah_ditolak = $jumlah_ditolak WHERE jadwal_pendaftaran_id = $jadwal_id";
    $conn->query($update_sql);
}

$sql = "SELECT * FROM jadwal_pendaftaran";
$result = $conn->query($sql);

if (!$result) {
    die("Query gagal: " . $conn->error);
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Jadwal Pendaftaran</title>
</head>

<body>
    <h2>Daftar Jadwal Pendaftaran</h2>
    <a href="../../user/index.php">lihat</a>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Jenjang</th>
                <th>Tanggal Mulai</th>
                <th>Tanggal Selesai</th>
                <th>Tahun Ajaran</th>
                <th>Jumlah Pendaftar</th>
                <th>Jumlah Diterima</th>
                <th>Jumlah Ditolak</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $status = getStatusPendaftaran($row["tanggal_selesai"]);
                    $jadwal_id = $row["jadwal_pendaftaran_id"];

                    updateJadwalPendaftaran($conn, $jadwal_id); // Panggil fungsi update

                    // Query untuk menghitung jumlah pendaftar, diterima, dan ditolak
                    $jumlah_pendaftar_sql = "SELECT COUNT(*) as total FROM pendaftar WHERE jadwal_pendaftaran_id = $jadwal_id";
                    $jumlah_diterima_sql = "SELECT COUNT(*) as total FROM pendaftar WHERE jadwal_pendaftaran_id = $jadwal_id AND status = 'Diterima'";
                    $jumlah_ditolak_sql = "SELECT COUNT(*) as total FROM pendaftar WHERE jadwal_pendaftaran_id = $jadwal_id AND status = 'Ditolak'";

                    $jumlah_pendaftar_result = $conn->query($jumlah_pendaftar_sql);
                    $jumlah_diterima_result = $conn->query($jumlah_diterima_sql);
                    $jumlah_ditolak_result = $conn->query($jumlah_ditolak_sql);

                    $jumlah_pendaftar = $jumlah_pendaftar_result->fetch_assoc()['total'];
                    $jumlah_diterima = $jumlah_diterima_result->fetch_assoc()['total'];
                    $jumlah_ditolak = $jumlah_ditolak_result->fetch_assoc()['total'];

                    echo "<tr>";
                    echo "<td>" . $row["jadwal_pendaftaran_id"] . "</td>";
                    echo "<td>" . $row["jenjang"] . "</td>";
                    echo "<td>" . $row["tanggal_mulai"] . "</td>";
                    echo "<td>" . $row["tanggal_selesai"] . "</td>";
                    echo "<td>" . $row["tahun_ajaran"] . "</td>";
                    echo "<td>" . $jumlah_pendaftar . "</td>";
                    echo "<td>" . $jumlah_diterima . "</td>";
                    echo "<td>" . $jumlah_ditolak . "</td>";
                    echo "<td>";
                    if ($status == "Buka") {
                        if (isset($_SESSION['user_id'])) {
                            echo "<a href='../../user/pendaftaran/pendaftaran.php?jadwal_id=" . $row["jadwal_pendaftaran_id"] . "'>" . $status . "</a>";
                        } else {
                            echo $status;
                        }
                    } else {
                        echo $status;
                    }
                    echo "</td>";
                    echo "<td>";
                    echo "<a href='edit_jadwal_pendaftaran.php?id=" . $row["jadwal_pendaftaran_id"] . "'>Edit</a> | <a href='delete_jadwal_pendaftaran.php?id=" . $row["jadwal_pendaftaran_id"] . "'>Delete</a>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='10'>No records found</td></tr>";
            }
            ?>
        </tbody>
    </table>

</body>

</html>

<?php $conn->close(); ?>