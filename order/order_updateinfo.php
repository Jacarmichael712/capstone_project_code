<?php include "../../../inc/dbinfo.inc"; ?>
<?php session_start();?>
<html>

<head>
<style type="text/css">
body {
  background-color: #fff5d1;
  margin: 0;
  padding: 0;
  height: auto;
  width: auto;
}

h1 {
  text-align: left;
  margin-left: 5%;
  margin-top: 15%;
  font-family: "Monaco", monospace;
  /*font-size: 3em;*/
  font-size: 2.5vmax;
  color: #FEF9E6;
}

p {
  margin-top: 15%;
  font-family: "Monaco", monospace;
  /*font-size: 1.25em;*/
  font-size: 1.25vmax;
  color: #FF0000;
}

#flex-container-header {
  display: flex;
  flex: 1;
  justify-content: stretch;
  margin-top: 2.5%;
  background-color: #ff5e6c;
}

#flex-container-child {
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 1.5%;
  margin-left: 2%
}

form {
  text-align: center;
  margin: 20px 20px;
}

input[type=text], input[type=password] {
  width: 60%;
  padding: 12px 20px;
  margin: 8px 0;
  box-sizing: border-box;
}

input[type=submit] {
  width: 50%;
  padding: 12px 20px;
  background-color: #F2E6B7;
  font-family: "Monaco", monospace;
  font-size: 1.25vmax;
}

input[type=submit]:hover {
  background-color: #F1E8C9;
}

#hyperlink-wrapper {
  text-align: center;
  margin-top: 20px;
}

#hyperlink {
  text-align: center;
  justify-content: center;
  font-family: "Monaco", monospace;
  font-size: 1.25vmax;
  margin-top: 10px;
}

table {
  margin-left: auto;
  margin-right: auto;
}

td {
  text-align: center;
  width:400px;
  font-family: "Monaco", monospace;
  padding: 12px 20px;
  margin: 8px 0;
  font-size: 1.25vmax;
  border: 1px solid;
}

tr:nth-child(even) {
  background-color: #effad9;
  text-align: center;
  width:400px;
  font-family: "Monaco", monospace;
  padding: 12px 20px;
  margin: 8px 0;
  font-size: 1.25vmax;
}

.div_before_table {
    overflow:hidden;
    overflow-y: scroll;
    overscroll-behavior: none;
    height: 500px;
    width: 1250px;
    margin-top: 0.5%;
    margin-bottom: 2.5%;
    margin-left: auto;
    margin-right: auto;
    border: 4px solid;
    border-color: #ff5e6c;
}

.sticky {
  position: sticky;
  top: 0;
}

th {
  background-color: #ff5e6c;
  width:400px;
  font-family: "Monaco", monospace;
  padding: 12px 20px;
  margin: 8px 0;
  font-size: 1.25vmax;
  border: 2px solid;
}

.navbar {
  overflow: hidden;
  background-color: #FEF9E6;
  font-family: "Monaco", monospace;
  margin-bottom: -2.5%;
}

.navbar a {
  float: left;
  font-size: 16px;
  font-family: "Monaco", monospace;
  color: white;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
}

.dropdown {
  float: left;
  overflow: hidden;
}

.dropdown .dropbtn {
  font-size: 16px;  
  border: none;
  outline: none;
  color: black;
  padding: 14px 16px;
  background-color: inherit;
  font-family: inherit;
  margin: 0;
}

.navbar a:hover, .dropdown:hover .dropbtn {
  background-color: #fff5d1;
;
}

.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f9f9f9;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

.dropdown-content a {
  float: none;
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
  text-align: left;
}

.dropdown-content a:hover {
  background-color: #ddd;
}

.dropdown:hover .dropdown-content {
  display: block;
}

.menu { 
  float: none;
  color: black;
  font-size: 16px;
  margin: 0;
  text-decoration: none;
  display: block;
  text-align: left;
} 
.menu a{ 
  float: left;
  overflow: hidden;
  font-size: 16px;  
  border: none;
  outline: none;
  color: black;
  padding: 12px 16px;
  background-color: inherit;
  font-family: inherit;
  margin: 0;
}
input.remove {
  background-color: #F2E6B7;
  font-family: "Monaco", monospace;
  font-size: 0.8vmax;
  width: 80%;
  padding: 0px 0px;
  margin: 0px 8px;
  cursor:pointer
}
</style>
</head>

