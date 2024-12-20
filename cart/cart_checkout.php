<?php include "../../../inc/dbinfo.inc"; ?>
<?php session_start();?>
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
    text-align: left;
    /*font-size: 1.25em;*/
    font-size: 1.25vmax;
    color: #0A1247;
    margin-left: 10%;
}

p {
  font-family: "Monaco", monospace;
  text-align: center;
  /*font-size: 1.25em;*/
  font-size: 1.25vmax;
  color: #0A1247;
  margin-left: 10%
}

#flex-container-header {
  display: flex;
  flex: 1;
  justify-content: stretch;
  margin-top: 2.5%;
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
  grid-template-columns: 30% 48%;
  gap: 30px;
  background-color: #fff5d1;
  padding: 10px;
}

.grid-container > div {
  background-color: #fff5d1/*FEF9E6*/;
  text-align: center;
  padding: 20px 0;
  font-size: 30px;
}

form {
  text-align: center;
}

input[type=text], input[type=password] {
  width: 60%;
  padding: 12px 20px;
  margin: 8px 0;
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
  margin-bottom: -2.5%;
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
;
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
      <h1>Confirm</h1>
      <h1>Order</h1>
   </div>
</div>

<body>

<?php
    $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
    $database = mysqli_select_db($connection, DB_DATABASE);

    $username = $_SESSION['username'];

    // Check if user has enough points for item
    $driver_query = mysqli_query($connection, "SELECT * FROM drivers");
    while($rows=$driver_query->fetch_assoc()) {
      if($rows['driver_username'] == $username) {
        $driver_address = $rows['driver_address'];
        $driver_points = $rows['driver_points'];
      }
    }

    $cart_price = $_POST['cart_price'];
    $num_items = $_POST['cart_items_num'];
    $itemInfo = $_SESSION['cart_item_info'];
    $updated_point_preview = $driver_points - $cart_price;
?>
<div class = "grid-container">
    <div class = "item">
    <?php 
        echo "<h2>You currently have $driver_points points.</h2>";
        if($updated_point_preview < 0) {
          echo "<h2>You do not have enough points to checkout your entire cart.</h2>";
          
        } else {
          echo "<h2>Your entire cart will cost $cart_price points.</h2>";
          echo "<h2>After checking out, you will have $updated_point_preview points.</h2>";
          echo "<h2>Items will be shipped to $driver_address.</h2>";
          ?>
          <form action="http://team05sif.cpsc4911.com/S24-Team05/cart/submit_cart_checkout.php" method="post">
            <input type="hidden" name="cart_price" value="<?= $cart_price ?>">
            <input type="hidden" name="cart_items_num" value="<?= $num_items ?>">
            <input type="hidden" name="item_info" value="<?= $itemInfo ?>">
            <input type="submit" class="link" value="Confirm" />
          </form>
          <?php
        }
        
    ?>
        
    <form action="http://team05sif.cpsc4911.com/S24-Team05/catalog/catalog_home.php">
      <input type="submit" class="link" value="Cancel" />
    </form>

    </div>
</div>

</body>
</html>