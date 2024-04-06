
DROP DATABASE IF EXISTS AcmeMedicalDatabase;
CREATE DATABASE AcmeMedicalDatabase;
USE AcmeMedicalDatabase; 


CREATE TABLE IF NOT EXISTS PatientInformation (
  PatientID INT AUTO_INCREMENT PRIMARY KEY,
  FirstName VARCHAR(255) NOT NULL,
  LastName VARCHAR(255) NOT NULL,
  Gender ENUM('Male', 'Female', 'Other') NOT NULL,
  Birthdate DATE NOT NULL,
  Genetics TEXT,
  Diabetes ENUM('Yes', 'No') NOT NULL,
  OtherConditions TEXT
);

INSERT INTO PatientInformation
(FirstName, LastName, Gender, Birthdate, Genetics, Diabetes, OtherConditions) 
VALUES 
('Alice', 'Smith', 'Female', '1980-05-21', 'BRCA1 mutation', 'No', 'None'),
('Bob', 'Johnson', 'Male', '1992-07-04', 'No known mutations', 'Yes', 'Hypertension'),
('Charlie', 'Brown', 'Other', '1975-12-17', 'ApoE4 allele', 'No', 'Hyperlipidemia');


CREATE TABLE Medication (
  PatientID INT,
  Vest ENUM('Yes', 'No') NOT NULL DEFAULT 'No',
  Acapella ENUM('Yes', 'No') NOT NULL DEFAULT 'No',
  Pulmozyme ENUM('Yes', 'No') NOT NULL DEFAULT 'No',
  PulmozymeQuantity INT DEFAULT NULL,
  PulmozymeDateReceived DATE DEFAULT NULL,
  InhaledTobi ENUM('Yes', 'No') NOT NULL DEFAULT 'No',
  InhaledColistin ENUM('Yes', 'No') NOT NULL DEFAULT 'No',
  HypertonicSaline ENUM('3%', '7%', 'No') NOT NULL DEFAULT 'No',
  Azithromycin ENUM('Yes', 'No') NOT NULL DEFAULT 'No',
  Clarithromycin ENUM('Yes', 'No') NOT NULL DEFAULT 'No',
  InhaledGentamicin ENUM('Yes', 'No') NOT NULL DEFAULT 'No',
  Enzymes ENUM('Yes', 'No') NOT NULL DEFAULT 'No',
  EnzymesTypeDosage TEXT,
  PRIMARY KEY (PatientID),
  FOREIGN KEY (PatientID) REFERENCES PatientInformation(PatientID)
);

INSERT INTO Medication 
(PatientID, Vest, Acapella, Pulmozyme, PulmozymeQuantity, PulmozymeDateReceived, 
InhaledTobi, InhaledColistin, HypertonicSaline, Azithromycin, 
Clarithromycin, InhaledGentamicin, Enzymes, EnzymesTypeDosage) 
VALUES 
(1, 'No', 'Yes', 'No', NULL, NULL, 'No', 'No', '7%', 'Yes', 'No', 'No', 'Yes', 'Type1, 250mg'),
(2, 'Yes', 'No', 'Yes', 1, '2024-04-05', 'Yes', 'No', '3%', 'No', 'Yes', 'Yes', 'No', NULL),
(3, 'No', 'Yes', 'Yes', 2, '2024-04-06', 'No', 'Yes', 'No', 'Yes', 'No', 'No', 'Yes', 'Type2, 500mg');


CREATE TABLE PatientTests (
  TestRecordID INT AUTO_INCREMENT PRIMARY KEY,
  PatientID INT,
  TestDate DATE,
  FEV TEXT,
  FOREIGN KEY (PatientID) REFERENCES PatientInformation(PatientID)
);

INSERT INTO PatientTests (TestRecordID, PatientID, TestDate, FEV) VALUES
(1, 1, '2024-04-06', '89'),
(2, 1, '2024-04-06', '89'),
(3, 2, '2024-04-06', '88'),
(4, 3, '2024-04-06', '90');


DROP USER IF EXISTS 'kermit';
CREATE USER 'kermit'@'localhost' IDENTIFIED BY 'sesame';

GRANT SELECT, INSERT, DELETE, UPDATE 
ON AcmeMedicalDatabase.* TO 'kermit'@'localhost';
TO kermit@localhost
IDENTIFIED BY 'sesame';

