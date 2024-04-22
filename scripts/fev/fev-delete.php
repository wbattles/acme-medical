<?php
@include_once('../../app_config.php');
@include_once(APP_ROOT.APP_FOLDER_NAME.'/scripts/functions.php');
$pdo = pdo_connect_mysql();
$msg = '';

// Check that the TestRecordID exists
if (isset($_GET['TestRecordID'])) {
    // Select the record that is going to be deleted
    $stmt = $pdo->prepare('SELECT * FROM Tests WHERE TestRecordID = ?');
    $stmt->execute([$_GET['TestRecordID']]);
    $test = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$test) {
        exit('Test doesn\'t exist with that TestRecordID!');
    }
    // Make sure the user confirms before deletion
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            // User clicked the "Yes" button, delete record
            $stmt = $pdo->prepare('DELETE FROM Tests WHERE TestRecordID = ?');
            $stmt->execute([$_GET['TestRecordID']]);
            $msg = 'You have deleted the test!';
        } else {
            // User clicked the "No" button, redirect them back to the read page
            header('Location: test-read.php');
            exit;
        }
    }
} else {
    exit('No TestRecordID specified!');
}
?>
<?=template_header('Delete Test')?>

<div class="content delete">
    <h2>Delete Test Record #<?= $test['TestRecordID'] ?></h2>
    <?php if ($msg): ?>
    <p><?= $msg ?></p>
    <?php else: ?>
    <p>Are you sure you want to delete this test record #<?= $test['TestRecordID'] ?>?</p>
    <div class="yesno">
        <a href="fev-delete.php?TestRecordID=<?= $test['TestRecordID'] ?>&confirm=yes">Yes</a>
        <a href="fev-delete.php?TestRecordID=<?= $test['TestRecordID'] ?>&confirm=no">No</a>
    </div>
    <?php endif; ?>
</div>

<?=template_footer()?>
