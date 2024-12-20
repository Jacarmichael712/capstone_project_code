<?php include "../../../inc/dbinfo.inc"; ?>
<?php session_start(); ?>
<html>
<body>

<?php
// Create connection to database
$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
if (mysqli_connect_errno()) {  
    echo "Database connection failed.";  
} 


// Get query variables from POST
$sponsorApp = $_POST['listsponsors'];
$username = $_SESSION['user_data'][$_SESSION['real_account_type']."_username"];
echo "Username" . $username;
$connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
$database = mysqli_select_db($connection, DB_DATABASE);

$query = mysqli_query($connection, "SELECT * FROM organizations WHERE organization_archived=0 AND organization_username='$sponsorApp'");

    while($rows=$query->fetch_assoc()) {
        $orgId = $rows['organization_id'];
    }
$appStatus = "Pending";
$comments = $_POST['comments'];
if(strcmp($_SESSION['real_account_type'], "administrator") == 0){
    $query = mysqli_query($connection, "SELECT * FROM administrators WHERE administrator_username='$username'");
    while($rows=$query->fetch_assoc()) {
        $driver_id = $rows['administrator_id'];
    }
}else if(strcmp($_SESSION['real_account_type'], "sponsor") == 0){
    $query = mysqli_query($connection, "SELECT * FROM sponsors WHERE sponsor_username='$username'");
    while($rows=$query->fetch_assoc()) {
        $driver_id = $rows['sponsor_id'];
    }
}else{
    $query = mysqli_query($connection, "SELECT * FROM drivers WHERE driver_username='$username'");
    while($rows=$query->fetch_assoc()) {
        $driver_id = $rows['driver_id'];
    }
}



$appDateTime = new DateTime('now');
$appDate = $appDateTime->format("Y-m-d H:i:s");
$user_type = 'driver';
// Function to check for valid dates
function validateDate($date, $format = 'Y-m-d'){
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) === $date;
}


    $sql_apply = "INSERT INTO applications (driver_id, organization_id, application_status, application_date, application_comments) VALUES (?, ?, ?, ?, ?)";
    $stmt_apply = $connection->prepare($sql_apply);
    $stmt_apply->bind_param("iisss", $driver_id, $orgId, $appStatus, $appDate, $comments);
    if ($stmt_apply->execute()) {
        echo '<script>alert("Your application has been submitted!\n\nRedirecting to homepage...")</script>';
        echo '<script>window.location.href = "http://team05sif.cpsc4911.com/S24-Team05/account/driverhomepage.php"</script>';
    }else{
        echo '<script>alert("Your application submission failed...\n\nCheck your information and retry...")</script>';
        echo '<script>window.location.href = "driver_apply.php"</script>';
    }
    
?>

</body>
</html>