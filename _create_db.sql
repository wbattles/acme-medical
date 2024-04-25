-- User kermit@localhost
-- Password sesame

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


CREATE TABLE Doctors (
  DoctorID INT AUTO_INCREMENT PRIMARY KEY,
  DFirstName VARCHAR(255) NOT NULL,
  DLastName VARCHAR(255) NOT NULL
);

INSERT INTO Doctors
(DFirstName, DLastName) 
VALUES
('John', 'Doe'),
('Jane', 'Doe'),
('Jim', 'Beam');


CREATE TABLE Visits (
  VisitID INT AUTO_INCREMENT PRIMARY KEY,
  PatientID INT,
  DoctorID INT,
  VisitDate DATE,
  FOREIGN KEY (PatientID) REFERENCES PatientInformation(PatientID) ON DELETE CASCADE,
  FOREIGN KEY (DoctorID) REFERENCES Doctors(DoctorID) ON DELETE CASCADE
);

INSERT INTO Visits (PatientID, DoctorID, VisitDate) 
VALUES
(1, 1, '2023-01-10'),
(2, 1, '2023-01-15'),
(3, 2, '2023-02-05');


CREATE TABLE Tests (
  TestRecordID INT AUTO_INCREMENT PRIMARY KEY,
  VisitID INT,
  FEV TEXT,
  FOREIGN KEY (VisitID) REFERENCES Visits(VisitID) ON DELETE CASCADE
);

INSERT INTO Tests (VisitID, FEV) 
VALUES
(1, '90'),
(1, '74'),
(2, '95'),
(3, '82');


CREATE TABLE Medications (
  MedID INT AUTO_INCREMENT PRIMARY KEY,
  MedName VARCHAR(255) NOT NULL,
  MedType VARCHAR(255),
  Enzyme VARCHAR(255)
);

INSERT INTO Medications (MedName, MedType, Enzyme) 
VALUES
('Vest', NULL, 'N'),
('Acapella', NULL, 'N'),
('Pulmozyme', NULL, 'N'),
('Tobi', 'Inhaled', 'N'),
('Tobi', 'Oral', 'N'),
('Inhaled Colistin', NULL, 'N'),
('Hypertonic Saline', NULL, 'N'),
('Azithromycin', NULL, 'N'),
('Clarithromycin', NULL, 'N'),
('Inhaled Gentamicin', NULL, 'N'),
('Creon', NULL, 'Y');



CREATE TABLE Prescriptions (
  PrescriptionID INT AUTO_INCREMENT PRIMARY KEY,
  MedID INT,
  VisitID INT,
  Dosage VARCHAR(255),
  Quantity VARCHAR(255),
  DateReceived DATE,
  FOREIGN KEY (MedID) REFERENCES Medications(MedID) ON DELETE CASCADE,
  FOREIGN KEY (VisitID) REFERENCES Visits(VisitID) ON DELETE CASCADE
);

INSERT INTO Prescriptions (MedID, VisitID, Dosage, Quantity, DateReceived)
VALUES
(1, 3, '100 mg', NULL, NULL),
(1, 3, '100 mg', NULL, NULL),
(8, 2, '1000 ml' , NULL, NULL),
(11, 3, '350 mg', NULL, NULL);




DROP USER IF EXISTS 'kermit'@'localhost';
CREATE USER 'kermit'@'localhost' IDENTIFIED BY 'sesame';
GRANT SELECT, INSERT, DELETE, UPDATE ON AcmeMedicalDatabase.* TO 'kermit'@'localhost';