<?php
include '../../config/config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM galeri WHERE galeri_gambar_id=$id";

    if ($conn->query($sql) === TRUE) {
        header("Location: ../../admin/galeri/galeri.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo "ID gambar tidak diberikan.";
}

$conn->close();
