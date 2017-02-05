<?php
    header($_SERVER['SERVER_PROTOCOL'].' 404 Not Found', true, 404);
    require_once("../sessionAdmin.php"); 
    confirm_logged_in();
?>

<!-- <link href="../stylesheets/MainStyle.css" rel="stylesheet" type="text/css" /> -->
<body>
<div id="container">
    <div id="banner">
   
  </div>
  <div id="navcontainer">
    <ul id="navlist">
      <li id="active"><a id="current" href="../Admin/Welcome.php">My Details</a></li>
      <li><a href="../logout.php">Log out</a></li>
    </ul>
  </div>
  <div id="sidebar">
    <h2>Appointments</h2>
    <div class="navlist">
      <ul>         
        <li><a href="search_visits.php">See Appointments</a></li>                
      </ul>
    </div>

              <h2>Doctors</h2>
    <div class="navlist">
      <ul>
           <li><a href="view_doctors.php">View / Edit / Remove Doctors</a></li>
           <li><a href="add_doctor.php">Add Doctors</a></li>
      </ul>
    </div>
              <h2>Branchs</h2>
    <div class="navlist">
      <ul>
           <li><a href="view_branch.php">View / Edit / Remove Branchs</a></li>
           <li><a href="add_branch.php">Add Branchs</a></li>
      </ul>
    </div>
    </div>
    
  </div>
 