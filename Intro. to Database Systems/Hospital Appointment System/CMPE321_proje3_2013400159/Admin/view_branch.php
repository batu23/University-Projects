<?php require_once("../includes/connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php include("../Templates/Admin_Template.php"); ?>
<link href="../stylesheets/TableStyles.css" rel="stylesheet" type="text/css" />


<div id="content">
    <h2>                 
        View all branchs <br/> <br/>
    </h2>
        <form action="Welcome.php" method="post">
            <input type="submit" name="back" value="<< BACK">
        </form>
        <form action="edit_branch.php" method="post">
        <div class="datagrid">            
        <table>
        <thead>
			<tr>
                <th>Select</th>
                <th>Name</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
                <td colspan="2"></td>
                <td colspan="2">
                    <input type="submit" name="edit" value="EDIT SELECTED BRANCH">
                    <input type="submit" name="delete" value="DELETE SELECTED BRANCH">
                </td>
			</tr>
		</tfoot>
        
        <tbody>
        <?php
            $query = "SELECT * FROM branch";
            $set = mysqli_query($conn,$query);
            while ($br = mysqli_fetch_array($set)) {
                $name = $br["name"]; 
                $output = "<tr>";
                $output .= "<td><input type=\"radio\" name=\"branch_name\" value=\"" . $name . "\"></td>";
                $output .= "<td>" . $br["name"] . "</td>";
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