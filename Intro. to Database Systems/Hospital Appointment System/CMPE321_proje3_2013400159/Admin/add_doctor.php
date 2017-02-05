<?php require_once("../includes/connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php include("../Templates/Admin_Template.php"); ?>

<?php
    if (isset($_POST['back'])) {
        header("Location: http://localhost/321pr/Admin/Welcome.php");
    }
    if (isset($_POST['add'])) {
			$errors = array();

			$required_fields = array('new_name','new_dep');
			foreach($required_fields as $fieldname) {
				if (!isset($_POST[$fieldname]) || empty($_POST[$fieldname])) { 
					$errors[] = $fieldname . " is required!"; 
				}
			}
			// $fields_with_lengths = array('new_name' => 8, 'new_id' => 9);
			// foreach($fields_with_lengths as $fieldname => $length ) {
			// 	if (strlen(trim($_POST[$fieldname])) <> $length) { $errors[] = $fieldname . " length is invalid"; }
			// }

            $_POST['doctor_id'] = $_POST['new_id'];
            find_selected_doc();
            if (isset($selected_doc)) { $errors[] = "A doctor with the specified ID is already in the database!";}
			
			if (empty($errors)) {
				// Perform Update
                $id = $_POST['new_id'];
				$name = $_POST['new_name'];
                $department = $_POST['new_dep'];
				
				$query = "INSERT INTO docs(id,name,branch) VALUES (
                            '" . $id . "', 
							'" . $name . "', 
                            '" . $department . "')";
				$result = mysqli_query($conn, $query);
                //echo $query;

				if (mysqli_affected_rows($conn) == 1) {
					// Success
					$message = "Doctor {$name}'s information was successfully added.";
				} else {
					// Failed
					$message = "The add failed.";
					$message .= "<br />". mysqli_error($conn);
				}
				
			} else {
				// Errors occurred
				$message = "There were " . count($errors) . " errors in the form.";
			}
			
		} // end: if (isset($_POST['submit']))
?>


<div id="content"> 
        <?php if (!empty($message)) {
				echo "<p class=\"info\">" . $message . "</p>";
			} ?>
			<?php
			// output a list of the fields that had errors
			if (!empty($errors)) {
				echo "<p class=\"blockquote\">";
				echo "Please review the following errors:<br />";
				foreach($errors as $error) {
					echo " - " . $error . "<br />";
				}
				echo "</p>";
			}
			?>
    <h2>                 
        Add New Doctor<br/> <br/>
    </h2>            
    <form method="post" action="add_doctor.php" >
        <table>
             <tr>
                <td>
                    Id:
                </td>
                <td>
                    <input name="new_id" type="text">
                </td>
            </tr>
            <tr>
                <td>
                    Name:
                </td>
                <td>
                    <input name="new_name" type="text">
                </td>
            </tr>
            <tr>
                <td>
                    Branch:
                </td>
                <td>
                    <select name="new_dep">
                        <?php
                            $query = "SELECT name FROM branch ORDER BY name ASC";
                             $doctor_set = mysqli_query($conn,$query);
                            while($branch = mysqli_fetch_array($doctor_set)) {
                                echo "<option value=\"".$branch["name"]."\">".$branch["name"]."&nbsp; &nbsp; &nbsp;</option>";
                            }
                        ?>
                    </select>
                </td>
            </tr>
        </table>
        <br />
            <div class="button_holder">
                    <input class="button" type="submit" name="add" value="ADD RECORD"> &nbsp; &nbsp; &nbsp;
                    <input class="button" type="submit" name="back" value="DISCARD">
            </div>
        
    </form>
    
</div>

<?php include("../includes/footer.php"); ?>