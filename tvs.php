<?php
session_start();
include("config/connection.php");


if (isset($_POST["searchedTerm"])) {
    $searchedTerm = filter_input(INPUT_POST, "searchedTerm", FILTER_SANITIZE_SPECIAL_CHARS);
    // Build and execute the query
    $query2 = "SELECT * FROM tvs WHERE brand LIKE '%$searchedTerm%' OR model LIKE '%$searchedTerm%'";
    $result2 = mysqli_query($conn, $query2);
    $tvList = mysqli_fetch_all($result2, MYSQLI_ASSOC);
} else {
    $query = "select * from tvs";
    $result = mysqli_query($conn, $query);
    $tvList = mysqli_fetch_all($result, MYSQLI_ASSOC);

}
// var_dump($tvList);
$tvNames = [];
for ($i = 0; $i < sizeof($tvList); $i++) {
    $tvBrandName = $tvList[$i]['brand'];
    $tvModelName = $tvList[$i]['model'];
    $tvNames[$i] = "$tvBrandName $tvModelName";
}
$tvResolution = [];
for ($i = 0; $i < sizeof($tvList); $i++) {
    $tvResolution[$i] = $tvList[$i]['resolution'];
}

$tvDisplay = [];
for ($i = 0; $i < sizeof($tvList); $i++) {
    $tvDisplay[$i] = $tvList[$i]['display'];
}
$tvRefreshRate = [];
for ($i = 0; $i < sizeof($tvList); $i++) {
    $tvRefreshRate[$i] = $tvList[$i]['refreshRate'];
}
$tvPrice = [];
for ($i = 0; $i < sizeof($tvList); $i++) {
    $tvPrice[$i] = $tvList[$i]['price'];
}

$tvScreenSize = [];
for ($i = 0; $i < sizeof($tvList); $i++) {
    $tvScreenSize[$i] = $tvList[$i]['screenSize'];
}


$tvImage_data = [];
for ($i = 0; $i < sizeof($tvList); $i++) {
    $tvImage_data[$i] = $tvList[$i]['tvImage'];
    $encodedIMG = base64_encode($tvImage_data[$i]);
    $tvImage_data[$i] = $encodedIMG;
}
function setTvDescription($i)
{
    global $tvDisplay, $tvRefreshRate, $tvResolution, $tvScreenSize;
    $description = "Screen size:$tvScreenSize[$i]inches <br>Resolution: $tvResolution[$i] <br>Display: $tvDisplay[$i]<br> Refresh rate: $tvRefreshRate[$i]Hz";
    echo $description;
}

$numberOfTvs = sizeof($tvList);
// $numberOfSearchedPhones = sizeof($searchedPhones);
function getCartQuantity()
{
    global $conn;
    $itemsNumberArr = mysqli_fetch_all(mysqli_query($conn, "select productName from cart"), MYSQLI_ASSOC);
    return (sizeof($itemsNumberArr));
}

if (isset($_POST["addToCart"])) {
    if (isset($_SESSION['username'])) {
        $itemsInCartNumber = 0;
        $productImage = $_POST["productImage"];
        $productName = $_POST["productName"];
        $productPrice = $_POST["productPrice"];
        $selectCart = mysqli_query($conn, "select * from cart where productName='$productName'");
        if (mysqli_num_rows($selectCart) > 0) {
            $message[] = "Product is already in cart!";
        } else {
            $query = "insert into cart(productImage, productName, price) values ('$productImage', '$productName', '$productPrice')";
            mysqli_query($conn, $query);
            $message[] = "Product added to cart!";
        }
    } else {
        ?>
        <script>
            confirm("Users must log in before accessing cart");
            window.location.href = "login.php";
        </script>
        <?php
    }

}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./styles/product.css" />
    <link rel="stylesheet" href="https://kit.fontawesome.com/f7b9feb3b9.css" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
        integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./styles/general.css" />
    <title>card</title>
</head>

