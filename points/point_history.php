<?php include "../../../inc/dbinfo.inc"; 
session_start();
?>

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
</style>
</head>
<body>

<?php
if(strcmp($_SESSION['account_type'], "administrator") == 0) {
  ?>
    <div class="navbar">
    <div class="menu">
      <a href="/S24-Team05/account/homepageredirect.php">Home</a>
      <a href="/S24-Team05/account/profileuserinfo.php">Profile</a>
      <a href="/S24-Team05/account/logout.php">Logout</a>
      <a href="/S24-Team05/admin_about_page.php">About</a>
    </div>
    <div class="dropdown">
      <button class="dropbtn">Audit Log 
        <i class="fa fa-caret-down"></i>
      </button>
      <div class="dropdown-content">
        <a href="/S24-Team05/audit/logins.php">Login Attempts - All </a>
        <a href="/S24-Team05/audit/logins_all_drivers.php">Login Attempts - Drivers</a>
        <a href="/S24-Team05/audit/logins_all_sponsors.php">Login Attempts - Sponsors</a>
        <a href="/S24-Team05/audit/logins_all_admins.php">Login Attempts - Admins</a>
        <a href="/S24-Team05/audit/password_changes.php">Password Changes - All</a>
        <a href="/S24-Team05/audit/password_changes_all_drivers.php">Password Changes - Drivers</a>
        <a href="/S24-Team05/audit/password_changes_all_sponsors.php">Password Changes - Sponsors</a>
        <a href="/S24-Team05/audit/password_changes_all_admins.php">Password Changes - Admins</a>
        <a href="/S24-Team05/audit/point_changes_all_drivers.php">Point Changes - All Drivers</a>
        <a href="/S24-Team05/audit/email_changes.php">Email Changes - All</a>
        <a href="/S24-Team05/audit/username_changes.php">Username Changes - All</a>
      </div>
    </div>
    <div class="dropdown">
      <button class="dropbtn">Create Account
        <i class="fa fa-caret-down"></i>
      </button>
      <div class="dropdown-content">
        <a href="/S24-Team05/account/driver_account_creation.php">Driver Account</a>
        <a href="/S24-Team05/account/sponsor_account_creation.php">Sponsor Account</a>
        <a href="/S24-Team05/account/admin_account_creation.php">Admin Account</a>
      </div>
    </div>
    <div class="menu">
      <a href="/S24-Team05/account/admin_view_organizations.php">View Organizations</a>
    </div>
    <div class="dropdown">
      <button class="dropbtn">Archive Accounts
        <i class="fa fa-caret-down"></i>
      </button>
      <div class="dropdown-content">
        <a href="/S24-Team05/account/admin_archive_account.php">Archive Account</a>
        <a href="/S24-Team05/account/admin_unarchive_account.php">Unarchive Account</a>
      </div>
    </div>
    <div class="dropdown">
      <button class="dropbtn">Edit User
        <i class="fa fa-caret-down"></i>
      </button>
      <div class="dropdown-content">
        <a href="/S24-Team05/account/admin_edit_driver_account.php">Edit Driver</a>
        <a href="/S24-Team05/account/admin_edit_sponsor_account.php">Edit Sponsor</a>
        <a href="/S24-Team05/account/admin_edit_admin_account.php">Edit Admin</a>
      </div>
    </div>
  </div>
  <?php
} else if(strcmp($_SESSION['account_type'], "sponsor") == 0) {
  ?>
  <div class="navbar">
    <div class="menu">
      <a href="/S24-Team05/account/homepageredirect.php">Home</a>
      <a href="/S24-Team05/account/profileuserinfo.php">Profile</a>
      <a href="/S24-Team05/account/logout.php">Logout</a>
      <a href="/S24-Team05/sponsor_about_page.php">About</a>
    </div>
    <div class="dropdown">
      <button class="dropbtn">Catalog 
        <i class="fa fa-caret-down"></i>
      </button>
      <div class="dropdown-content">
        <a href="/S24-Team05/catalog/sponsor_catalog_home.php">View Catalog</a>
        <a href="/S24-Team05/catalog/sponsor_add_to_catalog.php">Add to Catalog</a>
      </div>
    </div>
    <div class="dropdown">
      <button class="dropbtn">Audit Log 
        <i class="fa fa-caret-down"></i>
      </button>
      <div class="dropdown-content">
        <a href="/S24-Team05/audit/logins_drivers_under_sponsor.php">Login Attempts</a>
        <a href="/S24-Team05/audit/password_changes_under_sponsor.php">Password Changes</a>
        <a href="/S24-Team05/audit/point_changes_under_sponsor.php">Point Changes</a>
        <a href="/S24-Team05/audit/email_changes_under_sponsor.php">Email Changes</a>
        <a href="/S24-Team05/audit/username_changes_under_sponsor.php">Username Changes</a>
      </div>
    </div>
    <div class="dropdown">
      <button class="dropbtn">Set Driving Behavior
        <i class="fa fa-caret-down"></i>
      </button>
      <div class="dropdown-content">
        <a href="/S24-Team05/points/set_behavior.php">Add New Behavior</a>
        <a href="/S24-Team05/points/remove_behavior.php">Remove Behavior</a>
      </div>
    </div>
    <div class="dropdown">
      <button class="dropbtn">Create Account
        <i class="fa fa-caret-down"></i>
      </button>
      <div class="dropdown-content">
        <a href="/S24-Team05/account/sponsor_account_creation.php">Sponsor Account</a>
      </div>
    </div>
    <div class="dropdown">
      <button class="dropbtn">Archive Accounts
        <i class="fa fa-caret-down"></i>
      </button>
      <div class="dropdown-content">
        <a href="/S24-Team05/account/sponsor_archive_account.php">Archive Account</a>
        <a href="/S24-Team05/account/sponsor_unarchive_account.php">Unarchive Account</a>
      </div>
    </div>
    <div class="dropdown">
      <button class="dropbtn">Edit User
        <i class="fa fa-caret-down"></i>
      </button>
      <div class="dropdown-content">
        <a href="/S24-Team05/account/sponsor_edit_driver_account.php">Edit Driver</a>
        <a href="/S24-Team05/account/sponsor_edit_sponsor_account.php">Edit Sponsor</a>
      </div>
    </div>
  </div>
  <?php
} else {
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
  <?php
}
?>

