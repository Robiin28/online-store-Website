<?php

$dbHost = "localhost";
$dbUser = "root";
$dbPass = "";
$dbName = "onlinestore";

$conn = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);

if (!$conn) {
    die("failed to connect");
}