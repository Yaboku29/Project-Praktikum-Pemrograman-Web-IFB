<?php

$host = "localhost";
$username =  "root";
$password = "";
$database = "database_bima_kw";

$db = new mysqli($host, $username, $password, $database);

if($db->connect_errno){
    die("error occured: " . $db->connect_error);
}