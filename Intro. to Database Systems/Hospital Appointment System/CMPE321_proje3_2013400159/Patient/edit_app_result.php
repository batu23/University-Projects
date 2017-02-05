<?php require_once("../includes/connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php
    // include("../Templates/Patients_Template.php");
    //session_start();
?>

<?php
    if (isset($_POST['edit'])) {
			$errors = array();

   //          $required_fields = array('new_ing', 'new_unit', 'new_price', 'new_usage');
			// foreach($required_fields as $fieldname) {
			// 	if (!isset($_POST[$fieldname]) || empty($_POST[$fieldname])) { 
			// 		$errors[] = $fieldname . "is required!"; 
			// 	}
			// }
			
			if (empty($errors)) {
				// Perform Update
                
				$brname = $_POST['br'];
				$docname = $_POST['doc'];
                $date = $_POST['date'];
                $pat = $_POST['pat'];
                $newbr= $_POST['new_branch'];
                $newdoc= $_POST['new_doc'];
                $newdate= $_POST['new_date'];
                $newdate1= date('Y-m-d H:i:s', strtotime($newdate));
              
          
				$query = "UPDATE appons SET  
							branch = '".$newbr. "',
                            docname = '".$newdoc."',
                            datetime = '".$newdate1."'
						WHERE branch = '" . $brname . "' AND docname = '". $docname ."' AND datetime = '".$date."'";
				$result = mysqli_query($conn, $query);

				if (mysqli_affected_rows($conn) == 1) {
					// Success
					echo "Appoinment information successfully updated.";
				} else {
					// Failed
					echo "The update failed.";
					echo "<br />". mysqli_connect_error();
				}
				
			} else {
				// Errors occurred
				echo "There were " . count($errors) . " errors in the form.";
			}
        }
        else {
            echo "ERROR";
        }

?>

<form action="home.php">
    <input class="button" type="submit" name="back" value="HOME">

</form>


<!-- <?php include("includes/footer.php"); ?> -->