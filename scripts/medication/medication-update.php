<?php
@include_once ('../../app_config.php');
@include_once (APP_ROOT.APP_FOLDER_NAME . '/scripts/functions.php');
$pdo = pdo_connect_mysql();
$msg = '';

if (isset($_GET['MedID'])) {
    if (!empty($_POST)) {

        $MedID = isset($_POST['MedID']) ? $_POST['MedID'] : NULL;
        $MedName = isset($_POST['MedName']) ? $_POST['MedName'] : '';
        $MedType = isset($_POST['MedType']) ? $_POST['MedType'] : '';
        $Enzyme = isset($_POST['Enzyme']) ? $_POST['Enzyme'] : '';
       
        $stmt = $pdo->prepare('UPDATE Medications SET MedID = ?, MedName = ?, MedType = ?, Enzyme = ? WHERE MedID = ?');
        $stmt->execute([$MedID, $MedName, $MedType, $Enzyme, $_GET['MedID']]);
        $msg = 'Updated Successfully!';
    }

    $stmt = $pdo->prepare('SELECT * FROM Medications WHERE MedID = ?');
    $stmt->execute([$_GET['MedID']]);
    $medication = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$medication) {
        exit('Medication doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>
<?=template_header('Read')?>

<div class="content update">
	<h2>Update Medication #<?=$medication['MedID']?></h2>
    <form action="medication-update.php?MedID=<?=$medication['MedID']?>" method="post">
        <label for="MedID">ID</label>
        <input type="text" name="MedID" placeholder="auto" value="<?=$medication['MedID']?>" id="MedID">
        
        <label for="MedName">Med Name</label>
        <input type="text" name="MedName" value="<?=$medication['MedName']?>" id="MedName">
        
        <label for="MedType">MedType</label>
        <input type="text" name="MedType" value="<?=$medication['MedType']?>" id="MedType">
        
        <label for="Enzyme">Enzyme</label>
        <input type="text" name="Enzyme" value="<?=$medication['Enzyme']?>" id="Enzyme">
        
        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>