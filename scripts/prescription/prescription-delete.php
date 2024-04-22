<?php
@include_once ('../../app_config.php');
@include_once (APP_ROOT.APP_FOLDER_NAME . '/scripts/functions.php');
$pdo = pdo_connect_mysql();
$msg = '';
// Check that the contact prescriptionID exists
if (isset($_GET['PrescriptionID'])) {
    // Select the record that is going to be deleted
    $stmt = $pdo->prepare('SELECT * FROM Prescriptions WHERE PrescriptionID = ?');
    $stmt->execute([$_GET['PrescriptionID']]);
    $prescription = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$prescription) {
        exit('prescription doesn\'t exist with that prescriptionID!');
    }
    // Make sure the user confirms before deletion
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            // User clicked the "Yes" button, delete record
            $stmt = $pdo->prepare('DELETE FROM prescriptions WHERE prescriptionID = ?');
            $stmt->execute([$_GET['PrescriptionID']]);
            $msg = 'You have deleted the prescription!';
        } else {
            // User clicked the "No" button, redirect them back to the read page
            header('Location: prescription-read.php');
            exit;
        }
    }
} else {
    exit('No prescriptionID specified!');
}
?>
<?=template_header('Delete')?>

<div class="content delete">
	<h2>Delete prescription #<?=$prescription['PrescriptionID']?></h2>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php else: ?>
	<p>Are you sure you want to delete prescription #<?=$prescription['PrescriptionID']?>?</p>
    <div class="yesno">
        <a href="prescription-delete.php?PrescriptionID=<?=$prescription['PrescriptionID']?>&confirm=yes">Yes</a>
        <a href="prescription-delete.php?PrescriptionID=<?=$prescription['PrescriptionID']?>&confirm=no">No</a>
    </div>
    <?php endif; ?>
</div>

<?=template_footer()?>
