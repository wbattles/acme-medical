<?php
@include_once ('../../app_config.php');
@include_once (APP_ROOT.APP_FOLDER_NAME . '/scripts/functions.php');
$pdo = pdo_connect_mysql();
$msg = '';

if (isset($_GET['VisitID'])) {
    if (!empty($_POST)) {

        $VisitID = isset($_POST['VisitID']) ? $_POST['VisitID'] : NULL;
        $PatientID = isset($_POST['PatientID']) ? $_POST['PatientID'] : '';
        $DoctorID = isset($_POST['DoctorID']) ? $_POST['DoctorID'] : '';
        $VisitDate = isset($_POST['VisitDate']) ? $_POST['VisitDate'] : date('Y-m-d H:i:s');

        $stmt = $pdo->prepare('UPDATE Visits SET VisitID = ?, PatientID = ?, DoctorID = ?, VisitDate = ? WHERE VisitID = ?');
        $stmt->execute([$VisitID, $PatientID, $DoctorID, $VisitDate, $_GET['VisitID']]);
        $msg = 'Updated Successfully!';
    }

    $stmt = $pdo->prepare('SELECT * FROM Visits WHERE VisitID = ?');
    $stmt->execute([$_GET['VisitID']]);
    $visit = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$visit) {
        exit('Visit doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>
<?=template_header('Read')?>

<div class="content update">
    <h2>Update Visit #<?= $visit['VisitID'] ?></h2>
    <form action="visit-update.php?VisitID=<?= $visit['VisitID'] ?>" method="post">
        <label for="VisitID">Visit ID</label>
        <input type="text" name="VisitID" placeholder="Visit ID" value="<?= $visit['VisitID'] ?>" id="VisitID">

        <label for="PatientID">Patient ID</label>
        <input type="text" name="PatientID" placeholder="Patient ID" value="<?= $visit['PatientID'] ?>" id="PatientID">

        <label for="DoctorID">Doctor ID</label>
        <input type="text" name="DoctorID" placeholder="Doctor ID" value="<?= $visit['DoctorID'] ?>" id="DoctorID">

        <label for="VisitDate">Visit Date</label>
        <input type="date" name="VisitDate"
            value="<?= isset($visit['VisitDate']) ? $visit['VisitDate'] : date('Y-m-d') ?>" id="VisitDate">
        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
        <p><?= $msg ?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>
