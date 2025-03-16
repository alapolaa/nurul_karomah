<?php
include '../../config/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $admin_id = $_POST['admin_id'];


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
            $sql = "INSERT INTO galeri (gambar, admin_id) VALUES ('$gambar', $admin_id)";

            if ($conn->query($sql) === TRUE) {
                header("Location: ../../admin/galeri/galeri.php");
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
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
        <label>Admin ID:</label><br>
        <input type="number" name="admin_id"><br><br>
        <input type="submit" value="Simpan">
    </form>
</body>

</html>

<?php
$conn->close();
?>