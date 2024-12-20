<?php include "../../../inc/dbinfo.inc"; ?>
<?php
  session_start();
  $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
  $database = mysqli_select_db($connection, DB_DATABASE);


  if(!$_SESSION['login']) {
      echo "Invalid page.<br>";
      echo "Redirecting.....";
      sleep(2);
      header( "Location: http://team05sif.cpsc4911.com/", true, 303);
      exit();
  }
  if(isset($_POST['newpassword']) && isset($_POST['confirm_password']) && isset($_POST['oldpassword'])) {
    $oldpassword = $_POST['oldpassword'];
    $passwordOne = $_POST['newpassword'];
    $passwordTwo = $_POST['confirm_password'];
    if(strlen($passwordOne) < 8) {
      $_SESSION['errors']['user_info'] = "The new password is too short!";
      goto redirect;
    }

    //Verifies they inputted the correct old password and if they inputted the new password in correctly twice.
    if(!password_verify($oldpassword, $_SESSION['user_data'][$_SESSION['real_account_type']."_password"])) {
        $_SESSION['errors']['user_info'] = "Your old password is incorrect!";
        goto redirect;
    } else if(strcmp($passwordOne, $passwordTwo) != 0) {
        $_SESSION['errors']['user_info'] = "Passwords do not match!";
        goto redirect;
    }

    //Updates the password in the database.
    $newpassword = password_hash($passwordOne, PASSWORD_DEFAULT);
    $query = "UPDATE ".$_SESSION['real_account_type']."s SET ".$_SESSION['real_account_type']."_password = '$newpassword' WHERE ".$_SESSION['real_account_type']."_username = '".$_SESSION['username']."'";
    mysqli_query($connection, $query);

    // Add password change success to password change audit log
    $name = $_SESSION['username'];
    $passwordChangeTime = new DateTime('now');
    $passwordChangeTime = $passwordChangeTime->format("Y-m-d H:i:s");
    $desc = "{$name} ({$_SESSION['real_account_type']}) changed their own password.";
    $auditQuery = "INSERT INTO audit_log_password (audit_log_password_username, audit_log_password_date, audit_log_password_desc) VALUES (?, ?, ?)";
    
    $preparedQuery = $connection->prepare($auditQuery);
    $preparedQuery->bind_param("sss", $name, $passwordChangeTime, $desc);
    $preparedQuery->execute();

    $_SESSION['errors']['user_info'] = "Successfully updated password!";
  }

  //Resets the session variable I have storing the user_data from a query.
  $queryString ="SELECT * FROM ".$_SESSION['real_account_type']."s WHERE ".$_SESSION['real_account_type']."_username = '".$_SESSION['username']."'";
  $result = mysqli_query($connection, $queryString);
  unset($_SESSION['user_data']);
  $_SESSION['user_data'] = mysqli_fetch_assoc($result);
  redirect:
  header("Location: http://team05sif.cpsc4911.com/S24-Team05/account/profilepassword.php", true, 303);
  exit();

?>