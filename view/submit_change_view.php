<?php include "../../../inc/dbinfo.inc"; ?>
<?php
  session_start();
  $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
  $database = mysqli_select_db($connection, DB_DATABASE);

  $result = mysqli_query($connection, "SELECT * FROM users");

  // Get user id
  $username = $_SESSION['username'];
  while($rows=$result->fetch_assoc()) {
    if($rows['username'] == $username) {
        $user_id = $rows['id'];
    }
  }

  // Reset session variable depending on view change
  if(isset($_POST['change_view'])) {
    if(strcmp($_POST['change_view'], "administrator") == 0) {
        $_SESSION['account_type'] = "administrator";
    } else if(strcmp($_POST['change_view'], "sponsor") == 0) {
        $_SESSION['account_type'] = "sponsor";
    } else if(strcmp($_POST['change_view'], "driver") == 0) {
        $_SESSION['account_type'] = "driver";
    }

    $new_view = $_SESSION['account_type'];

    // Update the view in the users table
    $queryOne = "UPDATE users SET user_view_type = '$new_view' WHERE id = '$user_id'";
    mysqli_query($connection, $queryOne);
    $_SESSION['errors']['user_info'] = "Information updated!";
  }

  header("Location: http://team05sif.cpsc4911.com/S24-Team05/view/change_view.php");
  exit()
?>