<div class="navbar">
    <div class="menu">
      <a href="/S24-Team05/account/homepageredirect.php">Home</a>
      <a href="/S24-Team05/account/profileuserinfo.php">Profile</a>
      <a href="/S24-Team05/account/logout.php">Logout</a>
      <a href="/S24-Team05/driver_about_page.php">About</a>
      <?php if($curr_sponsor != "none") {?> <a href="/S24-Team05/catalog/catalog_home.php">Catalog</a> <?php } ?>
      <?php if($curr_sponsor != "none") {?> <a href="/S24-Team05/order/order_history.php">Orders</a> <?php } ?>
    </div>
</div>

<body>

<div id = "flex-container-header">
    <div id = "flex-container-child">
      <h1>Order</h1>
      <h1>Details</h1>
   </div>
</div>

<?php

$order_id = $_POST['order_id'];
$order_point_cost = $_POST['order_point_cost'];
$order_status = $_POST['order_status'];
$driver_user = $_SESSION['username'];
// get info
$connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
$database = mysqli_select_db($connection, DB_DATABASE);

$order_info = mysqli_query($connection, "SELECT * FROM orders WHERE order_id=$order_id");

$rows = $order_info->fetch_assoc();


$date_ordered = (new DateTime($rows['order_date_ordered']))->format('Y-m-d');
$status = $rows['order_status'];
$estimated_date = ((new DateTime($rows['order_date_ordered']))->modify('+3 days'))->format("Y-m-d");
$delivered_date = $rows['order_date_delivered'];

$result = mysqli_query($connection, "SELECT * FROM order_contents WHERE order_id=$order_id");

$driver_info = mysqli_query($connection, "SELECT driver_address FROM drivers WHERE driver_username='$driver_user'");
$driver_addr = $driver_info->fetch_assoc();

?>

<div class="div_before_table">
<table>
    <tr>
        <th class="sticky">Order ID</th>
        <th class="sticky">Item Name</th>
        <th class="sticky">Item Cost</th>
        <th class="sticky">Status</th>
        <th class="sticky">Date Ordered</th>
        <?php if($order_status === "Delivered"){ ?>
          <th class="sticky">Date Delivered</th>
        <?php } ?>
        <?php if($order_status === "Shipped" || $order_status === "Processing"){ ?>
          <th class="sticky">Estimated Delivery Date</th>
        <?php } ?>
        <th class="sticky">Order Destination</th>
        <th class="sticky">Remove Item</th>

    </tr>
    <!-- PHP CODE TO FETCH DATA FROM ROWS -->
    <?php 
        // LOOP TILL END OF DATA
        while($rows=$result->fetch_assoc())
        {
    ?>
    <tr>
        <!-- FETCHING DATA FROM EACH
            ROW OF EVERY COLUMN -->
        <td><?php echo $rows['order_id'];?></td>
        <td><?php echo $rows['order_contents_item_name'];?></td>
        <td><?php echo $rows['order_contents_item_cost'];?></td>
        <?php if($rows['order_contents_removed'] == 1){?>
        <td><?php echo 'Removed';?></td>
        <?php } else {echo "<td>",$status,"</td>";} ?>
        <td><?php echo $date_ordered?></td>
        <?php if($status === "Delivered"){?>
        <td><?php echo $delivered_date;?></td>
        <?php
              }
        ?>
        <?php if($order_status === "Shipped" || $order_status === "Processing"){?>
        <td><?php echo $estimated_date;?></td>
        <?php
              }
        ?>
        <td><?php echo $driver_addr['driver_address']?></td>
        <?php if($rows['order_contents_removed'] == 0){ ?>
        <td>
            <form action="http://team05sif.cpsc4911.com/S24-Team05/order/order_remove_item.php" method="post">
                <input type="hidden" name="order_id" value="<?= $rows['order_id'] ?>">
                <input type="hidden" name="order_item_name" value="<?= $rows['order_contents_item_name'] ?>">
                <input type="hidden" name="order_status" value="<?= $rows['order_status'] ?>">
                <input type="hidden" name="order_item_cost" value="<?= $rows['order_contents_item_cost'] ?>">
                <input type="submit" class="remove" value="Remove"/>
            </form>
        </td>
        <?php }else{echo "<td>Item Removed</td>";} ?>
    <?php
        }
    ?>

    </tr>
</table>
</div>
<?php 
if($_POST['order_status'] === "Processing") {
?>

<form action="http://team05sif.cpsc4911.com/S24-Team05/order/order_history.php" method="post">
    <input type="hidden" name="order_id" value="<?= $order_id ?>">
    <input type="hidden" name="order_point_cost" value="<?= $order_point_cost ?>">
    <input type="submit" class="link" value="Finalize Changes"/>
</form>
<?php
} 
?>
</body>
</html>