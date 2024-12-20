<?php include "../../inc/dbinfo.inc"; ?>

<html>

<head>
<style type="text/css">
body {
  background-color: #fff5d7;
  margin: 0;
  padding: 0;
  height: auto;
  width: auto;
}
.wrapper{
  display: flex;
  position: relative;
}

.wrapper .options{
  position: fixed;
  width: 150px;
  height: 100%;
  background: #ff5e6c;

}

.wrapper .content{
  margin-top: 1%;
  margin-left: 30%;
  border-style: solid;
  border-color: black;
}

p {
  color: green;
  font-size: 30px;
  margin-left: 40%;
}

h1 {
  text-align: left;
  margin-left: 2%;
  margin-top: 12%;
  font-family: "Monaco", monospace;
  /*font-size: 3em;*/
  font-size: 2.5vmax;
  color: #FEF9E6
}

h2 {
  text-align: left;
  margin-left: 2.5%;
  font-family: "Monaco", monospace;
  /*font-size: 2em;*/
  font-size: 2vmax;
}

h3 {
  text-align: left;
  margin-left: 2.5%;
  font-family: "Monaco", monospace;
  /*font-size: 1.25em;*/
  font-size: 1.25vmax;
  color: #ff5e6c
}

p {
  font-family: "Monaco", monospace;
  /*font-size: 1.25em;*/
  font-size: 1.25vmax;
}

#flex-container-header {
  display: flex;
  flex: 1;
  justify-content: stretch;
  margin-top: 2.5%;
  background-color: #ff5e6c;
}

#flex-container-description {
  display: flex;
  margin-top: 1%;
  margin-left: 2%;
  margin-right: 2%;
  background-color: #FEF9E6;
}

#flex-container-team-info {
  display: flex;
  /*height: 15%;*/
  width: auto;
  background-color: #FEF9E6;
  margin-top: 1%;
  margin-left: 5%;
  margin-right: 2%;
}

#flex-container-child {
  display: flex;
  justify-content: center;
  align-items: center;
  margin-top: 0%;
  margin-left: 2.5%;
}

#flex-container-child-2 {
  display: flex;
  flex: 1;
  justify-content: left;
  align-items: center;
  padding: 3.5%;
}

form {
  text-align: center;
  margin: 30px 20px;
}

.link{
  text-align: center;
  border-style: outset;
  color: black;
  background-color: #ffaaab;
  font-family: "Monaco", monospace;
  font-size: 35px;
  width: 60%;
}

.link:hover {
  background-color: #ff8889;
  cursor: pointer;
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
.container {
  width: 90%;
  height: 370px;
  margin: auto;
  padding: 25px;
}

.one {
  width: 0%;
  height: 1000px;
  float: left;
}

.two {
  margin-left: 50%;
  margin-top: 6%;
  height: 50%;
  background-color: #fff5d1;
  border-style: inset;
}

.text-box{
  text-align: center;
  font-size: 27;
  font-family: "Monaco", monospace;
  background-color: #ffaaab;
  border-style: dotted;
}


</style>
</head>

<title>Landing Page</title>
<link rel="icon" type="image/x-icon" href="S24-Team05/images/Logo.png">
<body>

  <div class="navbar">
    <div class="menu">
      <a href="/">Landing Page</a>
      <a href="/S24-Team05/about_page.php">About</a>
    </div>
  </div>

  <div id = "flex-container-header">
    <div id = "flex-container-child">
      <h1> </h1>
      <h1>Create</h1>
      <h1> </h1>
      <h1>Account</h1>
      <h1> </h1>
      <h1>or</h1>
      <h1> </h1>
      <h1>Login</h1>
    </div>
  </div>

<section class="container">
  <div class="one">
    <div class="wrapper">
      <div class="content">
        <img src="S24-Team05/images/Logo.png" style="width: 600px; height: 350px;">
      </div>
    </div>
  </div>
  <div class="two">
    <!-- Add links that redirect to login and account creation -->
    <form action="S24-Team05/account/login.php">
      <input type="submit" class="link" value="Login" />
    </form>

    <form action="S24-Team05/account/driver_account_creation.php">
      <input type="submit" class="link" value="Create Account" />
    </form>
  </div>
</section>

<div class="text-box">
   The Driver Incentive Program is a revolutionary application designed specifically for truck drivers, aimed at promoting and rewarding safe and responsible driving habits. Built with cutting-edge technology and a user-friendly interface, it empowers drivers to enhance their driving skills while earning valuable rewards.
</div>

  <!-- Clean up. -->
<?php
        mysqli_free_result($result);
        mysqli_close($connection);
?>

</body>
</html>