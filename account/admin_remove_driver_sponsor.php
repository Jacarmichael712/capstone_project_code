<?php include "../../../inc/dbinfo.inc"; require "../sendnotification.php";?>
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

<?php 
    $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
    $database = mysqli_select_db($connection, DB_DATABASE);
    $driver_id = $_POST['driver_id'];
    $organization = $_POST['organization'];
    $sponsor_id = $_POST['sponsor_id'];
    
    //Query to gather driver info to send the email to.
    $sql_driver_info = "SELECT * FROM drivers WHERE driver_id=$driver_id";
    $driver_info = (mysqli_query($connection, $sql_driver_info))->fetch_assoc();
    $driver_email = $driver_info['driver_email'];
    $driver_name = $driver_info['driver_first_name'];

    //Query to remove the driver-sponsor association.
    $sql_remove_sponsor = "DELETE FROM driver_sponsor_assoc WHERE driver_id=? AND assoc_sponsor_id=?";
    $stmt_removed = $connection->prepare($sql_remove_sponsor);
    $stmt_removed->bind_param('ii', $driver_id, $sponsor_id);
    $stmt_removed->execute();

    //Query to grab the next sponsor the driver has.
    $sql_next_sponsor = "SELECT * FROM driver_sponsor_assoc CROSS JOIN organizations 
    ON driver_sponsor_assoc.assoc_sponsor_id=organizations.organization_id WHERE driver_id=$driver_id;";
    $result = mysqli_query($connection, $sql_next_sponsor);
    $next_sponsor = $result->fetch_assoc();
    if($next_sponsor) {
        $next_sponsor_company = $next_sponsor['organization_username'];
        $next_points = $next_sponsor['assoc_points'];

        $sql_update_driver = "UPDATE drivers SET driver_associated_sponsor=?, driver_points=? WHERE driver_id=?";
        $stmt_update_driver = $connection->prepare($sql_update_driver);
        $stmt_update_driver->bind_param('sii', $next_sponsor_company, $next_points, $driver_id);
        if($stmt_update_driver->execute()) {
            $message_body = "Hello {$driver_name},".PHP_EOL."The sponsor {$organization} has been removed from your account. Your current assigned sponsor is now {$next_sponsor_company}.";
            send_email('Sponsor Removed From Account', $message_body, $driver_email);
            $redirectpage = "admin_edit_driver_account.php";
            echo '<script>alert("Succesfully removed sponsor company from driver!")</script>';
            echo '<script>window.location.href = "',$redirectpage,'"</script>';
        } else {
            echo '<script>alert("Failed to remove the sponsor company...")</script>';
        }
    } else {
        $next_sponsor_company = 'none';
        $next_points = 0;

        $sql_update_driver = "UPDATE drivers SET driver_associated_sponsor=?, driver_points=? WHERE driver_id=?";
        $stmt_update_driver = $connection->prepare($sql_update_driver);
        $stmt_update_driver->bind_param('sii', $next_sponsor_company, $next_points, $driver_id);
        if($stmt_update_driver->execute()) {
            $message_body = "Hello {$driver_name},".PHP_EOL."The sponsor {$organization} has been removed from your account. You have no assigned sponsors left...";
            send_email('Sponsor Removed From Account', $message_body, $driver_email);
            $redirectpage = "admin_edit_driver_account.php";
            echo '<script>alert("Succesfully removed sponsor company from driver! Driver has no sponsor...")</script>';
            echo '<script>window.location.href = "',$redirectpage,'"</script>';
        } else {
            echo '<script>alert("Failed to remove the sponsor company...")</script>';
        }
    }
?>