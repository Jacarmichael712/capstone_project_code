<?php include "../../../inc/dbinfo.inc"; ?>
<?php  session_start(); ?>
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
  width: 80%;
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
    width: 1200px;
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
      <h1>History</h1>
   </div>
</div>

<?php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
    $database = mysqli_select_db($connection, DB_DATABASE);

    

    // Check whether account is admin viewing as driver or is an actual driver account
    if(strcmp($_SESSION['account_type'], $_SESSION['real_account_type']) == 0) {
      $driver_info = mysqli_query($connection, "SELECT * FROM drivers");

      while($rows=$driver_info->fetch_assoc()) { 
          if($rows['driver_username'] == $_SESSION['username']) {
              $driver_id = $rows['driver_id'];
          }
      }

    } else if (strcmp($_SESSION['real_account_type'], "administrator") == 0) {
      $driver_info = mysqli_query($connection, "SELECT * FROM administrators");

      while($rows=$driver_info->fetch_assoc()) { 
          if($rows['administrator_username'] == $_SESSION['username']) {
              $driver_id = $rows['administrator_id'];
          }
      }
      
    } else {
      $driver_info = mysqli_query($connection, "SELECT * FROM sponsors");

      while($rows=$driver_info->fetch_assoc()) { 
          if($rows['sponsor_username'] == $_SESSION['username']) {
              $driver_id = $rows['sponsor_id'];
          }
      }
    }

    $result = mysqli_query($connection, "SELECT * FROM orders WHERE order_driver_id=$driver_id ORDER BY order_date_ordered DESC");

    $regDateTime = new DateTime('now');
    $regDate = $regDateTime->format("Y-m-d");
    
    // Update order status
    while($rows=$result->fetch_assoc()) {
      if($rows['order_status'] != "Cancelled") {
        $date_shipped_time = new DateTime($rows['order_date_ordered']);
        $date_shipped_time->modify('+1 day');
        $date_shipped = $date_shipped_time->format("Y-m-d");

        $date_delivered_time = new DateTime($rows['order_date_ordered']);
        $date_delivered_time->modify('+3 days');
        $date_delivered = $date_delivered_time->format("Y-m-d");
        $date_delivered_timestamp = $date_delivered_time->format("Y-m-d H:i:s");
      
        // Update table if order is shipped (orders are shipped after 1 day)
        if($regDate >= $date_shipped) {
          $order_id = $rows['order_id'];
          $order_status = "Shipped";

          $sql_orders = "UPDATE orders SET order_status=? WHERE order_id='$order_id'";
          $stmt_orders = $connection->prepare($sql_orders);
          $stmt_orders->bind_param("s", $order_status);
          $stmt_orders->execute();
        }

        // Update table if order is delivered (orders are delivered after 3 days)
        if($regDate >= $date_delivered) {
          $order_id = $rows['order_id'];
          $order_status = "Delivered";

          $sql_orders = "UPDATE orders SET order_status=? WHERE order_id='$order_id'";
          $stmt_orders = $connection->prepare($sql_orders);
          $stmt_orders->bind_param("s", $order_status);
          $stmt_orders->execute();

          $sql_delivery_date = "UPDATE orders SET order_date_delivered=? WHERE order_id='$order_id'";
          $stmt_delivery_date = $connection->prepare($sql_delivery_date);
          $stmt_delivery_date->bind_param("s", $date_delivered_timestamp);
          $stmt_delivery_date->execute();
        }
      }
    }

    $result = mysqli_query($connection, "SELECT * FROM orders WHERE order_driver_id=$driver_id ORDER BY order_date_ordered DESC");
?>

<div class="div_before_table">
<table id="myTable2">
    <tr>
        <th class="sticky">Order ID</th>
        <th class="sticky">Date Ordered</th>
        <th class="sticky" onclick="sortTableByText(0)">Status</th>
        <th class="sticky">Total Cost</th>
        <th class="sticky">Contents</th>
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
        <td><?php echo $rows['order_date_ordered'];?></td>
        <td><?php echo $rows['order_status'];?></td>
        <td><?php echo $rows['order_total_cost'];?></td>
        <td>
            <form action="http://team05sif.cpsc4911.com/S24-Team05/order/order_view_contents.php" method="post">
                <input type="hidden" name="order_id" value="<?= $rows['order_id'] ?>">
                <input type="hidden" name="order_status" value="<?= $rows['order_status'] ?>">
                <input type="hidden" name="order_point_cost" value="<?= $rows['order_total_cost'] ?>">
                <input type="submit" class="link" value="View More Info..."/>
            </form>
        </td>
    </tr>
    <?php
        }
    ?>
</table>
</div>

<script type="text/javascript">
  // Sorting function for the table columns from W3Schools
  function sortTableByText(n) {
    var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
    table = document.getElementById("myTable2");
    switching = true;
    // Set the sorting direction to ascending:
    dir = "asc";
    /* Make a loop that will continue until
    no switching has been done: */
    while (switching) {
      // Start by saying: no switching is done:
      switching = false;
      rows = table.rows;
      /* Loop through all table rows (except the
      first, which contains table headers): */
      for (i = 1; i < (rows.length - 1); i++) {
        // Start by saying there should be no switching:
        shouldSwitch = false;
        /* Get the two elements you want to compare,
        one from current row and one from the next: */
        x = rows[i].getElementsByTagName("TD")[n];
        y = rows[i + 1].getElementsByTagName("TD")[n];
        /* Check if the two rows should switch place,
        based on the direction, asc or desc: */
        if (dir == "asc") {
          if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
            // If so, mark as a switch and break the loop:
            shouldSwitch = true;
            break;
          }
        } else if (dir == "desc") {
          if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
            // If so, mark as a switch and break the loop:
            shouldSwitch = true;
            break;
          }
        }
      }
      if (shouldSwitch) {
        /* If a switch has been marked, make the switch
        and mark that a switch has been done: */
        rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
        switching = true;
        // Each time a switch is done, increase this count by 1:
        switchcount ++;
      } else {
        /* If no switching has been done AND the direction is "asc",
        set the direction to "desc" and run the while loop again. */
        if (switchcount == 0 && dir == "asc") {
          dir = "desc";
          switching = true;
        }
      }
    }
  }
</script>

</body>
</html>