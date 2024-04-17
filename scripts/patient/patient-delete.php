<?php
@include_once ('../../app_config.php');
@include_once (APP_ROOT . APP_FOLDER_NAME . '/scripts/functions.php');
$pdo = pdo_connect_mysql();
$msg = '';
// Check that the contact ID exists
if (isset($_GET['PatientID'])) {
    // Select the record that is going to be deleted
    $stmt = $pdo->prepare('SELECT * FROM PatientInformation WHERE PatientID = ?');
    $stmt->execute([$_GET['PatientID']]);
    $contact = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$contact) {
        exit('Contact doesn\'t exist with that PatientID!');
    }
    // Make sure the user confirms before deletion
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            // User clicked the "Yes" button, delete record
            $stmt = $pdo->prepare('DELETE FROM PatientInformation WHERE PatientID = ?');
            $stmt->execute([$_GET['PatientID']]);
            $msg = 'You have deleted the contact!';
        } else {
            // User clicked the "No" button, redirect them back to the read page
            header('Location: patient-read.php');
            exit;
        }
    }
} else {
    exit('No PatientID specified!');
}
?>
<?= template_header('Delete') ?>

<div class="content delete">
    <h2>Delete Contact #<?= $contact['PatientID'] ?></h2>
    <?php if ($msg): ?>
        <p><?= $msg ?></p>
    <?php else: ?>
        <p>Are you sure you want to delete contact #<?= $contact['PatientID'] ?>?</p>
        <div class="yesno">
            <a href="patient-delete.php?PatientID=<?= $contact['PatientID'] ?>&confirm=yes">Yes</a>
            <a href="patient-delete.php?PatientID=<?= $contact['PatientID'] ?>&confirm=no">No</a>
        </div>
    <?php endif; ?>
</div>

<?= template_footer() ?>
