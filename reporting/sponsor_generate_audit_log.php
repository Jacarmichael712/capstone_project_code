<?php include "../../../inc/dbinfo.inc";?>
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
    error_reporting(E_ALL);
    ini_set('display_errors',1);
    $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
    $database = mysqli_select_db($connection, DB_DATABASE);

    $driver_username = $_POST['driver'];
    $al_type = $_POST['audit_type'];

    //Formats the dates so they don't cause errors when naming the CSV file.
    $start_range = $_POST['start_date'];
    $start_range = (new DateTime($start_range))->format("Y-m-d");
    $end_range = $_POST['end_date'];
    
    //Adds 23:59:59 to the end range to make it include all orders on that day.
    $end_range_format = new DateTime($end_range);
    $end_range_format->add(new DateInterval("PT23H59M59S"));
    $end_range_format = $end_range_format->format("Y-m-d H:i:s");
    
    $end_range = (new DateTime($end_range))->format("Y-m-d");

    $sponsor_username = $_SESSION['username'];
    $organization_query = mysqli_query($connection, "SELECT * FROM " . $_SESSION['real_account_type'] . "s WHERE " . $_SESSION['real_account_type'] . "_username='$sponsor_username';");  
    while($rows=$organization_query->fetch_assoc()) {
        $org_name = $rows[$_SESSION['real_account_type'] . "_associated_sponsor"];
    }


    //Opens the CSV file for writing, overwrites any existing one. 
    $test = fopen("csvs/{$start_range}_{$end_range}_audit_log_{$al_type}_for_$driver_username.csv", 'w');

    $header_array = array("{$al_type} Report - {$driver_username}");
    fputcsv($test, $header_array);

    if($al_type === "Driver Applications") {
        $header_array = array("Username", "First Name", "Last Name", "Application Status", "Application Date", "Decision Date", "Associated Sponsor", "Reason for Acceptance/Rejection");
        ?>
        <table id="point-details">
        <tr>
            <th colspan = "7"; style = "background-color: #857f5b"> <?php echo "{$al_type} Report - {$driver_username}" ?></th>
            <th style = "background-color: #857f5b;"> <?php echo "{$start_range} - {$end_range}" ?></th>
        </tr>
        <tr>
            <th>Username</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Application Status</th>
            <th>Application Date</th>
            <th>Decision Date</th>
            <th>Associated Sponsor</th>
            <th>Reason for Acceptance/Rejection</th>
        </tr>
        <?php
        fputcsv($test, $header_array);
    }

    if($al_type === "Point Changes") {
        $header_array = array("Username", "First Name", "Last Name", "Associated Sponsor", "Point Change", "Total Points", "Date of Point Change", "Reason for Point Change");
        ?>
        <table id="point-details">
        <tr>
            <th colspan = "7"; style = "background-color: #857f5b"> <?php echo "{$al_type} Report - {$driver_username}" ?></th>
            <th style = "background-color: #857f5b;"> <?php echo "{$start_range} - {$end_range}" ?></th>
        </tr>
        <tr>
            <th>Username</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Associated Sponsor</th>
            <th>Point Change</th>
            <th>Total Points</th>
            <th>Date of Point Change</th>
            <th>Reason for Point Change</th>
        </tr>
        <?php
        fputcsv($test, $header_array);
    }

    if($al_type === "Password Changes") {
        $header_array = array("Username", "Date of Change", "Type of Change");
        ?>
        <table id="point-details">
        <tr>
            <th colspan = "2"; style = "background-color: #857f5b"> <?php echo "{$al_type} Report - {$driver_username}" ?></th>
            <th style = "background-color: #857f5b;"> <?php echo "{$start_range} - {$end_range}" ?></th>
        </tr>
        <tr>
            <th>Username</th>
            <th>Date of Change</th>
            <th>Type of Change</th>
        </tr>
        <?php
        fputcsv($test, $header_array);
    }

    if($al_type === "Login Attempts") {
        $header_array = array("Username", "Date of Attempt", "Success or Failure");
        ?>
        <table id="point-details">
        <tr>
            <th colspan = "2"; style = "background-color: #857f5b"> <?php echo "{$al_type} Report - {$driver_username}" ?></th>
            <th style = "background-color: #857f5b;"> <?php echo "{$start_range} - {$end_range}" ?></th>
        </tr>
        <tr>
            <th>Username</th>
            <th>Date of Attempt</th>
            <th>Success or Failure</th>
        </tr>
        <?php
        fputcsv($test, $header_array);
    }
    

    if($driver_username === "All Drivers") {
        if($al_type === "Driver Applications") {
            $applications_query = mysqli_query($connection, "SELECT * FROM applications JOIN organizations ON applications.organization_id=organizations.organization_id JOIN drivers ON applications.driver_id=drivers.driver_id WHERE application_date >= '$start_range' AND decision_date <= '$end_range_format' AND organization_username='$org_name';");  

            while($rows=$applications_query->fetch_assoc()) {
                //Stores info in an array to be written to the CSV.
                $temp_array = array($rows['driver_username'], $rows['driver_first_name'], $rows['driver_last_name'], $rows['application_status'], $rows['application_date'], $rows['decision_date'], $rows['organization_username'], $rows['application_reasoning']);
                fputcsv($test, $temp_array);

                ?>
                <tr>
                    <td><?php echo "{$rows['driver_username']}" ?></td>
                    <td><?php echo "{$rows['driver_first_name']}" ?></td>
                    <td><?php echo "{$rows['driver_last_name']}" ?></td>
                    <td><?php echo "{$rows['application_status']}" ?></td>
                    <td><?php echo "{$rows['application_date']}" ?></td>
                    <td><?php echo "{$rows['decision_date']}" ?></td>
                    <td><?php echo "{$rows['organization_username']}" ?></td>
                    <td><?php echo "{$rows['application_reasoning']}" ?></td>
                </tr>
                <?php
            }
        }

        if($al_type === "Point Changes") {
            $points_query = mysqli_query($connection, "SELECT * FROM point_history JOIN drivers ON drivers.driver_id = point_history.point_history_driver_id WHERE point_history_date BETWEEN '$start_range' AND '$end_range_format' AND point_history_associated_sponsor='$org_name' ORDER BY point_history_date, point_history_driver_id;");  

            while($rows=$points_query->fetch_assoc()) {
                //Stores info in an array to be written to the CSV.
                $temp_array = array($rows['driver_username'], $rows['driver_first_name'], $rows['driver_last_name'], $rows['point_history_associated_sponsor'], $rows['point_history_amount'], $rows['point_history_points'], $rows['point_history_date'], $rows['point_history_reason']);
                fputcsv($test, $temp_array);

                ?>
                <tr>
                    <td><?php echo "{$rows['driver_username']}" ?></td>
                    <td><?php echo "{$rows['driver_first_name']}" ?></td>
                    <td><?php echo "{$rows['driver_last_name']}" ?></td>
                    <td><?php echo "{$rows['point_history_associated_sponsor']}" ?></td>
                    <td><?php echo "{$rows['point_history_amount']}" ?></td>
                    <td><?php echo "{$rows['point_history_points']}" ?></td>
                    <td><?php echo "{$rows['point_history_date']}" ?></td>
                    <td><?php echo "{$rows['point_history_reason']}" ?></td>
                </tr>
                <?php
            }
        }

        if($al_type === "Password Changes") {
            $password_query = mysqli_query($connection, "SELECT * FROM audit_log_password JOIN driver_sponsor_assoc ON driver_sponsor_assoc.driver_username = audit_log_password.audit_log_password_username JOIN organizations ON driver_sponsor_assoc.assoc_sponsor_id=organizations.organization_id WHERE audit_log_password_date BETWEEN '$start_range' AND '$end_range_format' AND organization_username='$org_name'");  

            while($rows=$password_query->fetch_assoc()) {
                //Stores info in an array to be written to the CSV.
                $temp_array = array($rows['audit_log_password_username'], $rows['audit_log_password_date'], $rows['audit_log_password_desc']);
                fputcsv($test, $temp_array);

                ?>
                <tr>
                    <td><?php echo "{$rows['audit_log_password_username']}" ?></td>
                    <td><?php echo "{$rows['audit_log_password_date']}" ?></td>
                    <td><?php echo "{$rows['audit_log_password_desc']}" ?></td>
                </tr>
                <?php
            }
        }

        if($al_type === "Login Attempts") {
            $login_query = mysqli_query($connection, "SELECT * FROM audit_log_login JOIN driver_sponsor_assoc ON driver_sponsor_assoc.driver_username = audit_log_login.audit_log_login_username JOIN organizations ON driver_sponsor_assoc.assoc_sponsor_id=organizations.organization_id WHERE audit_log_login_date BETWEEN '$start_range' AND '$end_range_format' AND organization_username='$org_name'");  

            while($rows=$login_query->fetch_assoc()) {
                //Stores info in an array to be written to the CSV.
                $temp_array = array($rows['audit_log_login_username'], $rows['audit_log_login_date'], $rows['audit_log_login_s_or_f']);
                fputcsv($test, $temp_array);

                ?>
                <tr>
                    <td><?php echo "{$rows['audit_log_login_username']}" ?></td>
                    <td><?php echo "{$rows['audit_log_login_date']}" ?></td>
                    <td><?php echo "{$rows['audit_log_login_s_or_f']}" ?></td>
                </tr>
                <?php
            }
        }

    } else {
        if($al_type === "Driver Applications") {
            $applications_query = mysqli_query($connection, "SELECT * FROM applications JOIN organizations ON applications.organization_id=organizations.organization_id JOIN drivers ON applications.driver_id=drivers.driver_id WHERE application_date >= '$start_range' AND decision_date <= '$end_range_format' AND organization_username='$org_name' AND driver_username='$driver_username';");  

            while($rows=$applications_query->fetch_assoc()) {
                //Stores info in an array to be written to the CSV.
                $temp_array = array($rows['driver_username'], $rows['driver_first_name'], $rows['driver_last_name'], $rows['application_status'], $rows['application_date'], $rows['decision_date'], $rows['organization_username'], $rows['application_reasoning']);
                fputcsv($test, $temp_array);

                ?>
                <tr>
                    <td><?php echo "{$rows['driver_username']}" ?></td>
                    <td><?php echo "{$rows['driver_first_name']}" ?></td>
                    <td><?php echo "{$rows['driver_last_name']}" ?></td>
                    <td><?php echo "{$rows['application_status']}" ?></td>
                    <td><?php echo "{$rows['application_date']}" ?></td>
                    <td><?php echo "{$rows['decision_date']}" ?></td>
                    <td><?php echo "{$rows['organization_username']}" ?></td>
                    <td><?php echo "{$rows['application_reasoning']}" ?></td>
                </tr>
                <?php
            }
        }

        if($al_type === "Point Changes") {
            $points_query = mysqli_query($connection, "SELECT * FROM point_history JOIN drivers ON drivers.driver_id = point_history.point_history_driver_id WHERE point_history_date BETWEEN '$start_range' AND '$end_range_format' AND point_history_associated_sponsor='$org_name' AND drivers.driver_username='$driver_username' ORDER BY point_history_date, point_history_driver_id;");    

            while($rows=$points_query->fetch_assoc()) {
                //Stores info in an array to be written to the CSV.
                $temp_array = array($rows['driver_username'], $rows['driver_first_name'], $rows['driver_last_name'], $rows['point_history_associated_sponsor'], $rows['point_history_amount'], $rows['point_history_points'], $rows['point_history_date'], $rows['point_history_reason']);
                fputcsv($test, $temp_array);

                ?>
                <tr>
                    <td><?php echo "{$rows['driver_username']}" ?></td>
                    <td><?php echo "{$rows['driver_first_name']}" ?></td>
                    <td><?php echo "{$rows['driver_last_name']}" ?></td>
                    <td><?php echo "{$rows['point_history_associated_sponsor']}" ?></td>
                    <td><?php echo "{$rows['point_history_amount']}" ?></td>
                    <td><?php echo "{$rows['point_history_points']}" ?></td>
                    <td><?php echo "{$rows['point_history_date']}" ?></td>
                    <td><?php echo "{$rows['point_history_reason']}" ?></td>
                </tr>
                <?php
            }
        }

        if($al_type === "Password Changes") {
            $password_query = mysqli_query($connection, "SELECT * FROM audit_log_password JOIN driver_sponsor_assoc ON driver_sponsor_assoc.driver_username = audit_log_password.audit_log_password_username JOIN organizations ON driver_sponsor_assoc.assoc_sponsor_id=organizations.organization_id WHERE audit_log_password_date BETWEEN '$start_range' AND '$end_range_format' AND organization_username='$org_name' AND audit_log_password_username='$driver_username';");  
    

            while($rows=$password_query->fetch_assoc()) {
                //Stores info in an array to be written to the CSV.
                $temp_array = array($rows['audit_log_password_username'], $rows['audit_log_password_date'], $rows['audit_log_password_desc']);
                fputcsv($test, $temp_array);

                ?>
                <tr>
                    <td><?php echo "{$rows['audit_log_password_username']}" ?></td>
                    <td><?php echo "{$rows['audit_log_password_date']}" ?></td>
                    <td><?php echo "{$rows['audit_log_password_desc']}" ?></td>
                </tr>
                <?php
            }
        }

        if($al_type === "Login Attempts") { 
            $login_query = mysqli_query($connection, "SELECT * FROM audit_log_login JOIN driver_sponsor_assoc ON driver_sponsor_assoc.driver_username = audit_log_login.audit_log_login_username JOIN organizations ON driver_sponsor_assoc.assoc_sponsor_id=organizations.organization_id WHERE audit_log_login_date BETWEEN '$start_range' AND '$end_range_format' AND organization_username='$org_name' AND audit_log_login_username='$driver_username';");  

            while($rows=$login_query->fetch_assoc()) {
                //Stores info in an array to be written to the CSV.
                $temp_array = array($rows['audit_log_login_username'], $rows['audit_log_login_date'], $rows['audit_log_login_s_or_f']);
                fputcsv($test, $temp_array);

                ?>
                <tr>
                    <td><?php echo "{$rows['audit_log_login_username']}" ?></td>
                    <td><?php echo "{$rows['audit_log_login_date']}" ?></td>
                    <td><?php echo "{$rows['audit_log_login_s_or_f']}" ?></td>
                </tr>
                <?php
            }
        }
        
    }
    //Closes the file pointer.
    fclose($test);
?>
<a href=" <?= "http://team05sif.cpsc4911.com/S24-Team05/reporting/csvs/{$start_range}_{$end_range}_audit_log_{$al_type}_for_$driver_username.csv" ?>" download> Download csv... </a>