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
  color: #FEF9E6
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
  margin-top: 2.5%;
  background-color: #ff5e6c;
}

#flex-container-child {
  display: flex;
  justify-content: center;
  align-items: center;
  /*padding: 1.5%;*/
  margin-left: 2%
}

form {
  text-align: center;
  margin: 20px 20px;
}

input[type=text], input[type=password] {
  width: 30%;
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
  margin-bottom: 3%
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

table {
  margin-left: auto;
  margin-right: auto;
}

td {
  text-align: center;
  width:400px;
  font-family: "Monaco", monospace;
  padding: 12px 20px;
  margin: 8px 0;
  font-size: 1.25vmax;
  border: 1px solid;
}

tr:nth-child(even) {
  background-color: #effad9;
  text-align: center;
  width:400px;
  font-family: "Monaco", monospace;
  padding: 12px 20px;
  margin: 8px 0;
  font-size: 1.25vmax;
}

.div_before_table {
    overflow:hidden;
    overflow-y: scroll;
    overscroll-behavior: none;
    height: 500px;
    width: 1200px;
    margin-top: 0.5%;
    margin-bottom: 2.5%;
    margin-left: auto;
    margin-right: auto;
    border: 4px solid;
    border-color: #ff5e6c;
}

.sticky {
  position: sticky;
  top: 0;
}

th {
  background-color: #ff5e6c;
  width:400px;
  font-family: "Monaco", monospace;
  padding: 12px 20px;
  margin: 8px 0;
  font-size: 1.25vmax;
  border: 2px solid;
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

<body>

<?php
    $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
    $database = mysqli_select_db($connection, DB_DATABASE);
?>

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

<div id = "flex-container-header">
    <div id = "flex-container-child">
      <h1>Review</h1>
      <h1><?= $_POST['driver_first_name']?></h1>
      <h1><?= $_POST['driver_last_name']?>'s</h1>
      <h1>Application</h1>
   </div>
</div>

<div class="div_before_table">
<table id="myTable2">
    <tr>
        <th class="sticky">Driver Name</th>
        <th class="sticky">Driver Profile Picture</th>
        <th class="sticky">Driver Username</th>
        <th class="sticky">Application Status</th>
        <th class="sticky">Application Date</th>
        <th class="sticky">Driver Comments</th>
    </tr>
    <!-- PHP CODE TO FETCH DATA FROM ROWS -->
    <?php 
    ?>
    <?php
        //var_dump(file_exists("/var/www/html/S24-Team05/images/profilepictures/dntran_profile_picture.png"));
        if(file_exists("/var/www/html/S24-Team05/images/profilepictures/".$_POST['driver_username']."_profile_picture.png")) {
            $picturepath = "/S24-Team05/images/profilepictures/".$_POST['driver_username']."_profile_picture.png";
        } else {
            $picturepath = "/S24-Team05/images/Logo.png";
        }
    ?>
    <tr>
        <!-- FETCHING DATA FROM EACH
            ROW OF EVERY COLUMN -->
        <td><?php echo $_POST['driver_first_name'] . " " . $_POST['driver_last_name'];?></td>
        <td><img src =<?php echo $picturepath?>></td>
        <td><?php echo $_POST['driver_username'];?></td>
        <td><?php echo $_POST['application_status'];?></td>
        <td><?php echo $_POST['application_date'];?></td>
        <?php 
          $appId = $_POST['application_id'];
          $commentQuery = mysqli_query($connection, "SELECT * FROM applications WHERE application_id = $appId");
          while($rows=$commentQuery->fetch_assoc())
          {
        ?>
        <td><?php echo $rows['application_comments'];?></td>
        <?php 
          } 
        ?>
    </tr>
</table>
        </div>
<?php
if($_POST['application_status'] != "Accepted" && $_POST['application_status'] != "Rejected" && $_POST['application_status'] != "Revoked") { 
?>
  <form action="http://team05sif.cpsc4911.com/S24-Team05/application/accept_application.php" method="post">
      <input type="hidden" name="account_id" value="<?= $_POST['account_id'] ?>">
      <input type="hidden" name="driver_username" value="<?= $_POST['driver_username'] ?>">
      <input type="hidden" name="organization_name" value="<?= $_POST['organization_name'] ?>">
      <input type="hidden" name="organization_id" value="<?= $_POST['organization_id'] ?>">
      <input type="hidden" name="application_id" value="<?= $_POST['application_id'] ?>">
      <input type="hidden" id="account_type" name="account_type" value="driver">

      <p><label for="reason">Reason For Acceptance:</label><br>
      <input type="text" id="reason" name="reason" placeholder="Why are you accepting this driver's application?" required><br></p>

      <input type="submit" class="remove" value="Accept"/>
  </form>
  <form action="http://team05sif.cpsc4911.com/S24-Team05/application/reject_application.php" method="post">
      <input type="hidden" name="account_id" value="<?= $_POST['account_id'] ?>">
      <input type="hidden" name="driver_username" value="<?= $_POST['driver_username'] ?>">
      <input type="hidden" name="organization_name" value="<?= $_POST['organization_name'] ?>">
      <input type="hidden" name="organization_id" value="<?= $_POST['organization_id'] ?>">
      <input type="hidden" name="application_id" value="<?= $_POST['application_id'] ?>">
      <input type="hidden" id="account_type" name="account_type" value="driver">

      <p><label for="reason">Reason For Rejection:</label><br>
      <input type="text" id="reason" name="reason" placeholder="Why are you rejecting this driver's application?" required><br></p>

      <input type="submit" class="remove" value="Reject"/>
  </form>
<?php
} elseif ( $_POST['application_status'] === "Accepted") { ?>
  <form action="http://team05sif.cpsc4911.com/S24-Team05/application/revoke_application.php" method="post">
      <input type="hidden" name="account_id" value="<?= $_POST['account_id'] ?>">
      <input type="hidden" name="driver_username" value="<?= $_POST['driver_username'] ?>">
      <input type="hidden" name="organization_name" value="<?= $_POST['organization_name'] ?>">
      <input type="hidden" name="organization_id" value="<?= $_POST['organization_id'] ?>">
      <input type="hidden" name="application_id" value="<?= $_POST['application_id'] ?>">
      <input type="hidden" id="account_type" name="account_type" value="driver">
      <p><label for="reason">Reason For Revoking:</label><br>
      <input type="text" id="reason" name="reason" placeholder="Why are you revoking this driver's application?" required><br></p>
      <input type="submit" class="remove" value="Revoke"/>
  </form>

<?php
}
?>
 
<!-- Clean up. -->
<?php
        mysqli_free_result($result);
        mysqli_close($connection);
?>
</body>
</html>