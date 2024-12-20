<?php include "../../../inc/dbinfo.inc"; require "../sendnotification.php" ?>
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
?>
<html>
<body>

<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
// Create connection to database
$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
if (mysqli_connect_errno()) {  
    echo "Database connection failed.";  
}  

session_start();
$connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
$database = mysqli_select_db($connection, DB_DATABASE);

$account_id = $_POST['account_id'];
$application_id = $_POST['application_id'];
$organization_id = $_POST['organization_id'];
$reason = $_POST['reason'];
$regDateTime = new DateTime('now');
$regDate = $regDateTime->format("Y-m-d H:i:s");

$check_query = mysqli_query($conn, "SELECT * FROM driver_sponsor_assoc WHERE driver_id='$account_id' AND assoc_sponsor_id='$organization_id'");
if(($check_query->fetch_assoc())['driver_sponsor_assoc_archived'] == 1) {
    echo '<script>alert("This driver is already revoked from ' . $_POST['organization_name'] . '")</script>';
    echo '<script>window.location.href = "http://team05sif.cpsc4911.com/S24-Team05/application/sponsor_view_applications.php"</script>';
} else {
    $driver_query = mysqli_query($conn, "SELECT * FROM drivers WHERE driver_id='$account_id'");

    while($rows=$driver_query->fetch_assoc()) {
        $curr_sponsor = $rows['driver_associated_sponsor'];
        $driver_email = $rows['driver_email'];
        $driver_notifications = $rows['driver_notifications'];
    }



    // Check if organization is already associated with sponsor
    $assoc_query = mysqli_query($connection, "SELECT * FROM driver_sponsor_assoc");
    $org_is_assoc = false;

    while($rows=$assoc_query->fetch_assoc()) {
        if($rows['assoc_sponsor_id'] == $_POST['organization_id'] && $rows['driver_id'] == $_POST['account_id']) {
            $org_is_assoc = true;
            $assoc_id = $rows['id'];
        }
    }

    if($org_is_assoc) {
        $archived = 1;
        $sql_assoc = "UPDATE driver_sponsor_assoc SET driver_sponsor_assoc_archived=? WHERE id = '$assoc_id'";
        $stmt_assoc = $conn->prepare($sql_assoc);
        $stmt_assoc->bind_param("i", $archived);  
    }

    $stmt_assoc->execute();



    // Update associated sponsor in drivers table if they have no sponsor
    if(strcmp($curr_sponsor,$_POST['organization_name']) == 0) {
        $sql_next_sponsor = "SELECT * FROM driver_sponsor_assoc CROSS JOIN organizations 
        ON driver_sponsor_assoc.assoc_sponsor_id=organizations.organization_id WHERE driver_id=$account_id AND organization_archived=0 AND driver_sponsor_assoc_archived=0;";
        $next_sponsor_query = mysqli_query($connection, $sql_next_sponsor);

        // Check if there are no rows returned
        if(mysqli_num_rows($next_sponsor_query) == 0) {
            $next_sponsor = "none";
            $points = 0;
        } else {
            $next_sponsor = ($next_sponsor_query->fetch_assoc())['organization_username'];
            $points = ($next_sponsor_query->fetch_assoc())['assoc_points'];
        }

        $sql_drivers = "UPDATE drivers SET driver_associated_sponsor=? WHERE driver_id='$account_id'";
        $stmt_drivers = $conn->prepare($sql_drivers);
        $stmt_drivers->bind_param("s", $next_sponsor);
        $stmt_drivers->execute();

        $sql_points = "UPDATE drivers SET driver_points=? WHERE driver_id='$account_id'";
        $stmt_points = $conn->prepare($sql_points);
        $stmt_points->bind_param("i", $points);
        $stmt_points->execute();
    }

    $application_status = "Revoked";
    $sql_application = "UPDATE applications SET application_status=? WHERE application_id = '$application_id'";
    $stmt_application = $conn->prepare($sql_application);
    $stmt_application->bind_param("s", $application_status); 

    $sql_application2 = "UPDATE applications SET decision_date=? WHERE application_id = '$application_id'";
    $stmt_application2 = $conn->prepare($sql_application2);
    $stmt_application2->bind_param("s", $regDate);

    $sql_application3 = "UPDATE applications SET application_reasoning=? WHERE application_id = '$application_id'";
    $stmt_application3 = $conn->prepare($sql_application3);
    $stmt_application3->bind_param("s", $reason);

        
    if($driver_notifications == 1) {
        $email_subject = $_POST['organization_name']." has revoked your application.";
        $email_body = $_POST['organization_name']." has revoked your application with the following reason: $reason";
        send_email($email_subject, $email_body, $driver_email);
    }


    if ($stmt_application->execute() && $stmt_application2->execute() && $stmt_application3->execute()) {
        echo '<script>alert("Application revoked\n")</script>';
        echo '<script>window.location.href = "http://team05sif.cpsc4911.com/S24-Team05/application/sponsor_view_applications.php"</script>';
    }
    else{
        echo '<script>alert("Failed to revoke application...redirecting")</script>';
        echo '<script>window.location.href = ""http://team05sif.cpsc4911.com/S24-Team05/application/sponsor_view_applications.php""</script>';
    }
}
    
?>

</body>
</html>