<?php
    header($_SERVER['SERVER_PROTOCOL'].' 404 Not Found', true, 404);
    //require_once("../sessionPatient.php"); 
   // confirm_logged_in();
?>
<title>Welcome to the Clinic System</title>
<link href="../stylesheets/MainStyle.css" rel="stylesheet" type="text/css" />
<link href="../stylesheets/TableStyles.css" rel="stylesheet" type="text/css" />
<body>
<div id="container">
  <div id="banner">
   
  </div>
   <div id="sidebar">
    <h2>Log in by user</h2>
    <div class="navlist">
      <ul>
        <li><a href="Visitor_login.php">Patient log-in</a></li>
        <li><a href="Admin_login.php">Admin log-in</a></li>
        <li><a href="Register.php">Register</a></li>
      </ul>
    </div>
</div>
</div>
</body> 