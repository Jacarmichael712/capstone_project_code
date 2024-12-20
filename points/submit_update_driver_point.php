<?php include "../../../inc/dbinfo.inc"; ?>
<?php
session_start();
if(!$_SESSION['login'] || strcmp($_SESSION['real_account_type'], "sponsor") != 0) {
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
// Create connection to database
$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
if (mysqli_connect_errno()) {  
    echo "Database connection failed.";  
}  

session_start();
$connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
$database = mysqli_select_db($connection, DB_DATABASE);

// Get query variables from POST/SESSION
$driver_username = $_POST['driver_username'];
$org_name = $_POST['sponsor'];
$reason = $_POST['reason'];
$_SESSION['point_val'] = 0;
$regDateTime = new DateTime('now');
$regDate = $regDateTime->format("Y-m-d H:i:s");

// Create query to see if driver associated sponsor was chosen.
$driver_query = mysqli_query($conn, "SELECT * FROM drivers WHERE driver_username='$driver_username'");

while($rows=$driver_query->fetch_assoc()) {
    if($rows['driver_associated_sponsor'] == $org_name) {
        $_SESSION['point_val'] = $rows['driver_points'];
        $point_val = $_SESSION['point_val'] + $_POST['points']; 

        // Prepare query on drivers table if sponsor chosen is current associated sponsor.
        $sql_drivers = "UPDATE drivers SET driver_points=? WHERE driver_username='$driver_username'";
        $stmt_drivers = $conn->prepare($sql_drivers);
        $stmt_drivers->bind_param("i", $point_val);
        $stmt_drivers->execute();
    }
    $driver_id = $rows['driver_id'];
}

$sponsor_id = mysqli_query($conn, "SELECT * FROM organizations WHERE organization_username='$org_name'");
$sponsor_id = ($sponsor_id->fetch_assoc())['organization_id'];

$driver_sponsor_assoc_query = mysqli_query($conn, "SELECT * FROM driver_sponsor_assoc WHERE driver_username='$driver_username' AND assoc_sponsor_id=$sponsor_id;");
while($rows=$driver_sponsor_assoc_query->fetch_assoc()) {
    $_SESSION['point_val'] = $rows['driver_points'];
    $point_val = $_SESSION['point_val'] + $_POST['points'];
}

$sql_DSAssoc = "UPDATE driver_sponsor_assoc SET assoc_points=? WHERE driver_username='$driver_username' AND assoc_sponsor_id=$sponsor_id";
$stmt_DSAssoc = $conn->prepare($sql_DSAssoc);
$stmt_DSAssoc->bind_param("i", $point_val);

$point_change = "+" . $_POST['points'];
$sql_point_history = "INSERT INTO point_history (point_history_date, point_history_points, point_history_driver_id, point_history_reason, point_history_amount, point_history_associated_sponsor) VALUES (?, ?, ?, ?, ?, ?)";
$stmt_point_history = $conn->prepare($sql_point_history);
$stmt_point_history->bind_param("ssisss", $regDate, $point_val, $driver_id, $reason, $point_change, $org_name);

$sql_audit = "INSERT INTO audit_log_point_changes (audit_log_point_changes_username, audit_log_point_changes_date, audit_log_point_changes_reason, audit_log_point_changes_number) VALUES (?, ?, ?, ?)";
$stmt_audit = $conn->prepare($sql_audit);
$point_change_reason = "Added: " . $reason;
$stmt_audit->bind_param("ssss", $driver_username, $regDate, $point_change_reason, $point_change);

if ($stmt_point_history->execute() && $stmt_audit->execute() && $stmt_DSAssoc->execute()) {
    echo '<script>alert("Points sucessfully added!\n")</script>';
    echo '<script>window.location.href = "http://team05sif.cpsc4911.com/S24-Team05/account/administratorhomepage.php"</script>';
}
else{
    echo '<script>alert("Failed to add points...\n\nCheck your information and retry...")</script>';
    echo '<script>window.location.href = "admin_update_driver_point_status.php"</script>';
}
?>

</body>
</html>