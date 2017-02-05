<?php require_once("../includes/connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../Templates/Admin_Template.php"); ?>
<link href="../stylesheets/TableStyles.css" rel="stylesheet" type="text/css" />

<?php
    if (isset($_POST['back'])) {
        header("Location: http://localhost/321pr/Admin/search_visits.php");
    
    }

    if(isset($_POST['search'])){
        $br="";
        if($_POST['radio']=='ALL'){
            $query="SELECT * FROM appons GROUP BY branch ORDER BY branch";
            $results= mysqli_query($conn,$query);
            echo mysqli_error($conn);
            // while($row=mysqli_fetch_array($results)){
            //     echo $row['pat'] ."  : ". $row['datetime'];
            // }
        }

        elseif(isset($_POST['branch'])){
            $br=$_POST['branch'];
            if($_POST['radio']=='aft'){
                $query="CALL get_app_aft('{$br}')";
                $results= mysqli_query($conn,$query);
                echo mysqli_error($conn);
                // while($row=mysqli_fetch_array($results)){
                //     echo $row['pat'] ."  : ". $row['datetime'];
                // }
            }
             if($_POST['radio']=='bef'){
                $query="CALL get_app_bef('{$br}')";
                $results= mysqli_query($conn,$query);
                echo mysqli_error($conn);
                // while($row=mysqli_fetch_array($results)){
                //     echo $row['pat'] ."  : ". $row['datetime'];
                // }
            }
        }

         

    }
?>

<div class="datagrid">
    <h2>                 
        Search Appointment Results<br/> <br/>
    </h2>   
          <form method="post" action="search_visits_res.php" >
                <table>
        <thead>
            <tr>
                <th>Branch</th>
                <th>Doctor</th>
                <th>Patient</th>
                <th>Date</th>
            </tr>
        </thead>
        <tfoot>

            <tr>
                <td colspan="2"></td>
                <td colspan="2">
                    <input type="submit" name="back" value="BACK">
                </td>
            </tr>
        </tfoot>
        <tbody>
        <?php
            while ($visit = mysqli_fetch_array($results)) {
                $output = "<tr>";
                if($_POST['radio']=='ALL'){
                    $output .= "<td>" . $visit['branch']  ."</td>";
                }else{
                    $output .= "<td>" . $br  ."</td>";
                }
                $output .= "<td>" . $visit["docname"] . "</td>";
                $output .= "<td>" . $visit["pat"] . "</td>";
                $output .= "<td>" . $visit["datetime"] . "</td>";
                // $output .= "<td>" . date_format($visit["datetime"], 'd-m-Y H:i') . "</td>";
                $output .= "</tr>";
                echo $output;
            }
        ?>
        <tr><td></td></tr>
        </tbody>
        </table>
        </form>
    
</div>
