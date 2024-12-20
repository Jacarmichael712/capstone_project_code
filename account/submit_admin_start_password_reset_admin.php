<?php include "../../../inc/dbinfo.inc"; ?>
<?php session_start();?>

<!DOCTYPE html>

<title>Password Reset</title>

<body>
    <?php 
    // Create connection to database
        $conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
        if (mysqli_connect_errno()) {  
        echo "Database connection failed.";  
        }
      
        $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
        $database = mysqli_select_db($connection, DB_DATABASE);
        $username = $_POST["name"];
        $tempPass = "tempPassword";
        $newHashPass = password_hash($tempPass, PASSWORD_DEFAULT);
        echo "" . $username;
        $check_valid_query = mysqli_query($conn, "SELECT * FROM administrators WHERE administrator_username = '$username';");

// Check for invald info
if(!($row=$check_valid_query->fetch_row())){
    echo '<script>alert("The Admin username you entered is not valid. \n\nPlease enter in a different username and retry...")</script>';
    echo '<script>window.location.href = "admin_start_password_reset_admin.php"</script>';
} else{

    // Prepare query on admins table
    $sql_admin_pw_reset = "UPDATE administrators SET administrator_password=? WHERE administrator_username = '$username';";
    $stmt_admin_pw_reset = $conn->prepare($sql_admin_pw_reset);
    $stmt_admin_pw_reset->bind_param("s", $newHashPass);

    if ($stmt_admin_pw_reset->execute()) {
        echo '<script>alert("Password Successfully Reset! Get in contact with the admin and give them instructions on what to do next!\n")</script>';
        echo '<script>window.location.href = "http://team05sif.cpsc4911.com/S24-Team05/account/admin_start_password_reset_admin.php"</script>';
    }
    else{
        echo '<script>alert("Failed to reset password...\n\nCheck your information and retry...")</script>';
        echo '<script>window.location.href = "admin_start_password_reset_admin.php"</script>';
    }
}
    /* EDIT FOR AUDIT LOG
    // Add password change success to password change audit log
        $passwordChangeTime = new DateTime('now');
        $passwordChangeTime = $passwordChangeTime->format("Y-m-d H:i:s");
        $desc = "{$name} ({$_SESSION['account_type']}) changed their own password.";
        $auditQuery = "INSERT INTO audit_log_password (audit_log_password_username, audit_log_password_date, audit_log_password_desc) VALUES (?, ?, ?)";
    
        $preparedQuery = $connection->prepare($auditQuery);
        $preparedQuery->bind_param("sss", $name, $passwordChangeTime, $desc);
        $preparedQuery->execute();
        */
    ?>

</body>
</html>