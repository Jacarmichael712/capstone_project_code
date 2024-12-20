<?php include "../../../inc/dbinfo.inc"; ?>
<html>
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
  
  //Makes sure they inputted in they want to archive account.
  if(!isset($_POST['disable'])) {
    $_SESSION['errors']['archive'] = "No button was selected.";
    header( "Location: http://team05sif.cpsc4911.com/S24-Team05/account/confirmarchiveaccount.php", true, 303);
    exit();
  } elseif(strcmp($_POST['disable'], "yes") == 0) {
    //Sends query to set _archived to 1.
    $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
    $database = mysqli_select_db($connection, DB_DATABASE);
    $query = "UPDATE ".$_SESSION['real_account_type']."s SET ".$_SESSION['real_account_type']."_archived = 1 WHERE ".$_SESSION['real_account_type']."_username = '".$_SESSION['username']."'";
    mysqli_query($connection, $query);
    echo '<script>alert("Account has been archived! Redirecting to home page...")</script>';
    echo '<script>window.location.href = "logout.php"</script>';
  }
?>


    <script>alert('test');</script>
</html>