<?php include "../../../inc/dbinfo.inc"; ?>
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
  text-align: left;
  margin: 20px 75px;
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
    <a href="/S24-Team05/about_page.php">About</a>
    <a href="/S24-Team05/catalog/catalog_home.php">Catalog</a>
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
    session_start();
    $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
    $database = mysqli_select_db($connection, DB_DATABASE);

    $image_data = $_POST['item_image'];
    $item_id = $_POST['item_id'];
    $item_name = $_POST['item_name'];
    $item_artist = $_POST['item_artist'];
    $item_price = $_POST['item_price'];
    $item_release_date = $_POST['item_release_date'];
    $advisory_rating = $_POST['advisory_rating'];
    $item_type = $_POST['item_type'];

    $username = $_SESSION['username'];

    $item_image = base64_encode(file_get_contents($image_data));

    // Check whether account is admin or sponsor viewing as driver or is an actual driver account
    if(strcmp($_SESSION['account_type'], $_SESSION['real_account_type']) == 0) {
      // Check if user has enough points for item
      $driver_query = mysqli_query($connection, "SELECT * FROM drivers");
      while($rows=$driver_query->fetch_assoc()) {
        if($rows['driver_username'] == $username) {
          $driver_address = $rows['driver_address'];
          $driver_points = $rows['driver_points'];
        }
      }

    } else if (strcmp($_SESSION['real_account_type'], "administrator") == 0) {
      // Check if user has enough points for item
      $driver_query = mysqli_query($connection, "SELECT * FROM administrators");
      while($rows=$driver_query->fetch_assoc()) {
        if($rows['administrator_username'] == $username) {
          $driver_address = $rows['administrator_address'];
          $driver_points = $rows['administrator_points'];
        }
      }  
    } else {
      $driver_query = mysqli_query($connection, "SELECT * FROM sponsors");
      while($rows=$driver_query->fetch_assoc()) {
        if($rows['sponsor_username'] == $username) {
          $driver_address = $rows['sponsor_address'];
          $driver_points = $rows['sponsor_points'];
        }
      }
    }

    $updated_point_preview = $driver_points - $item_price;
?>
<div class = "grid-container">
    <div class = "item">
    <?php
      echo '<p><img src="data:image/jpeg;base64,'.$item_image.'"></p>';
      if($item_type == "album") {
          echo "<p>Album Name: $item_name</p>";
          echo "<p>Artist Name: $item_artist</p>";
          echo "<p>Album Point Cost: $item_price</p>";
      } else if ($item_type == "movie") {
          echo "<p>Movie Name: $item_name</p>";
          echo "<p>Director: $artist_name</p>";
          echo "<p>Movie Point Cost: $item_price</p>";
      }
      echo "<p>Release Date: $item_release_date</p>";
      if($advisory_rating != NULL) {
          echo "<p>Content Advisory Rating: $advisory_rating</p>";
      }
    ?>
    </div>
    <div class = "item">
    <?php 
        echo "<h2>You currently have $driver_points points.</h2>";
        if($updated_point_preview < 0) {
          echo "<h2>You do not have enought points for this item.</h2>";

          if(strcmp($_SESSION['real_account_type'], "administrator") == 0) {
            echo "<h2>As an admin, you are not able to purchase from the catalog.</h2>";
          } else if(strcmp($_SESSION['real_account_type'], "sponsor") == 0) {
            echo "<h2>As a sponsor, you are not able to purchase from the catalog.</h2>";
          }
        } else if(strcmp($_SESSION['real_account_type'], "administrator") == 0) {
          echo "<h2>You do have enought points for this item.</h2>";
          echo "<h2>However, as an admin, you are not able to purchase from the catalog.</h2>";
        
        } else if(strcmp($_SESSION['real_account_type'], "sponsor") == 0) {
          echo "<h2>You do have enought points for this item.</h2>";
          echo "<h2>However, as a sponsor, you are not able to purchase from the catalog.</h2>";
          
        } else {
          echo "<h2>After ordering, you will have $updated_point_preview points.</h2>";
          echo "<h2>Item will be shipped to $driver_address.</h2>";

          ?>
          <form action="http://team05sif.cpsc4911.com/S24-Team05/catalog/submit_buy_now.php" method="post">
            <input type="hidden" name="item_id" value="<?= $item_id?>">
            <input type="hidden" name="current_item_price" value="<?= $item_price ?>">
            <input type="hidden" name="current_item_name" value="<?= $item_name ?>">
            <input type="hidden" name="current_item_image" value="<?= $image_data ?>">
            <input type="hidden" name="current_item_release_date" value="<?= $item_release_date ?>">
            <input type="hidden" name="current_item_rating" value="<?= $advisory_rating ?>">
            <input type="hidden" name="current_item_type" value="<?= $item_type ?>">
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