<?php include "../../../inc/dbinfo.inc";?>
<?php session_start();?>
<?php
  if($_SESSION['login']) {
    header("Location: http://team05sif.cpsc4911.com/S24-Team05/account/homepageredirect.php");
    exit();
  }

  function generateRandomCode() {
    // Define the characters to be used for the alphanumeric code
    $characters = '123456789abcdefghijkmnopqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ';
    
    // Get the length of the character set
    $characters_length = strlen($characters);
    
    // Initialize the code variable
    $code = '';
    
    // Generate a random character 6 times and append it to the code
    for ($i = 0; $i < 6; $i++) {
        $random_index = mt_rand(0, $characters_length - 1);
        $code .= $characters[$random_index];
    }
    
    return $code;
}
?>

<!DOCTYPE html>

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
  margin: 20px 20px;
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

<title>Login Page</title>
<body>

  <div class="navbar">
    <div class="menu">
      <a href="/">Landing Page</a>
      <a href="/S24-Team05/about_page.php">About</a>
    </div>
  </div>

  <div id="flex-container-header">
      <div id="flex-container-child">
        <h1>Login!</h1>
      </div>
  </div>

  <form action="loginvalidation.php" method="post">
  <label for="username"><p style = "font-size: 1vmax; color: black">Username/Email:</label><br>
  <input type="text" name="name" id="username" placeholder="Enter username or email..." required <?php 
    if(isset($_COOKIE["remember_user"])){
      list($name, $password) = explode(":", $_COOKIE["remember_user"]);
      echo "value=$name";
    }
  ?>><br>
  <label for="password">Password:</label><br>
  <input type="password" name="password" id="password" placeholder="Enter password..." required <?php 
    if(isset($_COOKIE["remember_user"])){
      list($name, $password) = explode(":", $_COOKIE["remember_user"]);
      echo "value=$password";
    }
  ?>><br>
  <button type="button" onclick="togglePasswordVisibility()">
    <span id="toggleLabel">Show Password</span>
  </button><br>
  <label for="rememberCook">Remember Me</label><br>
  <input type="checkbox" id="rememberCook" name="remember" <?php 
    if(isset($_COOKIE["remember_user"])){
      echo "checked";
    }
  ?>><br>
  

<?php   
        $_SESSION["name"] = $_POST["name"];
        $_SESSION["password"] = $_POST["password"];
        if(isset($_SESSION['errors']['login'])) {
                echo "<p>", $_SESSION['errors']['login'], "</p>", "<br>";
                unset($_SESSION['errors']['login']);
        }
?>
<input type="hidden" name="code" value="<?php echo generateRandomCode();?>">
<input type="submit"> <br></p>

</form>
<!-- Hyperlink to account creation php -->
<div id="hyperlink-wrapper">
  <a id="hyperlink" href="driver_account_creation.php">Sign Up</a>
</div>

<div id="hyperlink-wrapper">
  <a id="hyperlink" href="passwordreset.php">Forgot Password?</a>
</div>

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

</body>
</html>