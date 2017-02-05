<?php require_once("../includes/connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php
    // include("../Templates/Patients_Template.php");
    //session_start();
?>

<?php

    $id_data = explode(":", $_POST['appid']);
        $br=$id_data[0];
        $doc=$id_data[1];
        $date=$_POST['date'];
        $pat=$id_data[3];
    if (isset($_POST['back'])) {
         header("Location: http://localhost/321pr/Patient/app_list.php");
    }
    if (isset($_POST['delete'])) {

        $query = "DELETE FROM appons WHERE pat= '".$pat."' AND datetime = '" . $date."'";
				$result = mysqli_query($conn, $query);
                echo mysqli_error($conn);
				if (mysqli_affected_rows($conn) == 1) {
					// Success
					$message = "Appointment on  {$date} with doctor {$doc} was successfully removed from database.";
				} else {
					// Failed
					$message = "The delete failed.";
					$message .= "<br />". mysqli_error($conn);
				}
    } 			
?>
<div id="content">
    <div id="para3">
    <h2>
        <?php
        if (!isset($_POST['from_view'])) { 
            if (!empty($message)) {
                echo "<p class=\"info\">" . $message . "</p>";
            } ?>
            </h2>
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
        Edit Appoinment: <br/> <br/>
    </h2>            
    <form method="post" action="edit_app_result.php" >
        <table>
        
             <tr>
                <td>
                    New Date:<!-- tarih sectir-->
                </td>
                <td>

                        <input type="datetime-local" name="new_date" step=300>
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
            <tr>
                <td>
                   New Doctor :
                </td>
                <td>
                    <select name="new_doc">
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
                    <input class="button" type="submit" name="edit" value="UPDATE RECORD"> &nbsp; &nbsp; &nbsp;
                    <input  type="hidden" name="br" value="<?php echo $br ?>">
                    <input  type="hidden" name="doc" value="<?php echo $doc ?>">
                    <input  type="hidden" name="date" value="<?php echo $date ?>">
                    <input  type="hidden" name="pat" value="<?php echo $pat ?>">
                   
            </div>
        
    </form>
    <form action="home.php">
    <input class="button" type="submit" name="back" value="HOME">
    </form> 
    
</div>


<!-- <?php include("includes/footer.php"); ?> -->