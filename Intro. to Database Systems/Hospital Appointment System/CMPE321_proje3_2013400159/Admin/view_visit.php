<?php require_once("../includes/connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php include("../Templates/Admin_Template.php"); ?>
<link href="../stylesheets/TableStyles.css" rel="stylesheet" type="text/css" />

<?php
    $visit = get_visit($_POST['datetime']);
?>

<div id="content">
    <h2>                 
        View visit<br/> <br/>
    </h2>
       
        <div class="datagrid">            
        <table>
            <tr>
                <th>Doctor</th>
                <td><?php echo get_doc_name($visit['docname']); ?></td>
            </tr>
            <tr>
                <th>Patient</th>
                <td><?php echo get_patient_name($visit['pat']); ?></td>
            </tr>
            <tr>
                <th>Visit Time</th>
                <td><?php echo date_format($visit['datetime'], 'd-M-Y  H:i'); ?></td>
            </tr>
        </table>
        
        </div>
        
</div>

<?php include("../includes/footer.php"); ?>