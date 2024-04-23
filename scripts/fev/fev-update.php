<?php
@include_once('../../app_config.php');
@include_once(APP_ROOT.APP_FOLDER_NAME.'/scripts/functions.php');
$pdo = pdo_connect_mysql();
$msg = '';

if (isset($_GET['TestRecordID'])) {
    if (!empty($_POST)) {
        // Collect POST data
        $FEV = isset($_POST['FEV']) ? $_POST['FEV'] : '';
        $VisitID = isset($_POST['VisitID']) ? $_POST['VisitID'] : '';

        // Prepare an UPDATE statement
        $stmt = $pdo->prepare('UPDATE Tests SET VisitID = ?, FEV = ? WHERE TestRecordID = ?');
        $stmt->execute([$VisitID, $FEV, $_GET['TestRecordID']]);
        $msg = 'Updated Successfully!';
    }

    // Fetch the existing data
    $stmt = $pdo->prepare('SELECT * FROM Tests WHERE TestRecordID = ?');
    $stmt->execute([$_GET['TestRecordID']]);
    $test = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$test) {
        exit('Test doesn\'t exist with that ID!');
    }
} else {
    exit('No TestRecordID specified!');
}
?>
<?=template_header('Update Test Record')?>

<div class="content update">
    <h2>Update Test Record #<?= $test['TestRecordID'] ?></h2>
    <form action="fev-update.php?TestRecordID=<?= $test['TestRecordID'] ?>" method="post">
            <label for="FEV">FEV</label>
            <input type="text" name="FEV" id="FEV" value="<?= $test['FEV'] ?>">

            <label for="VisitID">Visit</label>
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
                $stmt->bindParam(':visitID', $test['VisitID'], PDO::PARAM_INT);
                $stmt->execute();
                $test = $stmt->fetch(PDO::FETCH_ASSOC);

                echo "<option value='{$test['VisitID']}'> {$test['FirstName']} {$test['LastName']} - {$test['VisitDate']} </option>";

                foreach($visits as $visit) {
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

