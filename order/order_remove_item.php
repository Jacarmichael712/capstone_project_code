<?php include "../../../inc/dbinfo.inc"; ?>
<?php session_start();?>


<?php
    $order_id = $_POST['order_id'];
    $item_name = $_POST['order_item_name'];
    $item_cost = $_POST['order_item_cost'];
    $new_item_status = 1;

    $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
    $database = mysqli_select_db($connection, DB_DATABASE);

    $regDateTime = new DateTime('now');
    $regDate = $regDateTime->format("Y-m-d H:i:s");
    $driver_info = mysqli_query($connection, "SELECT * FROM drivers");

    while($rows=$driver_info->fetch_assoc()) { 
        if($rows['driver_username'] == $_SESSION['username']) {
            $driver_id = $rows['driver_id'];
            $driver_points = $rows['driver_points'];
        }
    }
    $new_points = $driver_points + $item_cost;

    $sql_removed = "UPDATE order_contents SET order_contents_removed=? WHERE order_id='$order_id' AND order_contents_item_name=?";
    $stmt_removed = $connection->prepare($sql_removed);
    $stmt_removed->bind_param("is", $new_item_status, $item_name);

    $sql_point_update = "UPDATE drivers SET driver_points=? WHERE driver_id='$driver_id'";
    $stmt_point_update = $connection->prepare($sql_point_update);
    $stmt_point_update->bind_param("i", $new_points);

    $reason = "Item {$item_name} was removed from Order-{$order_id}.";
    $username = $_SESSION['username'];
    $sql_audit = "INSERT INTO audit_log_point_changes (audit_log_point_changes_username, audit_log_point_changes_date, audit_log_point_changes_reason, audit_log_point_changes_number) VALUES (?, ?, ?, ?)";
    $stmt_audit = $connection->prepare($sql_audit);
    $stmt_audit->bind_param("ssss", $username, $regDate, $reason, $item_cost);

    if ($stmt_removed->execute() && $stmt_point_update->execute() && $stmt_audit->execute()) {
        $order_details = mysqli_query($connection, "SELECT * FROM order_contents WHERE order_id = '$order_id'");
        $cancel_order_flag = true;
        while($row=$order_details->fetch_assoc()) {
            if($row['order_contents_removed'] == 0) {
                var_dump($row);
                $cancel_order_flag = false;
            }
        }
        if($cancel_order_flag){
            $cancel = "Cancelled";
            $sql_cancel = "UPDATE orders SET order_status=? WHERE order_id='$order_id'";
            $stmt_cancel = $connection->prepare($sql_cancel);
            $stmt_cancel->bind_param("s", $cancel);
            $stmt_cancel->execute();
        }
        echo '<script>alert("Item was succesfully removed!\n")</script>';
        echo '<script>window.location.href = "http://team05sif.cpsc4911.com/S24-Team05/order/order_history.php"</script>';
    } else {
        echo '<script>alert("There was an error removing your item...\n")</script>';
    }
?>