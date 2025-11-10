<?php
session_start();

if(isset($_SESSION['username'])){
    header("Location: index.php");
    exit();
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
</head>
<body>
    <form action="process/login_process.php" method="POST">
        <label for="">Email :</label><br>
        <input type="email" name="email" required><br><br>

        <label for="">Password :</label><br>
        <input type="text" name="password" required><br><br>

        <button type="submit"> Login </button>
    </form>
</body>
</html>