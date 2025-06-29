<?php
session_start();
include '../config/config.php';

// Ambil tahun ajaran
$sqlTahun = "SELECT DISTINCT tahun_ajaran FROM jadwal_pendaftaran ORDER BY tahun_ajaran ASC";
$tahunResult = $conn->query($sqlTahun);

$tahunLabels = [];
while ($row = $tahunResult->fetch_assoc()) {
    $tahunLabels[] = $row['tahun_ajaran'];
}

// Fungsi ambil data pendaftar per jenjang per tahun
function getJumlahByJenjang($conn, $jenjang, $tahunList)
{
    $data = [];
    foreach ($tahunList as $tahun) {
        $sql = "SELECT jumlah_pendaftar FROM jadwal_pendaftaran WHERE tahun_ajaran = '$tahun' AND jenjang = '$jenjang'";
        $result = $conn->query($sql);
        $jumlah = 0;
        if ($result && $result->num_rows > 0) {
            $jumlah = (int)$result->fetch_assoc()['jumlah_pendaftar'];
        }
        $data[] = $jumlah;
    }
    return $data;
}

$dataMI = getJumlahByJenjang($conn, 'MI', $tahunLabels);
$dataMTs = getJumlahByJenjang($conn, 'MTs', $tahunLabels);
$dataMA = getJumlahByJenjang($conn, 'MA', $tahunLabels);

// Data Pie
$jenjangs = ['MI', 'MTs', 'MA'];
$dataPie = [];

foreach ($jenjangs as $jenjang) {
    $sql = "SELECT 
                SUM(jumlah_diterima) AS diterima, 
                SUM(jumlah_ditolak) AS ditolak,
                SUM(jumlah_pendaftar) AS total 
            FROM jadwal_pendaftaran 
            WHERE jenjang = '$jenjang'";
    $res = $conn->query($sql)->fetch_assoc();
    $dataPie[$jenjang] = [
        'diterima' => (int)$res['diterima'],
        'ditolak' => (int)$res['ditolak'],
        'total' => (int)$res['total']
    ];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Grafik Pendaftar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>

    <!-- Navbar -->
    <div class="container-fluid bg-light shadow">
        <nav class="navbar navbar-expand-lg bg-light navbar-light py-3 px-0 px-lg-5">
            <a href="#" class="navbar-brand font-weight-bold text-secondary" style="font-size: 50px;">
                <img src="../img/nurul.png" alt="Logo" style="height: 60px; margin-right: 10px;">
                <span class="text-primary">Nurul Karomah</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                <div class="navbar-nav font-weight-bold mx-auto">
                    <a href="../admin/dashboard.php" class="nav-item nav-link active">Home</a>
                    <a href="../admin/data_pendaftar.php" class="nav-item nav-link">Data Pendaftar</a>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Profile Lembaga</a>
                        <div class="dropdown-menu">
                            <a href="../admin/sejarah/sejarah.php" class="dropdown-item">Sejarah</a>
                            <a href="../admin/visi_misi/visi_misi.php" class="dropdown-item">Visi Misi</a>
                            <a href="../admin/fasilitas/fasilitas.php" class="dropdown-item">Fasilitas</a>
                            <a href="../admin/prestasi/prestasi.php" class="dropdown-item">Prestasi</a>
                        </div>
                    </div>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Akademik</a>
                        <div class="dropdown-menu">
                            <a href="../admin/mi/mi.php" class="dropdown-item">MI</a>
                            <a href="../admin/mts/mts.php" class="dropdown-item">MTs</a>
                            <a href="../admin/ma/ma.php" class="dropdown-item">MA</a>
                        </div>
                    </div>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Informasi</a>
                        <div class="dropdown-menu">
                            <a href="../admin/jadwal/jadwal.php" class="dropdown-item">Jadwal Pendaftaran</a>
                            <a href="../admin/mapel/mapel.php" class="dropdown-item">Mata Pelajaran</a>
                            <a href="../admin/guru/guru.php" class="dropdown-item">Guru</a>
                            <a href="../admin/kegiatan/kegiatan.php" class="dropdown-item">Kegiatan</a>
                            <a href="../admin/galeri/galeri.php" class="dropdown-item">Galeri</a>
                        </div>
                    </div>
                    <a href="../admin/kelola_admin.php" class="nav-item nav-link">Kelola Admin</a>
                    <a href="../admin/kotak_masuk/kotak_masuk.php" class="nav-item nav-link">Kotak Masuk</a>
                    <a href="../admin/profile/profile.php" class="nav-item nav-link">Profile</a>
                </div>
            </div>
        </nav>
    </div>

    <!-- Header -->
    <div class="container-fluid bg-primary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 200px">
            <h1 class="text-white">Statistik Pendaftaran</h1>
        </div>
    </div>

    <!-- Grafik Batang -->
    <div class="container mb-5">
        <h3 class="text-center mb-4">Grafik Pendaftar per Tahun Ajaran per Jenjang</h3>
        <div class="text-center mb-4" style="max-width: 700px; margin: 0 auto;">
            <canvas id="barChartGrouped" style="max-height: 300px;"></canvas>
        </div>

        <hr class="my-5">

        <h3 class="text-center mb-4">Grafik Pie</h3>
        <div class="row">
            <?php foreach ($jenjangs as $jenjang): ?>
                <div class="col-md-4 text-center">
                    <h5><?= $jenjang ?></h5>
                    <canvas id="pie<?= $jenjang ?>"></canvas>
                    <p class="mt-2">
                        Jumlah Pendaftar: <strong><?= $dataPie[$jenjang]['total'] ?></strong><br>
                        Diterima: <strong class="text-success"><?= $dataPie[$jenjang]['diterima'] ?></strong><br>
                        Ditolak: <strong class="text-danger"><?= $dataPie[$jenjang]['ditolak'] ?></strong>
                    </p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Footer -->
    <?php include '../footer.html'; ?>

    <!-- JS Grafik -->
    <script>
        const barConfig = {
            type: 'bar',
            data: {
                labels: <?= json_encode($tahunLabels) ?>,
                datasets: [{
                        label: 'MI',
                        backgroundColor: '#007bff',
                        data: <?= json_encode($dataMI) ?>
                    },
                    {
                        label: 'MTs',
                        backgroundColor: '#28a745',
                        data: <?= json_encode($dataMTs) ?>
                    },
                    {
                        label: 'MA',
                        backgroundColor: '#ffc107',
                        data: <?= json_encode($dataMA) ?>
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top'
                    },
                    title: {
                        display: true,
                        text: 'Jumlah Pendaftar per Tahun'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        };

        new Chart(document.getElementById('barChartGrouped'), barConfig);

        // Pie Chart
        const pieData = {
            <?= implode(",\n", array_map(function ($j) use ($dataPie) {
                return "'$j': { diterima: {$dataPie[$j]['diterima']}, ditolak: {$dataPie[$j]['ditolak']} }";
            }, $jenjangs)); ?>
        };

        ['MI', 'MTs', 'MA'].forEach(jenjang => {
            const ctx = document.getElementById('pie' + jenjang).getContext('2d');
            new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: ['Diterima', 'Ditolak'],
                    datasets: [{
                        data: [pieData[jenjang].diterima, pieData[jenjang].ditolak],
                        backgroundColor: ['#28a745', '#dc3545']
                    }]
                },
                options: {
                    responsive: true
                }
            });
        });
    </script>

</body>

</html>