<div id = "flex-container-header">
    <div id = "flex-container-child">
      <h1>Point</h1>
      <h1>History</h1>
   </div>
</div>

<?php
    $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
    $database = mysqli_select_db($connection, DB_DATABASE);

    // Check whether account is admin viewing as driver or is an actual driver account
    if(strcmp($_SESSION['account_type'], $_SESSION['real_account_type']) == 0) {
      $result = mysqli_query($connection, "SELECT * FROM drivers");
    
      // Get the driver id
      $account_type = $_SESSION['account_type'];
      if($account_type == 'driver') {
        $username = $_SESSION['username'];
        while($rows=$result->fetch_assoc()) {
          if($rows['driver_username'] == $username) {
            $driver_id = $rows['driver_id'];
            $currSponsor = $rows['driver_associated_sponsor'];
          }
        }
      } else {
        $driver_id = $_POST['driver_id'];
      }

      $result2 = mysqli_query($connection, "SELECT * FROM drivers WHERE driver_id = '$driver_id' AND driver_archived=0");

    } else if (strcmp($_SESSION['real_account_type'], "administrator") == 0) {
      $result = mysqli_query($connection, "SELECT * FROM administrators");
    
      // Get the driver id
      $account_type = $_SESSION['account_type'];
      if($account_type == 'driver') {
        $username = $_SESSION['username'];
        while($rows=$result->fetch_assoc()) {
          if($rows['administrator_username'] == $username) {
            $driver_id = $rows['administrator_id'];
          }
        }
      } else {
        $driver_id = $_POST['driver_id'];
      }

      $result2 = mysqli_query($connection, "SELECT * FROM administrators WHERE administrator_id = '$driver_id' AND administrator_archived=0");
      
    }

    

   /* // Check for invald info
    if(!($row=$result2->fetch_row())){
      echo '<script>alert("The Driver ID is invalid. \n\nPlease enter in a new ID number and retry...")</script>';
      echo '<script>window.location.href = "admin_enter_driver_id.php"</script>';
    }*/

    if($account_type == "driver") {
      $result3 = mysqli_query($connection, "SELECT * FROM point_history 
                                          WHERE point_history_driver_id = '$driver_id' 
                                          AND point_history_associated_sponsor = '$currSponsor'
                                          ORDER BY point_history_date DESC;");
    }
    else {
      $result3 = mysqli_query($connection, "SELECT * FROM point_history 
                                          WHERE point_history_driver_id = '$driver_id' 
                                          ORDER BY point_history_date DESC;");
    }
?>

<div class="div_before_table">
<table id="myTable2">
    <tr>
        <th class="sticky" onclick="sortTableByNumber(0)">Total Points</th>
        <th class="sticky" onclick="sortTableByText(1)">Date</th>
        <th class="sticky" onclick="sortTableByNumber(2)">Point Change</th>
        <th class="sticky" onclick="sortTableByText(3)">Reason for Change</th>
        <th class="sticky">Sponsor</th>
    </tr>
    <!-- PHP CODE TO FETCH DATA FROM ROWS -->
    <?php 
        // LOOP TILL END OF DATA
        while($rows=$result3->fetch_assoc())
        {
    ?>
    <tr>
        <!-- FETCHING DATA FROM EACH
            ROW OF EVERY COLUMN -->
        <td><?php echo $rows['point_history_points'];?></td>
        <td><?php echo $rows['point_history_date'];?></td>
        <td><?php echo $rows['point_history_amount'];?></td>
        <td><?php echo $rows['point_history_reason'];?></td>
        <td><?php echo $rows['point_history_associated_sponsor'];?></td>
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
</body>
</html>