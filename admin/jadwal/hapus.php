<?php
include '../../config/config.php';


$id = $_GET['id'];
$sql = "DELETE FROM jadwal_pendaftaran WHERE jadwal_pendaftaran_id = $id";

if ($conn->query($sql) === TRUE) {
    header("Location: ../../admin/jadwal/jadwal.php");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
