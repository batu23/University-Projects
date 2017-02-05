<?php //require_once("../includes/connection.php"); ?>
<?php //require_once("../includes/functions.php"); ?>
<?php include("../Templates/Patients_Template.php"); ?>
<?php //include("./home.php"); ?>
<?php
    if (isset($_POST['back'])) {
        header("Location: http://localhost/321pr/Patient/home.php");
    }
    
    if (isset($_POST['add'])) {
			$errors = array();

			if (empty($errors)) {
				// Perform Update
				$patient = $patient_id;
                $doctor = $_POST['doctor'];
				$branch = $_POST['branch'];
                $date = $_POST['date'];

				$query = "INSERT INTO appons(docname,pat,datetime,branch) VALUES (
                            '". $doctor ."',
							'" . $patient . "', 
                            '" . $date . "',
							'" . $branch . "')";
				$result = mysqli_query($conn, $query);
                //echo $query;
				
                if (mysqli_affected_rows($conn) == 1) {
					// Success
					$message = "New appointment was successfully added.";
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
<head>
    <title>
        Add Appointment
    </title>
   
</head>


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
        Add New Appointment<br/> <br/>
    </h2>            
    <form method="post" action="add_app.php" >
        <table>
            <tr>
                <td>
                    Date:<!-- tarih sectir-->
                </td>
                <td>

						<input type="datetime-local" name="date" step=300>
                </td>
            </tr>
        
            <tr>
                <td>
                    Branch:
                </td>
                <td>
                    <select name="branch" >
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
            <tr>
                <td>
                    Doctor :
                </td>
                <td>
                    <select name="doctor">
                        <?php
                            $query = "SELECT name FROM docs ORDER BY name ASC";
							$all_doctors = mysqli_query($conn,$query);
                            while($doctor = mysqli_fetch_array($all_doctors)) {
                                echo "<option value=\"".$doctor["name"]."\">&nbsp; &nbsp; &nbsp; ".$doctor["name"]."</option>";
                            }

                        ?>
                    </select>
                </td>
            </tr>
        </table>
        <br />
            <div class="button_holder">
                    <input class="button" type="submit" name="add" value="ADD APPOINTMENT"> &nbsp; &nbsp; &nbsp;
                    <input class="button" type="submit" name="back" value="DISCARD"> &nbsp; &nbsp; &nbsp;
            </div>
                            <input type="hidden" name="date" value="<?php echo $date->format('Y-m-d H:i:s');?>">
    </form>
    
</div>

<?php include("../includes/footer.php"); ?>