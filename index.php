<?php
session_start();
include("config/connection.php");
$sql = "select * from phones order by price desc limit 4";
$result = mysqli_query($conn, $sql);
$phoneList = mysqli_fetch_all($result, MYSQLI_ASSOC);


$phoneNames = [];
for ($i = 0; $i < 4; $i++) {
  $phoneBrandName = $phoneList[$i]['brand'];
  $phoneModelName = $phoneList[$i]['model'];
  $phoneNames[$i] = "$phoneBrandName $phoneModelName";
}
$phonePrice = [];
for ($i = 0; $i < 4; $i++) {
  $phonePrice[$i] = $phoneList[$i]['price'];
}
$phoneStorage = [];
for ($i = 0; $i < 4; $i++) {
  $phoneStorage[$i] = $phoneList[$i]['storage'];
}
$phoneRam = [];
for ($i = 0; $i < 4; $i++) {
  $phoneRam[$i] = $phoneList[$i]['ram'];
}
$phoneBattery = [];
for ($i = 0; $i < 4; $i++) {
  $phoneBattery[$i] = $phoneList[$i]['batterySize'];
}

$phoneOs = [];
for ($i = 0; $i < 4; $i++) {
  $phoneOs[$i] = $phoneList[$i]['OS'];
}
function setPhoneDescription($i)
{
  global $phoneStorage, $phoneOs, $phoneBattery, $phoneRam;
  $description = "Storage: $phoneStorage[$i]GB <br>RAM: $phoneRam[$i]GB <br> OS: $phoneOs[$i]<br> Battery Capacity: $phoneBattery[$i]mAh";
  echo $description;
}
// var_dump($image_data);
$phoneImage_data = [];
for ($i = 0; $i < 4; $i++) {
  $phoneImage_data[$i] = $phoneList[$i]['phoneImage'];
  $encodedIMG = base64_encode($phoneImage_data[$i]);
  $phoneImage_data[$i] = $encodedIMG;
}
$sql2 = "select * from laptops order by price desc limit 4";
$result2 = mysqli_query($conn, $sql2);
$laptopList = mysqli_fetch_all($result2, MYSQLI_ASSOC);
$laptopNames = [];
for ($i = 0; $i < 4; $i++) {
  $laptopBrandName = $laptopList[$i]['brand'];
  $laptopModelName = $laptopList[$i]['model'];
  $laptopNames[$i] = "$laptopBrandName $laptopModelName";
}
$laptopProcessor = [];
for ($i = 0; $i < 4; $i++) {
  $laptopProcessor[$i] = $laptopList[$i]['processor'];
}
$laptopGen = [];
for ($i = 0; $i < 4; $i++) {
  $laptopGen[$i] = $laptopList[$i]['gen'];
}
$laptopProcessorSpeed = [];
for ($i = 0; $i < 4; $i++) {
  $laptopProcessorSpeed[$i] = $laptopList[$i]['processorSpeed'];
}
$laptopOS = [];
for ($i = 0; $i < 4; $i++) {
  $laptopOS[$i] = $laptopList[$i]['OS'];
}
$laptopStorage = [];
for ($i = 0; $i < 4; $i++) {
  $laptopStorage[$i] = $laptopList[$i]['storage'];
}
$laptopStorageType = [];
for ($i = 0; $i < 4; $i++) {
  $laptopStorageType[$i] = $laptopList[$i]['storageType'];
}
$laptopRam = [];
for ($i = 0; $i < 4; $i++) {
  $laptopRam[$i] = $laptopList[$i]['ram'];
}
$laptopScreenSize = [];
for ($i = 0; $i < 4; $i++) {
  $laptopScreenSize[$i] = $laptopList[$i]['screenSize'];
}
$laptopPrice = [];
for ($i = 0; $i < 4; $i++) {
  $laptopPrice[$i] = $laptopList[$i]['price'];
}

$laptopImage_data = [];
for ($i = 0; $i < 4; $i++) {
  $laptopImage_data[$i] = $laptopList[$i]['laptopImage'];
  $encodedIMG = base64_encode($laptopImage_data[$i]);
  $laptopImage_data[$i] = $encodedIMG;
}
function setLaptopDescription($i)
{
  global $laptopStorage, $laptopProcessorSpeed, $laptopGen, $laptopOS, $laptopProcessor, $laptopRam, $laptopStorageType, $laptopScreenSize;
  $description = "$laptopProcessor[$i], $laptopProcessorSpeed[$i]GHz, $laptopGen[$i]<sup>th</sup>gen,<br> $laptopStorage[$i]GB $laptopStorageType[$i], $laptopRam[$i]GB Ram,<br> $laptopOS[$i],<br> $laptopScreenSize[$i]inches";
  echo $description;
}

