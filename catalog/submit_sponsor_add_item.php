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

if($_SESSION['item_name'] == NULL) {
    $item_image = $_POST['item_image'];
    $item_name = $_POST['item_name'];
    $item_artist = $_POST['item_artist'];
    $item_price = $_POST['item_price'];
    $item_release_date = $_POST['item_release_date'];
    $advisory_rating = $_POST['advisory_rating'];
    $item_type = $_POST['item_type'];
} else {
    $item_image = $_SESSION['item_image'];
    $item_name = $_SESSION['item_name'];
    $item_artist = $_SESSION['item_artist'];
    $item_price = $_SESSION['item_price'];
    $item_release_date = $_SESSION['item_release_date'];
    $advisory_rating = $_SESSION['advisory_rating'];
    $item_type = $_SESSION['item_type'];
}

$sponsor_username = $_SESSION['username'];

// Check whether account is admin viewing as sponsor or is an actual sponsor account
if(strcmp($_SESSION['account_type'], $_SESSION['real_account_type']) == 0) {
    $result = mysqli_query($connection, "SELECT * FROM sponsors");

    // Get the sponsor id associated with the sponsor's username
    $username = $_SESSION['username'];
    while($rows=$result->fetch_assoc()) {
        if($rows['sponsor_username'] == $username) {
            $associated_sponsor = $rows['sponsor_associated_sponsor'];
        }
    }
  } else if (strcmp($_SESSION['real_account_type'], "administrator") == 0) {
    $result = mysqli_query($connection, "SELECT * FROM administrators");
    
    // Get the sponsor id associated with the sponsor's username
    $username = $_SESSION['username'];
    while($rows=$result->fetch_assoc()) {
        if($rows['administrator_username'] == $username) {
            $associated_sponsor = $rows['administrator_associated_sponsor'];
        }
    }
}


$point_ratio_query = mysqli_query($connection, "SELECT * FROM organizations");
while($rows=$point_ratio_query->fetch_assoc()) {
    if($rows['organization_username'] == $associated_sponsor) {
        $point_ratio = $rows['organization_dollar2pt'];
    }
}

$item_point_cost = $item_price / floatval($point_ratio);

// Prepare query on catalog table
$sql_catalog = "INSERT INTO catalog (catalog_associated_sponsor, catalog_item_name, catalog_item_image, catalog_item_point_cost, catalog_item_artist, catalog_item_release_date, catalog_item_rating, catalog_item_type) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$stmt_catalog = $conn->prepare($sql_catalog);
$stmt_catalog->bind_param("sssissss", $associated_sponsor, $item_name, $item_image, $item_point_cost, $item_artist, $item_release_date, $advisory_rating, $item_type);

if ($stmt_catalog->execute()) {
    echo '<script>alert("Successfully added to catalog!\n")</script>';
    echo '<script>window.location.href = "http://team05sif.cpsc4911.com/S24-Team05/catalog/sponsor_catalog_home.php"</script>';
}
else{
    echo '<script>alert("Failed to add to catalog...\n\nCheck your information and retry...")</script>';
    echo '<script>window.location.href = "sponsor_add_to_catalog.php"</script>';
}
?>

</body>
</html>