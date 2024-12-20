<?php include "../../../inc/dbinfo.inc"; ?>
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

<html>
<body>

<?php
// Create connection to database

$connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
$database = mysqli_select_db($connection, DB_DATABASE);

// Get query variables from POST
$sponsor_id = $_POST['organization_id'];
$archived = 0;

$sql_organization = "UPDATE organizations SET organization_archived=? WHERE organization_id=?";
$stmt_organization = $connection->prepare($sql_organization);
$stmt_organization->bind_param('ii',$archived,$sponsor_id);

// Check for invald info
if($stmt_organization->execute()){
    echo '<script>alert("The organization has been unarchived succesfully!")</script>';
    echo '<script>window.location.href = "admin_view_organizations.php"</script>';
}
?>

</body>
</html>