<?php include "../../../inc/dbinfo.inc"; 
session_start();
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
  color: #FEF9E6
}

p {
  font-family: "Monaco", monospace;
  /*font-size: 1.25em;*/
  font-size: 1vmax;
  color: black;
}

select {
  width: 60%;
  height: 3%;
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
  margin: 20px 20px;
}

input[type=text] {
  width: 60%;
  padding: 12px 20px;
  margin: 8px 0;
  box-sizing: border-box;
}

textarea {
  width: 60%;
  height: 30%;
  padding: 12px 20px;
  margin: 8px 0;
  font-family: Arial;
  box-sizing: border-box;
  resize: none;
}

input[type=password] {
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

<title>Driver Sponsor Application</title>
<body>

<?php
  $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
  $database = mysqli_select_db($connection, DB_DATABASE);
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

<div id = "flex-container-header">
    <div id = "flex-container-child">
      <h1>Driver</h1>
      <h1>Sponsor</h1>
      <h1>Application</h1>
    </div>
  </div>

<!-- Get User Input -->
<?php

  $query = mysqli_query($connection, "SELECT * FROM organizations WHERE organization_archived=0");
?>
<form action="submit_driver_apply.php" method="POST">

  <label for="listsponsors"><p>Sponsor you are applying to:</label><br>
  <select name="listsponsors" id="listsponsors">
    <?php
      while($rows=$query->fetch_assoc()) {
        echo "<option>" . $rows['organization_username'] . "</option>";
      }
    ?>
  </select><br></p>

  <label for="comments"><p>Comments:</label><br>
  <textarea id="comments" name="comments" placeholder="Anything else we should know or other comments..."></textarea>

  <input type="submit" value="Submit"><br></p>
</form> 

<!-- Clean up. -->
<?php
        mysqli_free_result($result);
        mysqli_close($connection);
?>

</body>
</html>
 
