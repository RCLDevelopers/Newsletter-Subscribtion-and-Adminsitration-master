<?php
require_once('abstractDAO.php');
require_once('./model/employee.php');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of employeeDAO
 *
 * @author Matt
 */
class employeeDAO extends abstractDAO {
        
    function __construct() {
        try{
            parent::__construct();
        } catch(mysqli_sql_exception $e){
            throw $e;
        }
    }
    
    /*
     * This is an example of how to use the query() method of a mysqli object.
     * 
     * Returns an array of <code>Employee</code> objects. If no employees exist, returns false.
     */
    public function getEmployees(){
        //The query method returns a mysqli_result object
        $result = $this->mysqli->query('SELECT * FROM employees');
        $employees = Array();
        
        if($result->num_rows >= 1){
            while($row = $result->fetch_assoc()){
                //Create a new employee object, and add it to the array.
                $employee = new Employee($row['employeeId'], $row['firstName'], $row['lastName']);
                $employees[] = $employee;
            }
            $result->free();
            return $employees;
        }
        $result->free();
        return false;
    }
    
    /*
     * This is an example of how to use a prepared statement
     * with a select query.
     */
    public function getEmployee($employeeId){
        $query = 'SELECT * FROM employees WHERE employeeId = ?';
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param('i', $employeeId);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows == 1){
            $temp = $result->fetch_assoc();
            $employee = new Employee($temp['employeeId'], $temp['firstName'], $temp['lastName']);
            $result->free();
            return $employee;
        }
        $result->free();
        return false;
    }

    public function addEmployee($employee){
        if(!is_numeric($employee->getEmployeeId())){
            return 'EmployeeId must be a number.';
        }
        if(!$this->mysqli->connect_errno){
            //The query uses the question mark (?) as a
            //placeholder for the parameters to be used
            //in the query.
            $query = 'INSERT INTO employees VALUES (?,?,?)';
            //The prepare method of the mysqli object returns
            //a mysqli_stmt object. It takes a parameterized 
            //query as a parameter.
            $stmt = $this->mysqli->prepare($query);
            //The first parameter of bind_param takes a string
            //describing the data. In this case, we are passing 
            //three variables: an integer(employeeId), and two
            //strings (firstName and lastName).
            //
            //The string contains a one-letter datatype description
            //for each parameter. 'i' is used for integers, and 's'
            //is used for strings.
            $stmt->bind_param('iss', 
                    $employee->getEmployeeId(), 
                    $employee->getFirstName(), 
                    $employee->getLastName());
            //Execute the statement
            $stmt->execute();
            //If there are errors, they will be in the error property of the
            //mysqli_stmt object.
            if($stmt->error){
                return $stmt->error;
            } else {
                return $employee->getFirstName() . ' ' . $employee->getLastName() . ' added successfully!';
            }
        } else {
            return 'Could not connect to Database.';
        }
    }
    
    public function deleteEmployee($employeeId){
        if(!$this->mysqli->connect_errno){
            $query = 'DELETE FROM employees WHERE employeeId = ?';
            $stmt = $this->mysqli->prepare($query);
            $stmt->bind_param('i', $employeeId);
            $stmt->execute();
            if($stmt->error){
                return false;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }
    
    public function editEmployee($employeeId, $firstName, $lastName){
        if(!$this->mysqli->connect_errno){
            $query = 'UPDATE employees SET firstName = ?, lastName = ? WHERE employeeId = ?';
            $stmt = $this->mysqli->prepare($query);
            $stmt->bind_param('ssi', $firstName, $lastName, $employeeId);
            $stmt->execute();
            if($stmt->error){
                return false;
            } else {
                return $stmt->affected_rows;
            }
        } else {
            return false;
        }
    }
}

?>
