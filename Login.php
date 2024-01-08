<?php
session_start();
include("config/connection.php");
$incorrectPassword = false;
$unregisteredEmail = false;
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);

    $query = "select * from users where email = '$email'";
    $result = mysqli_query($conn, $query);
    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $user_data = mysqli_fetch_assoc($result);
            if ($user_data['password'] === $password) {
                $_SESSION['username'] = $user_data['username'];
                $_SESSION['balance'] = $user_data['balance'];
                $_SESSION['email'] = $user_data['email'];
                header("location:index.php");
                die;
            } else {
                $incorrectPassword = true;
            }

        } else {
            $unregisteredEmail = true;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/login.css">
    <title>Log in</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"
        integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    </link>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
        integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body>


    <div class="container">
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" id="form" class="form" method="post">
            <h2>Log in</h2>
            <div class="form-control">
                <label for="email"><i class="fa fa-envelope"></i> Email</label>
                <input required type="email" id="email" placeholder="Enter user Email" name="email">
            </div>

            <div class="form-control ">
                <label for="password"> <i class="fa fa-lock"></i> Password</label>
                <input min="6" max="16" required type="Password" id="password" placeholder="Enter user Password"
                    name="password">
                <small>Error Message</small>
                <?php
                if ($incorrectPassword) {
                    echo "<style>input[type='password'] { border: 1px solid red; }</style>";
                    echo "<p style='color:red; font-size:13px;'>Incorrect password. Please try again.</p>";
                    $incorrectPassword = false;
                }
                if ($unregisteredEmail) {
                    echo "<style>input[type='email'] { border: 1px solid red; }</style>";
                    echo "<p style='color:red; font-size:13px;'>Email address is not registered. Please sign up.</p>";
                    $unregisteredEmail = false;
                }
                ?>
            </div>
            <button type="submit" name="submit">log in</button>
            <p>Don't you have an account?</p>
            <a href="sign-up.html" class="signUp">sign up</a>
        </form>
    </div>
    <script src="./script/login.js"></script>
</body>

</html>