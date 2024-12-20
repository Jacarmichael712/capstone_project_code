<?php include "../../../inc/dbinfo.inc"; ?>

<?php
        session_start();
        if(!$_SESSION['login'] && strcmp($_SESSION['account_type'], "driver") != 0) {
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

p {
  font-family: "Monaco", monospace;
  /*font-size: 1.25em;*/
  font-size: 1.25vmax;
  color: #FF0000;
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
  width: 60%;
  padding: 12px 20px;
  margin: 8px 0;
  box-sizing: border-box;
  background-color: #F2E6B7;
  font-family: "Monaco", monospace;
  align: center;
}

input[type=submit]:hover {
  background-color: #F1E8C9;
  cursor: pointer;
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
<?php
  $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
  if (mysqli_connect_errno()) {  
      echo "Database connection failed.";  
  } 

  // Get curr sponsor. If curr sponsor is "none" restrict access to certain buttons
  $account_id = $_SESSION['user_data'][$_SESSION['real_account_type'] . '_id'];
  $sponsor_name_query = mysqli_query($connection, "SELECT * FROM " . $_SESSION['real_account_type'] . "s WHERE ". $_SESSION['real_account_type'] ."_id='$account_id'");

  while($rows=$sponsor_name_query->fetch_assoc()) {
      $curr_sponsor = $rows[$_SESSION['real_account_type'] . '_associated_sponsor'];
  }
  
?>
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
  <?php if($curr_sponsor != "none") {?>
    <div class="dropdown" style = "float: right; background-color: #F2E6B7;">
      <button class="dropbtn">Switch Sponsor
        <i class="fa fa-caret-down"></i>
      </button>
      <div class="dropdown-content">
        <?php
          $username = $_SESSION['username'];
          $driver_id = 0;
          $assoc_spons_query = 0;
          $sponsor_id = 0;
          $spons_id_query = 0;
          if(strcmp($_SESSION['real_account_type'], "driver") == 0) {
            $driver_id = mysqli_query($connection, "SELECT driver_id FROM drivers WHERE driver_username='$username' AND driver_archived=0");
            $driver_id = ($driver_id->fetch_assoc())['driver_id'];

            $assoc_spons_query = mysqli_query($connection, "SELECT * FROM driver_sponsor_assoc WHERE driver_id=$driver_id AND driver_sponsor_assoc_archived=0");
          } else if(strcmp($_SESSION['real_account_type'], "sponsor") == 0) {
            $assoc_spons_query = mysqli_query($connection, "SELECT * FROM organizations JOIN sponsors ON sponsors.sponsor_associated_sponsor=organizations.organization_username WHERE sponsor_username='$username' AND organization_archived=0");
          } else if(strcmp($_SESSION['real_account_type'], "administrator") == 0) {
            $assoc_spons_query = mysqli_query($connection, "SELECT * FROM organizations JOIN administrators ON administrators.administrator_associated_sponsor=organizations.organization_username WHERE administrator_username='$username' AND organization_archived=0");
          }

          while($row = $assoc_spons_query->fetch_assoc()){
            if(strcmp($_SESSION['real_account_type'], "driver") == 0){
              $sponsor_id = $row['assoc_sponsor_id'];
              $sponsor_name = mysqli_query($connection, "SELECT organization_username FROM organizations WHERE organization_id=$sponsor_id");
              $sponsor_name = ($sponsor_name->fetch_assoc())['organization_username'];
            } else {
              $sponsor_id = $row['organization_id'];
              $sponsor_name = mysqli_query($connection, "SELECT organization_username FROM organizations WHERE organization_id=$sponsor_id");
              $sponsor_name = ($sponsor_name->fetch_assoc())['organization_username'];
            }

            echo("<form action='http://team05sif.cpsc4911.com/S24-Team05/account/switch_sponsor.php' method='post'>
              <input type='hidden' name='driver_id' value='$driver_id'/>
              <input type='hidden' name='sponsor_id' value='$sponsor_id'/>
              <input type='hidden' name='sponsor_name' value='$sponsor_name'/>
              <input type='submit' class='link' value='$sponsor_name'/>
              </form>");
          }
        ?>
      </div>
    </div>
  <?php } ?>
</div>
<body>



<div id = "flex-container-header">
    <div id = "flex-container-child">
      <h1>Welcome</h1>
      <h1>Driver!</h1>
   </div>
</div>

<form action="http://team05sif.cpsc4911.com/S24-Team05/application/driver_view_applications.php">
  <input type="submit" class="link" value="View Applications" />
</form>

<?php if($curr_sponsor != "none") {?>
  <form action="http://team05sif.cpsc4911.com/S24-Team05/points/view_ways_to_gain_points.php">
    <input type="submit" class="link" value="How To Gain Points" />
  </form>

  <form action="http://team05sif.cpsc4911.com/S24-Team05/points/view_ways_to_lose_points.php">
    <input type="submit" class="link" value="How To Lose Points" />
  </form>

  <form action="http://team05sif.cpsc4911.com/S24-Team05/points/view_point_status.php">
    <input type="submit" class="link" value="Review Point Status" />
  </form>

  <form action="http://team05sif.cpsc4911.com/S24-Team05/points/point_history.php">
    <input type="submit" class="link" value="View Point History" />
  </form>
<?php } ?>

<form action="http://team05sif.cpsc4911.com/S24-Team05/application/driver_apply.php">
  <input type="submit" class="link" value="Apply To A Sponsor" />
</form>

</body>

</html>