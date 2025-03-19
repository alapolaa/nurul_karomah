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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
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
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $status = getStatusPendaftaran($row["tanggal_selesai"]);
                    $jadwal_id = $row["jadwal_pendaftaran_id"];

                    updateJadwalPendaftaran($conn, $jadwal_id);
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

                    echo "<td>";
                    if ($status == "Buka") {
                        $user_id = $_SESSION['user_id'];
                        $cek_pendaftaran_sql = "SELECT COUNT(*) as total FROM pendaftar WHERE user_id = $user_id AND jadwal_pendaftaran_id = $jadwal_id";
                        $cek_pendaftaran_result = $conn->query($cek_pendaftaran_sql);
                        $cek_pendaftaran = $cek_pendaftaran_result->fetch_assoc()['total'];
                        $cek_pendaftaran_lain_sql = "SELECT COUNT(*) as total FROM pendaftar WHERE user_id = $user_id";
                        $cek_pendaftaran_lain_result = $conn->query($cek_pendaftaran_lain_sql);
                        $cek_pendaftaran_lain = $cek_pendaftaran_lain_result->fetch_assoc()['total'];

                        if ($cek_pendaftaran == 0 && $cek_pendaftaran_lain == 0) {

                            echo "<a href='../../daftar.php?jadwal_id=" . $row["jadwal_pendaftaran_id"] . "'>" . $status . "</a>";
                        } else {

                            echo "<a href='#' onclick=\"showAccountUsedAlert(); return false;\">" . $status . "</a>";
                        }
                    } else {
                        echo $status;
                    }
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='10'>No records found</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <script>
        function showAccountUsedAlert() {
            Swal.fire({
                icon: 'error',
                title: 'Akun anda sudah digunakan',
                confirmButtonText: 'Tutup'
            });
        }
    </script>
</body>

</html>

<?php $conn->close(); ?>