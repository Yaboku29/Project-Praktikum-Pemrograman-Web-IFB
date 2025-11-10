<?php
require "../config/db.php";
session_start();

// Pastikan hanya admin
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
    header("Location: ../index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    // Cek apakah email sudah digunakan
    $check = $db->prepare("SELECT email FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        echo "Email sudah terdaftar!";
        exit();
    }

    // Hash password
    $hashed = password_hash($password, PASSWORD_DEFAULT);

    // Insert dengan role mahasiswa
    $stmt = $db->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, 'mahasiswa')");
    $stmt->bind_param("sss", $username, $email, $hashed);

    if ($stmt->execute()) {
        echo "Mahasiswa berhasil didaftarkan! <a href='register_mahasiswa.php'>Daftarkan lagi</a>";
    } else {
        echo "Gagal mendaftarkan mahasiswa.";
    }
}
