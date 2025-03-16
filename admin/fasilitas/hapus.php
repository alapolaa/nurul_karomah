<?php
include '../../config/config.php';

$id = $_GET['id'];
$sql = "DELETE FROM fasilitas WHERE fasilitas_id=$id";

if ($conn->query($sql) === TRUE) {
    header("Location: ../../admin/fasilitas/fasilitas.php");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
