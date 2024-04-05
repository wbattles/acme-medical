/*****************************************
* Create the MyCustomers database
*****************************************/
DROP DATABASE IF EXISTS MyCustomers;
CREATE DATABASE MyCustomers;
USE MyCustomers;  -- MySQL command

-- create the table
CREATE TABLE customers_main (
  email       VARCHAR(255)        NOT NULL,
  password    VARCHAR(255)   	  NOT NULL,
  first_name  VARCHAR(255) 		NOT NULL,
  state		VARCHAR(2)			NOT NULL,
  zip       VARCHAR(10)			NOT NULL,
  phone		VARCHAR(20)			NOT NULL,
  membership_type VARCHAR(20)   NOT NULL,
  starting_date DATETIME        NOT NULL,
  PRIMARY KEY (email)
);

-- create the users and grant priveleges to those users
DROP USER IF EXISTS 'kermit';
CREATE USER kermit
IDENTIFIED BY 'sesame';

GRANT SELECT, INSERT, DELETE, UPDATE
ON customers_main
TO kermit@localhost
IDENTIFIED BY 'sesame';

