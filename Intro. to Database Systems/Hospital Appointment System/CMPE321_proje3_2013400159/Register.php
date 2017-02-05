<?php require_once("./includes/connection.php"); ?>
<?php require_once("./includes/functions.php"); ?>
<?php include("./Templates/MainPage_Template.php"); ?>

<?php
    if (isset($_POST['back'])) {
        header("Location: http://localhost/321pr/index.php");
    }
    if (isset($_POST['add'])) {
			$errors = array();

			$required_fields = array('new_pass', 'new_id');
			foreach($required_fields as $fieldname) {
				if (!isset($_POST[$fieldname]) || empty($_POST[$fieldname])) { 
					$errors[] = $fieldname . " is required!"; 
				}
			}

			
			if (empty($errors)) {
				// Perform Update
				$id = $_POST['new_id'];
				$pass = $_POST['new_pass'];
              
				$query = "INSERT INTO pats(id,pass) VALUES (
                            '". $id ."',
							'" . $pass . "')";
				$result = mysqli_query($conn, $query);
                //echo $query;
                
				if (mysqli_affected_rows($conn) == 1) {
					// Success
					$message = "Patient {$id}'s information was successfully added.";
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
        Register:<br/> <br/> <!-- register -->
    </h2>            
    <form method="post" action="Register.php" >
        <table>
            <tr>
                <td>
                    ID:
                </td>
                <td>
                    <input name="new_id" type="text">
                </td>
            </tr>
            <tr>
                <td>
                    Password:
                </td>
                <td>
                    <input name="new_pass" type="password">
                </td>
            </tr>
        </table>
        <br />
            <div class="button_holder">
                    <input class="button" type="submit" name="add" value="REGISTER"> &nbsp; &nbsp; &nbsp;
                    <input class="button" type="submit" name="back" value="DISCARD">
            </div>
        
    </form>
    
</div>

<?php include("includes/footer.php"); ?>

<!-- CREATE TRIGGER doc_delete AFTER DELETE on docs
FOR EACH ROW
BEGIN
DELETE FROM appons
    WHERE appons.docname = old.name;
END -->