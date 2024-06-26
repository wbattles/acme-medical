<?php
@include_once ('../../app_config.php');
@include_once (APP_ROOT . APP_FOLDER_NAME . '/scripts/functions.php');
$pdo = pdo_connect_mysql();
$msg = '';

if (!empty($_POST)) {
    $PrescriptionID = isset($_POST['PrescriptionID']) && !empty($_POST['PrescriptionID']) && $_POST['PrescriptionID'] != 'auto' ? $_POST['PrescriptionID'] : NULL;
    $MedID = isset($_POST['MedID']) ? $_POST['MedID'] : '';
    $VisitID = isset($_POST['VisitID']) ? $_POST['VisitID'] : '';
    $Dosage = isset($_POST['Dosage']) ? $_POST['Dosage'] : '';
    $Quantity = isset($_POST['Quantity']) ? $_POST['Quantity'] : '';
    $DateReceived = isset($_POST['DateReceived']) ? $_POST['DateReceived'] : date('Y-m-d H:i:s');

    $stmt = $pdo->prepare('INSERT INTO Prescriptions VALUES (?, ?, ?, ?, ?, ?)');
    if ($stmt->execute([$PrescriptionID, $MedID, $VisitID, $Dosage, $Quantity, $DateReceived])) {
        $msg = 'Created Successfully!';
    } else {
        $msg = 'Failed to Create Prescription.';
    }
}
?>

<?= template_header('Create Prescription') ?>

<div class="content update">
    <h2>Create Prescription</h2>
    <form action="prescription-add.php" method="post">
        <label for="VisitID">PrescriptionID</label>
        <input type="text" name="VisitID" placeholder="" value="auto" id="VisitID">


        <label for="MedID">Medication ID</label>
        <select name="MedID" id="MedID">
            <?php
            $stmt = $pdo->query("SELECT MedID, MedName, MedType FROM Medications");
            $medications = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($medications as $medication) {
                echo "<option value='{$medication['MedID']}'>{$medication['MedID']} - {$medication['MedName']} {$medication['MedType']}</option>";
            }
            ?>
        </select>

        <label for="Dosage">Dosage</label>
        <input type="text" name="Dosage" placeholder="Enter Dosage" id="Dosage">

        <label for="Quantity">Quantity</label>
        <input type="text" name="Quantity" placeholder="Quantity" id="Quantity">

        <label for="DateReceived">Date Received</label>
        <input type="date" name="DateReceived" id="DateReceived" value="<?= date('Y-m-d') ?>">

        <label for="VisitID">Visit</label>
        <?php
        $stmt = $pdo->query("
            SELECT 
                Visits.VisitID, 
                Visits.VisitDate, 
                PatientInformation.FirstName, 
                PatientInformation.LastName
            FROM 
                Visits
            JOIN 
                PatientInformation ON Visits.PatientID = PatientInformation.PatientID
            ORDER BY 
                Visits.VisitDate DESC
        ");
        $visits = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>

        <select name="VisitID" id="VisitID">
            <?php foreach($visits as $visit) : ?>
                <?php echo "<option value='{$visit['VisitID']}'>{$visit['FirstName']} {$visit['LastName']} - {$visit['VisitDate']}</option>"; ?>
            <?php endforeach; ?>
        </select>

        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
        <p><?= $msg ?></p>
    <?php endif; ?>
</div>

<?= template_footer() ?>