<body>
    <div>
        <?php
        if (isset($message)) {
            foreach ($message as $message) {
                echo '<div class="message" onclick="this.remove();">' . $message . '</div>';
            }
        }
        ?>

    </div>

    <!-- header-html -->
    <header>
        <div class="header">
            <div class="left-section">
                <img class="logo" src="./logo/logo.jpg" alt="Logo image" />
            </div>
            <form method="post" class="middle-section">
                <input class="search-bar" type="text" name="searchedTerm" placeholder="Search any product" />
                <button type="submit" class="search-button">
                    <i class="fa fa-search"></i>
                </button>
            </form>
            <div class="right-section">
                <div class="login-and-account">
                    <div class="my-account">
                        <?php
                        if (isset($_SESSION['username'])) {
                            $username = $_SESSION['username'];
                            echo "signed in as $username";
                        }
                        ?>
                    </div>
                    <div class="login">
                        <?php
                        if (isset($_SESSION['username'])) {
                            echo '<a class="login-txt" href="logout.php">logout</a>';
                        } else {
                            echo '<a class="login-txt" href="login.php">login</a>';
                        }
                        ?>
                    </div>
                </div>
                <div class="cart-and-balance">
                    <?php
                    if (isset($_SESSION['username'])) {
                        $currentBalance = $_SESSION['balance'];
                        echo "<div class=balance>";
                        echo "Balance:$currentBalance Br";
                        echo "</div>";
                    }
                    ?>
                    <a style="text-decoration:none; display:flex; align-items:center; color:black;" href="cart.php">
                        <div class="fa-cart"><i class="fa fa-cart-plus"></i></div>
                        <h3>Cart</h3>
                        <?php
                        echo "<h3 style='background:black;
                      color:white;
                      width:20px;
                      height:20px;
                      display:flex;
                      align-items:center;
                      justify-content:center;
                      font-size:14px;
                      border-radius:50%;
                      margin-left:5px;'>" . getCartQuantity() . "</h3>";
                        ?>
                    </a>

                </div>
            </div>
            <div class="hamburger-menu">
                <i class="fa fa-hamburger"></i>
                <ul class="main-menu">
                    <li><a href="index.php">HOME</a></li>
                    <li><a href="phones.php">BUY PHONES</a></li>
                    <li><a href="laptops.php">BUY LAPTOPS</a></li>
                    <li><a href="tvs.php">BUY TVS</a></li>
                    <li><a href="contact.html">CONTACT US</a></li>
                    <li><a href="aboutUs.html">ABOUT US</a></li>
                </ul>
            </div>
        </div>
        <nav>
            <ul class="main-menu">
                <li><a href="index.php">HOME</a></li>
                <li><a href="phones.php">BUY PHONES</a></li>
                <li><a href="laptops.php">BUY LAPTOPS</a></li>
                <li><a href="tvs.php">BUY TVS</a></li>
                <li><a href="contact.html">CONTACT US</a></li>
                <li><a href="aboutUs.html">ABOUT US</a></li>
            </ul>
        </nav>
    </header>

    <!--/ header-html -->

    <div class="section">
        <div class="cards">

            <?php
            if (!isset($_POST["searchedTerm"])) {
                for ($i = 0; $i < $numberOfTvs; $i++): ?>
                    <div class="card">
                        <div class="image-section">
                            <?php
                            echo '<img src="data:image/jpeg;base64,' . $tvImage_data[$i] . '" class="image" alt = "tvs image">';
                            ?>
                        </div>
                        <div class="description">
                            <?php
                            echo "<h1>$tvNames[$i]</h1>";
                            ?>
                            <p><span>
                                    <?php
                                    echo "Br. $tvPrice[$i]";
                                    ?>
                                </span></p>
                        </div>

                        <div class="button-group">
                            <form method="post">
                                <input type="hidden" name="productImage" value="<?php echo $tvImage_data[$i]; ?>">
                                <input type="hidden" name="productName" value="<?php echo $tvNames[$i]; ?>">
                                <input type="hidden" name="productPrice" value="<?php echo $tvPrice[$i]; ?>">

                                <input class="car-t" type="submit" name="addToCart" value="Add to Cart" />

                            </form>
                            <!-- <span onclick="incrementValue()" href="" class="car-t">Add to cart</span> -->

                            <input onclick="on(<?php echo $i; ?>)" class="details" value="detail" type="submit">
                            <div id="overlay<?php echo $i; ?>" onclick="off(<?php echo $i; ?>)" class="overlay">
                                <div id="text">
                                    <h3>details</h3>
                                    <p>
                                        <?php
                                        echo "$tvNames[$i]<br><br>";
                                        setTvDescription($i);
                                        echo "<br>Price: $tvPrice[$i]";
                                        ?>
                                    </p>

                                </div>
                            </div>
                        </div>
                    </div>
                <?php endfor;
            } else {
                if ($numberOfTvs !== 0) {
                    for ($i = 0; $i < $numberOfTvs; $i++):
                        ?>
                        <div class="card">
                            <div class="image-section">
                                <?php
                                echo '<img src="data:image/jpeg;base64,' . $tvImage_data[$i] . '" class="image" alt = "tv
                 image">';
                                ?>
                            </div>
                            <div class="description">
                                <?php
                                echo "<h1>$tvNames[$i]</h1>";
                                ?>
                                <p><span>
                                        <?php
                                        echo "Br. $tvPrice[$i]";
                                        ?>
                                    </span></p>
                            </div>
                            <div class="button-group">
                                <form method="post">
                                    <input type="hidden" name="productImage" value="<?php echo $tvImage_data[$i]; ?>">
                                    <input type="hidden" name="productName" value="<?php echo $tvNames[$i]; ?>">
                                    <input type="hidden" name="productPrice" value="<?php echo $tvPrice[$i]; ?>">

                                    <input class="car-t" type="submit" name="addToCart" value="Add to Cart" />

                                </form>
                                <!-- <span onclick="incrementValue()" href="" class="car-t">Add to cart</span> -->

                                <input onclick="on(<?php echo $i; ?>)" class="details" value="detail" type="submit">
                                <div id="overlay<?php echo $i; ?>" onclick="off(<?php echo $i; ?>)" class="overlay">
                                    <div id="text">
                                        <h3>details</h3>
                                        <p>
                                            <?php
                                            echo "$tvNames[$i]<br><br>";
                                            setTvDescription($i);
                                            echo "<br>Price: $tvPrice[$i]";
                                            ?>
                                        </p>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    endfor;
                } else {
                    echo "product not available";
                }
            }
            ?>
        </div>
    </div>

    <!-- footer-html -->
    <footer>
        <div class="footer-main">
            <div class="quick-links">
                <p class="footer-title">QUICK LINKS</p>
                <ul>
                    <li><a href="index.php">HOME</a></li>
                    <li><a href="login.php">LOGIN / SIGNUP</a></li>
                    <li><a href="phones.php">PHONES</a></li>
                    <li><a href="laptops.php">LAPTOPS</a></li>
                    <li><a href="tvs.php">TVS</a></li>
                    <li><a href="aboutUs.html">ABOUT US</a></li>
                    <li><a href="contact.html">CONTACT US</a></li>
                </ul>
            </div>
            <div class="contact-information">
                <p class="footer-title">CONTACT INFORMATION</p>
                <ul>
                    <li><i class="fa fa-phone"></i> Call: +251-9-40-40-40-40</li>
                    <li>
                        <a href="mailto:abelectronics@gmail.com"><i class="fa fa-envelope"></i> Email:
                            abelectronics@gmail.com</a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-globe"></i> Website: www.abelectornics.com</a>
                    </li>
                </ul>
            </div>
            <div class="follow-us">
                <p class="footer-title">FOLLOW US</p>
                <ul class="social-media">
                    <li class="facebook">
                        <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                    </li>
                    <li class="instagram">
                        <a href="#"><i class="fa-brands fa-instagram"></i></a>
                    </li>
                    <li class="telegram">
                        <a href="#"><i class="fa-brands fa-telegram"></i></a>
                    </li>
                    <li class="twitter">
                        <a href="#"><i class="fa-brands fa-twitter"></i></a>
                    </li>
                    <li class="youtube">
                        <a href="#"><i class="fa-brands fa-youtube"></i></a>
                    </li>
                </ul>
            </div>
        </div>
        <hr />
        <p class="copyright-footer">
            &#169; Copyright 2023 - <span>AB Electronics - </span>All rights
            reserved
        </p>
    </footer>

    <!-- /footer-html -->
    <script src="./script/product.js"></script>
    <script>
        document.querySelector("button[type='submit']").addEventListener("click", function (event) {
            event.preventDefault();
            // alert("hello");
            this.form.submit();
        });
    </script>
</body>

</html>