<?php include "../../../inc/dbinfo.inc"; ?>
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
// Create connection to database
$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
if (mysqli_connect_errno()) {  
    echo "Database connection failed.";  
}  

session_start();
$connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
$database = mysqli_select_db($connection, DB_DATABASE);

// Get query variables from POST
$catalog_id = $_POST['catalog_id'];

$catalog_id_query = mysqli_query($conn, "SELECT * FROM catalog WHERE catalog_id='$catalog_id'");

// Check for invalid info
if(!($row=$catalog_id_query->fetch_row())){
    echo '<script>alert("Item cannot be removed...")</script>';
    echo '<script>window.location.href = "http://team05sif.cpsc4911.com/S24-Team05/catalog/sponsor_catalog_home.phpp"</script>';
} else{

    // Prepare query on catalog table
    $sql_catalog = "DELETE FROM catalog WHERE catalog_id='$catalog_id'";

    if ($connection->query($sql_catalog)) {
        echo '<script>alert("Item successfully removed!\n")</script>';
        echo '<script>window.location.href = "http://team05sif.cpsc4911.com/S24-Team05/catalog/sponsor_catalog_home.php"</script>';
    }
    else{
        echo '<script>alert("Failed to remove item...")</script>';
        echo '<script>window.location.href = "http://team05sif.cpsc4911.com/S24-Team05/catalog/sponsor_catalog_home.php"</script>';
    }
}
?>

</body>
</html>