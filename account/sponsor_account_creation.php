<?php include "../../../inc/dbinfo.inc"; 
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
  font-size: 1vmax;
  color: black;
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

input[type=password] {
  width: 60%;
  padding: 12px 20px;
  margin: 8px 0;
  box-sizing: border-box;
}

input[type=submit] {
  width: 60%;
  padding: 12px 20px;
  background-color: #F2E6B7;
  font-family: "Monaco", monospace;
  font-size: 1.25vmax;
}

input[type=submit]:hover {
  background-color: #F1E8C9;
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

<title>Sponsor Account Creation</title>
<body>

<?php
  if(strcmp($_SESSION['account_type'], "administrator") == 0) {
    ?>
    <div class="navbar">
    <div class="menu">
      <a href="/S24-Team05/account/homepageredirect.php">Home</a>
      <a href="/S24-Team05/account/profileuserinfo.php">Profile</a>
      <a href="/S24-Team05/account/logout.php">Logout</a>
      <a href="/S24-Team05/admin_about_page.php">About</a>
    </div>
    <div class="dropdown">
      <button class="dropbtn">Audit Log 
        <i class="fa fa-caret-down"></i>
      </button>
      <div class="dropdown-content">
        <a href="/S24-Team05/audit/logins.php">Login Attempts - All </a>
        <a href="/S24-Team05/audit/logins_all_drivers.php">Login Attempts - Drivers</a>
        <a href="/S24-Team05/audit/logins_all_sponsors.php">Login Attempts - Sponsors</a>
        <a href="/S24-Team05/audit/logins_all_admins.php">Login Attempts - Admins</a>
        <a href="/S24-Team05/audit/password_changes.php">Password Changes - All</a>
        <a href="/S24-Team05/audit/password_changes_all_drivers.php">Password Changes - Drivers</a>
        <a href="/S24-Team05/audit/password_changes_all_sponsors.php">Password Changes - Sponsors</a>
        <a href="/S24-Team05/audit/password_changes_all_admins.php">Password Changes - Admins</a>
        <a href="/S24-Team05/audit/point_changes_all_drivers.php">Point Changes - All Drivers</a>
        <a href="/S24-Team05/audit/email_changes.php">Email Changes - All</a>
        <a href="/S24-Team05/audit/username_changes.php">Username Changes - All</a>
      </div>
    </div>
    <div class="dropdown">
      <button class="dropbtn">Create Account
        <i class="fa fa-caret-down"></i>
      </button>
      <div class="dropdown-content">
        <a href="/S24-Team05/account/driver_account_creation.php">Driver Account</a>
        <a href="/S24-Team05/account/sponsor_account_creation.php">Sponsor Account</a>
        <a href="/S24-Team05/account/admin_account_creation.php">Admin Account</a>
      </div>
    </div>
    <div class="menu">
      <a href="/S24-Team05/account/admin_view_organizations.php">View Organizations</a>
    </div>
    <div class="dropdown">
      <button class="dropbtn">Archive Accounts
        <i class="fa fa-caret-down"></i>
      </button>
      <div class="dropdown-content">
        <a href="/S24-Team05/account/admin_archive_account.php">Archive Account</a>
        <a href="/S24-Team05/account/admin_unarchive_account.php">Unarchive Account</a>
      </div>
    </div>
    <div class="dropdown">
      <button class="dropbtn">Edit User
        <i class="fa fa-caret-down"></i>
      </button>
      <div class="dropdown-content">
        <a href="/S24-Team05/account/admin_edit_driver_account.php">Edit Driver</a>
        <a href="/S24-Team05/account/admin_edit_sponsor_account.php">Edit Sponsor</a>
        <a href="/S24-Team05/account/admin_edit_admin_account.php">Edit Admin</a>
      </div>
    </div>
    </div>
    <?php
  }
  else if(strcmp($_SESSION['account_type'], "sponsor") == 0) {
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
    <?php
  }
  else {
    ?>
    <div class="navbar">
      <div class="menu">
        <a href="/">Landing Page</a>
        <a href="/S24-Team05/account/login.php">Login</a>
        <a href="/S24-Team05/about_page.php">About</a>
      </div>
    </div>
    <?php
  }
  ?>

<div id = "flex-container-header">
    <div id = "flex-container-child">
      <h1>Sponsor</h1>
      <h1>Account</h1>
      <h1>Creation</h1>
    </div>
  </div>

<!-- Get User Input -->
<form action="sponsor_submit_account.php" method="POST">
  <label for="fname"><p>First Name:</label><br>
  <input type="text" id="fname" name="fname" placeholder="Enter your first name..." required><br></p>

  <label for="lname"><p>Last Name:</label><br>
  <input type="text" id="lname" name="lname" placeholder="Enter your last name..." required><br></p>

  <label for="username"><p>Username:</label><br>
  <input type="text" id="username" name="username" placeholder="Enter your username..." required><br></p>

  <label for="email"><p>Email Address:</label><br>
  <input type="text" id="email" name="email" placeholder="Enter your email address..." required><br></p>

  <label for="password"><p>Password:</label><br>
  <input type="password" id="password" name="password" placeholder="Enter your password..." required><br>

  <button type="button" onclick="togglePasswordVisibility()">
    <span id="toggleLabel">Show Password</span>
  </button><br></p>

  <label for="phone"><p>Phone Number:</label><br>
  <input type="text" id="phone" name="phone" placeholder="Enter your phone number..." required><br></p>

  <label for="birthday"><p>Birthday (YYYY-MM-DD):</label><br>
  <input type="text" id="birthday" name="birthday" placeholder="Enter your birthday..." required><br></p>

<?php 
  $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
  $database = mysqli_select_db($connection, DB_DATABASE);

  // Check whether account is admin viewing as sponsor or is an actual sponsor account
  if(strcmp($_SESSION['account_type'], $_SESSION['real_account_type']) == 0) {
    $result = mysqli_query($connection, "SELECT * FROM sponsors");

    // Get the sponsor id associated with the sponsor's username
    $username = $_SESSION['username'];
    while($rows=$result->fetch_assoc()) {
        if($rows['sponsor_username'] == $username) {
            $sponsor_name = $rows['sponsor_associated_sponsor'];
        }
    }
  } else if (strcmp($_SESSION['real_account_type'], "administrator") == 0) {
    $result = mysqli_query($connection, "SELECT * FROM administrators");
    
    // Get the sponsor id associated with the sponsor's username
    $username = $_SESSION['username'];
    while($rows=$result->fetch_assoc()) {
        if($rows['administrator_username'] == $username) {
            $sponsor_name = $rows['administrator_associated_sponsor'];
        }
    }
  }
?>
<?php if(strcmp($_SESSION['real_account_type'], "sponsor") == 0) { ?>
  <label for="associated_sponsor"><p>Associated Sponsor:</label><br>
  <input type="text" id="associated_sponsor" name="associated_sponsor" value="<?php echo "$sponsor_name"?>" readonly><br>
  <input type="submit" value="Submit"><br></p>
<?php } else { ?>
  <label for="associated_sponsor"><p>Associated Sponsor:</label><br>
    <select name="associated_sponsor" id="associated_sponsor">
      <?php $result=mysqli_query($connection, "SELECT * FROM organizations"); 
      while($rows=$result->fetch_assoc()) { ?>
        <option value="<?=$rows['organization_username']?>"><?=$rows['organization_username']?></option>
     <?php } ?>
    </select><br></p>
  <input style = "margin-top: 2%" type="submit" value="Submit"><br>
<?php } ?>
</form> 

<script>
function togglePasswordVisibility() {
    var passwordField = document.getElementById("password");
    var toggleLabel = document.getElementById("toggleLabel");
    
    if (passwordField.type === "password") {
        passwordField.type = "text";
        toggleLabel.textContent = "Hide Password";
    } else {
        passwordField.type = "password";
        toggleLabel.textContent = "Show Password";
    }
}
</script>

<!-- Clean up. -->
<?php
        mysqli_free_result($result);
        mysqli_close($connection);
?>

</body>
</html>