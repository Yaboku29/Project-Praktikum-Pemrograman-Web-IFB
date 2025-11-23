<?php
// require "../../config/db.php";
// //session_start();

// // Pastikan hanya admin yang bisa mengakses
// if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
//     header("Location: ../index.php");
//     exit();
// }

// if ($_SERVER["REQUEST_METHOD"] === "POST") {

//     $username = trim($_POST["username"]);
//     $nama = trim($_POST["nama"]);
//     $email = trim($_POST["email"]);
//     $password = $_POST["password"];


//     if (empty($username) || empty($nama) || empty($email) || empty($password)) {
//         $_SESSION['error'] = "Semua Kolom Harus Diisi!";
//         header("Location: ../register.php");
//         exit();
//     }

//     if (strlen($password) < 6) {
//      $_SESSION['error'] = "Password harus terdiri dari minimal 6 karakter.";
//         header("Location: ../register.php");
//     exit();
// }


//     // Cek apakah email sudah digunakan
//     $check = $db->prepare("SELECT email FROM users WHERE email = ?");
//     if (!$check) {
//         error_log("Prepare failed: " . $db->error);
//         echo "Terjadi kesalahan server.";
//         exit();
//     }

//     $check->bind_param("s", $email);
//     $check->execute();
//     $result = $check->get_result();

//     if ($result->num_rows > 0) {
//         echo "Email sudah terdaftar!";
//         $check->close();
//         exit();
//     }
//     $check->close();

//     // Hash password dengan algoritma bcrypt
//     $hashed = password_hash($password, PASSWORD_DEFAULT);

//     // Insert dengan role mahasiswa
//     $stmt = $db->prepare("INSERT INTO users (username, nama, email, password, role) VALUES (?, ?, ?, ?, 'mahasiswa')");    
//     if (!$stmt) {
//         error_log("Prepare failed: " . $db->error);
//         echo "Terjadi kesalahan server.";
//         exit();
//     }

//     $stmt->bind_param("ssss", $username, $nama, $email, $hashed);
  

// if ($stmt->execute()) {
//     header("Location: ../register.php?status=success");
//     exit();
// } else {
//     header("Location: ../register.php?status=failed");
//     exit();
// }

//     $stmt->close();
// }

require "../../config/db.php";
session_start();

// Hanya admin boleh register mahasiswa
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
    header("Location: ../index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = trim($_POST["username"]);
    $nama = trim($_POST["nama"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    // Validasi wajib isi
    if (empty($username) || empty($nama) || empty($email) || empty($password)) {
        $_SESSION['error'] = "Semua kolom harus diisi!";
        header("Location: ../register.php");
        exit();
    }

    // Validasi email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Format email tidak valid!";
        header("Location: ../register.php");
        exit();
    }

    // Validasi password minimal 6 karakter
    // if (strlen($password) < 6) {
    //     $_SESSION['error'] = "Password minimal 6 karakter.";
    //     header("Location: ../register.php");
    //     exit();
    // }

    // Cek email sudah ada atau belum
    $cek_email = $db->prepare("SELECT idUser FROM users WHERE email = ?");
    $cek_email->bind_param("s", $email);
    $cek_email->execute();
    $res_email = $cek_email->get_result();

    if ($res_email->num_rows > 0) {
        $_SESSION['error'] = "Email sudah digunakan!";
        header("Location: ../register.php");
        exit();
    }
    $cek_email->close();

    // Cek username juga!
    $cek_user = $db->prepare("SELECT idUser FROM users WHERE username = ?");
    $cek_user->bind_param("s", $username);
    $cek_user->execute();
    $res_user = $cek_user->get_result();

    if ($res_user->num_rows > 0) {
        $_SESSION['error'] = "Username sudah digunakan!";
        header("Location: ../register.php");
        exit();
    }
    $cek_user->close();

    // Hash password
    $hashed = password_hash($password, PASSWORD_DEFAULT);

    // Insert user baru
    $insert_user = $db->prepare("
        INSERT INTO users (username, nama, email, password, role)
        VALUES (?, ?, ?, ?, 'mahasiswa')
    ");
    $insert_user->bind_param("ssss", $username, $nama, $email, $hashed);
    $insert_user->execute();

    // Ambil ID user yang baru dibuat
    $id_user_baru = $insert_user->insert_id;
    $insert_user->close();

    // Buat KRS semester 1–12 langsung
    $insert_krs = $db->prepare("
        INSERT INTO krs (idUser, semester, tahun_ajaran)
        VALUES (?, ?, NULL)
    ");

    for ($sem = 1; $sem <= 12; $sem++) {
        $insert_krs->bind_param("ii", $id_user_baru, $sem);
        $insert_krs->execute();
    }

    $insert_krs->close();

    // Berhasil
    header("Location: ../register.php?status=success");
    exit();
}
?>
