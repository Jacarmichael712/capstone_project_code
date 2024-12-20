<?php include "../../../inc/dbinfo.inc"; ?>
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
  text-align: center;
  /*font-size: 1.25em;*/
  font-size: 1.25vmax;
  color: #0A1247;
 /* margin-left: 2.5%;*/
}

p {
  font-family: "Monaco", monospace;
  text-align: center;
  /*font-size: 1.25em;*/
  font-size: 1.15vmax;
  color: #0A1247;
  /*margin-left: 2.5%;*/
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

form {
  text-align: center;
  margin: 20px 20px;
}

input[type=text], input[type=password] {
  width: 60%;
  padding: 12px 20px;
  margin: 8px 0;
  box-sizing: border-box;
}

input[type=submit] {
  width: 30%;
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
      <h1>Add</h1>
      <h1>To</h1>
      <h1>Catalog</h1>
   </div>
</div>

<?php 

$album_name = $_POST['album_name'];
$_SESSION['album_name'] = $album_name;
$album_name_parsed = "";

// Replace spaces in string entered with "+"
$array = str_split($album_name); 
  
foreach($array as $char){ 
    if($char == " ")  {
      $album_name_parsed .= "+";
    }
    else {
      $album_name_parsed .= $char;
    }
} 

$content = file_get_contents("https://itunes.apple.com/search?entity=album&term=$album_name_parsed");
$array = json_decode($content);

if($array->resultCount != 0) {

  // Search through results to determine best fit
  $returned_album_name = $array->results[0]->collectionName;
  $chosen_result_num = 0;

  for($i = count($array->results)-1; $i >= 0 ; $i--) {
    if(strcmp($array->results[$i]->collectionName, $album_name) == 0) {
      $returned_album_name = $array->results[$i]->collectionName;
      $chosen_result_num = $i;
    }
  }

  $artist_name = $array->results[$chosen_result_num]->artistName;
  $album_price = $array->results[$chosen_result_num]->collectionPrice;
  $album_release_date = $array->results[$chosen_result_num]->releaseDate;
  $image_data = $array->results[$chosen_result_num]->artworkUrl100;

  // Resize the image
  $image_data = str_replace("100x100", "300x300", $image_data);

  // Save each variable as session variable in case of adding to database
  $_SESSION['item_image'] = $image_data;
  $_SESSION['item_name'] = $returned_album_name;
  $_SESSION['item_artist'] = $artist_name;
  $_SESSION['item_price'] = $album_price;
  $_SESSION['item_release_date'] = $album_release_date;
  $_SESSION['item_type'] = "album";
  $_SESSION['advisory_rating'] = NULL;

  $album_image = base64_encode(file_get_contents($image_data));

  echo "<h2>Is this the album you are looking for?</h2>";
  echo '<h2><img src="data:image/jpeg;base64,'.$album_image.'"></h2>';
  echo "<p>Album Name: $returned_album_name</p>";
  echo "<p>Arist Name: $artist_name</p>";
  echo "<p>Album Price: $album_price</p>";
  echo "<p>Release Date: $album_release_date</p>";
  ?>

  <form action="http://team05sif.cpsc4911.com/S24-Team05/catalog/submit_sponsor_add_item.php">
    <input type="submit" class="link" value="Yes" />
  </form>

  <form action="http://team05sif.cpsc4911.com/S24-Team05/catalog/sponsor_view_more_albums.php">
    <input type="submit" class="link" value="No" />
  </form>
<?php
}
else {
  echo "<h2>No album found!</h2>";
  ?>
  <form action="http://team05sif.cpsc4911.com/S24-Team05/catalog/sponsor_add_album.php">
    <input type="submit" class="link" value="Search Again" />
  </form>
  <?php
}
?>

</body>

</html>