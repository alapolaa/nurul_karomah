<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            display: flex;
        }

        #sidebar {
            min-width: 250px;
            max-width: 250px;
            min-height: 100vh;
            background-color: #343a40;
            color: white;
            padding-top: 20px;
        }

        #sidebar a {
            color: white;
            text-decoration: none;
            padding: 10px;
            display: block;
        }

        #sidebar a:hover {
            background-color: #495057;
        }

        #content {
            flex-grow: 1;
            padding: 20px;
        }

        #sidebar a.active {
            background-color: #495057;
        }
    </style>
</head>

<body>
    <nav id="sidebar">
        <h4 class="text-center">Menu</h4>
        <a href="#" id="menu-dashboard">Dashboard</a>
        <a href="#" id="menu-jadwal">Jadwal Pendaftaran</a>
        <a href="#" id="menu-guru">Guru</a>
        <a href="#" id="menu-mapel">Mata Pelajaran</a>
        <a href="#" id="menu-kegiatan">Kegiatan</a>
        <a href="#" id="menu-prestasi">Prestasi</a>
        <a href="../auth/logout.php" class="btn btn-danger w-100 mt-3">Logout</a>
    </nav>


    <div id="content">
        <?php include 'dashboard.php'; ?>
        <?php include 'jadwal.php'; ?>
        <?php include 'guru.php'; ?>
        <?php include 'mapel.php'; ?>
        <?php include 'kegiatan.php'; ?>
        <?php include 'prestasi.php'; ?>
    </div>

    <script>
        document.querySelectorAll('#content > *').forEach(page => page.style.display = 'none');
        document.getElementById('dashboard').style.display = 'block';
        document.getElementById('menu-dashboard').classList.add('active');

        document.querySelectorAll('#sidebar a[id^="menu-"]').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                document.querySelectorAll('#content > *').forEach(page => page.style.display = 'none');
                document.getElementById(this.id.replace('menu-', '')).style.display = 'block';
                document.querySelectorAll('#sidebar a[id^="menu-"]').forEach(a => a.classList.remove('active'));
                this.classList.add('active');
            });
        });
    </script>
</body>

</html>