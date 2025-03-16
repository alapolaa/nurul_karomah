<?php
include '../../config/config.php';

$id = $_GET['id'];

$sql = "DELETE FROM mata_pelajaran WHERE mata_pelajaran_id=$id";

if ($conn->query($sql) === TRUE) {
    header("Location: ../../admin/mapel/mapel.php");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
