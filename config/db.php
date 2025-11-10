<?php

$host = "localhost";
$username =  "root";
$password = "";
$database = "web_if_b";

$db = new mysqli($host, $username, $password, $database);

if($db->connect_errno){
    die("error occured: " . $db->connect_error);
}