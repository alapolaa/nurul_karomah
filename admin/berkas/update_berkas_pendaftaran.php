<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $berkas_pendaftaran_id = $_POST["berkas_pendaftaran_id"];
    $pendaftar_id = $_POST["pendaftar_id"];

    $uploadDir = "uploads/";

    $pas_foto_name = (isset($_FILES["pas_foto"]["name"]) && $_FILES["pas_foto"]["name"] != "") ? $uploadDir . basename($_FILES["pas_foto"]["name"]) : "";
    $ijazah_depan_name = (isset($_FILES["ijazah_depan"]["name"]) && $_FILES["ijazah_depan"]["name"] != "") ? $uploadDir . basename($_FILES["ijazah_depan"]["name"]) : "";
    $ijazah_belakang_name = (isset($_FILES["ijazah_belakang"]["name"]) && $_FILES["ijazah_belakang"]["name"] != "") ? $uploadDir . basename($_FILES["ijazah_belakang"]["name"]) : "";

    // Move uploaded files if they exist
    if ($pas_foto_name != "") {
        move_uploaded_file($_FILES["pas_foto"]["tmp_name"], $pas_foto_name);
    }
    if ($ijazah_depan_name != "") {
        move_uploaded_file($_FILES["ijazah_depan"]["tmp_name"], $ijazah_depan_name);
    }
    if ($ijazah_belakang_name != "") {
        move_uploaded_file($_FILES["ijazah_belakang"]["tmp_name"], $ijazah_belakang_name);
    }

    // Update database
    $sql = "UPDATE berkas_pendaftaran SET pendaftar_id='$pendaftar_id'";
    if ($pas_foto_name != "") {
        $sql .= ", pas_foto='$pas_foto_name'";
    }
    if ($ijazah_depan_name != "") {
        $sql .= ", ijazah_depan='$ijazah_depan_name'";
    }
    if ($ijazah_belakang_name != "") {
        $sql .= ", ijazah_belakang='$ijazah_belakang_name'";
    }
    $sql .= " WHERE berkas_pendaftaran_id='$berkas_pendaftaran_id'";

    if ($conn->query($sql) === TRUE) {
        header("Location: index_berkas_pendaftaran.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
