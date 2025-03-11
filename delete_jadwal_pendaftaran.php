<?php
include 'config.php';

$jadwal_pendaftaran_id = $_GET["id"];
$sql = "DELETE FROM jadwal_pendaftaran WHERE jadwal_pendaftaran_id = '$jadwal_pendaftaran_id'";

if ($conn->query($sql) === TRUE) {
    header("Location: index_jadwal_pendaftaran.php");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
