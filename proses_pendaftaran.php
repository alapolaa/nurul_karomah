<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Proses data dari form pendaftaran
    $user_id = $_POST['user_id'];
    $nisn = $_POST['nisn'];
    $nik = $_POST['nik'];
    $nama_lengkap = $_POST['nama_lengkap'];
    // ... (Proses data lainnya dari form pendaftaran) ...

    // Simpan data pendaftaran ke database
    $sql_pendaftar = "INSERT INTO pendaftar (...) VALUES (...)";
    $conn->query($sql_pendaftar);
    $pendaftar_id = $conn->insert_id;

    // Proses data dari form orang tua/wali
    $nik_ayah = $_POST['nik_ayah'];
    $nama_ayah = $_POST['nama_ayah'];
    // ... (Proses data lainnya dari form orang tua/wali) ...

    // Simpan data orang tua/wali ke database
    $sql_orang_tua_wali = "INSERT INTO orang_tua_wali (...) VALUES (...)";
    $conn->query($sql_orang_tua_wali);

    // Proses data dari form asal sekolah
    $npsn = $_POST['npsn'];
    $nama_sekolah = $_POST['nama_sekolah'];
    // ... (Proses data lainnya dari form asal sekolah) ...

    // Simpan data asal sekolah ke database
    $sql_asal_sekolah = "INSERT INTO asal_sekolah (...) VALUES (...)";
    $conn->query($sql_asal_sekolah);

    // Proses data dari form berkas pendaftaran
    $pas_foto = $_FILES['pas_foto']['name'];
    $ijazah_depan = $_FILES['ijazah_depan']['name'];
    $ijazah_belakang = $_FILES['ijazah_belakang']['name'];
    // ... (Proses upload file dan data lainnya dari form berkas pendaftaran) ...

    // Simpan data berkas pendaftaran ke database
    $sql_berkas_pendaftaran = "INSERT INTO berkas_pendaftaran (...) VALUES (...)";
    $conn->query($sql_berkas_pendaftaran);

    echo "Pendaftaran berhasil!";
}

$conn->close();
