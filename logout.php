<?php
include("config/connection.php");
session_start();
$query = "delete from cart";
mysqli_query($conn, $query);
// Unset all of the session variables
$_SESSION = array();


// Destroy the session
session_destroy();

// Redirect to the login page
header("location:index.php");
?>