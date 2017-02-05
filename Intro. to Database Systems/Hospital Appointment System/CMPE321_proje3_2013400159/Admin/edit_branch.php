<?php require_once("../includes/connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php include("../Templates/Admin_Template.php"); ?>

<?php
	$name=$_POST['branch_name'];

    if (isset($_POST['back'])) {
        header("Location: http://localhost/321pr/Admin/Welcome.php");;
    }
    if (isset($_POST['delete'])) {
        $query = "DELETE FROM branch WHERE name = '" . $name . "'";
				$result = mysqli_query($conn, $query);
                // echo mysqli_error($conn);
				if (mysqli_affected_rows($conn) == 1) {
					// Success
					echo "Branch with name " . $name . " successfully removed from database.";
				} else {
					// Failed
					echo "The delete failed.";
					echo "<br />".mysqli_connect_error();
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
        Edit Branch:<br/> <br/>
    </h2>            
    <form method="post" action="edit_branch_result.php" >
        <table>
            <tr>
                <td>
                    New Name:
                </td>
                <td>
                    <input name="new_name" type="text">
                </td>
            </tr>
            
        </table>
        <br />
            <div class="button_holder">
                    <input class="button" type="submit" name="edit" value="UPDATE RECORD"> &nbsp; &nbsp; &nbsp;
                    <input class="button" type="hidden" name="branch_name" value="<?php  echo $name ?>">
            </div>
        
    </form>
    <form action="view_branch.php">
    <input class="button" type="submit" name="back" value="BACK">
    </form> 
    
</div>

<!-- <?php include("../includes/footer.php"); ?> -->