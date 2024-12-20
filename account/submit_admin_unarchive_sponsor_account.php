<?php include "../../../inc/dbinfo.inc"; ?>

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

// Get query variables from POST
$sponsor_id = $_POST['sponsor_id'];
$archived = 0;

$sponsor_id_query = mysqli_query($conn, "SELECT * FROM sponsors WHERE sponsor_id='$sponsor_id' AND sponsor_archived=1");

// Check for invald info
if(!($row=$sponsor_id_query->fetch_row())){
    echo '<script>alert("The Sponsor ID number you entered is not valid. \n\nPlease enter in a new ID number and retry...")</script>';
    echo '<script>window.location.href = "admin_unarchive_sponsor_account.php"</script>';
} else{

    // Prepare query on drivers table
    $sql_sponsors = "UPDATE sponsors SET sponsor_archived=? WHERE sponsor_id='$sponsor_id'";
    $stmt_sponsors = $conn->prepare($sql_sponsors);
    $stmt_sponsors->bind_param("i", $archived);

    if ($stmt_sponsors->execute()) {
        echo '<script>alert("Account successfully unarchived!\n")</script>';
        echo '<script>window.location.href = "http://team05sif.cpsc4911.com/S24-Team05/account/admin_unarchive_account.php"</script>';
    }
    else{
        echo '<script>alert("Failed to unarchive account...\n\nCheck your information and retry...")</script>';
        echo '<script>window.location.href = "admin_unarchive_sponsor_account.php"</script>';
    }
}
?>

</body>
</html>