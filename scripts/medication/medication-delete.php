<?php
@include_once ('../../app_config.php');
@include_once (APP_ROOT.APP_FOLDER_NAME . '/scripts/functions.php');
$pdo = pdo_connect_mysql();
$msg = '';

if (isset($_GET['MedID'])) {
    // Select the record that is going to be deleted
    $stmt = $pdo->prepare('SELECT * FROM Medications WHERE MedID = ?');
    $stmt->execute([$_GET['MedID']]);
    $medications = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$medications) {
        exit('Medication doesn\'t exist with that ID!');
    }
    // Make sure the user confirms before deletion
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            // User clicked the "Yes" button, delete record
            $stmt = $pdo->prepare('DELETE FROM Medications WHERE MedID = ?');
            $stmt->execute([$_GET['MedID']]);
            $msg = 'You have deleted the medication!';
        } else {
            // User clicked the "No" button, redirect them back to the read page
            header('Location: medication-portal.php');
            exit;
        }
    }
} else {
    exit('No ID specified!');
}
?>
<?=template_header('Delete')?>

<div class="content delete">
	<h2>Delete Medication #<?=$medications['MedID']?></h2>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php else: ?>
	<p>Are you sure you want to delete medication #<?=$medications['MedID']?>?</p>
    <div class="yesno">
        <a href="medication-delete.php?MedID=<?=$medications['MedID']?>&confirm=yes">Yes</a>
        <a href="medication-delete.php?MedID=<?=$medications['MedID']?>&confirm=no">No</a>
    </div>
    <?php endif; ?>
</div>

<?=template_footer()?>
