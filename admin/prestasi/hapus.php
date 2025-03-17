<?php
include '../../config/config.php';
$id = $_GET['id'];

$conn->query("DELETE FROM prestasi_lembaga WHERE prestasi_lembaga_id = $id");
header("Location: ../../admin/prestasi/prestasi.php");
exit();
