<?php
  session_start();
  if(!$_SESSION['login']) {
    echo "Invalid page.<br>";
    echo "Redirecting.....";
    sleep(2);
    header( "Location: http://team05sif.cpsc4911.com/", true, 303);
    exit();
    //unset($_SESSION['login']);
  }
  if(!isset($_POST['disable'])) {
    $_SESSION['errors']['archive'] = "No button was selected.";
    header( "Location: http://team05sif.cpsc4911.com/S24-Team05/account/profilearchiveaccount.php", true, 303);
    exit();
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
  /*font-size: 3em;*/
  padding: 0px;
  font-size: 1.5vmax;
  color: black;
  font-weight:normal;
}
h3 {
  font-family: "Monaco", monospace;
  /*font-size: 3em;*/
  padding: 0px;
  font-size: 1vmax;
  color: red;

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
ul {
  list-style-type: none;
  margin: 0;
  padding: 0;
  width: 150px;
  background-color: #ff5e6c;
}

li a {
  display: block;
  color: #000;
  padding: 8px 16px;
  text-decoration: none;
}

li a.active {
  background-color: #fff5d1;

}

li a:hover:not(.active) {
  background-color: #fff5d1;
}

.wrapper{
  display: flex;
  position: relative;
}

.wrapper .options{
  position: fixed;
  width: 150px;
  height: 100%;
  background: #ff5e6c;

}

.wrapper .content{
  width: 100%;
  margin-top: 1%;
  margin-left: 15%;
}

</style>
</head>

<div class="navbar">
  <div class="menu">
    <a href="/S24-Team05/account/homepageredirect.php">Home</a>
    <a href="/S24-Team05/account/profileuserinfo.php">Profile</a>
    <a href="/S24-Team05/account/logout.php">Logout</a>
    <a href="/S24-Team05/about_page.php">About</a>
  </div>
</div>


<body>
<div id = "flex-container-header">
    <div id = "flex-container-child">
    <?php echo "<h1>", $_SESSION['user_data'][$_SESSION['real_account_type']."_first_name"], "</h1>";?>
    <?php echo "<h1>", $_SESSION['user_data'][$_SESSION['real_account_type']."_last_name"], "</h1>";?>
   </div>
</div>

<div class ="wrapper">
  <div class="options">
    <ul>
      <li><a href="/S24-Team05/account/profileuserinfo.php">User Info</a></li>
      <li><a href="/S24-Team05/account/profilepassword.php">Change Password</a></li>
      <li><a href="/S24-Team05/account/profilechangepicture.php">Change Profile Picture</a></li>
      <?php if(strcmp($_SESSION['account_type'], 'driver') == 0) { echo '<li><a href="/S24-Team05/account/profileorderinfo.php">Orders</a></li>'; }?>
      <li><a href="/S24-Team05/account/profilearchiveaccount.php" class="active">Archive Account</a></li>
      <?php 
        if(strcmp($_SESSION['real_account_type'], 'administrator') == 0 || strcmp($_SESSION['real_account_type'], 'sponsor') == 0) {
            echo '<li><a href="/S24-Team05/view/change_view.php">Change View</a></li>'; 
        }
        ?>

    </ul>
  </div>
  <div class ="content">
    <form action="accountarchived.php" method="post">
        <h2>Are you sure you want to disable your account?</h2> <br>
        <h3>Disabled accounts will be deactivated, you will not be able to login again without contacting an administrator.</h3> <br>
        <input type="radio" id="yes" value="yes" name="disable" >
        <label for="disable">Yes</label><br>
        <input type="submit"> <br>
    </form>
    <?php if(isset($_SESSION['errors']['user_info'])) {echo $_SESSION['errors']['user_info']; unset($_SESSION['errors']['user_info']);}?>
  </div>
</div>

<?php
    //var_dump($_SESSION['login']);
    //echo "<p>", "Username: ", $_SESSION['user_data'][$_SESSION['account_type']."_username"], "</p>", "<br>";
    //echo "<p>", "Email: ", $_SESSION['user_data'][$_SESSION['account_type']."_email"], "</p>", "<br>";
    //echo "<p>","Birthday: ", $_SESSION['user_data'][$_SESSION['account_type']."_birthday"], "</p>","<br>";
    //echo "<p>","Phone-Number: ", $_SESSION['user_data'][$_SESSION['account_type']."_phone_number"], "</p>","<br>";
  ?> 

</body>

</html>