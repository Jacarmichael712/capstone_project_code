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

// Get query variables from POST
$driving_behavior_id = $_POST['driving_behavior_id'];
$archived = 1;

// Create query to see if driving behavior id exists
$driving_behavior_query = mysqli_query($conn, "SELECT * FROM driving_behavior WHERE driving_behavior_id='$driving_behavior_id' AND driving_behavior_archived=0 AND driving_behavior_associated_sponsor='$sponsor_name'");

// Check for taken/invalid account info
if (!($driving_behavior_query->fetch_row())){
    echo '<script>alert("The ID number you entered is not valid. \n\nPlease enter in a new ID number and retry...")</script>';
    echo '<script>window.location.href = "remove_behavior.php"</script>';
} else{
    // Prepare query on driving_behavior table
    $sql_driving_behavior = "UPDATE driving_behavior SET driving_behavior_archived=? WHERE driving_behavior_id=$driving_behavior_id";
    $stmt_driving_behavior = $conn->prepare($sql_driving_behavior);
    $stmt_driving_behavior->bind_param("i", $archived);

    if ($stmt_driving_behavior->execute()) {
     echo '<script>alert("Driving behavior successfully removed!\n")</script>';
        echo '<script>window.location.href = "remove_behavior.php"</script>';
    }
    else{
        echo '<script>alert("Failed to remove driving behavior...\n\nCheck your information and retry...")</script>';
        echo '<script>window.location.href = "remove_behavior.php"</script>';
    }
}
?>

</body>
</html>