$sql3 = "select * from Tvs order by price desc limit 4";
$result3 = mysqli_query($conn, $sql3);
$tvList = mysqli_fetch_all($result3, MYSQLI_ASSOC);
$tvNames = [];
for ($i = 0; $i < 4; $i++) {
  $tvBrandName = $tvList[$i]['brand'];
  $tvModelName = $tvList[$i]['model'];
  $tvNames[$i] = "$tvBrandName $tvModelName";
}
$tvResolution = [];
for ($i = 0; $i < 4; $i++) {
  $tvResolution[$i] = $tvList[$i]['resolution'];
}

$tvDisplay = [];
for ($i = 0; $i < 4; $i++) {
  $tvDisplay[$i] = $tvList[$i]['display'];
}
$tvRefreshRate = [];
for ($i = 0; $i < 4; $i++) {
  $tvRefreshRate[$i] = $tvList[$i]['refreshRate'];
}
$tvPrice = [];
for ($i = 0; $i < 4; $i++) {
  $tvPrice[$i] = $tvList[$i]['price'];
}

$tvScreenSize = [];
for ($i = 0; $i < 4; $i++) {
  $tvScreenSize[$i] = $tvList[$i]['screenSize'];
}


$tvImage_data = [];
for ($i = 0; $i < 4; $i++) {
  $tvImage_data[$i] = $tvList[$i]['tvImage'];
  $encodedIMG = base64_encode($tvImage_data[$i]);
  $tvImage_data[$i] = $encodedIMG;
}
function setTvDescription($i)
{
  global $tvDisplay, $tvRefreshRate, $tvResolution, $tvScreenSize;
  $description = "Screen size:$tvScreenSize[$i]inches, <br>Resolution: $tvResolution[$i], <br>Display: $tvDisplay[$i],<br> Refresh rate: $tvRefreshRate[$i]Hz";
  echo $description;
}

