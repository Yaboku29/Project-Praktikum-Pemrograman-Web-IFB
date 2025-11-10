<?php
session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>auth-register</title>
</head>
<body>
    <form action="process/register_process.php" method="POST">
        <label for="">Username :</label><br>
        <input type="text" name="username" required><br><br>

        <label for="">Email :</label><br>
        <input type="text" name="Email" required><br><br>

        <label for="">Password :</label><br>
        <input type="text" name="password" required><br><br>

        <button type="submit"> register </button>
    </form>
</body>
</html>