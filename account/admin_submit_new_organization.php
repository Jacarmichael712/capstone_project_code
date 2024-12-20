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
$org_name = $_POST['new_org_name'];
$org_ratio = $_POST['ratio'];

$duplicate_check = "SELECT 1 FROM organizations WHERE organization_username=?";
$stmt_dupe = $connection->prepare($duplicate_check);
$stmt_dupe->bind_param("s", $org_name);
$stmt_dupe->execute();
$result = $stmt_dupe->get_result();

if($result->fetch_assoc()) {
    echo '<script>alert("Error, organization already exist, please try again!")</script>';
    echo '<script>window.location.href = "admin_create_organization.php"</script>';
} else {
    $sql_add_org = "INSERT INTO organizations (organization_username,organization_dollar2pt,organization_archived) VALUES (?, ?, ?)";
    $archive_status = 0;
    $stmt_organization = $connection->prepare($sql_add_org);
    $stmt_organization->bind_param('sdi',$org_name,$org_ratio,$archive_status);
    if($stmt_organization->execute()) {
        echo '<script>alert("Organization successfully created!")</script>';
        echo '<script>window.location.href = "admin_view_organizations.php"</script>';
    }
}

?>

</body>
</html>