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
$admin_id = $_POST['admin_id'];
$archived = 1;

$admin_id_query = mysqli_query($conn, "SELECT * FROM administrators WHERE administrator_id='$admin_id' AND administrator_archived=0");

// Check for invalid info
if(!($row=$admin_id_query->fetch_row())){
    echo '<script>alert("The Admin ID number you entered is not valid. \n\nPlease enter in a new ID number and retry...")</script>';
    echo '<script>window.location.href = "admin_archive_admin_account.php"</script>';
} else{

    // Prepare query on drivers table
    $sql_admins = "UPDATE administrators SET administrator_archived=? WHERE administrator_id='$admin_id'";
    $stmt_admins = $conn->prepare($sql_admins);
    $stmt_admins->bind_param("i", $archived);

    if ($stmt_admins->execute()) {
        echo '<script>alert("Account successfully archived!\n")</script>';
        echo '<script>window.location.href = "http://team05sif.cpsc4911.com/S24-Team05/account/admin_archive_account.php"</script>';
    }
    else{
        echo '<script>alert("Failed to archive account...\n\nCheck your information and retry...")</script>';
        echo '<script>window.location.href = "admin_archive_admin_account.php"</script>';
    }
}
?>

</body>
</html>