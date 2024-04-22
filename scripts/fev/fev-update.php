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
        <label for="VisitID">Visit</label>
            <?php
            // Fetch all visits from the database. You might want to join this with patient or doctor information for more descriptive labels.
            $stmt = $pdo->query("SELECT VisitID, VisitDate FROM Visits");
            $visits = $stmt->fetchAll(PDO::FETCH_ASSOC);
            ?>

            <select name="VisitID" id="VisitID">
                <?php foreach($visits as $visit) : ?>
                    <option value="<?php echo $visit['VisitID']; ?>">
                        <?php echo $visit['VisitID'] . ' - ' . $visit['VisitDate']?>
                    </option>
                <?php endforeach; ?>
            </select>

        <label for="FEV">FEV (Forced Expiratory Volume)</label>
        <input type="text" name="FEV" id="FEV" value="<?= $test['FEV'] ?>">

        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
        <p><?= $msg ?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>

