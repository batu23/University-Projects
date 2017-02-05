<?php
//<require_once("includes/constants.php");
   $servername = "localhost";
   $username = 'root';
   $password = '';
   $dbname = "321den";

   
   $conn = mysqli_connect($servername, $username, $password, $dbname);

   
   //If you want to connect to a local SQL Server database
   //$conn = sqlsrv_connect( '(localdb)\v11.0', array( 'Database'=>'clinicSystem'));
  if (mysqli_error($conn)) 
      die("Connection failed: " . mysqli_error($conn));

   //phpinfo();

?>

