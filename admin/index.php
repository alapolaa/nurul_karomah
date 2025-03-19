<?php
session_start();
if (!isset($_SESSION['admin_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

include '../config/config.php'; // Sesuaikan dengan path config.php Anda

// Ambil data pendaftaran yang statusnya 'Pending'
$sql = "SELECT p.*, u.username AS nama_user FROM pendaftar p JOIN users u ON p.user_id = u.user_id WHERE p.status = 'Pending'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Admin</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        .hidden {
            display: none;
        }
    </style>
</head>

<body>
    <h2>Selamat datang, Admin <?php echo $_SESSION['nama']; ?>!</h2>
    <a href="logout.php">Logout</a>

    <h3>Data Pendaftaran Pending</h3>
    <table>
        <thead>
            <tr>
                <th>Nama Pendaftar</th>
                <th>NISN</th>
                <th>NIK</th>
                <th>Jenis Kelamin</th>
                <th>Tempat Lahir</th>
                <th>Tanggal Lahir</th>
                <th>Alamat</th>
                <th>Agama</th>
                <th>No. Telp</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr id='row_" . $row['pendaftar_id'] . "'>";
                    echo "<td>" . $row['nama_user'] . "</td>";
                    echo "<td>" . $row['nisn'] . "</td>";
                    echo "<td>" . $row['nik'] . "</td>";
                    echo "<td>" . $row['jenis_kelamin'] . "</td>";
                    echo "<td>" . $row['tempat_lahir'] . "</td>";
                    echo "<td>" . $row['tanggal_lahir'] . "</td>";
                    echo "<td>" . $row['alamat_lengkap'] . "</td>";
                    echo "<td>" . $row['agama'] . "</td>";
                    echo "<td>" . $row['no_telp'] . "</td>";
                    echo "<td>
                            <button onclick='terimaPendaftaran(" . $row['pendaftar_id'] . ")'>Terima</button>
                            <button onclick='tolakPendaftaran(" . $row['pendaftar_id'] . ")'>Tolak</button>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='10'>Tidak ada data pendaftaran pending.</td></tr>";
            }
            $conn->close();
            ?>
        </tbody>
    </table>

    <script>
        function terimaPendaftaran(pendaftarId) {
            updateStatus(pendaftarId, 'Diterima');
        }

        function tolakPendaftaran(pendaftarId) {
            updateStatus(pendaftarId, 'Ditolak');
        }

        function updateStatus(pendaftarId, status) {
            fetch('update_status.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'pendaftar_id=' + pendaftarId + '&status=' + status,
                })
                .then(response => {
                    if (response.ok) {
                        document.getElementById('row_' + pendaftarId).classList.add('hidden');
                    } else {
                        alert('Gagal memperbarui status.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan.');
                });
        }
    </script>
</body>

</html>