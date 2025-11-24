<?php
include "../../config/db.php";

$idUser = $_GET['idUser'];

$sql = "SELECT kd.id_krs_detail, k.nama_kelas 
        FROM krs_details kd
        JOIN krs ON kd.id_krs = krs.idKRS
        JOIN kelas k ON kd.id_kelas = k.id
        WHERE krs.idUser = $idUser";

$query = mysqli_query($db, $sql);

$data = [];
while ($row = mysqli_fetch_assoc($query)) {
    $data[] = $row;
}

echo json_encode($data);
?>
