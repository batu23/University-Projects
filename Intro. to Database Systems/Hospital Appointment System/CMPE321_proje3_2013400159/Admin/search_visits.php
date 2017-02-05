<?php require_once("../includes/connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../Templates/Admin_Template.php"); ?>
<link href="../stylesheets/TableStyles.css" rel="stylesheet" type="text/css" />

<?php
    if (isset($_POST['back'])) {
        header("Location: http://localhost/321pr/Admin/Welcome.php");
    }
?>

<div id="content">
    <?php if (isset($visit_set)) {?>
    <h2>                 
        Search Appointment<br/> <br/>
    </h2>   
			<!-- <?php
            if (mysqli_num_rows($visit_set)!=0) {
                echo "<blockquote> No Result found! </blockquote><br><br>";
            }
            else {
			?> -->

           <!--  <div class="datagrid">            
        <form method="post" action="view_visit.php" >
                <table>
        <thead>
			<tr>
                <th>Select</th>
                <th>Doctor</th>
                <th>Patient</th>
                <th>Date</th>
			</tr>
		</thead>
        <tfoot>

			<tr>
                <td colspan="2"></td>
                <td colspan="2">
                    <input type="submit" name="edit" value="VIEW SELECTED VISIT">
                </td>
			</tr>
		</tfoot>
        <tbody>
        <?php
            while ($visit = mysqli_fetch_array($visit_set)) {
                $output = "<tr>";
                $output .= "<td><input type=\"radio\" name=\"datetime\" value=\"" . date_format($visit["datetime"], 'Y-m-d\TH:i:s') . "\"></td>";
                $output .= "<td>" . $visit["doctor"] . "</td>";
                $output .= "<td>" . $visit["pat"] . "</td>";
                $output .= "<td>" . date_format($visit["datetime"], 'd-m-Y H:i') . "</td>";
                $output .= "</tr>";
                echo $output;
            }
        ?>
        <tr><td></td></tr>
        </tbody>
        </table>
        </form>
        </div> -->
    <br> <br>
     <?php            }}?>
    <h2>                 
        Search Appointment<br/> <br/>
    </h2>            
    <form method="post" action="search_visits_res.php" >
        <table>
            <tr>
                <td>
                    Branch:
                </td>
                <td>
                    <select name="branch">
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
                    Before:
                </td>
                <td>
                    <input name="radio" value="bef" type="radio">
                </td>
            </tr>
            <tr>
                <td>
                    After:
                </td>
                <td>
                    <input name="radio" value="aft" type="radio">
                </td>
            </tr>
            <tr>
                <td>
                    ALL:
                </td>
                <td>
                    <input name="radio" value="ALL" type="radio">
                </td>
            </tr>
        </table>
        <br />
            <div class="button_holder">
                    <input class="button" type="submit" name="search" value="SEARCH"> &nbsp; &nbsp; &nbsp;
            </div>
        
    </form>
    <form action="Welcome.php">
    <input class="button" type="submit" name="back" value="HOME">

</form>
    
</div>
