<?php
@include_once ('../../app_config.php');
@include_once (APP_ROOT.APP_FOLDER_NAME . '/scripts/functions.php');
$pdo = pdo_connect_mysql();
$msg = '';
// Check that the contact VisitID exists
if (isset($_GET['VisitID'])) {
    // Select the record that is going to be deleted
    $stmt = $pdo->prepare('SELECT * FROM Visits WHERE VisitID = ?');
    $stmt->execute([$_GET['VisitID']]);
    $visit = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$visit) {
        exit('visit doesn\'t exist with that VisitID!');
    }
    // Make sure the user confirms before deletion
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            // User clicked the "Yes" button, delete record
            $stmt = $pdo->prepare('DELETE FROM Visits WHERE VisitID = ?');
            $stmt->execute([$_GET['VisitID']]);
            $msg = 'You have deleted the visit!';
        } else {
            // User clicked the "No" button, redirect them back to the read page
            header('Location: visit-read.php');
            exit;
        }
    }
} else {
    exit('No VisitID specified!');
}
?>
<?=template_header('Delete')?>

<div class="content delete">
	<h2>Delete visit #<?=$visit['VisitID']?></h2>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php else: ?>
	<p>Are you sure you want to delete visit #<?=$visit['VisitID']?>?</p>
    <div class="yesno">
        <a href="visit-delete.php?VisitID=<?=$visit['VisitID']?>&confirm=yes">Yes</a>
        <a href="visit-delete.php?VisitID=<?=$visit['VisitID']?>&confirm=no">No</a>
    </div>
    <?php endif; ?>
</div>

<?=template_footer()?>
