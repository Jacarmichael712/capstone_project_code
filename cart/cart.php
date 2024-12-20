<?php include "../../../inc/dbinfo.inc"; ?>
<?php
    session_start();
    if(!$_SESSION['login'] != 0) {
        echo "Invalid page.<br>";
        echo "Redirecting.....";
        sleep(2);
        header( "Location: http://team05sif.cpsc4911.com/", true, 303);
        exit();
        //unset($_SESSION['login']);
    }
?>
<html>

<head>
<style type="text/css">
body {
  background-color: #fff5d1;
  margin: 0;
  padding: 0;
  height: auto;
  width: auto;
}

h1 {
  text-align: left;
  margin-left: 5%;
  margin-top: 15%;
  font-family: "Monaco", monospace;
  /*font-size: 3em;*/
  font-size: 2.5vmax;
  color: #FEF9E6;
}

h2 {
    font-family: "Monaco", monospace;
    text-align: middle;
    /*font-size: 1.25em;*/
    font-size: 1.25vmax;
    color: #0A1247;
    margin-left: 33%;
}

p {
  font-family: "Monaco", monospace;
  /*font-size: 1.25em;*/
  font-size: 1.25vmax;
  color: #0A1247;
}

#flex-container-header {
  display: flex;
  flex: 1;
  justify-content: stretch;
  margin-top: 3.5%;
  background-color: #ff5e6c;
}

#flex-container-child {
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 1.5%;
  margin-left: 2%
}

.grid-container {
  display: grid;
  grid-template-columns: 32% 32% 32%;
  gap: 30px;
  background-color: #fff5d1;
  padding: 10px;
}

.grid-container > div {
  background-color: #FEF9E6;
  text-align: center;
  padding: 20px 0;
  font-size: 30px;
}

form {
  text-align: center;
  margin: 20px 20px;
}

input[type=text], input[type=password] {
  width: 90%;
  padding: 12px 20px;
  margin: 8px 8px;
  box-sizing: border-box;
}

input[type=submit] {
  width: 30%;
  padding: 12px 20px;
  background-color: #F2E6B7;
  font-family: "Monaco", monospace;
  font-size: 1.25vmax;
}

input[type=submit]:hover {
  background-color: #F1E8C9;
}

#hyperlink-wrapper {
  text-align: center;
  margin-top: 20px;
}

#hyperlink {
  text-align: center;
  justify-content: center;
  font-family: "Monaco", monospace;
  font-size: 1.25vmax;
  margin-top: 10px;
}

.navbar {
  overflow: hidden;
  background-color: #FEF9E6;
  font-family: "Monaco", monospace;
  margin-bottom: -3.5%;
}

.navbar a {
  float: left;
  font-size: 16px;
  font-family: "Monaco", monospace;
  color: white;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
}

.dropdown {
  float: left;
  overflow: hidden;
}

.dropdown .dropbtn {
  font-size: 16px;  
  border: none;
  outline: none;
  color: black;
  padding: 14px 16px;
  background-color: inherit;
  font-family: inherit;
  margin: 0;
}

.navbar a:hover, .dropdown:hover .dropbtn {
  background-color: #fff5d1;
}

.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f9f9f9;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

.dropdown-content a {
  float: none;
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
  text-align: left;
}

.dropdown-content a:hover {
  background-color: #ddd;
}

.dropdown:hover .dropdown-content {
  display: block;
}

.menu { 
  float: none;
  color: black;
  font-size: 16px;
  margin: 0;
  text-decoration: none;
  display: block;
  text-align: left;
} 
.menu a{ 
  float: left;
  overflow: hidden;
  font-size: 16px;  
  border: none;
  outline: none;
  color: black;
  padding: 12px 16px;
  background-color: inherit;
  font-family: inherit;
  margin: 0;
} 

.point_info {
  font-size: 16px;
  color: black;
  font-family: monospace;
  margin: 0;
  position: absolute; 
  top: 3px; 
  right: 10px;
}
ul {
  list-style-type: none;
  margin: 0;
  padding: 0;
  width: 160px;
}

.link, .search{
  cursor:pointer
}

input.search {
  background-color: #F2E6B7;
  font-family: "Monaco", monospace;
  font-size: 0.8vmax;
  width: 90%;
  height: 5%;
  padding: 0px 0px;
  margin: 0px 8px;
}
</style>
</head>

<div class="navbar">
    <div class="menu">
      <a href="/S24-Team05/account/homepageredirect.php">Home</a>
      <a href="/S24-Team05/account/profileuserinfo.php">Profile</a>
      <a href="/S24-Team05/account/logout.php">Logout</a>
      <a href="/S24-Team05/driver_about_page.php">About</a>
      <?php if($curr_sponsor != "none") {?> <a href="/S24-Team05/catalog/catalog_home.php">Catalog</a> <?php } ?>
      <?php if($curr_sponsor != "none") {?> <a href="/S24-Team05/order/order_history.php">Orders</a> <?php } ?>
    </div>
