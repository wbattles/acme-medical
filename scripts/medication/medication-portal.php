<?php
require_once ('../../app_config.php');
require_once (APP_ROOT . '/' . APP_FOLDER_NAME . '/scripts/echoHTML.php');
require_once (APP_ROOT . '/' . APP_FOLDER_NAME . '/scripts/errorDisplay.php');
require_once (APP_ROOT . '/' . APP_FOLDER_NAME . '/scripts/tools.php');
require_once (APP_ROOT . '/' . APP_FOLDER_NAME . '/scripts/dbConnection.php');

$jsFile = APP_FOLDER_NAME . '/clientScripts/medication_client_checks.js';
$cssFile = APP_FOLDER_NAME . '/styles/main.css';

$db = getDB(DSN1, USER1, PASSWD1);

$selectStmt = "SELECT PatientID, Vest, Acapella, Pulmozyme, InhaledTobi, InhaledColistin, HypertonicSaline, Azithromycin, Clarithromycin, InhaledGentamicin, Enzymes, EnzymesTypeDosage FROM Medication";

try {
    $query = $db->prepare($selectStmt);
    $query -> execute();
    $allMedications = $query -> fetchAll();
    $query->closeCursor();
} catch(Exception $e) {
    echoError($e->getMessage());
    exit(1);
};

echoHead("Acme Medical Medications", $jsFile, $cssFile);
echoHeader("ACME MEDICAL MEDICATIONS");

echo "<table>
        <tr>
            <th>Patient ID</th>
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
        </tr>";

foreach ($allMedications as $medication) {
    echo "<tr>";
    echo "<td>" . $medication["PatientID"] . "</td>";
    echo "<td>" . $medication["Vest"] . "</td>";
    echo "<td>" . $medication["Acapella"] . "</td>";
    echo "<td>" . $medication["Pulmozyme"] . "</td>";
    echo "<td>" . $medication["InhaledTobi"] . "</td>";
    echo "<td>" . $medication["InhaledColistin"] . "</td>";
    echo "<td>" . $medication["HypertonicSaline"] . "</td>";
    echo "<td>" . $medication["Azithromycin"] . "</td>";
    echo "<td>" . $medication["Clarithromycin"] . "</td>";
    echo "<td>" . $medication["InhaledGentamicin"] . "</td>";
    echo "<td>" . $medication["Enzymes"] . "</td>";
    echo "<td>" . $medication["EnzymesTypeDosage"] . "</td>";
    echo "</tr>";
};
        
echo "</table><br>";

echoFooter();