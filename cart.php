<?php
session_start();
include("config/connection.php");

if (isset($_SESSION['email'])) {
    $userEmail = $_SESSION['email'];
}
$message = array();
if (isset($_POST['updateCart'])) {
    $updateQuantity = $_POST['cartQuantity'];
    $updateId = $_POST['cartId'];
    mysqli_query($conn, "UPDATE cart SET quantity = '$updateQuantity' WHERE id = '$updateId'") or die('query failed');
    $message[] = 'cart quantity updated successfully!';
}
function getCartQuantity()
{
    global $conn;
    $itemsNumberArr = mysqli_fetch_all(mysqli_query($conn, "select productName from cart"), MYSQLI_ASSOC);
    return (sizeof($itemsNumberArr));
}
if (isset($_GET['remove'])) {
    $removeId = $_GET['remove'];
    mysqli_query($conn, "DELETE FROM cart WHERE id = '$removeId'") or die('query failed');
}

if (isset($_GET['delete_all'])) {
    mysqli_query($conn, "DELETE FROM cart") or die('query failed');
}
if (isset($_POST['purchase'])) {
    if (isset($_SESSION['grandTotal'])) {
        $grandTotal = $_SESSION['grandTotal'];
        $balance = $_SESSION['balance'];
        if ($balance >= $grandTotal) {
            $balance -= $grandTotal;
            $_SESSION['balance'] = $balance;
            mysqli_query($conn, "UPDATE users SET balance = '$balance' WHERE email='$userEmail'");
            mysqli_query($conn, "DELETE FROM cart") or die('query failed');
            $message[] = 'purchase successful.';
        } else {
            $message[] = "insufficient balance.";
        }
    }
}

if (isset($message)) {
    foreach ($message as $message) {
        echo '<div class="message" onclick="this.remove();">' . $message . '</div>';
    }
}
$grandTotal = 0;

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/cart.css">
    <link rel="stylesheet" href="./styles/homeGeneral.css" />

    <title>Cart</title>
</head>

<body>
    <header>
        <div class="header">
            <div class="left-section">
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
            </div>
            <div class="middle-section">
                <img class="logo" src="./logo/logo.jpg" alt="Logo image" />
            </div>
            <div class="right-section">
                <div class="cart">
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
                    <li><a href="contact.php">CONTACT US</a></li>
                    <li><a href="#">ABOUT US</a></li>
                </ul>
            </div>
        </div>
        <nav>
            <ul class="main-menu">
                <li><a href="index.php">HOME</a></li>
                <li><a href="phones.php">BUY PHONES</a></li>
                <li><a href="laptops.php">BUY LAPTOPS</a></li>
                <li><a href="tvs.php">BUY TVS</a></li>
                <li><a href="contact.php">CONTACT US</a></li>
                <li><a href="#">ABOUT US</a></li>
            </ul>
        </nav>
    </header>

    <div class="container">
        <div class="shopping-cart">
            <h1 class="heading">shopping cart</h1>
            <table>
                <thead>
                    <th>Product</th>
                    <th>name</th>
                    <th>price</th>
                    <th>quantity</th>
                    <th>total price</th>
                    <th>action</th>
                </thead>
                <tbody>
                    <?php
                    $query = mysqli_query($conn, "SELECT * FROM cart") or die('query failed');
                    // $grandTotal = 0;
                    if (mysqli_num_rows($query) > 0) {
                        while ($fetch_cart = mysqli_fetch_assoc($query)) {
                            ?>
                            <tr>
                                <td>
                                    <img src="data:image/jpeg;base64,<?php echo $fetch_cart['productImage']; ?>" height="100"
                                        alt="">
                                </td>
                                <td>
                                    <?php echo $fetch_cart['productName']; ?>
                                </td>
                                <td>Br.
                                    <?php echo $fetch_cart['price']; ?>
                                </td>
                                <td>
                                    <form method="post">
                                        <input type="hidden" name="cartId" value="<?php echo $fetch_cart['id']; ?>">
                                        <input type="number" min="1" name="cartQuantity"
                                            value="<?php echo $fetch_cart['quantity']; ?>">
                                        <input type="submit" name="updateCart" value="update" class="option-btn">
                                    </form>
                                </td>
                                <td>Br.
                                    <?php echo $subTotal = ($fetch_cart['price'] * $fetch_cart['quantity']); ?>
                                </td>
                                <td><a href="cart.php?remove=<?php echo $fetch_cart['id']; ?>" class="delete-btn"
                                        onclick="return confirm('remove item from cart?');">remove</a></td>
                            </tr>
                            <?php
                            $grandTotal += $subTotal;
                            $_SESSION['grandTotal'] = $grandTotal;
                        }
                    } else {
                        echo '<tr><td style="padding:20px; text-transform:capitalize;" colspan="6">no item added</td></tr>';
                    }
                    ?>
                    <tr class="table-bottom">
                        <td colspan="4" style="text-align:right; padding-right:10%;">Total Cost:</td>
                        <td>Br.
                            <?php echo $grandTotal; ?>
                        </td>
                        <td><a href="cart.php?delete_all" onclick="return confirm('delete all from cart?');"
                                class="delete-btn <?php echo ($grandTotal > 1) ? '' : 'disabled'; ?>">delete all</a>
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="checkout-btn">
                <form method="post">
                    <input type="submit" name="purchase" value="Purchase"
                        class="btn <?php echo ($grandTotal > 1) ? '' : 'disabled'; ?>">
                </form>
            </div>

        </div>

    </div>
    </div>
</body>

</html>