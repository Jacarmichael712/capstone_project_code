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
  $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
  $database = mysqli_select_db($connection, DB_DATABASE);

  if(!$_SESSION['login'] || !isset($_SESSION['user_edited']['query'])) {
      echo "Invalid page.<br>";
      echo "Redirecting.....";
      sleep(2);
      header( "Location: http://team05sif.cpsc4911.com/", true, 303);
      exit();
  }
  $user_info = $_SESSION['user_edited']['query'];
  $account_type = $_SESSION['user_edited']['account_type'];
  $account_id = $_SESSION['user_edited']['account_id'];
  unset($_SESSION['user_edited']['query']);
  unset($_SESSION['user_edited']['account_type']);
  unset($_SESSION['user_edited']['account_id']);


  if(isset($_POST['notifications'])) {
    $oldnotifications = intval($user_info[$account_type."_notifications"]);
    if(strcmp($_POST['notifications'], "Enabled") == 0) {
      $newnotifications = 1;
    } else {
      $newnotifications = 0;
    }
    if($oldnotifications != $newnotifications) {
      $queryOne = "UPDATE ".$account_type."s SET ".$account_type."_notifications = $newnotifications WHERE ".$account_type."_id = $account_id;";
      mysqli_query($connection, $queryOne);
      $_SESSION['errors']['user_info'] = "Information updated!";
    }
  }

  //Checks if the address was changed.
  if(isset($_POST['shipping']) && strcmp($_POST['shipping'], $user_info[$account_type."_address"]) != 0) {
    $oldaddress = $user_info[$account_type."_address"];
    $newaddress = $_POST['shipping'];
    $queryOne = "UPDATE ".$account_type."s SET ".$account_type."_address = '$newaddress' WHERE ".$account_type."_address = '$oldaddress';";
    mysqli_query($connection, $queryOne);
    $_SESSION['errors']['user_info'] = "Information updated!";
  }

  //Checks if the birthday was changed.
  if(isset($_POST['birthday']) && strcmp($_POST['birthday'], $user_info[$account_type."_birthday"]) != 0) {
    $oldbirthday = $user_info[$account_type."_birthday"];
    $newbirthday = $_POST['birthday'];
    $queryOne = "UPDATE ".$account_type."s SET ".$account_type."_birthday = '$newbirthday' WHERE ".$account_type."_birthday = '$oldbirthday';";
    mysqli_query($connection, $queryOne);
    $_SESSION['errors']['user_info'] = "Information updated!";
  }

  //Checks if the phone number was changed.
  if(isset($_POST['phone_number']) && strcmp($_POST['phone_number'], $user_info[$account_type."_phone_number"]) != 0) {
    $oldphonenumber = $user_info[$account_type."_phone_number"];
    $newphonenumber = $_POST['phone_number'];
    $queryOne = "UPDATE ".$account_type."s SET ".$account_type."_phone_number = '$newphonenumber' WHERE ".$account_type."_phone_number = '$oldphonenumber';";;
    mysqli_query($connection, $queryOne);
    $_SESSION['errors']['user_info'] = "Information updated!";
  }

  //Checks if the email was changed.
  if(isset($_POST['email']) && strcmp($_POST['email'], $user_info[$account_type."_email"]) != 0) {
    $oldemail = $user_info[$account_type."_email"];
    $newemail = $_POST['email'];

    $user_id_query = mysqli_query($connection, "SELECT * FROM users WHERE user_email='$oldemail'");
    while($rows=$user_id_query->fetch_assoc()) {
      $user_id = $rows['id'];
    }

    $queryOne = "UPDATE ".$account_type."s SET ".$account_type."_email = '$newemail' WHERE ".$account_type."_email = '$oldemail';";
    $queryTwo = "UPDATE users SET user_email = '$newemail' WHERE user_email ='$oldemail'";

    $eventTime = new DateTime('now');
    $eventTime = $eventTime->format("Y-m-d H:i:s");
    $emailAuditQuery = "INSERT INTO audit_log_email_changes (audit_log_email_changes_old_email, audit_log_email_changes_new_email, audit_log_email_changes_date, audit_log_email_changes_account_id) VALUES (?, ?, ?, ?)";
    $stmt_emailAudit = $connection->prepare($emailAuditQuery);
    $stmt_emailAudit->bind_param("sssi", $oldemail, $newemail, $eventTime, $user_id);

    mysqli_query($connection, $queryOne);
    mysqli_query($connection, $queryTwo);
    $stmt_emailAudit->execute();
    $_SESSION['errors']['user_info'] = "Information updated!";
  }

    //Checks if the password was changed.
  if(isset($_POST['password']) && strcmp($_POST['password'], "") != 0) {
    $newpassword = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $queryOne = "UPDATE ".$account_type."s SET ".$account_type."_password = '$newpassword' WHERE ".$account_type."_id = $account_id;";
    mysqli_query($connection, $queryOne);

    //Adds the password change to the audit log.
    $passwordChangeTime = new DateTime('now');
    $passwordChangeTime = $passwordChangeTime->format("Y-m-d H:i:s");
    $desc = "{$_SESSION['username']} (sponsor) changed ".$user_info[$account_type."_username"]." password.";
    $auditQuery = "INSERT INTO audit_log_password (audit_log_password_username, audit_log_password_date, audit_log_password_desc) VALUES (?, ?, ?)";
    $name = $_SESSION['username'];
    $preparedQuery = $connection->prepare($auditQuery);
    $preparedQuery->bind_param("sss", $name, $passwordChangeTime, $desc);
    $preparedQuery->execute();


    $_SESSION['errors']['user_info'] = "Information updated!";
  }
  //Checks if the username was changed.
  if(isset($_POST['username']) && strcmp($user_info[$account_type."_username"], $_POST['username']) != 0) {
    $newusername = $_POST['username'];
    $oldusername = $user_info[$account_type."_username"];

    $user_id_query = mysqli_query($connection, "SELECT * FROM users WHERE username='$oldusername'");
    while($rows=$user_id_query->fetch_assoc()) {
      $user_id = $rows['id'];
    }

    $queryOne = "UPDATE ".$account_type."s SET ".$account_type."_username = '$newusername' WHERE ".$account_type."_username = '$oldusername';";
    $queryTwo = "UPDATE users SET username = '$newusername' WHERE username ='$oldusername'";

    $eventTime = new DateTime('now');
    $eventTime = $eventTime->format("Y-m-d H:i:s");
    $usernameAuditQuery = "INSERT INTO audit_log_username_changes (audit_log_username_changes_old_username, audit_log_username_changes_new_username, audit_log_username_changes_date, audit_log_username_changes_account_id) VALUES (?, ?, ?, ?)";
    $stmt_usernameAudit = $connection->prepare($usernameAuditQuery);
    $stmt_usernameAudit->bind_param("sssi", $oldusername, $newusername, $eventTime, $user_id);

    mysqli_query($connection, $queryOne);
    mysqli_query($connection, $queryTwo);
    $stmt_usernameAudit->execute();
    $_SESSION['errors']['user_info'] = "Information updated!";
  }
  //Resets the session variable I have storing the user_data from a query.
  //$queryString ="SELECT * FROM ".$_SESSION['account_type']."s WHERE ".$_SESSION['account_type']."_username = '".$_SESSION['username']."'";
  //$result = mysqli_query($connection, $queryString);
  //unset($_SESSION['user_data']);
  //$_SESSION['user_data'] = mysqli_fetch_assoc($result);

  header("Location: http://team05sif.cpsc4911.com/S24-Team05/account/sponsor_edit_".$account_type."_account.php");
  exit()
?>