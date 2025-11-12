<?php
require "../../config/db.php";
session_start();

// Pastikan hanya admin yang bisa mengakses
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
    header("Location: ../index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = trim($_POST["username"]); // NIM atau nama mahasiswa
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    if (empty($username) || empty($email) || empty($password)) {
        echo "Semua kolom wajib diisi!";
        exit();
    }

    // Cek apakah email sudah digunakan
    $check = $db->prepare("SELECT email FROM users WHERE email = ?");
    if (!$check) {
        error_log("Prepare failed: " . $db->error);
        echo "Terjadi kesalahan server.";
        exit();
    }

    $check->bind_param("s", $email);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        echo "Email sudah terdaftar!";
        $check->close();
        exit();
    }
    $check->close();

    // Hash password dengan algoritma bcrypt
    $hashed = password_hash($password, PASSWORD_DEFAULT);

    // Insert dengan role mahasiswa
    $stmt = $db->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, 'mahasiswa')");
    if (!$stmt) {
        error_log("Prepare failed: " . $db->error);
        echo "Terjadi kesalahan server.";
        exit();
    }

    $stmt->bind_param("sss", $username, $email, $hashed);

    if ($stmt->execute()) {
        echo "✅ Mahasiswa berhasil didaftarkan! <a href='register_mahasiswa.php'>Daftarkan lagi</a>";
    } else {
        echo "❌ Gagal mendaftarkan mahasiswa. Silakan coba lagi.";
    }

    $stmt->close();
}
?>
