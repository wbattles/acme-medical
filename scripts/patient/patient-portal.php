<?php
require_once ('../../app_config.php');
require_once (APP_ROOT . '/' . APP_FOLDER_NAME . '/scripts/echoHTML.php');
require_once (APP_ROOT . '/' . APP_FOLDER_NAME . '/scripts/errorDisplay.php');
require_once (APP_ROOT . '/' . APP_FOLDER_NAME . '/scripts/tools.php');
require_once (APP_ROOT . '/' . APP_FOLDER_NAME . '/scripts/dbConnection.php');

$jsFile = APP_FOLDER_NAME . '/clientScripts/patient_client_checks.js';
$cssFile = APP_FOLDER_NAME . '/styles/main.css';

$db = getDB(DSN1, USER1, PASSWD1);

$selectStmt = "SELECT PatientInformation.*
                FROM PatientInformation";

// $selectStmt = "SELECT PatientInformation.*,Medication.*
//                 FROM PatientInformation
//                 INNER JOIN Medication ON PatientInformation.PatientID = Medication.PatientID";


// $selectStmt = "SELECT PatientInformation.*, Medication.*, max_FEV_PatientTests.*
//                 FROM PatientInformation
//                 INNER JOIN Medication ON PatientInformation.PatientID = Medication.PatientID
//                 INNER JOIN (
//                     SELECT PatientID, MAX(FEV) AS max_FEV
//                     FROM PatientTests
//                     GROUP BY PatientID
//                 ) AS max_FEV_PatientTests ON PatientInformation.PatientID = max_FEV_PatientTests.PatientID;";

try {
    $query = $db->prepare($selectStmt);
    $query -> execute();
    $allData = $query -> fetchAll();
    $query->closeCursor();
} catch(Exception $e) {
    echoError($e-> getMessage());
    exit(1);
};

echoHead("Acme Medical", $jsFile, $cssFile);
echoHeader("ACME MEDICAL");

echo "<a href='patient-add.php'><button>Patient Add</button></a>";

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
            <th>Vest</th>
            <th>Acapella</th>
            <th>Pulmozyme</th>
            <th>Inhaled Tobi</th>
            <th>Inhaled Colistin</th>
            <th>Hypertonic Saline</th>
            <th>Azithromycin</th>
            <th>Clarithromycin</th>
            <th>Inhaled Gentamicin</th>
            <th>Enzymes</th>
            <th>Enzymes Type/Dosage</th>
            <th>FEV</th>
        </tr>";

foreach ($allData as $data) {
    echo "<tr>";
    echo "<td>" . $data["PatientID"] . "</td>";
    echo "<td>" . $data["FirstName"] . "</td>";
    echo "<td>" . $data["LastName"] . "</td>";
    echo "<td>" . $data["Gender"] . "</td>";
    echo "<td>" . $data["Birthdate"] . "</td>";
    echo "<td>" . $data["Genetics"] . "</td>";
    echo "<td>" . $data["Diabetes"] . "</td>";
    echo "<td>" . $data["OtherConditions"] . "</td>";
    // echo "<td>" . $data["Vest"] . "</td>";
    // echo "<td>" . $data["Acapella"] . "</td>";
    // echo "<td>" . $data["Pulmozyme"] . "</td>";
    // echo "<td>" . $data["InhaledTobi"] . "</td>";
    // echo "<td>" . $data["InhaledColistin"] . "</td>";
    // echo "<td>" . $data["HypertonicSaline"] . "</td>";
    // echo "<td>" . $data["Azithromycin"] . "</td>";
    // echo "<td>" . $data["Clarithromycin"] . "</td>";
    // echo "<td>" . $data["InhaledGentamicin"] . "</td>";
    // echo "<td>" . $data["Enzymes"] . "</td>";
    // echo "<td>" . $data["EnzymesTypeDosage"] . "</td>";
    // echo "<td>" . $data["max_FEV"] . "</td>";
    echo "</tr>";
}


echo "</table><br>";

echoFooter();