<?php
// Koneksi Database
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "coba";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Pencarian dan Filter
$cari = isset($_GET['cari']) ? $_GET['cari'] : '';
$tahun = isset($_GET['tahun']) ? $_GET['tahun'] : '';
$jenjang = 'MI';

$sql = "SELECT 
            p.nama_lengkap, 
            p.tempat_lahir, 
            p.tanggal_lahir, 
            p.nik, 
            p.alamat_lengkap, 
            p.nisn, 
            a.nama_sekolah
        FROM 
            pendaftar p
        JOIN 
            jadwal_pendaftaran j ON p.jadwal_pendaftaran_id = j.jadwal_pendaftaran_id
        LEFT JOIN 
            asal_sekolah a ON p.asal_sekolah_id = a.asal_sekolah_id
        WHERE 
            j.jenjang = '$jenjang'";

if (!empty($cari)) {
    $sql .= " AND (p.nama_lengkap LIKE '%$cari%' OR p.nisn LIKE '%$cari%')";
}

if (!empty($tahun)) {
    $sql .= " AND j.tahun_ajaran = '$tahun'";
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Data Pendaftar MI</title>
</head>

<body>
    <h2>Data Pendaftar MI</h2>

    <form method="GET">
        <input type="text" name="cari" placeholder="Cari nama atau NISN" value="<?php echo $cari; ?>">
        <select name="tahun">
            <option value="">Semua Tahun</option>
            <?php
            $tahun_sql = "SELECT DISTINCT j.tahun_ajaran FROM jadwal_pendaftaran j";
            $tahun_result = $conn->query($tahun_sql);
            if ($tahun_result->num_rows > 0) {
                while ($tahun_row = $tahun_result->fetch_assoc()) {
                    $selected = ($tahun == $tahun_row["tahun_ajaran"]) ? "selected" : "";
                    echo "<option value='" . $tahun_row["tahun_ajaran"] . "' " . $selected . ">" . $tahun_row["tahun_ajaran"] . "</option>";
                }
            }
            ?>
        </select>
        <button type="submit">Filter</button>
    </form>

    <form method="POST" action="export_pdf.php?jenjang=MI">
        <button type="submit">Ekspor PDF</button>
    </form>

    <table border="1">
        <tr>
            <th>No.</th>
            <th>Nama Lengkap</th>
            <th>Tempat, Tanggal Lahir</th>
            <th>NIK</th>
            <th>Alamat</th>
            <th>NISN</th>
            <th>Asal Sekolah</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            $nomor = 1;
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $nomor . "</td>";
                echo "<td>" . $row["nama_lengkap"] . "</td>";
                echo "<td>" . $row["tempat_lahir"] . ", " . $row["tanggal_lahir"] . "</td>";
                echo "<td>" . $row["nik"] . "</td>";
                echo "<td>" . $row["alamat_lengkap"] . "</td>";
                echo "<td>" . $row["nisn"] . "</td>";
                echo "<td>" . $row["nama_sekolah"] . "</td>";
                echo "</tr>";
                $nomor++;
            }
        } else {
            echo "<tr><td colspan='7'>Tidak ada data pendaftar untuk jenjang MI.</td></tr>";
        }
        ?>
    </table>
</body>

</html>

<?php
$conn->close();
?>