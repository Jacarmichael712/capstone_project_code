<?php include "../../../inc/dbinfo.inc"; ?>

<html>
<body>

<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
// Create connection to database
$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
if (mysqli_connect_errno()) {  
    echo "Database connection failed.";  
}  

session_start();
$connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
$database = mysqli_select_db($connection, DB_DATABASE);

$result = mysqli_query($connection, "SELECT * FROM drivers");

// Get the driver associated sponsor for order table
$username = $_SESSION['username'];
while($rows=$result->fetch_assoc()) {
  if($rows['driver_username'] == $username) {
    $sponsor_name = $rows['driver_associated_sponsor'];
  }
}

$regDateTime = new DateTime('now');
$regDate = $regDateTime->format("Y-m-d H:i:s");
$username = $_SESSION['username'];

// Create query to get drivers points
$driver_query = mysqli_query($conn, "SELECT * FROM drivers");

// Get the new point value for the driver
while($rows=$driver_query->fetch_assoc()) {
    if($rows['driver_username'] == $username) {
        $driver_points = $rows['driver_points'];
        $driver_id = $rows['driver_id'];
    }
}

$updated_points = $driver_points - $_POST['current_item_price'];
$reason = "{$username} purchased " .$_POST['current_item_name'];
$order_status = "Processing";
$item_id = $_POST['item_id'];

$sponsorID = mysqli_query($connection, "SELECT * FROM organizations WHERE organization_username='$sponsor_name'");
$sponsorID = $sponsorID->fetch_assoc();
$dollar2point = $sponsorID['organization_dollar2pt'];
$sponsorID = $sponsorID['organization_id'];

    // Prepare query on drivers table
    $sql_drivers = "UPDATE drivers SET driver_points=? WHERE driver_id=$driver_id";
    $stmt_drivers = $conn->prepare($sql_drivers);
    $stmt_drivers->bind_param("i", $updated_points);

    $sql_DSAssoc = "UPDATE driver_sponsor_assoc SET assoc_points=? WHERE driver_id=$driver_id AND assoc_sponsor_id=$sponsorID";
    $stmt_DSAssoc = $conn->prepare($sql_DSAssoc);
    $stmt_DSAssoc->bind_param("i", $updated_points);

    $point_change = "-" . $_POST['current_item_price'];
    $sql_point_history = "INSERT INTO point_history (point_history_date, point_history_points, point_history_driver_id, point_history_reason, point_history_amount, point_history_associated_sponsor) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt_point_history = $conn->prepare($sql_point_history);
    $stmt_point_history->bind_param("siisss", $regDate, $updated_points, $driver_id, $reason, $point_change, $sponsor_name);

    $sql_audit = "INSERT INTO audit_log_point_changes (audit_log_point_changes_username, audit_log_point_changes_date, audit_log_point_changes_reason, audit_log_point_changes_number) VALUES (?, ?, ?, ?)";
    $stmt_audit = $conn->prepare($sql_audit);
    $stmt_audit->bind_param("ssss", $username, $regDate, $reason, $point_change);

    $sql_order = "INSERT INTO orders (order_driver_id, order_associated_sponsor, order_status, order_date_ordered, order_total_cost, dollar2point) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt_order = $conn->prepare($sql_order);
    $int_driver_id = intval($driver_id);
    $float_item_price = floatval($_POST['current_item_price']);
    $stmt_order->bind_param("isssid", $int_driver_id, $sponsor_name, $order_status, $regDate, $float_item_price, $dollar2point);

    $sql_purchases = "UPDATE catalog SET catalog_purchases=catalog_purchases+1 WHERE catalog_id=?";
    $stmt_purchases = $conn->prepare($sql_purchases);
    $stmt_purchases->bind_param("i", $item_id);

    if($stmt_order->execute()) {
        $order_query = mysqli_query($conn, "SELECT * FROM orders WHERE order_driver_id='$driver_id' ORDER BY order_id DESC LIMIT 1");

        while($rows=$order_query->fetch_assoc()) {
            if($rows['order_driver_id'] == $driver_id) {
                $order_id = $rows['order_id'];
            }
        }

        $sql_order_contents = "INSERT INTO order_contents (order_id, order_contents_item_name, order_contents_item_cost, order_contents_item_image, order_contents_item_release_date, order_contents_item_rating, order_contents_item_type, order_contents_removed) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt_order_contents = $conn->prepare($sql_order_contents);
        $order_contents_removed = 0;
        $stmt_order_contents->bind_param("isissssi", $order_id, $_POST['current_item_name'], $_POST['current_item_price'], $_POST['current_item_image'], $_POST['current_item_release_date'], $_POST['current_item_rating'], $_POST['current_item_type'], $order_contents_removed);
    } else {
        echo '<script>alert("Failed to purchase item...redirecting")</script>';
        echo '<script>window.location.href = ""http://team05sif.cpsc4911.com/S24-Team05/catalog/catalog_home.php""</script>';
    }

    if ($stmt_drivers->execute() && $stmt_point_history->execute() && $stmt_audit->execute() && $stmt_order_contents->execute() && $stmt_purchases->execute() && $stmt_DSAssoc->execute()) {
        echo '<script>alert("Item successfully purchased!\n")</script>';
        echo '<script>window.location.href = "http://team05sif.cpsc4911.com/S24-Team05/catalog/catalog_home.php"</script>';
    }
    else{
        echo '<script>alert("Failed to purchase item...redirecting")</script>';
        echo '<script>window.location.href = ""http://team05sif.cpsc4911.com/S24-Team05/catalog/catalog_home.php""</script>';
    }
?>

</body>
</html>