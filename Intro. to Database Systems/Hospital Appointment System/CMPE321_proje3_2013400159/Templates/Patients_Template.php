<?php
     require_once("../includes/connection.php");
     include("../sessionPatient.php");
     include("../includes/functions.php");
     if(!isset($_SESSION['id']))
        header("Location: http://localhost/321pr/index.php");
    else
         $patient_id = $_SESSION['id'];

    /* $location = "../Visitor_login.php";
     if(isset($patient_id === FALSE)
     { 
         header("Location: " $location);
         exit();
     }*/
     //require_once("../Patient/sql_queries.php");
?>

<!-- <link href="../stylesheets/MainStyle.css" rel="stylesheet" type="text/css" /> -->
<link href="../stylesheets/TableStyles.css" rel="stylesheet" type="text/css" />
<body>
<div id="container">
  <div id="banner">
    <h1></h1>
  </div>
  <div id="navcontainer">
    <ul id="navlist">
      <li id="active"><a id="current" href="home.php">Home</a></li>
      <li><a href="../logout.php">Logout</a></li>
    </ul>
  </div>
  <div id="sidebar">
    <h2>Functions</h2>
    <div class="navlist">
      <ul>
        <li><a href="app_list.php">View / Edit / Cancel Appointments</a></li>
        <li><a href="add_app.php">Add Appointment</a></li>
      </ul>
    </div>
  </div>
  
