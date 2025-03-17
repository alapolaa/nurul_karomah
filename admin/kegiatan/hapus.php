<?php
include '../../config/config.php';

$id = $_GET['id'];
$query = "DELETE FROM kegiatan_lembaga WHERE kegiatan_lembaga_id = $id";

if ($conn->query($query)) {
    header("Location: ../../admin/kegiatan/kegiatan.php");
} else {
    echo "Gagal menghapus data: " . $conn->error;
}
