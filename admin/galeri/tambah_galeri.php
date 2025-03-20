<?php
session_start(); // Pastikan sesi dimulai
include '../../config/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $admin_id = $_SESSION['admin_id'] ?? NULL; // Ambil admin_id dari sesi

    $target_dir = "../../uploads/";
    $target_file = $target_dir . basename($_FILES["gambar"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    $check = getimagesize($_FILES["gambar"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File bukan gambar.";
        $uploadOk = 0;
    }

    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Maaf, hanya file JPG, JPEG, PNG & GIF yang diizinkan.";
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        echo "Maaf, file Anda tidak diunggah.";
    } else {
        if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
            $gambar = basename($_FILES["gambar"]["name"]);

            // Gunakan prepared statements untuk mencegah SQL injection
            $stmt = $conn->prepare("INSERT INTO galeri (gambar, admin_id) VALUES (?, ?)");
            $stmt->bind_param("si", $gambar, $admin_id); // "si" berarti string, integer

            if ($stmt->execute()) {
                header("Location: ../../admin/galeri/galeri.php");
                exit();
            } else {
                echo "Error: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "Maaf, terjadi kesalahan saat mengunggah file Anda.";
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Tambah Gambar</title>
</head>

<body>
    <h1>Tambah Gambar</h1>
    <form method="post" action="../../admin/galeri/tambah_galeri.php" enctype="multipart/form-data">
        <label>Pilih Gambar:</label><br>
        <input type="file" name="gambar"><br><br>
        <input type="submit" value="Simpan">
    </form>
</body>

</html>

<?php
$conn->close();
?>