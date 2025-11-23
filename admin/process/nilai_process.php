<?php
require "../../config/db.php";
session_start();
 

// Pastikan admin saja yang bisa akses
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit();
}

// Ambil data POST
$mataKuliah = $_POST['mataKuliah'] ?? '';
$nilai      = $_POST['nilai'] ?? '';
$bobot      = $_POST['bobot'] ?? '';
$jenis      = $_POST['jenis'] ?? '';
$idUser     = $_POST['idUser'] ?? '';


// Validasi minimal
if (empty($mataKuliah) || empty($nilai) || empty($bobot) || empty($jenis) || empty($idUser)) {
    $_SESSION['error'] = "Semua field wajib diisi!";
    header("Location: ../index.php?status=failed");
    exit();
}

// Cek apakah idUser valid
$cekUser = mysqli_query($db, "SELECT * FROM users WHERE idUser='$idUser' AND role='mahasiswa'");
if (mysqli_num_rows($cekUser) == 0) {
    $_SESSION['error'] = "ID Mahasiswa tidak ditemukan!";
    header("Location: ../index.php?status=failed");
    exit();
}

// Insert ke penilaian
$query = "INSERT INTO penilaian (nilai, bobot, jenis, mataKuliah, idUser)
          VALUES ('$nilai', '$bobot', '$jenis', '$mataKuliah', '$idUser')";

if (mysqli_query($db, $query)) {
    header("Location: ../inputnilai.php?status=success");
} else {
    $_SESSION['error'] = "Terjadi kesalahan di database: " . mysqli_error($db);
    header("Location: ../inputnilai.php?status=failed");
}

exit();
