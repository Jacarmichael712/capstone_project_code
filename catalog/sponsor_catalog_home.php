<?php include "../../../inc/dbinfo.inc"; ?>
<?php
  session_start();
  if(!$_SESSION['login'] || strcmp($_SESSION['account_type'], "driver") == 0) {
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
  text-align: center;
  /*font-size: 1.25em;*/
  font-size: 1.25vmax;
  color: #0A1247;
 /* margin-left: 2.5%;*/
}

p {
  font-family: "Monaco", monospace;
  text-align: center;
  /*font-size: 1.25em;*/
  font-size: 1.15vmax;
  color: #0A1247;
  /*margin-left: 2.5%;*/
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
  width: 60%;
  padding: 12px 20px;
  margin: 8px 0;
  box-sizing: border-box;
}

input[type=submit] {
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
    <a href="/S24-Team05/sponsor_about_page.php">About</a>
  </div>
  <div class="dropdown">
    <button class="dropbtn">Catalog 
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
      <a href="/S24-Team05/catalog/sponsor_catalog_home.php">View Catalog</a>
      <a href="/S24-Team05/catalog/sponsor_add_to_catalog.php">Add to Catalog</a>
    </div>
  </div>
  <div class="dropdown">
    <button class="dropbtn">Audit Log 
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
      <a href="/S24-Team05/audit/logins_drivers_under_sponsor.php">Login Attempts</a>
      <a href="/S24-Team05/audit/password_changes_under_sponsor.php">Password Changes</a>
      <a href="/S24-Team05/audit/point_changes_under_sponsor.php">Point Changes</a>
      <a href="/S24-Team05/audit/email_changes_under_sponsor.php">Email Changes</a>
      <a href="/S24-Team05/audit/username_changes_under_sponsor.php">Username Changes</a>
    </div>
  </div>
  <div class="dropdown">
    <button class="dropbtn">Set Driving Behavior
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
      <a href="/S24-Team05/points/set_behavior.php">Add New Behavior</a>
      <a href="/S24-Team05/points/remove_behavior.php">Remove Behavior</a>
    </div>
  </div>
  <div class="dropdown">
    <button class="dropbtn">Create Account
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
      <a href="/S24-Team05/account/sponsor_account_creation.php">Sponsor Account</a>
    </div>
  </div>
  <div class="dropdown">
    <button class="dropbtn">Archive Accounts
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
      <a href="/S24-Team05/account/sponsor_archive_account.php">Archive Account</a>
      <a href="/S24-Team05/account/sponsor_unarchive_account.php">Unarchive Account</a>
    </div>
  </div>
  <div class="dropdown">
    <button class="dropbtn">Edit User
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
      <a href="/S24-Team05/account/sponsor_edit_driver_account.php">Edit Driver</a>
      <a href="/S24-Team05/account/sponsor_edit_sponsor_account.php">Edit Sponsor</a>
    </div>
  </div>
</div>

<body>
<div id = "flex-container-header">
    <div id = "flex-container-child">
      <h1>Catalog</h1>
   </div>
</div>

<?php
  $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
  $database = mysqli_select_db($connection, DB_DATABASE);

  $sponsor_username = $_SESSION['username'];

  // Check whether account is admin viewing as sponsor or is an actual sponsor account
  if(strcmp($_SESSION['account_type'], $_SESSION['real_account_type']) == 0) {
    $result = mysqli_query($connection, "SELECT * FROM sponsors");

    // Get the sponsor id associated with the sponsor's username
    $username = $_SESSION['username'];
    while($rows=$result->fetch_assoc()) {
        if($rows['sponsor_username'] == $username) {
            $associated_sponsor = $rows['sponsor_associated_sponsor'];
        }
    }
  } else if (strcmp($_SESSION['real_account_type'], "administrator") == 0) {
    $result = mysqli_query($connection, "SELECT * FROM administrators");
    
    // Get the sponsor id associated with the sponsor's username
    $username = $_SESSION['username'];
    while($rows=$result->fetch_assoc()) {
        if($rows['administrator_username'] == $username) {
            $associated_sponsor = $rows['administrator_associated_sponsor'];
        }
    }
  }
  
  $result = mysqli_query($connection, "SELECT * FROM catalog WHERE catalog_associated_sponsor='$associated_sponsor'");
?>
<div class = "grid-container">
  <?php
  while($rows=$result->fetch_assoc())
  {
  ?>
    <div class = "item">
    <?php

      $item_name = $rows['catalog_item_name'];
      $artist_name = $rows['catalog_item_artist'];
      $item_price = $rows['catalog_item_point_cost'];
      $item_release_date = $rows['catalog_item_release_date'];
      $rating = $rows['catalog_item_rating'];
      $item_type = $rows['catalog_item_type'];

      $item_image = base64_encode(file_get_contents($rows['catalog_item_image']));
      echo '<h2><img src="data:image/jpeg;base64,'.$item_image.'"></h2>';
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
      
      // Add hidden input fields for each item's details
      ?>
      <form action="http://team05sif.cpsc4911.com/S24-Team05/catalog/sponsor_buy_item_for_driver.php" method="post">
            <input type="hidden" name="item_id" value="<?= $item_id ?>">
            <input type="hidden" name="item_image" value="<?= $rows['catalog_item_image'] ?>">
            <input type="hidden" name="item_name" value="<?= $item_name ?>">
            <input type="hidden" name="item_artist" value="<?= $artist_name ?>">
            <input type="hidden" name="item_price" value="<?= $item_price ?>">
            <input type="hidden" name="item_release_date" value="<?= $item_release_date ?>">
            <input type="hidden" name="advisory_rating" value="<?= $rating ?>">
            <input type="hidden" name="item_type" value= "<?= $item_type?>">
            <input type="submit" class="link" value="Buy for Driver"/>
      </form>
      <form action="http://team05sif.cpsc4911.com/S24-Team05/catalog/sponsor_remove_item.php" method="post">
          <input type="hidden" name="catalog_id" value="<?= $rows['catalog_id'] ?>">
          <input type="submit" class="link" value="Remove"/>
      </form>
    </div>
    <?php
  }
  ?>
</div>

</body>

</html>