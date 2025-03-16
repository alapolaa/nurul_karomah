<?php
include '../../config/config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $admin_id = $_POST['admin_id'];


        if ($_FILES["gambar"]["name"] != "") {
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


                    $sql_old_file = "SELECT gambar FROM galeri WHERE galeri_gambar_id=$id";
                    $result_old_file = $conn->query($sql_old_file);
                    if ($result_old_file->num_rows == 1) {
                        $row_old_file = $result_old_file->fetch_assoc();
                        $old_file = $row_old_file['gambar'];
                        if (file_exists("../../uploads/" . $old_file)) {
                            unlink("../../uploads/" . $old_file);
                        }
                    }

                    $sql = "UPDATE galeri SET gambar='$gambar', admin_id=$admin_id WHERE galeri_gambar_id=$id";

                    if ($conn->query($sql) === TRUE) {
                        header("Location: ../../admin/galeri/galeri.php");
                    } else {
                        echo "Error: " . $sql . "<br>" . $conn->error;
                    }
                } else {
                    echo "Maaf, terjadi kesalahan saat mengunggah file Anda.";
                }
            }
        } else {
            $gambar = $_POST['gambar_lama'];
            $sql = "UPDATE galeri SET gambar='$gambar', admin_id=$admin_id WHERE galeri_gambar_id=$id";

            if ($conn->query($sql) === TRUE) {
                header("Location: ../../admin/galeri/galeri.php");
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }

    $sql = "SELECT gambar, admin_id FROM galeri WHERE galeri_gambar_id=$id";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $gambar = $row['gambar'];
        $admin_id = $row['admin_id'];
    } else {
        echo "Gambar tidak ditemukan.";
        exit;
    }
} else {
    echo "ID gambar tidak diberikan.";
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Gambar</title>
</head>

<body>
    <h1>Edit Gambar</h1>
    <img src="../../uploads/<?php echo $gambar; ?>" alt="Gambar yang ada" width="200"><br><br>
    <form method="post" action="edit_galeri.php?id=<?php echo $id; ?>" enctype="multipart/form-data">
        <label>Pilih Gambar Baru:</label><br>
        <input type="file" name="gambar"><br><br>
        <input type="hidden" name="gambar_lama" value="<?php echo $gambar; ?>">
        <label>Admin ID:</label><br>
        <input type="number" name="admin_id" value="<?php echo $admin_id; ?>"><br><br>
        <input type="submit" value="Simpan">
    </form>
</body>

</html>

<?php
$conn->close();
?>