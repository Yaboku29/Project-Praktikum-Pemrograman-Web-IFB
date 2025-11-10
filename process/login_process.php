<?php
require "../config/db.php";

session_start(); // harus di paling atas sebelum output apapun

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // ambil input dengan sanitasi ringan
    $email = isset($_POST["email"]) ? trim($_POST["email"]) : "";
    $password = isset($_POST["password"]) ? $_POST["password"] : "";

    if (empty($email) || empty($password)) {
        echo "Email atau password tidak boleh kosong.";
        exit;
    }

    // siapkan statement — ambil password, username, dan role
    $stmt = $db->prepare("SELECT password, username, role FROM users WHERE email = ?");
    if (!$stmt) {
        // debug ringan jika prepare gagal
        error_log("Prepare failed: " . $db->error);
        echo "Terjadi kesalahan server.";
        exit;
    }

    // perbaikan: bind_param("s", $email) bukan ("s")
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows === 1) {
        $row = $result->fetch_assoc();

        // verifikasi password
        if (password_verify($password, $row['password'])) {
            // sukses login -> amankan session dan simpan info penting
            session_regenerate_id(true);
            $_SESSION["username"] = $row["username"];
            $_SESSION["email"] = $email;
            $_SESSION["role"] = $row["role"];

            // redirect berdasarkan role
            if ($row["role"] === "admin") {
                header("Location: ../admin/index.php");
                exit();
            } else {
                header("Location: ../index.php");
                exit();
            }
        } else {
            echo "Password salah.";
        }
    } else {
        echo "Akun dengan email tersebut tidak ditemukan.";
    }

    $stmt->close();
}
