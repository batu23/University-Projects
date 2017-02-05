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
                $id = $_POST['doctor_id'];
                $newbr= $_POST['new_branch'];
                $newname= $_POST['new_name'];
                
          
				$query = "UPDATE docs SET  
                            name = '".$newname."',
                            branch = '".$newbr."'
						WHERE id = '".$id."'";
				$result = mysqli_query($conn, $query);

				if (mysqli_affected_rows($conn) == 1) {
					// Success
					echo "Doctor with id {$id} successfully updated.";
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

<form action="Welcome.php">
    <input class="button" type="submit" name="back" value="HOME">

</form>


<!-- <?php include("includes/footer.php"); ?> -->