<?php
@include_once ('../../app_config.php');
@include_once (APP_ROOT.APP_FOLDER_NAME . '/scripts/functions.php');
$pdo = pdo_connect_mysql();
$msg = '';

if (isset($_GET['VisitID'])) {
    if (!empty($_POST)) {

        $PatientID = isset($_POST['PatientID']) ? $_POST['PatientID'] : '';
        $DoctorID = isset($_POST['DoctorID']) ? $_POST['DoctorID'] : '';
        $VisitDate = isset($_POST['VisitDate']) ? $_POST['VisitDate'] : date('Y-m-d H:i:s');

        $stmt = $pdo->prepare('UPDATE Visits SET  PatientID = ?, DoctorID = ?, VisitDate = ? WHERE VisitID = ?');
        $stmt->execute([$PatientID, $DoctorID, $VisitDate, $_GET['VisitID']]);
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
    
    
        <label for="VisitDate">Visit Date</label>
        <input type="date" name="VisitDate"
            value="<?= isset($visit['VisitDate']) ? $visit['VisitDate'] : date('Y-m-d') ?>"
            id="VisitDate">

        <div>
        <label for="PatientID">Patient</label>
        <?php
        $stmt = $pdo->query("SELECT PatientID, FirstName, LastName FROM PatientInformation");
        $patients = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>

        <select name="PatientID" id="PatientID">
            <!-- Assuming $visit['PatientID'] holds the current patient's ID for the visit context -->
            <option value="<?=$visit['PatientID']?>" selected><?=$visit['PatientID']?></option>
            <?php foreach($patients as $patient) : ?>
                <option value="<?php echo $patient['PatientID']; ?>">
                    <?php echo $patient['PatientID'] . ' - ' . $patient['FirstName'] . ' ' . $patient['LastName'] ?>
                </option>
            <?php endforeach; ?>
        </select>
        </div>

        <div>
        <label for="DoctorID">Doctor</label>
        <?php
        $stmt = $pdo->query("SELECT DoctorID, DFirstName, DLastName FROM Doctors");
        $doctors = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>

        <select name="DoctorID" id="DoctorID">
            <option value="<?=$visit['DoctorID']?>" selected><?=$visit['DoctorID']?></option>
            <?php foreach($doctors as $doctor) : ?>
                <option value="<?php echo $doctor['DoctorID']; ?>"><?php echo $doctor['DoctorID'] . ' - ' . $doctor['DFirstName'] . ' ' . $doctor['DLastName']?></option>
            <?php endforeach; ?>
        </select>
        </div>

        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
        <p><?= $msg ?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>
