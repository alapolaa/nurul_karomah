<?php
include '../config/config.php';

if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $sql = "DELETE FROM admin WHERE admin_id = $id";

    if ($conn->query($sql) === TRUE) {
        echo "Data admin berhasil dihapus";
        header("Location: ../admin/kelola_admin.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
