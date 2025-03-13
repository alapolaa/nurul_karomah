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


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $jenjang = $_POST["jenjang"];
    $tanggal_mulai = $_POST["tanggal_mulai"];
    $tanggal_selesai = $_POST["tanggal_selesai"];
    $jumlah_siswa = $_POST["jumlah_siswa"];

    $sql = "INSERT INTO jadwal_pendaftaran (jenjang, tanggal_mulai, tanggal_selesai, jumlah_siswa) VALUES ('$jenjang', '$tanggal_mulai', '$tanggal_selesai', '$jumlah_siswa')";

    if ($conn->query($sql) === TRUE) {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
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
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Jenjang</th>
                <th>Tanggal Mulai</th>
                <th>Tanggal Selesai</th>
                <th>Jumlah Siswa</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $status = getStatusPendaftaran($row["tanggal_selesai"]);
                    echo "<tr>";
                    echo "<td>" . $row["jadwal_pendaftaran_id"] . "</td>";
                    echo "<td>" . $row["jenjang"] . "</td>";
                    echo "<td>" . $row["tanggal_mulai"] . "</td>";
                    echo "<td>" . $row["tanggal_selesai"] . "</td>";
                    echo "<td>" . $row["jumlah_siswa"] . "</td>";
                    echo "<td>";
                    if ($status == "Buka") {

                        if (isset($_SESSION['user_id'])) {
                            echo "<a href='../../user/pendaftaran/pendaftaran.php?id=" . $row["jadwal_pendaftaran_id"] . "'>" . $status . "</a>";
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
                echo "<tr><td colspan='7'>No records found</td></tr>";
            }
            ?>
        </tbody>
    </table>

</body>

</html>

<?php $conn->close(); ?>