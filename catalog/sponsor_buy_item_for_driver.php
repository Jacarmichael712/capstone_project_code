<?php include "../../../inc/dbinfo.inc";
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

h2 {
    font-family: "Monaco", monospace;
    text-align: left;
    /*font-size: 1.25em;*/
    font-size: 1.25vmax;
    color: #0A1247;
    margin-left: 10%;
}

p {
  font-family: "Monaco", monospace;
  text-align: center;
  /*font-size: 1.25em;*/
  font-size: 1.25vmax;
  color: #0A1247;
  margin-left: 10%
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

.grid-container {
  display: grid;
  grid-template-columns: 90% 100%;
  gap: 30px;
  background-color: #fff5d1;
  padding: 10px;
}

.grid-container > div {
  background-color: #fff5d1/*FEF9E6*/;
  text-align: center;
  padding: 20px 0;
  font-size: 30px;
}

form {
  text-align: cneter;
  margin: 1px;
}

input[type=text], input[type=password] {
  width: 60%;
  padding: 12px 20px;
  margin: 8px 0;
  box-sizing: border-box;
}

input[type=submit] {
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

<body>

<div id = "flex-container-header">
    <div id = "flex-container-child">
      <h1>Buy</h1>
      <h1>Item</h1>
      <h1>For</h1>
      <h1>Driver</h1>
   </div>
</div>

<body>

<?php
    $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
    $database = mysqli_select_db($connection, DB_DATABASE);

    $image_data = $_POST['item_image'];
    $item_id = $_POST['item_id'];
    $item_name = $_POST['item_name'];
    $item_artist = $_POST['item_artist'];
    $item_price = $_POST['item_price'];
    $item_release_date = $_POST['item_release_date'];
    $advisory_rating = $_POST['advisory_rating'];
    $item_type = $_POST['item_type'];

    $item_image = base64_encode(file_get_contents($image_data));

    // Check whether account is admin viewing as sponsor or is an actual sponsor account
    if(strcmp($_SESSION['account_type'], $_SESSION['real_account_type']) == 0) {
        $result = mysqli_query($connection, "SELECT * FROM sponsors");

        // Get the sponsor id associated with the sponsor's username
        $username = $_SESSION['username'];
        while($rows=$result->fetch_assoc()) {
            if($rows['sponsor_username'] == $username) {
                $sponsor_name = $rows['sponsor_associated_sponsor'];
            }
        }
        } else if (strcmp($_SESSION['real_account_type'], "administrator") == 0) {
        $result = mysqli_query($connection, "SELECT * FROM administrators");

        // Get the sponsor id associated with the sponsor's username
        $username = $_SESSION['username'];
        while($rows=$result->fetch_assoc()) {
            if($rows['administrator_username'] == $username) {
                $sponsor_name = $rows['administrator_associated_sponsor'];
            }
        }
        }

    $sponsor_id = mysqli_query($connection, "SELECT * FROM organizations WHERE organization_username='$sponsor_name'");
    $sponsor_id = $sponsor_id->fetch_assoc();
    $dollar2point = $sponsor_id['dollar2point'];
    $sponsor_id = $sponsor_id['organization_id'];

    $result2 = mysqli_query($connection, "SELECT * FROM driver_sponsor_assoc 
                                          JOIN drivers ON drivers.driver_id = driver_sponsor_assoc.driver_id
                                          WHERE assoc_sponsor_id=$sponsor_id 
                                          AND driver_sponsor_assoc_archived=0 
                                          AND driver_archived=0
                                          ORDER BY drivers.driver_username");
?>
<div class = "grid-container">
    <div class = "item">
    <?php
      echo '<p><img src="data:image/jpeg;base64,'.$item_image.'"></p>';
      if($item_type == "album") {
          echo "<p>Album Name: $item_name</p>";
          echo "<p>Artist Name: $item_artist</p>";
          echo "<p>Album Point Cost: $item_price</p>";
      } else if ($item_type == "movie") {
          echo "<p>Movie Name: $item_name</p>";
          echo "<p>Director: $artist_name</p>";
          echo "<p>Movie Point Cost: $item_price</p>";
      }
      echo "<p>Release Date: $item_release_date</p>";
      if($advisory_rating != NULL) {
          echo "<p>Content Advisory Rating: $advisory_rating</p>";
      }
    ?>
    </div>
</div>

<div class="div_before_table">
<table id="myTable2">
    <tr>
        <th class="sticky" onclick="sortTableByText(0)">Driver Username</th>
        <th class="sticky" onclick="sortTableByText(1)">Driver First Name</th>
        <th class="sticky" onclick="sortTableByText(2)">Driver Last Name</th>
        <th class="sticky" onclick="sortTableByNumber(3)">Driver Total Points</th>
        <th class="sticky">Submit Order</th>
    </tr>
    <!-- PHP CODE TO FETCH DATA FROM ROWS -->
    <?php 
        // LOOP TILL END OF DATA
        while($rows=$result2->fetch_assoc())
        {
    ?>
    <tr>
        <!-- FETCHING DATA FROM EACH
            ROW OF EVERY COLUMN -->
        <td><?php echo $rows['driver_username'];?></td>
        <td><?php echo $rows['driver_first_name'];?></td>
        <td><?php echo $rows['driver_last_name'];?></td>
        <td><?php echo $rows['assoc_points'];?></td>
        <td>
            <form action="http://team05sif.cpsc4911.com/S24-Team05/catalog/submit_sponsor_buy_item_for_driver.php" method="post">
                <input type="hidden" name="driver_id" value="<?= $rows['driver_id']?>">
                <input type="hidden" name="sponsor_id" value="<?= $sponsor_id?>">
                <input type="hidden" name="sponsor_name" value="<?= $sponsor_name?>">
                <input type="hidden" name="dollar2point" value="<?= $dollar2point?>">
                <input type="hidden" name="driver_username" value="<?= $rows['driver_username']?>">
                <input type="hidden" name="item_id" value="<?= $item_id?>">
                <input type="hidden" name="current_item_price" value="<?= $item_price ?>">
                <input type="hidden" name="current_item_name" value="<?= $item_name ?>">
                <input type="hidden" name="current_item_image" value="<?= $image_data ?>">
                <input type="hidden" name="current_item_release_date" value="<?= $item_release_date ?>">
                <input type="hidden" name="current_item_rating" value="<?= $advisory_rating ?>">
                <input type="hidden" name="current_item_type" value="<?= $item_type ?>">
                <input type="submit" class="link" value="Buy"/>
            </form>
        </td>
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

</body>
</html>