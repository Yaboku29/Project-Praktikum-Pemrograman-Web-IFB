<?php 

require_once "../config/db.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = $_POST["username"];
    $email = $_POST["Email"];
    $password = $_POST["password"];

    //cek email apakah sudah terdaftar??

    $check = $db->prepare("SELECT id FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if($check->num_rows > 0){
        echo "Email sudah terdaftar";
    }else{
        $HashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $db->prepare("INSERT INTO users (username, email, password) VALUES (?,?,?)");
        $stmt->bind_param("sss", $username, $email, $HashedPassword);

        if($stmt->execute()){
            echo "Registrasi Berhasil";
            header("Location: ../login.php");
        }else{
            echo "Error occured : " . $db->error;
        }
        $stmt->close();
    }
    
    $check->close();
}
