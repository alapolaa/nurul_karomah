<?php
include 'config.php';

$berkas_pendaftaran_id = $_GET["id"];

// Get file paths before deleting record
$sql_select = "SELECT pas_foto, ijazah_depan, ijazah_belakang FROM berkas_pendaftaran WHERE berkas_pendaftaran_id = '$berkas_pendaftaran_id'";
$result_select = $conn->query($sql_select);
$row_select = $result_select->fetch_assoc();

// Delete record from database
$sql_delete = "DELETE FROM berkas_pendaftaran WHERE berkas_pendaftaran_id = '$berkas_pendaftaran_id'";
if ($conn->query($sql_delete) === TRUE) {
    // Delete files from server
    if (file_exists($row_select['pas_foto'])) {
        unlink($row_select['pas_foto']);
    }
    if (file_exists($row_select['ijazah_depan'])) {
        unlink($row_select['ijazah_depan']);
    }
    if (file_exists($row_select['ijazah_belakang'])) {
        unlink($row_select['ijazah_belakang']);
    }

    header("Location: index_berkas_pendaftaran.php");
} else {
    echo "Error: " . $sql_delete . "<br>" . $conn->error;
}

$conn->close();
