<?php
@include_once ('../../app_config.php');
@include_once (APP_ROOT . APP_FOLDER_NAME . '/scripts/functions.php');
$pdo = pdo_connect_mysql();
$msg = '';

if (isset($_GET['PatientID'])) {
    if (!empty($_POST)) {
        // Update a patient record
        $PatientID = isset($_POST['PatientID']) ? $_POST['PatientID'] : NULL;
        $FirstName = isset($_POST['FirstName']) ? $_POST['FirstName'] : '';
        $LastName = isset($_POST['LastName']) ? $_POST['LastName'] : '';
        $Gender = isset($_POST['Gender']) ? $_POST['Gender'] : '';
        $Birthdate = isset($_POST['Birthdate']) ? $_POST['Birthdate'] : '';
        $Genetics = isset($_POST['Genetics']) ? $_POST['Genetics'] : '';
        $Diabetes = isset($_POST['Diabetes']) ? $_POST['Diabetes'] : '';
        $OtherConditions = isset($_POST['OtherConditions']) ? $_POST['OtherConditions'] : '';

        // Update the record
        $stmt = $pdo->prepare('UPDATE PatientInformation SET PatientID = ?, FirstName = ?, LastName = ?, Gender = ?, Birthdate = ?, Genetics = ?, Diabetes = ?, OtherConditions = ? WHERE PatientID = ?');
        $stmt->execute([$PatientID, $FirstName, $LastName, $Gender, $Birthdate, $Genetics, $Diabetes, $OtherConditions, $_GET['PatientID']]);
        $msg = 'Updated Successfully!';
    }
    // Get the patient from the patients table
    $stmt = $pdo->prepare('SELECT * FROM PatientInformation WHERE PatientID = ?');
    $stmt->execute([$_GET['PatientID']]);
    $patient = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$patient) {
        exit('Patient doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>
<?= template_header('Update Patient') ?>

<div class="content update">
    <h2>Update Patient #<?= $patient['PatientID'] ?></h2>
    <form action="patient-update.php?PatientID=<?= $patient['PatientID'] ?>" method="post">
        <label for="PatientID">Patient ID</label>
        <label for="FirstName">First Name</label>
        <input type="text" name="PatientID" placeholder="1" value="<?= $patient['PatientID'] ?>" id="PatientID">
        <input type="text" name="FirstName" placeholder="John" value="<?= $patient['FirstName'] ?>" id="FirstName">

        <label for="LastName">Last Name</label>
        <label for="Gender">Gender</label>
        <input type="text" name="LastName" placeholder="Doe" value="<?= $patient['LastName'] ?>" id="LastName">
        <input type="text" name="Gender" placeholder="Male" value="<?= $patient['Gender'] ?>" id="Gender">

        <label for="Birthdate">Birthdate</label>
        <label for="genetics">Genetics</label>
        <input type="date" name="Birthdate" value="<?= $patient['Birthdate'] ?>" id="Birthdate">
        <input type="text" name="Genetics" placeholder="Genetic Details" value="<?= $patient['Genetics'] ?>"id="genetics">

        <label for="Diabetes">Diabetes</label>
        <label for="OtherConditions">Other Conditions</label>
        <input type="text" name="Diabetes" placeholder="Yes/No" value="<?= $patient['Diabetes'] ?>" id="Diabetes">
        <input type="text" name="OtherConditions" placeholder="Other Medical Conditions"
            value="<?= $patient['OtherConditions'] ?>" id="OtherConditions">
        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
        <p><?= $msg ?></p>
    <?php endif; ?>
</div>

<?= template_footer() ?>