<?php
include '../../config/config.php';

$id = $_GET['id'];
$conn->query("DELETE FROM sejarah WHERE sejarah_id = $id");

header("Location: ../../admin/sejarah/sejarah.php");
