<?php
@include_once ('../../app_config.php');
@include_once (APP_ROOT.APP_FOLDER_NAME . '/scripts/functions.php');
$pdo = pdo_connect_mysql();
$msg = '';

if (!empty($_POST)) {

    $DoctorID = isset($_POST['DoctorID']) && !empty($_POST['DoctorID']) && $_POST['DoctorID'] != 'auto' ? $_POST['DoctorID'] : NULL;

    $DFirstName = isset($_POST['DFirstName']) ? $_POST['DFirstName'] : '';
    $DLastName = isset($_POST['DLastName']) ? $_POST['DLastName'] : '';
    
    $stmt = $pdo->prepare('INSERT INTO Doctors VALUES (?, ?, ?)');
    $stmt->execute([$DoctorID, $DFirstName, $DLastName]);

    $msg = 'Created Successfully!';
};
?>

<?= template_header('Create') ?>

<div class="content update">
    <h2>Create Doctor Record</h2>
    <form action="doctor-add.php" method="post">
        <label for="DoctorID">DoctorID (leave as auto for automatic)</label>
        <input type="text" name="DoctorID" placeholder="auto" value="auto" id="DoctorID">
        <label for="DFirstName">Doctor First Name</label>
        <input type="text" name="DFirstName" placeholder="John" id="DFirstName">
        <label for="DLastName">Doctor Last Name</label>
        <input type="text" name="DLastName" placeholder="Doe" id="DLastName">
        
        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?= $msg ?></p>
    <?php endif; ?>
</div>

<?= template_footer() ?>