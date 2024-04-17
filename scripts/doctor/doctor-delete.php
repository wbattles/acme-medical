<?php
@include_once ('../../app_config.php');
@include_once (APP_ROOT . APP_FOLDER_NAME . '/scripts/functions.php');
$pdo = pdo_connect_mysql();
$msg = '';

if (isset($_GET['DoctorID'])) {

    $stmt = $pdo->prepare('SELECT * FROM Doctors WHERE DoctorID = ?');
    $stmt->execute([$_GET['DoctorID']]);
    $contact = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$contact) {
        exit('Contact doesn\'t exist with that DoctorID!');
    }

    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {

            $stmt = $pdo->prepare('DELETE FROM Doctors WHERE DoctorID = ?');
            $stmt->execute([$_GET['DoctorID']]);
            $msg = 'You have deleted the contact!';
        } else {

            header('Location: doctor-portal.php');
            exit;
        }
    }
} else {
    exit('No DoctorID specified!');
}
?>
<?= template_header('Delete') ?>

<div class="content delete">
    <h2>Delete Contact #<?= $contact['DoctorID'] ?></h2>
    <?php if ($msg): ?>
        <p><?= $msg ?></p>
    <?php else: ?>
        <p>Are you sure you want to delete contact #<?= $contact['DoctorID'] ?>?</p>
        <div class="yesno">
            <a href="doctor-delete.php?DoctorID=<?= $contact['DoctorID'] ?>&confirm=yes">Yes</a>
            <a href="doctor-delete.php?DoctorID=<?= $contact['DoctorID'] ?>&confirm=no">No</a>
        </div>
    <?php endif; ?>
</div>

<?= template_footer() ?>
