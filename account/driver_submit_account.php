<?php include "../../../inc/dbinfo.inc"; ?>

<html>
<body>

<?php
// Create connection to database
$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
if (mysqli_connect_errno()) {  
    echo "Database connection failed.";  
}  

// Get query variables from POST
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$username = $_POST['username'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); // this hashes the password. use password_verify to compare hash to password
$birthday = $_POST['birthday'];
$phone = $_POST['phone'];
$addr = $_POST['address'];
$regDateTime = new DateTime('now');
$regDate = $regDateTime->format('Y-m-d');
$sponsor = 'none';
$archived = 0;
$points = 0;
$user_type = 'driver';

// Create queries to check for taken account info (username, email, etc)
$username_query = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
$email_query = mysqli_query($conn, "SELECT * FROM drivers WHERE driver_email='$email'");
$phone_query = mysqli_query($conn, "SELECT * FROM drivers WHERE driver_phone_number='$phone'");

// Function to check for valid dates
function validateDate($date, $format = 'Y-m-d'){
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) === $date;
}

// Check for taken/invalid account info
if ($username_query->fetch_row()){
    echo '<script>alert("This username is already taken!\n\nPlease choose a different username and retry...")</script>';
    echo '<script>window.location.href = "driver_account_creation.php"</script>';
} elseif ($email_query->fetch_row()){
    echo '<script>alert("This email is already in use!\n\nPlease choose a different email and retry...")</script>';
    echo '<script>window.location.href = "driver_account_creation.php"</script>';
} elseif ($phone_query->fetch_row()){
    echo '<script>alert("This phone number is already in use!\n\nPlease choose a different phone number and retry...")</script>';
    echo '<script>window.location.href = "driver_account_creation.php"</script>';
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)){
    echo '<script>alert("Invalid email address format!\n\nPlease enter in a valid email address and retry...")</script>';
    echo '<script>window.location.href = "driver_account_creation.php"</script>';
} elseif (validateDate($birthday) == false) {
    echo '<script>alert("Invalid birthdate entered!\n\nPlease enter in a valid birthdate and retry...")</script>';
    echo '<script>window.location.href = "driver_account_creation.php"</script>';
} elseif (strlen($_POST['password']) < 8) {
    echo '<script>alert("Invalid password entered!\n\nYour password needs to be at least 8 characters long...")</script>';
    echo '<script>window.location.href = "driver_account_creation.php"</script>';
} else{
    // Prepare query on drivers table
    $sql_drivers = "INSERT INTO drivers (driver_first_name, driver_last_name, driver_username, driver_email, driver_password, driver_birthday, driver_phone_number, driver_address, driver_register_date, driver_associated_sponsor, driver_archived, driver_points) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt_drivers = $conn->prepare($sql_drivers);
    $stmt_drivers->bind_param("ssssssssssii", $fname, $lname, $username, $email, $password, $birthday, $phone, $addr, $regDate, $sponsor, $archived, $points);

    // Prepare query on users table
    $sql_users = "INSERT INTO users (username, user_type, user_email, user_view_type) VALUES (?, ?, ?, ?)";
    $stmt_users = $conn->prepare($sql_users);
    $stmt_users->bind_param("ssss", $username, $user_type, $email, $user_view_type);

    if ($stmt_drivers->execute() && $stmt_users->execute()) {
        echo '<script>alert("Your account is ready!\n\nRedirecting to login page...")</script>';
        echo '<script>window.location.href = "login.php"</script>';
    }
    else{
        echo '<script>alert("Failed to create account...\n\nCheck your information and retry...")</script>';
        echo '<script>window.location.href = "driver_account_creation.php"</script>';
    }
}
?>

</body>
</html>