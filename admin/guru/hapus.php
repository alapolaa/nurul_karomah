<?php
include '../../koneksi.php';
$id = $_GET['id'];

$conn->query("DELETE FROM guru WHERE guru_id=$id");
header("Location: ../../admin/guru/guru.php");
