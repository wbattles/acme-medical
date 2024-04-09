<?php
require_once ('../../app_config.php');
require_once (APP_ROOT . '/' . APP_FOLDER_NAME . '/scripts/echoHTML.php');
require_once (APP_ROOT . '/' . APP_FOLDER_NAME . '/scripts/errorDisplay.php');
require_once (APP_ROOT . '/' . APP_FOLDER_NAME . '/scripts/tools.php');
require_once (APP_ROOT . '/' . APP_FOLDER_NAME . '/scripts/dbConnection.php');

$jsFile = APP_FOLDER_NAME . '/clientScripts/patient_client_checks.js';
$cssFile = APP_FOLDER_NAME . '/styles/main.css';

if (isset($_POST['firstName'])) {
    $firstName = cleanIO($_POST['firstName']);
};

if (isset($_POST['lastName'])) {
    $lastName = cleanIO($_POST['lastName']);
};

if (isset($_POST['gender'])) {
    $gender = cleanIO($_POST['gender']);
};

if (isset($_POST['birthdate'])) {
    $birthdate = cleanIO($_POST['birthdate']);
};

if (isset($_POST['genetics'])) {
    $genetics = cleanIO($_POST['genetics']);
};

if (isset($_POST['diabetes'])) {
    $diabetes = cleanIO($_POST['diabetes']);
};

if (isset($_POST['otherConditions'])) {
    $otherConditions = cleanIO($_POST['otherConditions']);
};


$db = getDB(DSN1, USER1, PASSWD1);

// try to insert row into database
try {
    $insertStmt = "INSERT INTO PatientInformation (FirstName, LastName, Gender, Birthdate, Genetics, Diabetes, OtherConditions) 
                    VALUES (:firstNameB, :lastNameB, :genderB, :birthdateB, :geneticsB, :diabetesB, :otherConditionsB)";

    $statement = $db->prepare($insertStmt);
    $statement->bindValue(':firstNameB', $firstName);
    $statement->bindValue(':lastNameB', $lastName);
    $statement->bindValue(':genderB', $gender);
    $statement->bindValue(':birthdateB', $birthdate);
    $statement->bindValue(':geneticsB', $genetics);
    $statement->bindValue(':diabetesB', $diabetes);
    $statement->bindValue(':otherConditionsB', $otherConditions);
    $statement->execute();
    $statement->closeCursor();

} catch (Exception $e) {
    $error_message = $e->getMessage();
    echoError($error_messagee);
    exit(1);
}


echoHead("Acme Medical", $jsFile, $cssFile);
echoHeader("ACME MEDICAL");

echo "<a href='patient-portal.php'><button>Finish</button></a>";
echo "Success";
