<?php
@include_once ('../../app_config.php');
@include_once (APP_ROOT.APP_FOLDER_NAME . '/scripts/functions.php');
$pdo = pdo_connect_mysql();
$msg = '';
// Check if POST data is not empty
if (!empty($_POST)) {
    // Post data not empty insert a new record
    // Set-up the variables that are going to be inserted, //we must check if the POST variables exist if not we //can default them to blank
    $VisitID = isset($_POST['VisitID']) && !empty($_POST['VisitID']) && $_POST['VisitID'] != 'auto' ? $_POST['VisitID'] : NULL;
    /*Check if POST variable //"conversationSummary" exists, if not default //the value to blank, basically the same for //all variables*/
    $PatientID = isset($_POST['PatientID']) ? $_POST['PatientID'] : '';
    $DoctorID = isset($_POST['DoctorID']) ? $_POST['DoctorID'] : '';
    $VisitDate = isset($_POST['VisitDate']) ? $_POST['VisitDate'] : date('Y-m-d H:i:s');
    // Insert new record into the Visits table
    $stmt = $pdo->prepare('INSERT INTO Visits VALUES (?, ?, ?, ?)');
    $stmt->execute([$VisitID, $PatientID, $DoctorID, $VisitDate]);
    // Output message
    $msg = 'Created Successfully!';
}
?>
<?=template_header('Create')?>

<div class="content update">
	<h2>Create Conversation</h2>
    <form action="visit-add.php" method="post">
        <label for="VisitID">VisitID</label>
        <label for="VisitDate">VisitDate</label>
        <input type="text" name="VisitID" placeholder="" value="auto" id="VisitID">
        <input type="datetime-local" name="VisitDate" value="<?= date('Y-m-d\TH:i') ?>" id="VisitDate">
        
        
        <label for="PatientID">Patient</label>
        <?php
        $stmt = $pdo->query("SELECT PatientID, FirstName FROM PatientInformation");
        $patients = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>

        <select name="PatientID" id="PatientID">
            <?php foreach($patients as $patient) : ?>
                <option value="<?php echo $patient['PatientID']; ?>">
                <?php echo $patient['PatientID'] . ' - ' . $patient['FirstName']; ?></option>
            <?php endforeach; ?>
        </select>
        <br>


        <label for="DoctorID">Doctor</label>
        <?php
        $stmt = $pdo->query("SELECT DoctorID, DFirstName FROM Doctors");
        $doctors = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>
        
        <select name="DoctorID" id="DoctorID">
            <?php foreach ($doctors as $doctor): ?>
                <option value="<?php echo $doctor['DoctorID']; ?>">
                <?php echo $doctor['DoctorID'] . ' - ' . $doctor['DFirstName']; ?></option>
            <?php endforeach; ?>
        </select>

        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>