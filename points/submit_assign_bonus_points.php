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

// Check whether account is admin viewing as sponsor or is an actual sponsor account
if(strcmp($_SESSION['account_type'], $_SESSION['real_account_type']) == 0) {
    $result = mysqli_query($connection, "SELECT * FROM sponsors");

    // Get the sponsor id associated with the sponsor's username
    $username = $_SESSION['username'];
    while($rows=$result->fetch_assoc()) {
        if($rows['sponsor_username'] == $username) {
            $sponsor_name = $rows['sponsor_associated_sponsor'];
        }
    }
  } else if (strcmp($_SESSION['real_account_type'], "administrator") == 0) {
    $result = mysqli_query($connection, "SELECT * FROM administrators");
    
    // Get the sponsor id associated with the sponsor's username
    $username = $_SESSION['username'];
    while($rows=$result->fetch_assoc()) {
        if($rows['administrator_username'] == $username) {
            $sponsor_name = $rows['administrator_associated_sponsor'];
        }
    }
  }

// Get query variables from POST/SESSION
$driver_id = $_POST['driver_id'];
$reason = $_POST['reason'];
$_SESSION['point_val'] = 0;
$regDateTime = new DateTime('now');
$regDate = $regDateTime->format("Y-m-d H:i:s");

// Create query to see if driving behavior id exists
$driver_id_query = mysqli_query($conn, "SELECT * FROM driver_sponsor_assoc JOIN organizations ON organization_id=assoc_sponsor_id WHERE driver_id='$driver_id' AND organization_username='$sponsor_name'");

// Get the new point value for the driver
while($rows=$driver_id_query->fetch_assoc()) {
    if(!($rows['assoc_points'] == NULL)) {
        $_SESSION['point_val'] = $rows['assoc_points'];
    }
}

$point_val = $_SESSION['point_val'] + $_POST['points'];

$driver_id_query2 = mysqli_query($conn, "SELECT * FROM drivers WHERE driver_id='$driver_id' AND driver_associated_sponsor='$sponsor_name' AND driver_archived=0");
$sponsor_id = mysqli_query($conn, "SELECT * FROM organizations WHERE organization_username='$sponsor_name'");
$sponsor_id = ($sponsor_id->fetch_assoc())['organization_id'];

while($rows=$driver_id_query2->fetch_assoc()) {
    // Prepare query on drivers table
    $sql_drivers = "UPDATE drivers SET driver_points=? WHERE driver_id=$driver_id";
    $stmt_drivers = $conn->prepare($sql_drivers);
    $stmt_drivers->bind_param("i", $point_val);
    $stmt_drivers->execute();
}

$sql_DSAssoc = "UPDATE driver_sponsor_assoc SET assoc_points=? WHERE driver_id=$driver_id AND assoc_sponsor_id=$sponsor_id";
$stmt_DSAssoc = $conn->prepare($sql_DSAssoc);
$stmt_DSAssoc->bind_param("i", $point_val);

$point_change = "+" . $_POST['points'];
$sql_point_history = "INSERT INTO point_history (point_history_date, point_history_points, point_history_driver_id, point_history_reason, point_history_amount, point_history_associated_sponsor) VALUES (?, ?, ?, ?, ?, ?)";
$stmt_point_history = $conn->prepare($sql_point_history);
$stmt_point_history->bind_param("ssisss", $regDate, $point_val, $driver_id, $reason, $point_change, $sponsor_name);

$sql_audit = "INSERT INTO audit_log_point_changes (audit_log_point_changes_username, audit_log_point_changes_date, audit_log_point_changes_reason, audit_log_point_changes_number) VALUES (?, ?, ?, ?)";
$stmt_audit = $conn->prepare($sql_audit);
$point_change_reason = "Bonus: " . $reason;
$stmt_audit->bind_param("ssss", $row[3], $regDate, $point_change_reason, $point_change);

if ($stmt_point_history->execute() && $stmt_audit->execute() && $stmt_DSAssoc->execute()) {
    echo '<script>alert("Points sucessfully added!\n")</script>';
    echo '<script>window.location.href = "http://team05sif.cpsc4911.com/S24-Team05/account/sponsorhomepage.php"</script>';
}
else {
    echo '<script>alert("Failed to add points...\n\nCheck your information and retry...")</script>';
    echo '<script>window.location.href = "assign_bonus_points.php"</script>';
}

?>

</body>
</html>