<?php
@include_once ('../../app_config.php');
@include_once (APP_ROOT . APP_FOLDER_NAME . '/scripts/functions.php');
$pdo = pdo_connect_mysql();
$msg = '';

if (isset($_GET['DoctorID'])) {
    if (!empty($_POST)) {

        $DoctorID = isset($_POST['DoctorID']) ? $_POST['DoctorID'] : NULL;
        $DFirstName = isset($_POST['DFirstName']) ? $_POST['DFirstName'] : '';
        $DLastName = isset($_POST['DLastName']) ? $_POST['DLastName'] : '';

        $stmt = $pdo->prepare('UPDATE Doctors SET DoctorID = ?, DFirstName = ?, DLastName = ? WHERE DoctorID = ?');
        $stmt->execute([$DoctorID, $DFirstName, $DLastName, $_GET['DoctorID']]);
        $msg = 'Updated Successfully!';
    }

    $stmt = $pdo->prepare('SELECT * FROM Doctors WHERE DoctorID = ?');
    $stmt->execute([$_GET['DoctorID']]);
    $doctor = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$doctor) {
        exit('Doctor doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>
<?= template_header('Update Doctor') ?>

<div class="content update">
    <h2>Update Doctor #<?= $doctor['DoctorID'] ?></h2>
    <form action="doctor-update.php?DoctorID=<?= $doctor['DoctorID'] ?>" method="post">

        <label for="DFirstName">Doctor First Name</label>
        <input type="text" name="DFirstName" placeholder="John" value="<?= $doctor['DFirstName'] ?>" id="DFirstName">
        
        <label for="DLastName">Doctor Last Name</label>
        <input type="text" name="DLastName" placeholder="Doe" value="<?= $doctor['DLastName'] ?>" id="DLastName">
        
        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
        <p><?= $msg ?></p>
    <?php endif; ?>
</div>

<?= template_footer() ?>