<?php
include 'config.php';

if (isset($_GET['id'])) {
    $pendaftar_id = $_GET['id'];
    $sql = "UPDATE pendaftar SET status = 'Ditolak' WHERE pendaftar_id = '$pendaftar_id'";
    if ($conn->query($sql) === TRUE) {
        header("Location: admin.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
