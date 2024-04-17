<?php
@include_once ('../../app_config.php');
@include_once (APP_ROOT.APP_FOLDER_NAME . '/scripts/functions.php');
$pdo = pdo_connect_mysql();
$msg = '';

if (!empty($_POST)) {

    $MedID = isset($_POST['MedID']) && !empty($_POST['MedID']) && $_POST['MedID'] != 'auto' ? $_POST['MedID'] : NULL;
    // Check if POST variable "name" exists, if not default //the value to blank, basically the same for all //variables
    $MedName = isset($_POST['MedName']) ? $_POST['MedName'] : '';
    $MedType = isset($_POST['MedType']) ? $_POST['MedType'] : '';
    $Enzyme = isset($_POST['Enzyme?']) ? $_POST['Enzyme?'] : '';

    $stmt = $pdo->prepare('INSERT INTO Medications VALUES (?, ?, ?, ?)');
    $stmt->execute([$MedID, $MedName, $MedType, $Enzyme]);

    $msg = 'Created Successfully!';
};


template_header('Create');

echo '<div class="content update">
<h2>Create Medication Record</h2>
<form action="medication-add.php" method="post">
    <label for="MedID">MedID (leave as auto for automatic)</label>
    <input type="text" name="MedID" placeholder="auto" value="auto" id="MedID">
    <label for="MedName">Med Name</label>
    <input type="text" name="MedName" id="MedName">
    <label for="MedType">MedType</label>
    <input type="text" name="MedType" id="MedType">
    <label for="Enzyme?">Enzyme?</label>
    <input type="text" name="Enzyme?" placeholder="Y or N" id="Enzyme?">
    <input type="submit" value="Create">
</form>';
if (!empty($msg)):
    echo $msg;
endif;
echo '</div>';

template_footer();