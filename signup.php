<?php

session_start();
include("config/connection.php");
if (isset($_POST['submit'])) {
    $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);
    $query1 = "select email from users where email = '$email'";
    $result1 = mysqli_query($conn, $query1);
    if (mysqli_num_rows($result1) > 0) {
        ?>
        <script>alert("there is already an account by that email")</script><?php
    } else {
        $query2 = "insert into users(username, email, password) values ('$username', '$email', '$password')";
        $result2 = mysqli_query($conn, $query2);
        if ($result2) {
            header('location:login.php');
        } else {
            echo "error " . mysqli_error($conn);
        }
    }

}

?>