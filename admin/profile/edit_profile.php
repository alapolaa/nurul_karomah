<?php
session_start();
include '../../config/config.php';

// Cek login dan ambil data admin seperti di profile.php

// Handle form submission untuk update data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $email = $_POST['email'];

    $stmt = $conn->prepare("UPDATE admin SET nama = ?, email = ? WHERE admin_id = ?");
    $stmt->bind_param("ssi", $nama, $email, $admin_id);
    $stmt->execute();

    header("Location: ../../admin/profile/profile.php"); // Redirect kembali ke profil setelah update
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2>Edit Profil Admin</h2>
        <form method="POST" action="edit_profile.php">
            <div class="mb-3">
                <label for="nama" class="form-label">Nama:</label>
                <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $admin['nama']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $admin['email']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="profile.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>