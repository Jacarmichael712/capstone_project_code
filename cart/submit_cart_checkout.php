<?php include "../../../inc/dbinfo.inc"; ?>

<html>
<body>

<?php
session_start();
$connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
$database = mysqli_select_db($connection, DB_DATABASE);

$result = mysqli_query($connection, "SELECT * FROM sponsors");

// Get the sponsor id associated with the sponsor's username
$username = $_SESSION['username'];
while($rows=$result->fetch_assoc()) {
  if($rows['sponsor_username'] == $username) {
    $sponsor_name = $rows['sponsor_associated_sponsor'];
  }
}

$regDateTime = new DateTime('now');
$regDate = $regDateTime->format("Y-m-d H:i:s");
$username = $_SESSION['username'];

// Create query to get drivers points
$driver_query = mysqli_query($connection, "SELECT * FROM drivers");

// Get the new point value for the driver
while($rows=$driver_query->fetch_assoc()) {
    if($rows['driver_username'] == $username) {
        $driver_points = $rows['driver_points'];
        $driver_id = $rows['driver_id'];
        $driver_sponsor = $rows['driver_associated_sponsor'];
    }
}

$updated_points = $driver_points - $_POST['cart_price'];
$num_items = $_POST['cart_items_num'];
$itemInfo = $_SESSION['cart_item_info'];
$reason = "{$username} checked out their cart";

$sponsor_id = mysqli_query($connection, "SELECT * FROM organizations WHERE organization_username='$driver_sponsor'");
$sponsor_id = $sponsor_id->fetch_assoc();
$dollar2point = $sponsor_id['organization_dollar2pt'];
$sponsor_id = $sponsor_id['organization_id'];


    // Prepare query on drivers table
    $sql_drivers = "UPDATE drivers SET driver_points=? WHERE driver_id=$driver_id";
    $stmt_drivers = $connection->prepare($sql_drivers);
    $stmt_drivers->bind_param("i", $updated_points);

    $point_change = "-" . $_POST['cart_price'];
    $sql_point_history = "INSERT INTO point_history (point_history_date, point_history_points, point_history_driver_id, point_history_reason, point_history_amount, point_history_associated_sponsor) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt_point_history = $connection->prepare($sql_point_history);
    $stmt_point_history->bind_param("ssisss", $regDate, $updated_points, $driver_id, $reason, $point_change, $driver_sponsor);

    $sql_audit = "INSERT INTO audit_log_point_changes (audit_log_point_changes_username, audit_log_point_changes_date, audit_log_point_changes_reason, audit_log_point_changes_number) VALUES (?, ?, ?, ?)";
    $stmt_audit = $connection->prepare($sql_audit);
    $stmt_audit->bind_param("ssss", $username, $regDate, $reason, $point_change);

    $order_status = "Processing";
    $sql_order = "INSERT INTO orders (order_driver_id, order_associated_sponsor, order_status, order_date_ordered, order_total_cost, dollar2point) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt_order = $connection->prepare($sql_order);
    $stmt_order->bind_param("isssid", $driver_id, $driver_sponsor, $order_status, $regDate, $_POST['cart_price'], $dollar2point);

    if($stmt_order->execute()) {
        $order_query = mysqli_query($connection, "SELECT * FROM orders WHERE order_driver_id='$driver_id' ORDER BY order_id DESC LIMIT 1");

        while($rows=$order_query->fetch_assoc()) {
            if($rows['order_driver_id'] == $driver_id) {
                $order_id = $rows['order_id'];
            }
        }

        for($i = 0; $i < count($itemInfo); $i++) {
            
            $itemInfo[$i] = str_replace('"', '', $itemInfo[$i]);
            $individualItemInfo = explode(",", $itemInfo[$i]);

            $item_name = $individualItemInfo[1];
            $artist_name = $individualItemInfo[2];
            $item_price = $individualItemInfo[3];
            $item_release_date = $individualItemInfo[4];
            $rating = $individualItemInfo[5];
            $item_type = $individualItemInfo[6];
  
            $item_image_url = str_replace('\\', '', $individualItemInfo[0]);

            $order_contents_removed = 0;
            $sql_order_contents = "INSERT INTO order_contents (order_id, order_contents_item_name, order_contents_item_cost, order_contents_item_image, order_contents_item_release_date, order_contents_item_rating, order_contents_item_type, order_contents_removed) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt_order_contents = $connection->prepare($sql_order_contents);
            $stmt_order_contents->bind_param("isissssi", $order_id, $item_name, $item_price, $item_image_url, $item_release_date, $rating, $item_type, $order_contents_removed);
            if($stmt_order_contents->execute()) {
                unset($_SESSION['cart_item_info']);
            }
        }

        
    } else {
        echo '<script>alert("Failed to purchase items...redirecting")</script>';
        echo '<script>window.location.href = ""http://team05sif.cpsc4911.com/S24-Team05/catalog/catalog_home.php""</script>';
    }

    $driverResults = mysqli_query($connection, "SELECT * FROM drivers WHERE driver_username = '$username'");
    $driverResults = $driverResults->fetch_assoc();
    $driverID = $driverResults['driver_id'];
    $sponsorName = $driverResults['driver_associated_sponsor'];

    $sponsorID = mysqli_query($connection, "SELECT * FROM organizations WHERE organization_username='$sponsorName'");
    $sponsorID = $sponsorID->fetch_assoc();
    $sponsorID = $sponsorID['organization_id'];

    $sql_cart = "UPDATE driver_sponsor_assoc_cart SET assoc_cart_items=?, assoc_cart_point_total=0, assoc_cart_num_items=0 WHERE driver_id=$driver_id AND assoc_sponsor_id=$sponsorID";
    $cart_no_items = '';
    $stmt_cart = $connection->prepare($sql_cart);
    $stmt_cart->bind_param("s", $cart_no_items);

    $sql_DSAssoc = "UPDATE driver_sponsor_assoc SET assoc_points=? WHERE driver_id=$driver_id AND assoc_sponsor_id=$sponsorID";
    $stmt_DSAssoc = $connection->prepare($sql_DSAssoc);
    $stmt_DSAssoc->bind_param("i", $updated_points);

    //Increments the number of purchases by 1.
    /*$sql_update_purchase = "UPDATE catalog SET catalog_purchases = catalog_purchases + ? WHERE catalog_associated_sponsor=? AND catalog_item_name=?";
    $stmt_update_purchase = $connection->prepare($sql_update_purchase);
    $stmt_update_purchase->bind_param("iss", $num_items, $driver_sponsor, $_POST['current_item_name']);*/


    if ($stmt_drivers->execute() & $stmt_point_history->execute() && $stmt_audit->execute() && $stmt_cart->execute() && $stmt_DSAssoc->execute()) {
        echo '<script>alert("Cart checkout successful!\n")</script>';
        echo '<script>window.location.href = "http://team05sif.cpsc4911.com/S24-Team05/catalog/catalog_home.php"</script>';
    }
    else{
        echo '<script>alert("Failed to checkout cart...redirecting")</script>';
        echo '<script>window.location.href = ""http://team05sif.cpsc4911.com/S24-Team05/catalog/catalog_home.php""</script>';
    }
?>

</body>
</html>