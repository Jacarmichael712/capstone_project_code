<?php include "../../../inc/dbinfo.inc"; ?>

<?php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    session_start();
    $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
    $database = mysqli_select_db($connection, DB_DATABASE);

    $result = mysqli_query($connection, "SELECT * FROM users");
      
    // Get the user id
    $username = $_SESSION['username'];
    while($rows=$result->fetch_assoc()) {
        if($rows['username'] == $username) {
            $user_id = $rows['id'];
        }
    }

    $real_account_type = $_SESSION['real_account_type'];
    $updateViewType = "UPDATE users SET user_view_type = '$real_account_type' WHERE id = $user_id;";
    mysqli_query($connection, $updateViewType);

    session_unset();
    header( "Location: http://team05sif.cpsc4911.com/", true, 303);
    exit();
?>