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

<html>
<body>
<?php
  $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
  $database = mysqli_select_db($connection, DB_DATABASE);

  /*
  if(!$_SESSION['login'] || !isset($_SESSION['user_edited']['query'])) {
      echo "Invalid page.<br>";
      echo "Redirecting.....";
      sleep(2);
      header( "Location: http://team05sif.cpsc4911.com/", true, 303);
      exit();
  }
  */
$org_id = $_POST['org_id'];
$org_name = $_POST['new_org_name'];
$old_ratio = $_POST['old_ratio'];
$new_ratio = $_POST['new_ratio'];

$org_details_query = mysqli_query($connection, "SELECT * FROM organizations WHERE organization_id=$org_id");
$org_details = $org_details_query->fetch_assoc();

/*
  if(isset($_POST['org_name'])) {
    $oldname = $org_details['organization_username'];
    $duplicate_check = "SELECT 1 FROM organizations WHERE organization_username=?";
    $stmt_dupe = $connection->prepare($duplicate_check);
    $stmt_dupe->bind_param("s", $org_name);
    $stmt_dupe->execute();
    $result = $stmt_dupe->get_result();
    if($result->fetch_assoc() && $oldname !== $org_name) {
      echo '<script>alert("Error, duplicate organization name entered, please try again!")</script>';
      echo '<script>window.location.href = "admin_view_organizations.php"</script>';
    }
    //$queryOne = "UPDATE ".$account_type."s SET ".$account_type."_notifications = $newnotifications WHERE ".$account_type."_id = $account_id;";
    $sql_update_organizations = "UPDATE organizations SET organization_username=? WHERE organization_username=?";
    $sql_update_drivers = "UPDATE drivers SET driver_associated_sponsor=? WHERE driver_associated_sponsor=?";
    $sql_update_sponsors = "UPDATE sponsors SET sponsor_associated_sponsor=? WHERE sponsor_associated_sponsor=?";
    $sql_update_orders = "UPDATE orders SET order_associated_sponsor=? WHERE order_associated_sponsor=?";
    //mysqli_query($connection, $queryOne);
    $_SESSION['errors']['user_info'] = "Information updated!";
  }
*/
  
  if(isset($_POST['ratio'])) {
    if(!is_numeric($new_ratio)) {
      echo '<script>alert("Value entered is not a number, please try again!")</script>';
      echo '<script>window.location.href = "admin_view_organizations.php"</script>';
    } else {
      $sql_update_ratio_query = "UPDATE organizations SET organization_dollar2pt=? WHERE organization_id=?";
      $stmt_ratio = $connection->prepare($sql_update_ratio_query);
      $stmt_ratio->bind_param("di",$new_ratio, $org_id);

      if($stmt_ratio->execute()) {
        $catalog_items = mysqli_query($connection, "SELECT * FROM catalog WHERE catalog_associated_sponsor='$org_name'");

        while($rows = $catalog_items->fetch_assoc()){
            $catalog_item_id = $rows['catalog_id'];
            $new_price = ($rows['catalog_item_point_cost'] * $old_ratio) / $new_ratio;

            $catalog_update = mysqli_query($connection, "UPDATE catalog SET catalog_item_point_cost=$new_price WHERE catalog_id=$catalog_item_id");
        }

        echo '<script>alert("Dollar2pt ratio succesfully updated!")</script>';
        echo '<script>window.location.href = "admin_view_organizations.php"</script>';
      }
    }

  }
  

  //Resets the session variable I have storing the user_data from a query.
  //$queryString ="SELECT * FROM ".$_SESSION['account_type']."s WHERE ".$_SESSION['account_type']."_username = '".$_SESSION['username']."'";
  //$result = mysqli_query($connection, $queryString);
  //unset($_SESSION['user_data']);
  //$_SESSION['user_data'] = mysqli_fetch_assoc($result);

  //if($account_type == "administrator") {
    //header("Location: http://team05sif.cpsc4911.com/S24-Team05/account/admin_edit_admin_account.php");
  //} else {
    //header("Location: http://team05sif.cpsc4911.com/S24-Team05/account/admin_edit_".$account_type."_account.php");
 // }
  //exit()
?>
</body>
</html>