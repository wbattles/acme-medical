<?php
@include_once('../../app_config.php');
@include_once(APP_ROOT.APP_FOLDER_NAME.'/scripts/functions.php');
$pdo = pdo_connect_mysql();
$msg = '';

if (isset($_GET['PrescriptionID'])) {
    if (!empty($_POST)) {
        // Collect POST data
        // $PrescriptionID = $_GET['PrescriptionID'];
        // $MedID = isset($_POST['MedID']) ? $_POST['MedID'] : '';
        $VisitID = isset($_POST['VisitID']) ? $_POST['VisitID'] : '';
        $Dosage = isset($_POST['Dosage']) ? $_POST['Dosage'] : '';
        $Quantity = isset($_POST['Quantity']) ? $_POST['Quantity'] : '';
        $DateReceived = isset($_POST['DateReceived']) ? $_POST['DateReceived'] : date('Y-m-d');

        // Prepare an UPDATE statement
        $stmt = $pdo->prepare('UPDATE Prescriptions SET  VisitID = ?, Dosage = ?, Quantity = ?, DateReceived = ? WHERE PrescriptionID = ?');
        $stmt->execute([$VisitID, $Dosage, $Quantity, $DateReceived, $_GET['PrescriptionID']]);
        $msg = 'Updated Successfully!';
    }

    // Fetch the existing data
    $stmt = $pdo->prepare('SELECT * FROM Prescriptions WHERE PrescriptionID = ?');
    $stmt->execute([$_GET['PrescriptionID']]);
    $prescription = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$prescription) {
        exit('Prescription doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>
<?=template_header('Update Prescription')?>

<div class="content update">
    <h2>Update Prescription #<?= $prescription['PrescriptionID'] ?></h2>
    <form action="prescription-update.php?PrescriptionID=<?= $prescription['PrescriptionID'] ?>" method="post">
        <label for="Med">Medication</label>
        <?=
         $med = $prescription['MedID']; 
         $stmt = $pdo->query("SELECT MedName FROM Medications WHERE MedID = $med");
         $prescribedMed = $stmt->fetch(PDO::FETCH_ASSOC);
        ?>
        <input type="text" name="Med" id="Med" value="<?= $prescribedMed['MedName'] ?>" readonly>


        <label for="Dosage">Dosage</label>
        <input type="text" name="Dosage" id="Dosage" value="<?= $prescription['Dosage'] ?>">

        <label for="Quantity">Quantity</label>
        <input type="text" name="Quantity" id="Quantity" value="<?= $prescription['Quantity'] ?>">

        <label for="DateReceived">Date Received</label>
        <input type="date" name="DateReceived" id="DateReceived" value="<?= $prescription['DateReceived'] ?>">

        <label for="VisitID">Visit</label>
        <?php
        // Fetch all visits from the database. You might want to join this with patient or doctor information for more descriptive labels.
        $stmt = $pdo->query("SELECT VisitID, VisitDate FROM Visits");
        $visits = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>

        <select name="VisitID" id="VisitID">
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

            $stmt = $pdo->prepare("
                SELECT 
                    Visits.VisitID, 
                    Visits.VisitDate, 
                    PatientInformation.FirstName, 
                    PatientInformation.LastName
                FROM 
                    Visits
                JOIN 
                    PatientInformation ON Visits.PatientID = PatientInformation.PatientID
                WHERE 
                    Visits.VisitID = :visitID
                ORDER BY 
                    Visits.VisitDate DESC
                ");
            $stmt->bindParam(':visitID', $prescription['VisitID'], PDO::PARAM_INT);
            $stmt->execute();
            $test = $stmt->fetch(PDO::FETCH_ASSOC);

            echo "<option value='{$test['VisitID']}'> {$test['FirstName']} {$test['LastName']} - {$test['VisitDate']} </option>";

            foreach ($visits as $visit) {
                echo "<option value='{$visit['VisitID']}'>{$visit['FirstName']} {$visit['LastName']} - {$visit['VisitDate']}</option>";
            }
            ?>
        </select>
        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
        <p><?= $msg ?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>