</div>

<body>

<div id = "flex-container-header">
    <div id = "flex-container-child">
      <h1>Cart</h1>
   </div>
</div>

<div class="point_info">
    <body>
    Your Points: 
    <?php 
        $username = $_SESSION['user_data'][$_SESSION['real_account_type']."_username"];

        ini_set('display_errors',1);
        error_reporting(E_ALL);
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    
        $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
        $database = mysqli_select_db($connection, DB_DATABASE);

        // Check whether account is admin viewing as driver or is an actual driver account
        if(strcmp($_SESSION['account_type'], $_SESSION['real_account_type']) == 0) {
          $driverResults = mysqli_query($connection, "SELECT * FROM drivers WHERE driver_username = '$username'");
          $driverResults = $driverResults->fetch_assoc();
          $driverID = $driverResults['driver_id'];
          $sponsorName = $driverResults['driver_associated_sponsor'];

          $sponsorID = mysqli_query($connection, "SELECT * FROM organizations WHERE organization_username='$sponsorName'");
          $sponsorID = $sponsorID->fetch_assoc();
          $sponsorID = $sponsorID['organization_id'];

          $cartResults = mysqli_query($connection, "SELECT * FROM driver_sponsor_assoc_cart WHERE driver_id = '$driverID' AND assoc_sponsor_id=$sponsorID");
          $driverTotalPoints = mysqli_query($connection, "SELECT * FROM drivers WHERE driver_id = '$driverID'");

        } else if (strcmp($_SESSION['real_account_type'], "administrator") == 0) {
          $driverResults = mysqli_query($connection, "SELECT * FROM administrators WHERE administrator_username = '$username'");
          $driverResults = $driverResults->fetch_assoc();
          $driverID = $driverResults['administrator_id'];

          $cartResults = mysqli_query($connection, "SELECT * FROM driver_sponsor_assoc_cart WHERE driver_id = '$driverID'");
          $driverTotalPoints = mysqli_query($connection, "SELECT * FROM administrators WHERE administrator_id = '$driverID'");
            
        } else if (strcmp($_SESSION['real_account_type'], "sponsor") == 0) {
          $driverResults = mysqli_query($connection, "SELECT * FROM sponsors WHERE sponsor_username = '$username'");
          $driverResults = $driverResults->fetch_assoc();
          $driverID = $driverResults['sponsor_id'];

          $cartResults = mysqli_query($connection, "SELECT * FROM driver_sponsor_assoc_cart WHERE driver_id = '$driverID'");
          $driverTotalPoints = mysqli_query($connection, "SELECT * FROM sponsors WHERE sponsor_id = '$driverID'");
        }
        $cart_total_points = 0;
        $cart_num_items = 0;
        $itemInfo = "";
    
        while($rows = $driverTotalPoints->fetch_assoc()){
          echo $rows[$_SESSION['real_account_type'] . '_points'];
        }
    ?>
    <br>
    Cart Point Total:
    <?php
      $rows = $cartResults->fetch_assoc();
      while(1){
        if($rows == null){
          $cart_total_points = 0;
        }
        else{
          $cart_total_points = $rows['assoc_cart_point_total']; 
        }
        
        echo $cart_total_points;
        break;
      }
    ?>
    <br>
    <?php
      while(1){
        if($rows == null){
          $cart_num_items = 0;
        }
        else{
          $cart_num_items = $rows['assoc_cart_num_items']; 
        }

        break;
      }
    ?>
    <br>
</div>

