<?php
@include_once ('../../app_config.php');
@include_once (APP_ROOT.APP_FOLDER_NAME . '/scripts/functions.php');
$pdo = pdo_connect_mysql();
$msg = '';
// Check if POST data is not empty
if (!empty($_POST)) {
    // Post data not empty insert a new record
    // Set-up the variables that are going to be inserted, //we must check if the POST variables exist if not we //can default them to blank
    $PatientID = isset($_POST['PatientID']) && !empty($_POST['PatientID']) && $_POST['PatientID'] != 'auto' ? $_POST['PatientID'] : NULL;
    // Check if POST variable "name" exists, if not default //the value to blank, basically the same for all //variables
    $FirstName = isset($_POST['FirstName']) ? $_POST['FirstName'] : '';
    $LastName = isset($_POST['LastName']) ? $_POST['LastName'] : '';
    $Gender = isset($_POST['Gender']) ? $_POST['Gender'] : '';
    $Birthdate = isset($_POST['Birthdate']) ? $_POST['Birthdate'] : date('Y-m-d H:i:s');
    $Genetics = isset($_POST['Genetics']) ? $_POST['Genetics'] : '';
    $Diabetes = isset($_POST['Diabetes']) ? $_POST['Diabetes'] : '';
    $OtherConditions = isset($_POST['OtherConditions']) ? $_POST['OtherConditions'] : '';

    // Insert new record into the contacts table
    $stmt = $pdo->prepare('INSERT INTO PatientInformation VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
    $stmt->execute([$PatientID, $FirstName, $LastName, $Gender, $Birthdate, $Genetics, $Diabetes, $OtherConditions]);
    // Output message
    $msg = 'Created Successfully!';
}

template_header('Create');

echo '<div class="content update">
<h2>Create Patient Record</h2>
<form action="patient-add.php" method="post">
    <label for="PatientID">PatientID (leave as auto for automatic)</label>
    <input type="text" name="PatientID" placeholder="auto" value="auto" id="PatientID">
    <label for="FirstName">First Name</label>
    <input type="text" name="FirstName" placeholder="John" id="FirstName">
    <label for="LastName">Last Name</label>
    <input type="text" name="LastName" placeholder="Doe" id="LastName">
    <label for="Gender">Gender</label>
    <input type="text" name="Gender" placeholder="Male/Female/Other" id="Gender">
    <label for="Birthdate">Birthdate</label>
    <input type="date" name="Birthdate" id="Birthdate">
    <label for="Genetics">Genetics</label>
    <input type="text" name="Genetics" placeholder="Genetic Info" id="Genetics">
    <label for="Diabetes">Diabetes</label>
    <input type="text" name="Diabetes" placeholder="Yes/No" id="Diabetes">
    <label for="OtherConditions">Other Conditions</label>
    <input type="text" name="OtherConditions" placeholder="Other Conditions" id="OtherConditions">
    <input type="submit" value="Create">
</form>';
if (!empty($msg)):
    echo '<p>' . $msg .'/p>';
endif;
echo '</div>';

template_footer();