<?php include "../../../inc/dbinfo.inc"; ?>
<?php session_start();?>

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
  margin: 8px 0;
  box-sizing: border-box;
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
</style>
</head>

<title>Password Reset</title>
<div id="flex-container-header">
    <div id="flex-container-child">
      <h1>Password Reset</h1>
    </div>
  </div>
<body>
<?php 

    if($_SESSION['token'] == $_GET['token']){
        $name = $_SESSION['name'];
        $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
        $database = mysqli_select_db($connection, DB_DATABASE);
        $queryString = "SELECT * FROM users WHERE username = '$name'";
        $result = mysqli_query($connection, $queryString);
        $query_data = mysqli_fetch_row($result);
        $_SESSION['account_type'] = $query_data[2];
        $query = "SELECT * FROM ".$_SESSION['account_type']."s WHERE ".$_SESSION['account_type']."_username = '$name' OR ".$_SESSION['account_type']."_email = '$name'";
        $result = mysqli_query($connection, $query);
        $query_data = mysqli_fetch_row($result);
    }else{
        echo "<script>
            alert('Unauthorized Access');
            document.location.href = 'reset_password.php';
            </script>";
        header( "Location: http://team05sif.cpsc4911.com/S24-Team05/account/login.php", true, 303);
        exit();
    }
?>

<form action="reset_success.php" method="post">
    <label for="password">Password:</label><br>
    <input type="password" id="password" name="password" placeholder="Enter your new password..." required><br>
    <?php 
        $_SESSION["new-password"] = $_POST["password"];
    ?>
    <button type="button" onclick="togglePasswordVisibility()">
    <span id="toggleLabel">Show Password</span>
    </button><br>
    <input type="submit" value="Submit"><br>
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


<!-- Clean up -->
<?php
        mysqli_free_result($result);
        mysqli_close($connection);
?>

</body>

</html>