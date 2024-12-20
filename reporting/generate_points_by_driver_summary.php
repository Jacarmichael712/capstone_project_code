<?php include "../../../inc/dbinfo.inc"; ?>
<?php
    error_reporting(E_ALL);
    ini_set('display_errors',1);
    session_start();
    $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
    $database = mysqli_select_db($connection, DB_DATABASE);

    $driver_username = $_POST['driver'];

    //Formats the dates so they don't cause errors when naming the CSV file.
    $start_range = $_POST['start_date'];
    $start_range = (new DateTime($start_range))->format("Y-m-d");
    $end_range = $_POST['end_date'];
    
    //Adds 23:59:59 to the end range to make it include all orders on that day.
    $end_range_format = new DateTime($end_range);
    $end_range_format->add(new DateInterval("PT23H59M59S"));
    $end_range_format = $end_range_format->format("Y-m-d H:i:s");
    
    $end_range = (new DateTime($end_range))->format("Y-m-d");

    //Opens the CSV file for writing, overwrites any existing one. 
    $test = fopen("csvs/{$start_range}_{$end_range}_point_summary_for_$driver_username.csv", 'w');

    if($driver_username === "All Drivers") {

        $driver_id_query = mysqli_query($connection, "SELECT * FROM drivers where driver_associated_sponsor != 'none'");  

        while($rows=$driver_id_query->fetch_assoc()) {
            $driver_id = $rows['driver_id'];
            $driver_curr_username = $rows['driver_username'];
            $driver_fname = $rows['driver_first_name'];
            $driver_lname = $rows['driver_last_name'];

            $sponsor_id_query = mysqli_query($connection, "SELECT * FROM driver_sponsor_assoc where driver_id = '$driver_id'");

            while($rows=$sponsor_id_query->fetch_assoc()) {
                $sponsor_name_id = $rows['assoc_sponsor_id'];
                $sponsor_name_query = mysqli_query($connection, "SELECT * FROM organizations WHERE organization_id='$sponsor_name_id'");

                while($rows=$sponsor_name_query->fetch_assoc()) {
                    $sponsor_name = $rows['organization_username'];

                    //Grabs the total points for each driver with a specific sponsor
                    $total_driver_points_query = "SELECT *, SUM(point_history_amount) AS total_points FROM point_history WHERE point_history_associated_sponsor = '$sponsor_name' AND point_history_driver_id = '$driver_id' AND point_history_date BETWEEN '$start_range' AND '$end_range_format'";
                    $total_points = mysqli_query($connection, $total_driver_points_query);
                    $result = $total_points->fetch_assoc();
                    $total_points =  $result['total_points'];
                    if($total_points == NULL) {
                        $total_points = 0;
                    }

                    //Stores the company, item_type, and sales by item in an array to be written to the CSV.
                    $temp_array = array($driver_curr_username, $driver_fname, $driver_lname, $sponsor_name, $total_points);
                    fputcsv($test, $temp_array);
                    echo "{$driver_fname} {$driver_lname} ({$driver_curr_username}): has {$total_points} points under {$sponsor_name}.<br>";
                }
            }
        }

    } else {

        $driver_id_query = mysqli_query($connection, "SELECT * FROM drivers where driver_username = '$driver_username'"); 

        while($rows=$driver_id_query->fetch_assoc()) {
            $driver_id = $rows['driver_id'];
            $driver_fname = $rows['driver_first_name'];
            $driver_lname = $rows['driver_last_name'];
        }

        $sponsor_id_query = mysqli_query($connection, "SELECT * FROM driver_sponsor_assoc where driver_id = '$driver_id'");

        while($rows=$sponsor_id_query->fetch_assoc()) {
            $sponsor_name_id = $rows['assoc_sponsor_id'];
            $sponsor_name_query = mysqli_query($connection, "SELECT * FROM organizations WHERE organization_id='$sponsor_name_id'");

            while($rows=$sponsor_name_query->fetch_assoc()) {
                $sponsor_name = $rows['organization_username'];

                //Grabs the total points for each driver with a specific sponsor
                $total_driver_points_query = "SELECT *, SUM(point_history_amount) AS total_points FROM point_history WHERE point_history_associated_sponsor = '$sponsor_name' AND point_history_driver_id = '$driver_id' AND point_history_date BETWEEN '$start_range' AND '$end_range_format'";
                $total_points = mysqli_query($connection, $total_driver_points_query);
                $result = $total_points->fetch_assoc();
                $total_points =  $result['total_points'];
                if($total_points == NULL) {
                    $total_points = 0;
                }
                
                //Stores the company, item_type, and sales by item in an array to be written to the CSV.
                $temp_array = array($driver_username, $driver_fname, $driver_lname, $sponsor_name, $total_points);
                fputcsv($test, $temp_array);
                echo "{$driver_fname} {$driver_lname} ({$driver_username}): has {$total_points} points under {$sponsor_name}.<br>";
            }
        }
    }
    //Closes the file pointer.
    fclose($test);
?>
<a href=" <?= "http://team05sif.cpsc4911.com/S24-Team05/reporting/csvs/{$start_range}_{$end_range}_point_summary_for_$driver_username.csv" ?>" download> Download csv... </a>