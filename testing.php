<?php
session_start();
include 'config/config.php';

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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <meta charset="UTF-8">
    <title>Grafik Pendaftar</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <link href="img/favicon.ico" rel="icon">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Handlee&family=Nunito&display=swap" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <link href="lib/flaticon/font/flaticon.css" rel="stylesheet">

    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/lightbox/css/lightbox.min.css" rel="stylesheet">

    <link href="css/style.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

    <div class="container-fluid bg-light position-relative shadow">
        <nav class="navbar navbar-expand-lg bg-light navbar-light py-3 py-lg-0 px-0 px-lg-5">
            <a href="" class="navbar-brand font-weight-bold text-secondary"
                style="font-size: 50px; display: inline-flex; align-items: center;">
                <img src="img/nurul.png" alt="Logo" style="height: 60px; margin-right: 10px;">
                <span class="text-primary">Nurul Karomah</span>
            </a>
            <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                <div class="navbar-nav font-weight-bold mx-auto py-0">
                    <a href="index.php" class="nav-item nav-link">Home</a>
                    <a href="home.php" class="nav-item nav-link active">Grafik Pendaftaran</a>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Akademik</a>
                        <div class="dropdown-menu rounded-0 m-0">
                            <a href="jadwal.php" class="dropdown-item">Jadwal Pendaftaran</a>
                            <a href="mapel.php" class="dropdown-item">Mata Pelajaran</a>
                            <a href="guru.php" class="dropdown-item">Guru</a>
                        </div>
                    </div>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Informasi</a>
                        <div class="dropdown-menu rounded-0 m-0">
                            <a href="kegiatan.php" class="dropdown-item">Kegiatan</a>
                            <a href="prestasi.php" class="dropdown-item">Prestasi</a>
                        </div>
                    </div>
                    <a href="kontak.php" class="nav-item nav-link">Kontak</a>
                </div>
                <a href="auth/login.php" class="btn btn-primary px-4">Login</a>
            </div>
        </nav>
    </div>

    <div class="container-fluid bg-primary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 200px">
            <h1 class="text-white">Statistik Pendaftaran</h1>
        </div>
    </div>

    <div class="container mb-5">
        <h3 class="text-center mb-4">Grafik Tahun Aktif</h3>
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
        <hr class="my-5">
    </div>

    <div class="container mb-5">
        <h3 class="text-center mb-4">Grafik Pendaftaran 3 Tahun Terakhir</h3>
        <div class="text-center mb-4" style="max-width: 700px; margin: 0 auto;">
            <canvas id="barChartGrouped" style="max-height: 300px;"></canvas>
        </div>
    </div>

    <?php include 'footer.html'; ?>

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
    <a href="#" class="btn btn-primary p-3 back-to-top"><i class="fa fa-angle-double-up"></i></a>


    <!-- JavaScript Libraries -->
    <script>
        const galleryImages = document.querySelectorAll('.gallery-image');
        const fullscreenOverlay = document.getElementById('fullscreen-overlay');
        const fullscreenImage = document.getElementById('fullscreen-image');
        const closeFullscreen = document.getElementById('close-fullscreen');
        const imageDetails = document.getElementById('image-details');

        galleryImages.forEach(image => {
            image.addEventListener('click', () => {
                const imageName = image.getAttribute('data-gambar');
                fullscreenImage.src = 'uploads/' + imageName;
                imageDetails.textContent = imageName;
                fullscreenOverlay.style.display = 'block';
            });
        });

        closeFullscreen.addEventListener('click', () => {
            fullscreenOverlay.style.display = 'none';
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/isotope/isotope.pkgd.min.js"></script>
    <script src="lib/lightbox/js/lightbox.min.js"></script>

    <!-- Contact Javascript File -->
    <script src="mail/jqBootstrapValidation.min.js"></script>
    <script src="mail/contact.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>

</body>

</html>