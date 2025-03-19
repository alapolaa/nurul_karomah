<?php
function getProvinces($conn)
{
    $sql = "SELECT id, name FROM provinces"; // Mengambil semua provinsi
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

function getRegencies($conn, $province_id)
{
    $sql = "SELECT id, name FROM regencies WHERE province_id = '$province_id'";
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

function getDistricts($conn, $regency_id)
{
    $sql = "SELECT id, name FROM districts WHERE regency_id = '$regency_id'";
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

function getVillages($conn, $district_id)
{
    $sql = "SELECT id, name FROM villages WHERE district_id = '$district_id'";
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}
