<?php
include 'koneksi.php';

if (isset($_POST['district_id'])) {
    $district_id = $_POST['district_id'];
    $sql = "SELECT id, name FROM villages WHERE district_id = '$district_id'";
    $result = $conn->query($sql);

    $options = '<option value="">Pilih Desa</option>';
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $options .= '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
        }
    }
    echo $options;
}
$conn->close();
