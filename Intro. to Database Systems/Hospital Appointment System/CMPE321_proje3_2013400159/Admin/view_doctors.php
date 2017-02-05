<?php require_once("../includes/connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php include("../Templates/Admin_Template.php"); ?>
<link href="../stylesheets/TableStyles.css" rel="stylesheet" type="text/css" />


<div id="content">
    <h2>                 
        View all doctors <br/> <br/>
    </h2>
        <form action="Welcome.php" method="post">
            <input type="submit" name="back" value="<< BACK">
        </form>
        <form action="edit_doctor.php" method="post">
        <div class="datagrid">            
        <table>
        <thead>
			<tr>
                <th>Select</th>
                <th>ID</th>
                <th>Name</th>
                <th>Department</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
                <td colspan="2"></td>
                <td colspan="2">
                    <input type="submit" name="edit" value="EDIT SELECTED DOCTOR">
                    <input type="submit" name="delete" value="DELETE SELECTED DOCTOR">
                </td>
			</tr>
		</tfoot>
        
        <tbody>
        <?php
            $doctor_set = get_all_doctors();
            while ($doctor = mysqli_fetch_array($doctor_set)) {
                $id = $doctor["id"]; 
                $output = "<tr>";
                $output .= "<td><input type=\"radio\" name=\"doctor_id\" value=\"" . $id . "\"></td>";
                $output .= "<td>" . $doctor["id"] . "</td>";
                $output .= "<td>" . $doctor["name"] . "</td>";
                $output .= "<td>" . $doctor["branch"] . "</td>";
                $output .= "</tr>";
                echo $output;
               
            }
        ?>
              <tr><td></td></tr>
        </tbody>
        </table>
        </div>
        <input type="hidden" name="from_view" value=TRUE>
        </form>    
</div>

<!-- <?php include("../includes/footer.php"); ?> -->