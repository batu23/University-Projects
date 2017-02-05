<?php require_once("../includes/connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php include("../Templates/Admin_Template.php"); ?>

<?php
	$doc_id=$_POST['doctor_id'];

    if (isset($_POST['back'])) {
        header("Location: http://localhost/321pr/Admin/Welcome.php");;
    }
    if (isset($_POST['delete'])) {
        $query = "DELETE FROM docs WHERE id = '" . $doc_id . "'";
				$result = mysqli_query($conn, $query);
                //echo $query;
				if (mysqli_affected_rows($conn) == 1) {
        
					// Success
					echo "Doctor with id " . $doc_id . " successfully removed from database.";
				} else {
               
					// Failed
					echo "The delete failed.";
					echo "<br />".mysqli_error();
				}
    } 
?>


<div id="content">
    <div id="para3">
        <?php
        if (!isset($_POST['from_view'])) {
            if (!empty($message)) {
				echo "<p class=\"info\">" . $message . "</p>";
			} ?>
			<?php
			// output a list of the fields that had errors
			if (!empty($errors)) {
				echo "<p class=\"info\">";
				echo "Please review the following errors:<br />";
				foreach($errors as $error) {
					echo " - " . $error . "<br />";
				}
				echo "</p>";
			}
        }
			?>
    </div> 
    <h2>                 
        Edit Doctor:<br/> <br/>
    </h2>            
    <form method="post" action="edit_doctor_result.php" >
        <table>
            <tr>
                <td>
                    New Name:
                </td>
                <td>
                    <input name="new_name" type="text">
                </td>
            </tr>
            <tr>
                <td>
                    New Branch:
                </td>
                <td>
                    <select name="new_branch">
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
                    <input class="button" type="submit" name="edit" value="UPDATE RECORD"> &nbsp; &nbsp; &nbsp;
                    <input class="button" type="hidden" name="doctor_id" value="<?php  echo $doc_id ?>">
            </div>
        
    </form>
    <form action="view_doctors.php">
    <input class="button" type="submit" name="back" value="BACK">
    </form> 
    
</div>

<!-- <?php include("../includes/footer.php"); ?> -->