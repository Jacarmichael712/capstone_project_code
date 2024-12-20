<?php include "../../../inc/dbinfo.inc"; ?>
<?php
  session_start();
  if(!$_SESSION['login'] || strcmp($_SESSION['account_type'], "administrator") != 0) {
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
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
  <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
  <script>
        $( function() {
        $( ".datepicker" ).datepicker();
                      } );
     </script>
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
  margin: 10px 20px;
}

input[type=text] {
  width: 30%;
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
  width: 30%;
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
  padding: 14px 16px;
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

<body>
<div id = "flex-container-header">
    <div id = "flex-container-child">
      <h1>Audit</h1>
      <h1>Log</h1>
      <h1>Reports</h1>
   </div>
</div>

<?php
    $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
    $database = mysqli_select_db($connection, DB_DATABASE);

    $drivers = mysqli_query($connection, "SELECT organization_username FROM organizations WHERE organization_archived=0");
    
?>
<form action="http://team05sif.cpsc4911.com/S24-Team05/reporting/admin_generate_audit_log.php" method="POST">
  <label for="sponsor"><p>Select Sponsor:</label><br>
        <select name="sponsor" id="sponsor">
            <option value="All Sponsors">All Sponsors</option>
          <?php  while($rows=$drivers->fetch_assoc()) { ?>
            <option value="<?= $rows['organization_username'] ?>"> <?=$rows['organization_username']?></option>;
          <?php } ?>   
        </select><br></p>

  <label for="audit_type"><p>Select Audit Log Category:</label><br>
        <select name="audit_type" id="audit_type">
            <option value="Driver Applications">Driver Applications</option>
            <option value="Point Changes">Point Changes</option>
            <option value="Password Changes">Password Changes</option>
            <option value="Login Attempts">Login Attempts</option>  
        </select><br></p>
  <label for="start_date"><p>Starting Date:</label><br>
  <input type="text" name="start_date" class="datepicker"><br></p>
  <label for="end_date"><p>Ending Date:</label><br>
  <input type="text" name="end_date" class="datepicker"><br></p>
  <input type="submit" value="Generate Report"><br>
</form>
</body>
</html>