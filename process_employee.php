<?php
require_once('./dao/employeeDAO.php');
if(isset($_GET['action'])){
    if($_GET['action'] == "edit"){
        if(isset($_POST['employeeId']) && 
                isset($_POST['firstName']) && 
                isset($_POST['lastName'])){
        
        if(is_numeric($_POST['employeeId']) &&
                $_POST['firstName'] != "" &&
                $_POST['lastName'] != ""){    
               
                $employeeDAO = new employeeDAO();
                $result = $employeeDAO->editEmployee($_POST['employeeId'], 
                        $_POST['firstName'], $_POST['lastName']);
                

                if($result > 0){
                    header('Location:edit_employee.php?recordsUpdated='.$result.'&employeeId=' . $_POST['employeeId']);
                } else {
                    header('Location:edit_employee.php?employeeId=' . $_POST['employeeId']);
                }
            } else {
                header('Location:edit_employee.php?missingFields=true&employeeId=' . $_POST['employeeId']);
            }
        } else {
            header('Location:edit_employee.php?error=true&employeeId=' . $_POST['employeeId']);
        }
    }
    
    if($_GET['action'] == "delete"){
        if(isset($_GET['employeeId']) && is_numeric($_GET['employeeId'])){
            $employeeDAO = new employeeDAO();
            $success = $employeeDAO->deleteEmployee($_GET['employeeId']);
            echo $success;
            if($success){
                header('Location:index.php?deleted=true');
            } else {
                header('Location:index.php?deleted=false');
            }
        }
    }
}
?>