if (isset($_SESSION['username'])) {
  $currentBalance = $_SESSION['balance'];
  if (isset($_POST['depositBtn'])) {
    $userEmail = $_SESSION['email'];
    $query = "select balance from users where email = '$userEmail'";
    $result = mysqli_query($conn, $query);
    $prevBalance = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $prevBalance = (int) $prevBalance[0]['balance'];

    $deposit = $_POST['deposit'];
    $currentBalance = $prevBalance + (int) $deposit;
    $_SESSION['balance'] = $prevBalance + (int) $deposit;

    $query2 = "UPDATE users SET balance=$currentBalance WHERE email='$userEmail'";
    $result2 = mysqli_query($conn, $query2);
  }
}
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
  <title>AB Electronics</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet" />
  <link type="image/png" rel="shortcut icon" href="Images and logos/logo.png" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
    integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="./styles/home-page.css" />
  <link rel="stylesheet" href="./styles/homeGeneral.css" />
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

        <?php
        if (isset($_SESSION['username'])) {
          echo "<div class=balance>";
          echo "Balance:$currentBalance Br";
          echo "</div>";

          echo "<form method='post'>";
          echo "<input type='number' id='depositField' min='0' placeholder='deposit money'  name='deposit'>";
          echo "<input type='submit' id='depositBtn' value='Deposit' name='depositBtn'>";
          echo "</form>";

        }
        ?>

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

  <!-- homepage-html-->

  <div class="welcome-txt" id="welcome-background">
    <p class="welcome-header">"Welcome To AB Electronics Store !"</p>
    <p class="welcome-description">
      Welcome to our online electronic store! We're excited to offer you a
      wide selection of the latest and greatest in electronics, from
      smartphone, laptops and modern televisions. Our team is dedicated to
      providing you with the best customer service and the most competitive
      prices. Whether you're in the market for a new device or just browsing,
      we're here to help you find what you need. Thanks for choosing us, and
      happy shopping!
    </p>
  </div>

  <div class="sold-products">
    <div class="sold-products-header">
      <div class="featured-products">FEATURED PRODUCTS</div>
      <div class="top-selling-products">Top Selling Products</div>
    </div>

    <div class="product-type-and-image-container">
      <div class="product-header">PHONES</div>
      <div class="products-image-and-info">
        <div class="image-container">
          <div class="products-image">
            <?php
            echo '<img src="data:image/jpeg;base64,' . $phoneImage_data[0] . '" class="image" alt = "phone image">';
            ?>
          </div>
          <div class="products-info">
            <div class="name">
              <?php echo $phoneNames[0] ?>
            </div>
            <div class="specs"><span>Specs</span>
              <?php echo " <br>";
              setPhoneDescription(0); ?>
            </div>
            <div class="cost-and-former-cost">
              <div class="cost">Cost:
                <?php echo "$phonePrice[0]Br."; ?>
              </div>

            </div>
            <div class="add-to-cart-div">
              <form action="" method="post">
                <input type="hidden" name="productImage" value="<?php echo $phoneImage_data[0]; ?>">
                <input type="hidden" name="productName" value="<?php echo $phoneNames[0]; ?>">
                <input type="hidden" name="productPrice" value="<?php echo $phonePrice[0]; ?>">
                <input class="add-to-cart-button" type="submit" value="Add to Cart" name="addToCart">
              </form>
            </div>
          </div>
        </div>
        <div class="image-container">
          <div class="products-image">
            <?php
            echo '<img src="data:image/jpeg;base64,' . $phoneImage_data[1] . '" class="image" alt = "phone image">';
            ?>
          </div>
          <div class="products-info">
            <div class="name">
              <?php echo $phoneNames[1] ?>
            </div>
            <div class="specs"><span>Specs</span>
              <?php echo " <br>";
              setPhoneDescription(1); ?>
            </div>
            <div class="cost-and-former-cost">
              <div class="cost">Cost:
                <?php echo "$phonePrice[1]Br."; ?>

              </div>

            </div>
            <div class="add-to-cart-div">
              <form action="" method="post">
                <input type="hidden" name="productImage" value="<?php echo $phoneImage_data[1]; ?>">
                <input type="hidden" name="productName" value="<?php echo $phoneNames[1]; ?>">
                <input type="hidden" name="productPrice" value="<?php echo $phonePrice[1]; ?>">
                <input class="add-to-cart-button" type="submit" value="Add to Cart" name="addToCart">
              </form>
            </div>
          </div>
        </div>
        <div class="image-container">
          <div class="products-image">
            <?php
            echo '<img src="data:image/jpeg;base64,' . $phoneImage_data[2] . '" class="image" alt = "phone image">';
            ?>
          </div>
          <div class="products-info">
            <div class="name">
              <?php echo $phoneNames[2] ?>
            </div>
            <div class="specs"><span>Specs</span>
              <?php echo " <br>";
              setPhoneDescription(2); ?>
            </div>
            <div class="cost-and-former-cost">
              <div class="cost">Cost:
                <?php echo "$phonePrice[2]Br."; ?>

              </div>

            </div>
            <div class="add-to-cart-div">
              <form action="" method="post">
                <input type="hidden" name="productImage" value="<?php echo $phoneImage_data[2]; ?>">
                <input type="hidden" name="productName" value="<?php echo $phoneNames[2]; ?>">
                <input type="hidden" name="productPrice" value="<?php echo $phonePrice[2]; ?>">
                <input class="add-to-cart-button" type="submit" value="Add to Cart" name="addToCart">
              </form>
            </div>
          </div>
        </div>
        <div class="image-container">
          <div class="products-image">
            <?php
            echo '<img src="data:image/jpeg;base64,' . $phoneImage_data[3] . '" class="image" alt = "phone image">';
            ?>
          </div>
          <div class="products-info">
            <div class="name">
              <?php echo $phoneNames[3] ?>
            </div>
            <div class="specs"><span>Specs</span>
              <?php echo " <br>";
              setPhoneDescription(3); ?>
            </div>
            <div class="cost-and-former-cost">
              <div class="cost">Cost:
                <?php echo " $phonePrice[3]Br."; ?>

              </div>

            </div>
            <div class="add-to-cart-div">
              <form action="" method="post">
                <input type="hidden" name="productImage" value="<?php echo $phoneImage_data[3]; ?>">
                <input type="hidden" name="productName" value="<?php echo $phoneNames[3]; ?>">
                <input type="hidden" name="productPrice" value="<?php echo $phonePrice[3]; ?>">
                <input class="add-to-cart-button" type="submit" value="Add to Cart" name="addToCart">
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="product-type-and-image-container">
      <div class="product-header">LAPTOPS</div>
      <div class="products-image-and-info">
        <div class="image-container">
          <div class="products-image">
            <?php
            echo '<img src="data:image/jpeg;base64,' . $laptopImage_data[0] . '" class="image" alt = "phone image">';
            ?>
          </div>
          <div class="products-info">
            <div class="name">
              <?php echo $laptopNames[0]; ?>
            </div>
            <div class="specs">
              <div class="specs"><span>Specs</span>
                <div class="description">
                  <?php echo " <br>";
                  setLaptopDescription(0); ?>
                </div>
              </div>
            </div>
            <div class="cost-and-former-cost">
              <div class="cost">Cost:
                <?php echo "$laptopPrice[0]Br."; ?>
              </div>
            </div>
            <div class="add-to-cart-div">
              <form action="" method="post">
                <input type="hidden" name="productImage" value="<?php echo $laptopImage_data[0]; ?>">
                <input type="hidden" name="productName" value="<?php echo $laptopNames[0]; ?>">
                <input type="hidden" name="productPrice" value="<?php echo $laptopPrice[0]; ?>">
                <input class="add-to-cart-button" type="submit" value="Add to Cart" name="addToCart">
              </form>
            </div>
          </div>
        </div>
        <div class="image-container">
          <div class="products-image">
            <?php
            echo '<img src="data:image/jpeg;base64,' . $laptopImage_data[1] . '" class="image" alt = "phone image">';
            ?>
          </div>
          <div class="products-info">
            <div class="name">
              <?php echo $laptopNames[1]; ?>
            </div>
            <div class="specs">
              <div class="specs"><span>Specs</span>
                <div class="description">
                  <?php echo " <br>";
                  setLaptopDescription(1); ?>
                </div>
              </div>
            </div>
            <div class="cost-and-former-cost">
              <div class="cost">Cost:
                <?php echo "$laptopPrice[1]Br."; ?>
              </div>
            </div>
            <div class="add-to-cart-div">
              <form action="" method="post">
                <input type="hidden" name="productImage" value="<?php echo $laptopImage_data[1]; ?>">
                <input type="hidden" name="productName" value="<?php echo $laptopNames[1]; ?>">
                <input type="hidden" name="productPrice" value="<?php echo $laptopPrice[1]; ?>">
                <input class="add-to-cart-button" type="submit" value="Add to Cart" name="addToCart">
              </form>
            </div>
          </div>
        </div>
        <div class="image-container">
          <div class="products-image">
            <?php
            echo '<img src="data:image/jpeg;base64,' . $laptopImage_data[2] . '" class="image" alt = "phone image">';
            ?>
          </div>
          <div class="products-info">
            <div class="name">
              <?php echo $laptopNames[2]; ?>
            </div>
            <div class="specs">
              <div class="specs"><span>Specs</span>
                <div class="description">
                  <?php echo " <br>";
                  setLaptopDescription(2); ?>
                </div>
              </div>
            </div>
            <div class="cost-and-former-cost">
              <div class="cost">Cost:
                <?php echo "$laptopPrice[2]Br."; ?>
              </div>
            </div>
            <div class="add-to-cart-div">
              <form action="" method="post">
                <input type="hidden" name="productImage" value="<?php echo $laptopImage_data[2]; ?>">
                <input type="hidden" name="productName" value="<?php echo $laptopNames[2]; ?>">
                <input type="hidden" name="productPrice" value="<?php echo $laptopPrice[2]; ?>">
                <input class="add-to-cart-button" type="submit" value="Add to Cart" name="addToCart">
              </form>
            </div>
          </div>
        </div>
        <div class="image-container">
          <div class="products-image">
            <?php
            echo '<img src="data:image/jpeg;base64,' . $laptopImage_data[3] . '" class="image" alt = "phone image">';
            ?>
          </div>
          <div class="products-info">
            <div class="name">
              <?php echo $laptopNames[3]; ?>
            </div>
            <div class="specs">
              <div class="specs"><span>Specs</span>
                <div class="description">
                  <?php echo " <br>";
                  setLaptopDescription(3); ?>
                </div>
              </div>
            </div>
            <div class="cost-and-former-cost">
              <div class="cost">Cost:
                <?php echo "$laptopPrice[3]Br."; ?>
              </div>
            </div>
            <div class="add-to-cart-div">
              <form action="" method="post">
                <input type="hidden" name="productImage" value="<?php echo $laptopImage_data[3]; ?>">
                <input type="hidden" name="productName" value="<?php echo $laptopNames[3]; ?>">
                <input type="hidden" name="productPrice" value="<?php echo $laptopPrice[3]; ?>">
                <input class="add-to-cart-button" type="submit" value="Add to Cart" name="addToCart">
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="product-type-and-image-container">
      <div class="product-header">TELEVISIONS</div>
      <div class="products-image-and-info">
        <div class="image-container">
          <div class="products-image">
            <?php
            echo '<img src="data:image/jpeg;base64,' . $tvImage_data[0] . '" class="image" alt = "phone image">';
            ?>
          </div>
          <div class="products-info">
            <div class="name">
              <?php echo $tvNames[0] ?>
            </div>
            <div class="specs">
              <span>Specs</span>
              <div class="description">
                <?php echo " <br>";
                setTvDescription(0); ?>
              </div>
            </div>
            <div class="cost-and-former-cost">
              <div class="cost">Cost:
                <?php echo "$tvPrice[0]Br."; ?>
              </div>

            </div>
            <div class="add-to-cart-div">
              <form action="" method="post">
                <input type="hidden" name="productImage" value="<?php echo $tvImage_data[0]; ?>">
                <input type="hidden" name="productName" value="<?php echo $tvNames[0]; ?>">
                <input type="hidden" name="productPrice" value="<?php echo $tvPrice[0]; ?>">
                <input class="add-to-cart-button" type="submit" value="Add to Cart" name="addToCart">
              </form>
            </div>
          </div>
        </div>
        <div class="image-container">
          <div class="products-image">
            <?php
            echo '<img src="data:image/jpeg;base64,' . $tvImage_data[1] . '" class="image" alt = "phone image">';
            ?>
          </div>
          <div class="products-info">
            <div class="name">
              <?php echo $tvNames[1] ?>
            </div>
            <div class="specs">
              <span>Specs</span>
              <div class="description">
                <?php echo " <br>";
                setTvDescription(1); ?>
              </div>
            </div>
            <div class="cost-and-former-cost">
              <div class="cost">Cost:
                <?php echo "$tvPrice[1]Br."; ?>
              </div>

            </div>
            <div class="add-to-cart-div">
              <form action="" method="post">
                <input type="hidden" name="productImage" value="<?php echo $tvImage_data[1]; ?>">
                <input type="hidden" name="productName" value="<?php echo $tvNames[1]; ?>">
                <input type="hidden" name="productPrice" value="<?php echo $tvPrice[1]; ?>">
                <input class="add-to-cart-button" type="submit" value="Add to Cart" name="addToCart">
              </form>
            </div>
          </div>
        </div>
        <div class="image-container">
          <div class="products-image">
            <?php
            echo '<img src="data:image/jpeg;base64,' . $tvImage_data[2] . '" class="image" alt = "phone image">';
            ?>
          </div>
          <div class="products-info">
            <div class="name">
              <?php echo $tvNames[2] ?>
            </div>
            <div class="specs">
              <span>Specs</span>
              <div class="description">
                <?php echo " <br>";
                setTvDescription(2); ?>
              </div>
            </div>
            <div class="cost-and-former-cost">
              <div class="cost">Cost:
                <?php echo "$tvPrice[2]Br."; ?>
              </div>

            </div>
            <div class="add-to-cart-div">
              <form action="" method="post">
                <input type="hidden" name="productImage" value="<?php echo $tvImage_data[2]; ?>">
                <input type="hidden" name="productName" value="<?php echo $tvNames[2]; ?>">
                <input type="hidden" name="productPrice" value="<?php echo $tvPrice[2]; ?>">
                <input class="add-to-cart-button" type="submit" value="Add to Cart" name="addToCart">
              </form>
            </div>
          </div>
        </div>
        <div class="image-container">
          <div class="products-image">
            <?php
            echo '<img src="data:image/jpeg;base64,' . $tvImage_data[3] . '" class="image" alt = "phone image">';
            ?>
          </div>
          <div class="products-info">
            <div class="name">
              <?php echo $tvNames[3] ?>
            </div>
            <div class="specs">
              <span>Specs</span>
              <div class="description">
                <?php echo " <br>";
                setTvDescription(3); ?>
              </div>
            </div>
            <div class="cost-and-former-cost">
              <div class="cost">Cost:
                <?php echo "$tvPrice[3]Br."; ?>
              </div>

            </div>
            <div class="add-to-cart-div">
              <form action="" method="post">
                <input type="hidden" name="productImage" value="<?php echo $tvImage_data[3]; ?>">
                <input type="hidden" name="productName" value="<?php echo $tvNames[3]; ?>">
                <input type="hidden" name="productPrice" value="<?php echo $tvPrice[3]; ?>">
                <input class="add-to-cart-button" type="submit" value="Add to Cart" name="addToCart">
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- /homepage-html -->

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
          <li><i class="fa fa-phone"></i> Call: +251-9-41-46-01-05</li>
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
</body>

</html>