<?php
include 'koneksi.php';
$id = $_GET['id'];
$conn->query("DELETE FROM visi WHERE visi_id='$id'");
header("Location: visi_misi.php");
