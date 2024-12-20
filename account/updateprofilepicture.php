<?php include "../../../inc/dbinfo.inc"; ?>
<?php
  session_start();

  if(!$_SESSION['login']) {
      echo "Invalid page.<br>";
      echo "Redirecting.....";
      sleep(2);
      header( "Location: http://team05sif.cpsc4911.com/", true, 303);
      exit();
  }
  $target_dir = "/var/www/html/S24-Team05/images/profilepictures/";
  $target_file = $target_dir . basename($_FILES["profilepic"]["name"]);
  //var_dump($_FILES["profilepic"]);
  $uploadOk = 1;
  $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
  $filename = $_SESSION['user_id']."_profile_picture.png";
  $target_file = $target_dir . $filename;

  if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["profilepic"]["tmp_name"]);
    //Makes sure the file is an image.
    if($check !== false) {
        $uploadOk = 1;
    } else {
        $uploadOk = 0;
        $_SESSION['errors']['user_info'] = "File uploaded was not an image!";
        goto redirect;
    }
    if ($_FILES["fileToUpload"]["size"] > 1000000) {
      $_SESSION['errors']['user_info'] = "File is too large! Only files 1mb and below are supported.";
      $uploadOk = 0;
    }
    if($imageFileType !== "png" && $imageFileType !== "jpg" && $imageFileType != "jpeg") {
        $uploadOk = 0;
        $_SESSION['errors']['user_info'] = "File type not supported! Please upload a .png, .jpg, or .jpeg!";
        goto redirect;
    }
    var_dump("test1");
    if (is_writable($target_file)) {
      echo "File is writable." . PHP_EOL;
    } else {
      echo "File is NOT writable." . PHP_EOL;
    }
    
    if (is_readable($target_file)) {
      echo "File is readable." . PHP_EOL;
    } else {
      echo "File is NOT readable." . PHP_EOL;
    }
    var_dump($target_file);
    var_dump(is_readable($target_file));
    if($uploadOk == 1) {
      $imagick = new Imagick($_FILES["profilepic"]["tmp_name"]);
      var_dump("test2");
      $imagick->scaleImage(200, 200);
      var_dump("test3");
      //var_dump(Imagick::getVersion());
      //$temp = file_put_contents($target_file, $imagick);
      $imagick->writeImage($target_file);
      var_dump($temp);
      //var_dump(sys_get_temp_dir());
      $_SESSION['errors']['user_info'] = "Image sucessfully uploaded!";
    }
} else {
    header("Location: http://team05sif.cpsc4911.com/", true, 303);
    exit();
}
  redirect:
  header("Location: http://team05sif.cpsc4911.com/S24-Team05/account/profilechangepicture.php", true, 303);
  exit();

?>