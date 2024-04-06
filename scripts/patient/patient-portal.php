<?php
require_once ('../../app_config.php');
require_once (APP_ROOT . '/' . APP_FOLDER_NAME . '/scripts/echoHTML.php');
require_once (APP_ROOT . '/' . APP_FOLDER_NAME . '/scripts/errorDisplay.php');
require_once (APP_ROOT . '/' . APP_FOLDER_NAME . '/scripts/tools.php');
require_once (APP_ROOT . '/' . APP_FOLDER_NAME . '/scripts/dbConnection.php');

$jsFile = APP_FOLDER_NAME . '/clientScripts/patient_client_checks.js';
$cssFile = APP_FOLDER_NAME . '/styles/main.css';

$db = getDB(DSN1, USER1, PASSWD1);

$selectStmt = "SELECT PatientID, FirstName, LastName, Gender, Birthdate, Genetics, Diabetes, OtherConditions FROM PatientInformation";

try {
    $query = $db->prepare($selectStmt);
    $query -> execute();
    $allPatients = $query -> fetchAll();
    $query->closeCursor();
} catch(Exception $e) {
    echoError($e-> getMessage(), $jsFile, $cssFile);
    exit(1);
};

echoHead("Acme Medical", $jsFile, $cssFile);
echoHeader("ACME MEDICAL");

echo "<table>
        <tr>
            <th>Patient ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Gender</th>
            <th>Birthdate</th>
            <th>Genetics</th>
            <th>Diabetes</th>
            <th>Other Conditions</th>
        </tr>";

foreach ($allPatients as $nextPatient) {
    echo "<tr>";
    echo "<td>" . $nextPatient["PatientID"] . "</td>";
    echo "<td>" . $nextPatient["FirstName"] . "</td>";
    echo "<td>" . $nextPatient["LastName"] . "</td>";
    echo "<td>" . $nextPatient["Gender"] . "</td>";
    echo "<td>" . $nextPatient["Birthdate"] . "</td>";
    echo "<td>" . $nextPatient["Genetics"] . "</td>";
    echo "<td>" . $nextPatient["Diabetes"] . "</td>";
    echo "<td>" . $nextPatient["OtherConditions"] . "</td>";
    // Echo out other columns in the same manner if needed
    echo "</tr>";
}

echo "</table><br>";

echoFooter();