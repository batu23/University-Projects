<?php require_once("../includes/connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php include("../Templates/Admin_Template.php"); ?>

<?php
    if (isset($_POST['back'])) {
        header("Location: http://localhost/321pr/Admin/Welcome.php");
    }
    if (isset($_POST['add'])) {

        $name = $_POST['new_name'];

            $errors = array();

            // $required_fields = array('new_name','new_dep');
            // foreach($required_fields as $fieldname) {
            //     if (!isset($_POST[$fieldname]) || empty($_POST[$fieldname])) { 
            //         $errors[] = $fieldname . " is required!"; 
            //     }
            // }


            $query = "SELECT name FROM branch WHERE name ='".$name."' LIMIT 1";
            $result_set = mysqli_query($conn,$query);
            // $result_set = mysqli_fetch_array($result_set);
            if (mysqli_num_rows($result_set)!=0) {
                $errors[] = "A branch with the specified name is already in the database!";
            } 

            if (empty($errors)) {
                // Perform Update
                
                
                $query = "INSERT INTO branch(name) VALUES ('" . $name . "')";
                $result = mysqli_query($conn, $query);
                //echo $query;

                if (mysqli_affected_rows($conn) == 1) {
                    // Success
                    $message = "Branch {$name}'s information successfully added.";
                } else {
                    // Failed
                    $message = "The add failed.";
                    $message .= "<br />". mysqli_connect_error();
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
        Add New Branch<br/> <br/>
    </h2>            
    <form method="post" action="add_branch.php" >
        <table>
             
            <tr>
                <td>
                    Name:
                </td>
                <td>
                    <input name="new_name" type="text">
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