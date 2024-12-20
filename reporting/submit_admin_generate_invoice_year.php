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

<style>
    body {
        background-color: #fff5d1;
    }
    /* Table formatting from https://www.w3schools.com/css/css_table.asp */
    #point-details {
        font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    #point-details td, #point-details th {
        padding: 8px;
        border-bottom: 1px solid #ddd;
    }

    #point-details tr:nth-child(even){background-color: #f2f2f2;}
    #point-details tr:nth-child(odd){background-color: white;}

    #point-details tr:hover {background-color: #ddd;}

    #point-details th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        background-color: #b8a97b;
        color: white;
    }

    .navbar {
    overflow: hidden;
    background-color: #FEF9E6;
    font-family: "Monaco", monospace;
    margin-bottom: 1.5%
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
    padding: 14px 16px;
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

<body>
  <?php 
    $startDate = $_POST['start_date'];
    $startDate = (new DateTime($startDate))->format("Y-m-d H:i:s");
    $endDate = new DateTime($startDate);
    $endDate->add(new DateInterval("P365D"));
    $endDate->add(new DateInterval("PT23H59M59S"));
    $endDate = $endDate->format("Y-m-d H:i:s");
    $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
    $database = mysqli_select_db($connection, DB_DATABASE);

    $sponsor = $_POST['listsponsors'];
  
    $user = $_SESSION['username'];
    $test = fopen("csvs/invoice_sponsor_{$sponsor}_for_{$user}_1Year.csv", 'w');

    $header_array = array("Invoice For Single Sponsor-{$sponsor} - {$user} - 1 Year");
    fputcsv($test, $header_array);
    fputcsv($test, array("Driver ID", "Date", "Item", "Points", "Dollar Amount", "Fees"));

    $total = 0;
    $totalFees = 0;
    $orders = mysqli_query($connection, "SELECT * FROM orders WHERE order_associated_sponsor='$sponsor' AND order_status != 'Cancelled' AND order_date_ordered BETWEEN '$startDate' AND '$endDate'");
    $sponsor_info = mysqli_query($connection, "SELECT * FROM organizations WHERE organization_username='$sponsor'");
    ?>

<div id="hyperlink-wrapper">
<a id="hyperlink" href=" <?= "http://team05sif.cpsc4911.com/S24-Team05/reporting/csvs/invoice_sponsor_{$sponsor}_for_{$user}_1Year.csv" ?>" download> Download csv... </a>
</div>

<table id="point-details">
<tr>
    <th colspan = "5"; style = "background-color: #857f5b"> <?php echo "Invoice for Single Sponsor - {$sponsor}" ?></th>
    <th style = "background-color: #857f5b;"> <?php echo "1 Year" ?></th>
</tr>
<tr>
    <th>Driver ID</th>
    <th>Date</th>
    <th>Item</th>
    <th>Points</th>
    <th>Dollar Amount</th>
    <th>Fees</th>
</tr>

    <tbody>
      <?php 
        while($order_info=$orders->fetch_assoc()){
          $currentOrder = $order_info['order_id'];
          $queryString = "SELECT * FROM order_contents WHERE order_id=$currentOrder AND order_contents_removed=0";
          $order_contents = mysqli_query($connection, $queryString);
          $currentItem = "";
    
          $sponsor_info = mysqli_query($connection, "SELECT * FROM organizations WHERE organization_username='$sponsor'");
          while($dollar2pt = $sponsor_info->fetch_assoc()){
            $ratio = $dollar2pt['organization_dollar2pt'];
          }
      ?>
<tr>
        <td><?php echo $order_info['order_driver_id'];?></td>
        <td><?php echo $order_info['order_date_ordered'];?></td>
        <td><?php while($items = $order_contents->fetch_assoc()){ ?>
        <?php 
          $currentItem = $currentItem . $items['order_contents_item_name'] . " - " . $items['order_contents_item_type'] . " || ";
          echo $items['order_contents_item_name'] . " - " . $items['order_contents_item_type'] . " || ";?>
        <?php }?></td>
        <td><?php echo $order_info['order_total_cost']; 
        $total += $order_info['order_total_cost'];
        ?></td>
        <?php 
            $dollar_amount = $order_info['order_total_cost'] * $order_info['dollar2point'];
            $currentFee = $dollar_amount * 0.01;
            $totalFees += $dollar_amount * 0.01;
            $totalDollarAmount += $dollar_amount;
        ?>  
        <td><?php echo $dollar_amount;?></td>
        <td><?php echo $currentFee;?></td>
<?php 
$temp_array = array($order_info['order_driver_id'], $order_info['order_date_ordered'], $currentItem, $order_info['order_total_cost'], $dollar_amount, $currentFee);
fputcsv($test, $temp_array);
}
?>
</tr>

<tr>
  <td><?php echo "<b>TOTAL</b>" ?></td>
  <td><?php echo "" ?></td>
  <td><?php echo "" ?></td>
  <td><?php echo "<b>",$total,"</b>" ?></td>
  <td><?php echo "<b>","$",round($totalDollarAmount, 2),"</b>" ?></td>
  <td><?php echo "<b>","$",round($totalFees, 2),"</b>" ?></td>
</tr>

</tbody>
</div>
</div>
</table>

<?php 
fputcsv($test, array("  "));
fputcsv($test, array("Total", "Total Dollar Amount", "Total Fees"));


fputcsv($test, array($total, $totalDollarAmount, $totalFees));

fclose($test);
?>

</body>
