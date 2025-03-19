<?php
include '../../koneksi.php';

if (isset($_POST['regency_id'])) {
    $regency_id = $_POST['regency_id'];
    $sql = "SELECT id, name FROM districts WHERE regency_id = '$regency_id'";
    $result = $conn->query($sql);

    $options = '<option value="">Pilih Kecamatan</option>';
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $options .= '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
        }
    }
    echo $options;
}
$conn->close();
