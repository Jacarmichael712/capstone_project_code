<?php include "../../../inc/dbinfo.inc"; ?>
<?php session_start(); ?>
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
  color: #FEF9E6
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
  /*padding: 1.5%;*/
  margin-left: 2%
}

form {
  text-align: center;
  margin: 20px 20px;
}

input[type=text] {
  width: 60%;
  padding: 12px 20px;
  margin: 8px 0;
  box-sizing: border-box;
}

input[type=password] {
  width: 60%;
  padding: 12px 20px;
  margin: 8px 0;
  box-sizing: border-box;
}

input[type=submit] {
  width: 60%;
  padding: 12px 20px;
  margin: 8px 0;
  box-sizing: border-box;
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
  cursor: pointer;
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

<body>

<?php
    ini_set('display_startup_errors',1); 
    ini_set('display_errors',1);
    error_reporting(-1);

    $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
    $database = mysqli_select_db($connection, DB_DATABASE);

    // Get curr sponsor. If curr sponsor is "none" restrict access to certain buttons
    $account_id = $_SESSION['user_data'][$_SESSION['real_account_type'] . '_id'];
    $sponsor_name_query = mysqli_query($connection, "SELECT * FROM " . $_SESSION['real_account_type'] . "s WHERE ". $_SESSION['real_account_type'] ."_id='$account_id'");

    while($rows=$sponsor_name_query->fetch_assoc()) {
        $curr_sponsor = $rows[$_SESSION['real_account_type'] . '_associated_sponsor'];
    }

    // Check whether account is admin viewing as sponsor or is an actual sponsor account
    if(strcmp($_SESSION['account_type'], $_SESSION['real_account_type']) == 0) {
      $result = mysqli_query($connection, "SELECT * FROM drivers");

      // Get the sponsor id associated with the sponsor's username
      $username = $_SESSION['username'];
      while($rows=$result->fetch_assoc()) {
          if($rows['driver_username'] == $username) {
              $sponsor_name = $rows['driver_associated_sponsor'];
          }
      }

    } else if (strcmp($_SESSION['real_account_type'], "sponsor") == 0) {
        $result = mysqli_query($connection, "SELECT * FROM sponsors");
        
        // Get the sponsor id associated with the sponsor's username
        $username = $_SESSION['username'];
        while($rows=$result->fetch_assoc()) {
            if($rows['sponsor_username'] == $username) {
                $sponsor_name = $rows['sponsor_associated_sponsor'];
            }
        }
    } 
    else if (strcmp($_SESSION['real_account_type'], "administrator") == 0) {
      $result = mysqli_query($connection, "SELECT * FROM administrators");
      
      // Get the sponsor id associated with the sponsor's username
      $username = $_SESSION['username'];
      while($rows=$result->fetch_assoc()) {
          if($rows['administrator_username'] == $username) {
              $sponsor_name = $rows['administrator_associated_sponsor'];
          }
      }
  }

  $result = mysqli_query($connection, "SELECT * FROM organizations WHERE organization_archived=0");

  while($rows=$result->fetch_assoc())
  {
    if($sponsor_name == $rows['organization_username']) {
      $organization_id = $rows['organization_id'];
    }
  }

  $result2 = mysqli_query($connection, "SELECT * FROM application_driver_info WHERE driver_username='$username'");
?>

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

<div id = "flex-container-header">
    <div id = "flex-container-child">
      <h1>Your</h1>
      <h1>Applications</h1>
   </div>
</div>

<div class="div_before_table">
<table id="myTable2">
    <tr>
        <th class="sticky" onclick="sortTableByNumber(0)">Application ID</th>
        <th class="sticky" onclick="sortTableByText(1)">Application Date</th>
        <th class="sticky" onclick="sortTableByText(2)">Organization</th>
        <th class="sticky" onclick="sortTableByText(3)">Application Status</th>
        <th class="sticky" onclick="sortTableByText(4)">Decision Date</th>
        <th class="sticky" onclick="sortTableByText(5)">Decision Reasoning</th>
    </tr>
    <!-- PHP CODE TO FETCH DATA FROM ROWS -->
    <?php 
        // LOOP TILL END OF DATA
        while($rows=$result2->fetch_assoc())
        {
            $org_id = $rows['organization_id'];
            $org_name = mysqli_query($connection, "SELECT * FROM organizations WHERE organization_id=$org_id");
            $org_name = ($org_name->fetch_assoc())['organization_username'];
    ?>
    <tr>
        <!-- FETCHING DATA FROM EACH
            ROW OF EVERY COLUMN -->
        <td><?php echo $rows['application_id'];?></td>
        <td><?php echo $rows['application_date'];?></td>
        <td><?php echo $org_name;?></td>
        <td><?php echo $rows['application_status'];?></td>
        <td><?php echo $rows['decision_date'];?></td>
        <td><?php echo $rows['application_reasoning'];?></td>
    </tr>
    <?php
        }
    ?>
</table>

<!-- Javascript table sorting function sourced from W3Schools. Link to code in README -->
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

  function sortTableByNumber(n) {
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
          if (parseInt(x.innerHTML) > parseInt(y.innerHTML)) {
            // If so, mark as a switch and break the loop:
            shouldSwitch = true;
            break;
          }
        } else if (dir == "desc") {
          if (parseInt(x.innerHTML) < parseInt(y.innerHTML)) {
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

</div>
<!-- Clean up. -->
<?php
        mysqli_free_result($result);
        mysqli_close($connection);
?>
</body>
</html>