<?php
require_once ('../../app_config.php');
require_once (APP_ROOT . '/' . APP_FOLDER_NAME . '/scripts/echoHTML.php');
require_once (APP_ROOT . '/' . APP_FOLDER_NAME . '/scripts/errorDisplay.php');
require_once (APP_ROOT . '/' . APP_FOLDER_NAME . '/scripts/tools.php');
require_once (APP_ROOT . '/' . APP_FOLDER_NAME . '/scripts/dbConnection.php');

$jsFile = APP_FOLDER_NAME . '/clientScripts/patient_client_checks.js';
$cssFile = APP_FOLDER_NAME . '/styles/main.css';

if (isset($_POST['MedName'])) {
    $MedName = cleanIO($_POST['MedName']);
};

if (isset($_POST['MedType'])) {
    $MedType = cleanIO($_POST['MedType']);
};

if (isset($_POST['Enzyme?'])) {
    $Enzyme? = cleanIO($_POST['Enzyme?']);
};

$db = getDB(DSN1, USER1, PASSWD1);

try {
    $insertStmt = "INSERT INTO Medications (MedName, MedType, Enzyme?) VALUES (:MedNameB, :MedTypeB, :Enzyme?B)";

    $statement = $db->prepare($insertStmt);
    $statement->bindValue(':MedNameB', $MedName);
    $statement->bindValue(':MedTypeB', $MedType);
    $statement->bindValue(':Enzyme?', $Enzyme?);
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
