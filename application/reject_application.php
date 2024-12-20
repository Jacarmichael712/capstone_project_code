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
$reason = $_POST['reason'];
$regDateTime = new DateTime('now');
$regDate = $regDateTime->format("Y-m-d H:i:s");
$application_status = "Rejected";

$driver_query = mysqli_query($connection, "SELECT * FROM drivers WHERE driver_id='$account_id'");

while($rows=$driver_query->fetch_assoc()) {
    $driver_email = $rows['driver_email'];
    $driver_notifications = $rows['driver_notifications'];
}

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
    $email_subject = $_POST['organization_name']." has declined your application.";
    $email_body = $_POST['organization_name']." has reviewed your application, and has decided to decline your application with the following reason: $reason";
    send_email($email_subject, $email_body, $driver_email);
}

if ($stmt_application->execute() && $stmt_application2->execute() && $stmt_application3->execute()) {
    echo '<script>alert("Application rejected!\n")</script>';
    echo '<script>window.location.href = "http://team05sif.cpsc4911.com/S24-Team05/application/sponsor_view_applications.php"</script>';
}
else{
    echo '<script>alert("Failed to reject application...redirecting")</script>';
    echo '<script>window.location.href = ""http://team05sif.cpsc4911.com/S24-Team05/application/sponsor_view_applications.php""</script>';
}
    
?>

</body>
</html>