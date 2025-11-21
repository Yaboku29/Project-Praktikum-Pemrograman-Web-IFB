<?php
require "../../config/db.php";
session_start();

// Pastikan hanya admin yang bisa mengakses
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
    header("Location: ../index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = trim($_POST["username"]);
    $nama = trim($_POST["nama"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];


    if (empty($username) || empty($nama) || empty($email) || empty($password)) {
        $_SESSION['error'] = "Semua Kolom Harus Diisi!";
        header("Location: ../register.php");
        exit();
    }

    if (strlen($password) < 6) {
     $_SESSION['error'] = "Password harus terdiri dari minimal 6 karakter.";
        header("Location: ../register.php");
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
    $stmt = $db->prepare("INSERT INTO users (username, nama, email, password, role) VALUES (?, ?, ?, ?, 'mahasiswa')");    
    if (!$stmt) {
        error_log("Prepare failed: " . $db->error);
        echo "Terjadi kesalahan server.";
        exit();
    }

    $stmt->bind_param("ssss", $username, $nama, $email, $hashed);
  

if ($stmt->execute()) {
    header("Location: ../register.php?status=success");
    exit();
} else {
    header("Location: ../register.php?status=failed");
    exit();
}

    $stmt->close();
}
?>
