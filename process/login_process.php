<?php
require "../config/db.php";

session_start(); // harus di paling atas sebelum output apapun

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // ambil input dengan sanitasi ringan
    $username = isset($_POST["NIM"]) ? trim($_POST["NIM"]) : "";
    $password = isset($_POST["password"]) ? $_POST["password"] : "";

    if (empty($username) || empty($password)) {
        $_SESSION['error'] = "Username atau password tidak boleh kosong.";
        header("Location: ../login.php");
        exit();
    }

    // siapkan statement — ambil password, username, dan role
    $stmt = $db->prepare("SELECT username, password, role FROM users WHERE username = ?");
    if (!$stmt) {
        error_log("Prepare failed: " . $db->error);
        echo "Terjadi kesalahan server.";
        exit;
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows === 1) {
        $row = $result->fetch_assoc();

        // verifikasi password
        if (password_verify($password, $row['password'])) {
            session_regenerate_id(true);
            $_SESSION["username"] = $row["username"];
            $_SESSION["role"] = $row["role"];

            // redirect berdasarkan role
            if ($row["role"] === "admin") {
                header("Location: ../admin/index.php");
            } else {
                header("Location: ../index.php");
            }
            exit();
        } else {
            $_SESSION['error'] = "Password salah.";
            header("Location: ../login.php");
            exit();
        }
    } else {
        $_SESSION['error'] = "Username tidak ditemukan.";
        header("Location: ../login.php");
        exit();
    }

    $stmt->close();
}
?>
