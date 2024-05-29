<?php require_once('./dao/employeeDAO.php'); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Week 11 Demo App</title>
    </head>
    <body>
        <h1>Week 11 Demo App</h1>
        <?php
        //The abstractDAO and employeeDAO will throw exceptions
        //if there is a problem with the database connection.
        //The entire web page is contained in the try block, so
        //if there is any issue, the page does not load, and instead
        //informs the user about the error.
        try{
            $employeeDAO = new employeeDAO();
            //Tracks errors with the form fields
            $hasError = false;
            //Array for our error messages
            $errorMessages = Array();

            //Ensure all three values are set.
            //They will only be set when the form is submitted.
            //We only want the code that adds an employee to 
            //the database to run if the form has been submitted.
            if(isset($_POST['employeeId']) ||
                isset($_POST['firstName']) || 
                isset($_POST['lastName'])){
            
                //We know they are set, so let's check for values
                //EmployeeID should be a number
                if(!is_numeric($_POST['employeeId']) || $_POST['employeeId'] == ""){
                    $hasError = true;
                    $errorMessages['employeeIdError'] = 'Please enter a numeric Employee ID.';
                }

                if($_POST['firstName'] == ""){
                    $errorMessages['firstNameError'] = "Please enter a first name.";
                    $hasError = true;
                }

                if($_POST['lastName'] == ""){
                    $errorMessages['lastNameError'] = "Please enter a last name.";
                    $hasError = true;
                }

                if(!$hasError){
                    $employee = new Employee($_POST['employeeId'], $_POST['firstName'], $_POST['lastName']);
                    $addSuccess = $employeeDAO->addEmployee($employee);
                    echo '<h3>' . $addSuccess . '</h3>';
                }
            }  

            //The code that deletes a user directs them
            //back to this page with a parameter in the 
            //URL called 'deleted'. If this is set,
            //display a confirmation message.
            if(isset($_GET['deleted'])){
                if($_GET['deleted'] == true){
                    echo '<h3>Employee Deleted</h3>';
                }
            }
            
            
        ?>
        <form name="addEmployee" method="post" action="index.php">
        <table>
            <tr>
                <td>Employee ID:</td>
                <td><input type="text" name="employeeId" id="employeeId">
                <?php 
                //If there was an error with the employeeId field, display the message
                if(isset($errorMessages['employeeIdError'])){
                        echo '<span style=\'color:red\'>' . $errorMessages['employeeIdError'] . '</span>';
                      }
                ?></td>
            </tr>
            <tr>
                <td>First Name:</td>
                <td><input name="firstName" type="text" id="firstName">
                <?php 
                //If there was an error with the firstName field, display the message
                if(isset($errorMessages['firstNameError'])){
                        echo '<span style=\'color:red\'>' . $errorMessages['firstNameError'] . '</span>';
                      }
                ?>
                </td>
            </tr>
            <tr>
                <td>Last Name:</td>
                <td><input type="text" name="lastName" id="lastName">
                <?php 
                //If there was an error with the lastName field, display the message
                if(isset($errorMessages['lastNameError'])){
                        echo '<span style=\'color:red\'>' . $errorMessages['lastNameError'] . '</span>';
                      }
                ?>
                </td>
            </tr>
            <tr>
                <td><input type="submit" name="btnSubmit" id="btnSubmit" value="Add Employee"></td>
                <td><input type="reset" name="btnReset" id="btnReset" value="Reset"></td>
            </tr>
        </table>
            
        <?php
        //This section will display an HTML table containing all
        //the employees in the employees table. The getEmployees()
        //method of the employeeDAO class returns an array of employees
        //(if there are any).
        //
        $employees = $employeeDAO->getEmployees();
            if($employees){
                //We only want to output the table if we have employees.
                //If there are none, this code will not run.
                echo '<table border=\'1\'>';
                echo '<tr><th>Employee ID</th><th>First Name</th><th>Last Name</th></tr>';
                foreach($employees as $employee){
                    echo '<tr>';
                    echo '<td><a href=\'edit_employee.php?employeeId='. $employee->getEmployeeId() . '\'>' . $employee->getEmployeeId() . '</a></td>';
                    echo '<td>' . $employee->getFirstName() . '</td>';
                    echo '<td>' . $employee->getLastName() . '</td>';
                    echo '</tr>';
                }
            }
        
        }catch(Exception $e){
            //If there were any database connection/sql issues,
            //an error message will be displayed to the user.
            echo '<h3>Error on page.</h3>';
            echo '<p>' . $e->getMessage() . '</p>';            
        }
        ?>
        </form>
    </body>
</html>
