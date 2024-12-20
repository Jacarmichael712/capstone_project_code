<?php include "../../../inc/dbinfo.inc";

        $cookie_name = "remember_user";
        $cookie_value = $_POST["name"] . ":" . $_POST["password"];
        //seconds in a day * 30 days (sets remember cookie for 30 days)
        $arr_cookie_options = array (
                'expires' => time() + (86400 * 30), 
                'path' => '/', 
                'domain' => 'team05sif.cpsc4911.com', // leading dot for compatibility or use subdomain
                'secure' => false,     // or false
                'httponly' => true,    // or false
                'samesite' => 'None' // None || Lax  || Strict
                );
        setcookie($cookie_name, $cookie_value, $arr_cookie_options); //account/cookie    acccount/loginval/cookie
?>
<!DOCTYPE html>
<body>

<?php
        // Set cookies so session stays regardless of URL path change
        session_set_cookie_params(0, '/');
        session_start();
        $name = $_POST["name"];
        $password = $_POST["password"];
        $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
        $database = mysqli_select_db($connection, DB_DATABASE);
        $queryString = "SELECT * FROM users WHERE username = '$name' OR user_email = '$name'";
        $result = mysqli_query($connection, $queryString);
        $query_data = mysqli_fetch_row($result);
?>

<?php
        
        //Checks if the username exists in the database.
        if (strcmp($query_data[1], "") != 0) {
                
                // Account type is set to the user_view_type
                $_SESSION['account_type'] = $query_data[4];

                // Real account type of the user
                $_SESSION['real_account_type'] = $query_data[2];

                if($_SESSION['real_account_type'] === 'sponsor') {
                        $check_company_status_query = "SELECT * FROM sponsors RIGHT JOIN organizations 
                        ON sponsors.sponsor_associated_sponsor=organizations.organization_username WHERE sponsor_username='$query_data[1]';";
                        $company_status_result = mysqli_query($connection, $check_company_status_query);
                        $company_status = ($company_status_result->fetch_assoc())['organization_archived'];
                        
                        //If company is archived, the login is failed.
                        if($company_status == 1) {
                                goto login_fail;       
                        }
                }

                //var_dump($_SESSION['account_type']);
                $query = "SELECT * FROM ".$_SESSION['real_account_type']."s WHERE ".$_SESSION['real_account_type']."_username = '$name' OR ".$_SESSION['real_account_type']."_email = '$name'";
                $result = mysqli_query($connection, $query);
                $query_data = mysqli_fetch_assoc($result);

                if(password_verify($password, $query_data[$_SESSION['real_account_type']."_password"]) && intval($query_data[$_SESSION['real_account_type']."_archived"]) == 0) {

                        $_SESSION['username'] = $query_data[$_SESSION['real_account_type']."_username"];

                        // Add login success to login audit log
                        $loginTime = new DateTime('now');
                        $loginTime = $loginTime->format("Y-m-d H:i:s");
                        $s_or_f = "Success";
                        $auditQuery = "INSERT INTO audit_log_login (audit_log_login_username, audit_log_login_date, audit_log_login_s_or_f) VALUES (?, ?, ?)";
                        
                        $preparedQuery = $connection->prepare($auditQuery);
                        $preparedQuery->bind_param("sss", $query_data[$_SESSION['real_account_type']."_username"], $loginTime, $s_or_f);
                        $preparedQuery->execute();

                        $result = mysqli_query($connection, "SELECT * FROM users");
      
                        // Get the user id
                        $username = $_SESSION['username'];
                        while($rows=$result->fetch_assoc()) {
                                if($rows['username'] == $username) {
                                $user_id = $rows['id'];
                                }
                        }

                        $real_account_type = $_SESSION['real_account_type'];
                        $updateViewType = "UPDATE users SET user_view_type = '$real_account_type' WHERE id = $user_id;";
                        mysqli_query($connection, $updateViewType);

                        $_SESSION['account_type'] = $_SESSION['real_account_type'];
                        $_SESSION['user_id'] = $user_id;
                        // Redirect user to their homepage
                        //$_SESSION['login'] = true;
                        $result = mysqli_query($connection, $query);
                        $query_data = mysqli_fetch_assoc($result);
                        $_SESSION['user_data'] = $query_data;
                        $_SESSION['2facode'] = $_POST['code'];
                        //header("Location: http://team05sif.cpsc4911.com/S24-Team05/account/".$_SESSION['account_type']."homepage.php");
                        header("Location: http://team05sif.cpsc4911.com/S24-Team05/account/twofactor.php");
                        exit();
                } else {
                        login_fail:
                        // Add login failure to login audit log
                        $loginTime = new DateTime('now');
                        $loginTime = $loginTime->format("Y-m-d H:i:s");
                        $s_or_f = "Failure";
                        $auditQuery = "INSERT INTO audit_log_login (audit_log_login_username, audit_log_login_date, audit_log_login_s_or_f) VALUES (?, ?, ?)";
                        
                        $preparedQuery = $connection->prepare($auditQuery);
                        $preparedQuery->bind_param("sss", $query_data[$_SESSION['real_account_type']."_username"], $loginTime, $s_or_f);
                        $preparedQuery->execute();
                        
                        // Inform user to incorrect credentials and redirect
                        $_SESSION['errors']['login'] = "Incorrect username or password!";

                        unset($_SESSION['real_account_type']);
                        unset($_SESSION['account_type']);
                        goto error_redirect;
                }

        } else {
                $_SESSION['errors']['login'] = "Incorrect username or password!";
        }
        error_redirect:
        header( "Location: http://team05sif.cpsc4911.com/S24-Team05/account/login.php", true, 303);
        exit();
?>
<!-- Clean up. -->
<?php
        mysqli_free_result($result);
        mysqli_close($connection);
?>

</body>
</html>