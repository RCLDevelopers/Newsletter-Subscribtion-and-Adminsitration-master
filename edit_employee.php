<?php
require_once('./dao/employeeDAO.php');

if(!isset($_GET['employeeId']) || !is_numeric($_GET['employeeId'])){
//Send the user back to the main page
header("Location: index.php");
exit;

} else{
    $employeeDAO = new employeeDAO();
    $employee = $employeeDAO->getEmployee($_GET['employeeId']);
    if($employee){
?>    
        
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Week 11 Demo App - Edit Employee - <?php echo $employee->getFirstName() . ' ' . $employee->getLastName();?></title>
        <script type="text/javascript">
            function confirmDelete(employeeName){
                return confirm("Do you wish to delete " + employeeName + "?");
            }
        </script>
    </head>
    <body>
        
        <?php
        if(isset($_GET['recordsUpdated'])){
                if(is_numeric($_GET['recordsUpdated'])){
                    echo '<h3> '. $_GET['recordsUpdated']. ' Employee Record Updated.</h3>';
                }
        }
        if(isset($_GET['missingFields'])){
                if($_GET['missingFields']){
                    echo '<h3 style="color:red;"> Please enter both first and last names.</h3>';
                }
        }?>
        <h3>Edit Employee</h3>
        <form name="editEmployee" method="post" action="process_employee.php?action=edit">
            <table>
                <tr>
                    <td>Employee ID:</td>
                    <td><input type="hidden" name="employeeId" id="employeeId" 
                               value="<?php echo $employee->getEmployeeId();?>"><?php echo $employee->getEmployeeId();?></td>
                </tr>
                <tr>
                    <td>First Name:</td>
                    <td><input type="text" name="firstName" id="firstName" 
                               value="<?php echo $employee->getFirstName();?>"></td>
                </tr>
                <tr>
                    <td>Last Name:</td>
                    <td><input type="text" name="lastName" id="lastName" 
                               value="<?php echo $employee->getLastName();?>"></td>
                </tr>
                <tr>
                    <td cospan="2"><a onclick="return confirmDelete('<?php echo $employee->getFirstName() . ' ' . $employee->getLastName();?>')" href="process_employee.php?action=delete&employeeId=<?php echo $employee->getEmployeeId();?>">DELETE <?php echo $employee->getFirstName() . " " . $employee->getLastName();?></a></td>
                </tr>
                <tr>
                    <td><input type="submit" name="btnSubmit" id="btnSubmit" value="Update Employee"></td>
                    <td><input type="reset" name="btnReset" id="btnReset" value="Reset"></td>
                </tr>
            </table>
        </form>
        <h4><a href="index.php">Back to main page</a></h4>
    </body>
</html>
<?php } else{
//Send the user back to the main page
header("Location: index.php");
exit;
}

} ?>