<?php
	class Employee{
		private $employeeId;
		private $firstName;
		private $lastName;
		
		function __construct($employeeId, $firstName, $lastName){
			$this->setEmployeeId($employeeId);
			$this->setFirstName($firstName);
			$this->setLastName($lastName);
		}
		
		public function getEmployeeId(){
			return $this->employeeId;
		}
		
		public function setEmployeeId($employeeId){
			$this->employeeId = $employeeId;
		}
		
		public function getFirstName(){
			return $this->firstName;
		}
		
		public function setFirstName($firstName){
			$this->firstName = $firstName;
		}
		
		public function getLastName(){
			return $this->lastName;
		}
		
		public function setLastName($lastName){
			$this->lastName = $lastName;
		}
		
	}
?>