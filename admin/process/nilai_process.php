<?php
session_start();
include "../../config/db.php";
;

$nilai = $_POST['nilai'];
$bobot = $_POST['bobot'];
$jenis = $_POST['jenis'];
$id_krs_detail = $_POST['id_krs_detail'];

$sql = "INSERT INTO penilaian (nilai, bobot, jenis, id_krs_detail)
        VALUES ('$nilai', '$bobot', '$jenis', '$id_krs_detail')";

if (mysqli_query($db, $sql)) {
    header("Location: ../inputNilai.php?status=success");
} else {
    header("Location: ../inputNilai.php?status=failed");
}
?>
