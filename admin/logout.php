<?php

session_start();
session_destroy();
header("Location: ../Project-Praktikum-Pemrograman-Web-IFB/login.php");
exit();