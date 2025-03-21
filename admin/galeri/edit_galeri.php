<?php
session_start();
include '../../config/config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $admin_id = $_SESSION['admin_id'] ?? NULL;

        if ($_FILES["gambar"]["name"] != "") {
            $target_dir = "../../uploads/";
            $target_file = $target_dir . basename($_FILES["gambar"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            $check = getimagesize($_FILES["gambar"]["tmp_name"]);
            if ($check !== false) {
                $uploadOk = 1;
            } else {
                echo "<div class='alert alert-danger'>File bukan gambar.</div>";
                $uploadOk = 0;
            }

            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                echo "<div class='alert alert-danger'>Maaf, hanya file JPG, JPEG, PNG & GIF yang diizinkan.</div>";
                $uploadOk = 0;
            }

            if ($uploadOk == 0) {
                echo "<div class='alert alert-danger'>Maaf, file Anda tidak diunggah.</div>";
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

                    $stmt = $conn->prepare("UPDATE galeri SET gambar=?, admin_id=? WHERE galeri_gambar_id=?");
                    $stmt->bind_param("sii", $gambar, $admin_id, $id);

                    if ($stmt->execute()) {
                        header("Location: ../../admin/galeri/galeri.php");
                        exit();
                    } else {
                        echo "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
                    }
                    $stmt->close();
                } else {
                    echo "<div class='alert alert-danger'>Maaf, terjadi kesalahan saat mengunggah file Anda.</div>";
                }
            }
        } else {
            $gambar = $_POST['gambar_lama'];
            $stmt = $conn->prepare("UPDATE galeri SET gambar=?, admin_id=? WHERE galeri_gambar_id=?");
            $stmt->bind_param("sii", $gambar, $admin_id, $id);

            if ($stmt->execute()) {
                header("Location: ../../admin/galeri/galeri.php");
                exit();
            } else {
                echo "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
            }
            $stmt->close();
        }
    }

    $sql = "SELECT gambar FROM galeri WHERE galeri_gambar_id=$id";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $gambar = $row['gambar'];
    } else {
        echo "<div class='alert alert-danger'>Gambar tidak ditemukan.</div>";
        exit;
    }
} else {
    echo "<div class='alert alert-danger'>ID gambar tidak diberikan.</div>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <title>Edit Gambar</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .center-screen {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            /* Menghilangkan margin body */
        }
    </style>
</head>

<body>
    <div class="center-screen">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <h1>Edit Gambar</h1>
                    <img src="../../uploads/<?php echo $gambar; ?>" alt="Gambar yang ada" class="img-thumbnail" width="200"><br><br>
                    <form method="post" action="edit_galeri.php?id=<?php echo $id; ?>" enctype="multipart/form-data">
                        <div class="form-group">
                            <label>Pilih Gambar Baru:</label>
                            <input type="file" name="gambar" class="form-control-file">
                        </div>
                        <input type="hidden" name="gambar_lama" value="<?php echo $gambar; ?>">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="../../admin/galeri/galeri.php" class="btn btn-secondary">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>

<?php
$conn->close();
?>