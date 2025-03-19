<?php
include '../../koneksi.php';

if (isset($_POST['province_id'])) {
    $province_id = $_POST['province_id'];
    $sql = "SELECT id, name FROM regencies WHERE province_id = '$province_id'";
    $result = $conn->query($sql);

    $options = '<option value="">Pilih Kabupaten</option>';
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $options .= '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
        }
    }
    echo $options;
}
$conn->close();
