CREATE DATABASE cst8285;
GRANT USAGE ON *.* TO cst8285@localhost IDENTIFIED BY 'password';
GRANT ALL PRIVILEGES ON cst8285.* TO cst8285@localhost;
FLUSH PRIVILEGES;

USE cst8285;

CREATE TABLE employees(
        employeeId int not null,
	firstName VARCHAR(50) NOT NULL,
	lastName VARCHAR(50) NOT NULL,
	PRIMARY KEY (employeeId)
	);
