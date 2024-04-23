<?php
@include_once('../../app_config.php');
@include_once(APP_ROOT . APP_FOLDER_NAME . '/scripts/functions.php');
$pdo = pdo_connect_mysql();
$msg = '';

if (!empty($_POST)) {
    // Assuming TestRecordID is auto-increment and does not need to be provided by the user.
    $TestRecordID = isset($_POST['TestRecordID']) && !empty($_POST['TestRecordID']) && $_POST['TestRecordID'] != 'auto' ? $_POST['TestRecordID'] : NULL;
    $VisitID = isset($_POST['VisitID']) ? $_POST['VisitID'] : '';
    $FEV = isset($_POST['FEV']) ? $_POST['FEV'] : '';

    // Prepare the SQL insert statement for the Tests table
    $stmt = $pdo->prepare('INSERT INTO Tests (TestRecordID, VisitID, FEV) VALUES (?, ?, ?)');
    if ($stmt->execute([$TestRecordID, $VisitID, $FEV])) {
        $msg = 'Created Successfully!';
    } else {
        $msg = 'Failed to Create Test Record.';
    }
}
?>

<?= template_header('Create Test Record') ?>

<div class="content update">
    <h2>Create Test Record</h2>
    <form action="fev-add.php" method="post">
        <label for="TestRecordID">TestID (leave as auto for automatic)</label>
        <input type="text" name="TestRecordID" placeholder="auto" value="auto" id="TestRecordID">

        <label for="FEV">FEV</label>
        <input type="text" name="FEV" placeholder="Enter FEV" id="FEV">

        <label for="VisitID">Visit</label>
        <select name="VisitID" id="VisitID">
            <?php
            // Fetch all visits to allow selection of which visit this test is associated with
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
            foreach ($visits as $visit) {
                echo "<option value='{$visit['VisitID']}'>{$visit['FirstName']} {$visit['LastName']} - {$visit['VisitDate']}</option>";
            }
            ?>
        </select>

        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
        <p><?= $msg ?></p>
    <?php endif; ?>
</div>

<?= template_footer() ?>
