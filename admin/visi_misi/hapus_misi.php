<?php
include 'koneksi.php';
$id = $_GET['id'];
$conn->query("DELETE FROM misi WHERE misi_id='$id'");
header("Location: visi_misi.php");