<div class = "grid-container">
  <?php
    $username = $_SESSION['user_data'][$_SESSION['real_account_type']."_username"];

    ini_set('display_errors',1);
    error_reporting(E_ALL);
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
    $database = mysqli_select_db($connection, DB_DATABASE);

    // Check whether account is admin viewing as driver or is an actual driver account
    if(strcmp($_SESSION['account_type'], $_SESSION['real_account_type']) == 0) {
      $driverResults = mysqli_query($connection, "SELECT * FROM drivers WHERE driver_username = '$username'");
      $driverResults = $driverResults->fetch_assoc();
      $driverID = $driverResults['driver_id'];
      $sponsorName = $driverResults['driver_associated_sponsor'];

      $sponsorID = mysqli_query($connection, "SELECT * FROM organizations WHERE organization_username='$sponsorName'");
      $sponsorID = $sponsorID->fetch_assoc();
      $sponsorID = $sponsorID['organization_id'];

      $cartResults = mysqli_query($connection, "SELECT * FROM driver_sponsor_assoc_cart WHERE driver_id = '$driverID' AND assoc_sponsor_id=$sponsorID");

    } else if (strcmp($_SESSION['real_account_type'], "administrator") == 0) {
      $driverIDResult = mysqli_query($connection, "SELECT * FROM administrators WHERE administrator_username = '$username'");
      $driverID = $driverIDResult->fetch_assoc();
      $driverID = $driverID['administrator_id'];
      $cartResults = mysqli_query($connection, "SELECT * FROM driver_sponsor_assoc_cart WHERE driver_id = '$driverID'");
        
    } else if (strcmp($_SESSION['real_account_type'], "sponsor") == 0) {
      $driverIDResult = mysqli_query($connection, "SELECT * FROM sponsors WHERE sponsor_username = '$username'");
      $driverID = $driverIDResult->fetch_assoc();
      $driverID = $driverID['sponsor_id'];
      $cartResults = mysqli_query($connection, "SELECT * FROM driver_sponsor_assoc_cart WHERE driver_id = '$driverID'");
    }

    while($rows = $cartResults->fetch_assoc()){
  ?>
        <?php
        if($rows['assoc_cart_num_items'] == 0){
          break;
        }
        $itemInfo = trim($rows['assoc_cart_items'], '[]');
        $itemInfo = explode("][", $itemInfo);
        $_SESSION['cart_item_info'] = $itemInfo;
        for($i = 0; $i < count($itemInfo); $i++){
          ?>
          <div class = "item">
          <?php
          $itemInfo[$i] = str_replace('"', '', $itemInfo[$i]);
          $individualItemInfo = explode(",", $itemInfo[$i]);

          $item_name = $individualItemInfo[1];
          $artist_name = $individualItemInfo[2];
          $item_price = $individualItemInfo[3];
          $item_release_date = $individualItemInfo[4];
          $rating = $individualItemInfo[5];
          $item_type = $individualItemInfo[6];

          $item_image_url = str_replace('\\', '', $individualItemInfo[0]);
          $item_image = base64_encode(file_get_contents($item_image_url));

          echo '<p><img src="data:image/jpeg;base64,'.$item_image.'"></p>';
          if($item_type == "album") {
              echo "<p>Album Name: $item_name</p>";
              echo "<p>Artist Name: $artist_name</p>";
              echo "<p>Album Point Cost: $item_price</p>";
          } else if ($item_type == "movie") {
              echo "<p>Movie Name: $item_name</p>";
              echo "<p>Director: $artist_name</p>";
              echo "<p>Movie Point Cost: $item_price</p>";
          }
          echo "<p>Release Date: $item_release_date</p>";
          if($rating != NULL) {
              echo "<p>Content Advisory Rating: $rating</p>";
          }
          ?>
          
          <form action="http://team05sif.cpsc4911.com/S24-Team05/cart/remove_from_cart.php" method="post">
              <input type="hidden" name="item_image" value="<?= $item_image_url ?>">
              <input type="hidden" name="item_name" value="<?= $item_name ?>">
              <input type="hidden" name="item_artist" value="<?= $artist_name ?>">
              <input type="hidden" name="item_price" value="<?= $item_price ?>">
              <input type="hidden" name="item_release_date" value="<?= $item_release_date ?>">
              <input type="hidden" name="advisory_rating" value="<?= $rating ?>">
              <input type="hidden" name="item_type" value= "<?= $item_type?>">
              <input type="submit" class="link" value="Remove"/>
          </form>
          </div>
        <?php
        }
    }
  ?>
</div>
<?php if($cart_num_items != 0 && strcmp($_SESSION['account_type'], $_SESSION['real_account_type']) == 0) { ?>

  <form action="http://team05sif.cpsc4911.com/S24-Team05/cart/cart_checkout.php" method="post">
            <input type="hidden" name="cart_price" value="<?= $cart_total_points ?>">
            <input type="hidden" name="cart_items_num" value="<?= $cart_num_items ?>">
            <input type="hidden" name="item_info" value="<?= $itemInfo ?>">
            <?php
            if($cart_num_items == 1 ) {
              ?>
              <input type="submit" class="link" value="<?= "Checkout {$cart_num_items} Item"?>"/>
              <?php
            } else {
              ?>
              <input type="submit" class="link" value="<?= "Checkout {$cart_num_items} Items"?>"/>
              <?php
            }
          }
          ?>

            
<?php
if(strcmp($_SESSION['real_account_type'], "administrator") == 0) {
    echo "<h2> As an admin, you are unable to checkout your cart.</h2>";
    ?>
    <form action="http://team05sif.cpsc4911.com/S24-Team05/catalog/catalog_home.php">
      <input type="submit" class="link" value="Cancel" />
    </form>
    <?php
} 
else if(strcmp($_SESSION['real_account_type'], "sponsor") == 0) {
    echo "<h2> As a sponsor, you are unable to checkout your cart.</h2>";
    ?>
    <form action="http://team05sif.cpsc4911.com/S24-Team05/catalog/catalog_home.php">
      <input type="submit" class="link" value="Cancel" />
    </form>
    <?php
} 
?>

<!-- Clean up. -->
<?php
        mysqli_close($connection);
?>

</body>
</html>