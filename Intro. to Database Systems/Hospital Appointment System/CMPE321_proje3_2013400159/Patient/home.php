<?php
    session_start();
    require_once("../Templates/Patients_Template.php");
?>
<body>
<div>
<title>Welcome!</title>
<div id="content">
    <?php 
      $query = "SELECT * FROM pats WHERE id='".$patient_id."'";
      $params = array($patient_id);
      $query_results = mysqli_query($conn, $query);
      if(!$query_results)
			   die("No results found!");
      $results = mysqli_fetch_array($query_results);

      ?>
      <h2>Welcome Patient : <span style="color: #B29B35"><?php echo $results['id']?></span>!</h2>
      <p>Feel free to Add / View / Edit / Cancel appointments </p>
        <br /> <br /> <br />
       
        <?php
               // $query = "SELECT  v.datetime, d.name FROM visit v, doctor d WHERE v.doctor=d.id_number AND v.patient=(?)";
               // $params = array($patient_id);
               // $query_results = sqlsrv_query($conn, $query, $params);
               //     if(!$query_results)
			            //   die("No results found!");
               // $results = sqlsrv_fetch_array($query_results);        
        ?>
       
      
</div>
 
</div>
</body>