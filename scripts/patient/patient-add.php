<?php
require_once ('../../app_config.php');
require_once (APP_ROOT . '/' . APP_FOLDER_NAME . '/scripts/echoHTML.php');
require_once (APP_ROOT . '/' . APP_FOLDER_NAME . '/scripts/errorDisplay.php');
require_once (APP_ROOT . '/' . APP_FOLDER_NAME . '/scripts/tools.php');
require_once (APP_ROOT . '/' . APP_FOLDER_NAME . '/scripts/dbConnection.php');

$jsFile = APP_FOLDER_NAME . '/clientScripts/patient_client_checks.js';
$cssFile = APP_FOLDER_NAME . '/styles/main.css';

echoHead("Acme Medical", $jsFile, $cssFile);
echoHeader("ACME MEDICAL");

echo " <form action='process-patient-form.php' method='POST'>
        <label for='firstName'>First Name:</label><br>
        <input type='text' id='firstName' name='firstName' required><br><br>

        <label for='lastName'>Last Name:</label><br>
        <input type='text' id='lastName' name='lastName' required><br><br>

        <label for='gender'>Gender:</label><br>
        <select id='gender' name='gender' required>
            <option value='male'>Male</option>
            <option value='female'>Female</option>
            <option value='other'>Other</option>
        </select><br><br>

        <label for='birthdate'>Birthdate:</label><br>
        <input type='date' id='birthdate' name='birthdate' required><br><br>

        <label for='genetics'>Genetics:</label><br>
        <input type='text' id='genetics' name='genetics'><br><br>

        <label for='diabetes'>Diabetes:</label><br>
        <input type='radio' id='diabetesYes' name='diabetes' value='Yes'>
        <label for='diabetesYes'>Yes</label>
        <input type='radio' id='diabetesNo' name='diabetes' value='No'>
        <label for='diabetesNo'>No</label><br><br>

        <label for='otherConditions'>Other Conditions:</label><br>
        <textarea id='otherConditions' name='otherConditions'></textarea><br><br>

        <input type='submit' value='Submit'>
    </form>";

echoFooter();