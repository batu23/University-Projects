<?php
    include("../Templates/Patients_Template.php");
    //session_start();
?>

<title>Past Appointments</title>
<div id="content">
    <?php
        //$patient_id = "G1234567A";
        //Find all visits by patient - display datetime, doctor
        //Make it clickable list
        //Display all details on the right     
    // $query = "SELECT name, datetime, diagnosis FROM vw_Patient WHERE patient=(?) ORDER BY datetime DESC";
        $query = "SELECT docname, datetime,branch FROM appons WHERE pat='".$patient_id."' ORDER BY datetime DESC";
        //$query = "SELECT datetime, name FROM vw_Patient WHERE patient=(?) GROUP BY datetime HAVING COUNT(*)>0";
        $query_results = mysqli_query($conn, $query);
        if(!$query_results)
			   die("No results found!");

    ?>

    <div class="datagrid"> 
            
                <form method="post" action="edit_app.php">
                    <table id="inner">
                    <thead>  
                        <tr>
                            <th>Select</th>
                            <th>Branch</th>
                            <th>Doctor</th>
                            <th>Date-Time</th>
                        </tr>
                    </thead>


                    <tbody>
                    <?php
                      
                        while ($row = mysqli_fetch_array($query_results)) {
                            $brname = $row['branch'];
                            $docname = $row['docname'];
                            $date= $row['datetime'];
                            $date1= date('Y-m-d H:i:s', strtotime($date));
                            // $date1= date_create_from_format('Y-m-d H:i:s',$date);
                            // $pat=$patient_id;
                            $output = "<tr>";
                            $output .= "<td><input type=\"radio\" name=\"appid\" value=\"" . $brname.":".$docname. ":" .$date1.":".$patient_id."\"></td>";
                            // $output .= "<td><input type=\"hidden\" name=\"cname\" value=\"" . $id_name . "\">" . $doctor["commercial_name"] . "</td>";
                            // $output .= "<td><input type=\"hidden\" name=\"man\" value=\"" . $id_man . "\">" . $doctor["manufacturer"] . "</td>";
                            $output .= "<td>" . $brname . "</td>";
                            $output .= "<td>" . $docname . "</td>";
                            $output .= "<td>" . $date1 . "</td>";
                          

                            $output .= "</tr>";
                            echo $output;
                        }
                    ?>
                          <tr><td></td></tr>
                    </tbody>

<!-- 
                        <tbody>
                        <?php
                            $i = 0;
                            $row = mysqli_fetch_array($query_results);
                         do {
                                $i = $i+1;
                                echo "<tr class=\"alt\"><td> " . $row[2]. " </td> <td>" . $row[1]. " </td> <td>" . $row[0] . "</td></tr>";
                                //echo "<tr class=\"alt\"><td><input type=\"submit\" value=\"Details\"></td> <td>" . date_format($row[0], 'dS M, Y') . " </td> <td>" . $row[1] . "</td></tr>";
                          } while($row = mysqli_fetch_array($query_results)); 
                          //showData(date_format($firstVal[0], 'dS, M, Y'), $patient_id, $firstVal[1], $firstVal[2]);           
                        ?>
                    </tbody> -->
                <tfoot>
                    <tr>
                        <td colspan="2"></td>
                        <td colspan="2">
                            <input type="submit" name="edit" value="EDIT APPOINTMENT">
                            <input  type="hidden" name="date" value="<?php echo $date ?>">
                            <input type="submit" name="delete" value="CANCEL APPOINTMENT">
                        </td>
                    </tr>
                </tfoot>
             </table>
             </form>
               
    </div>
    
</div>
        
</div>
</body>
