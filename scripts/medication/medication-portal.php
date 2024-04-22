<?php
@include_once ('../../app_config.php');
@include_once (APP_ROOT.APP_FOLDER_NAME . '/scripts/functions.php');

$pdo = pdo_connect_mysql();

$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;

$records_per_page = 5;

$stmt = $pdo->prepare('SELECT * FROM Medications ORDER BY MedID LIMIT :current_page, :record_per_page');
$stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();

$medications = $stmt->fetchAll(PDO::FETCH_ASSOC);

$num_medications = $pdo->query('SELECT COUNT(*) FROM Medications')->fetchColumn();
?>

<?=template_header('Medication Read')?>

<div class="content read">
	<h2>Medication Info</h2>
	<a href="medication-add.php" class="create-entry">Add Medication</a>
    <table>
        <thead>
            <tr>
                <th>Med ID</th>
                <th>Med Name</th>
                <th>Med Type</th>
                <th>Enzyme?</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($medications as $medication) : ?>
            <tr>
                <td><?=$medication['MedID']?></td>
                <td><?=$medication['MedName']?></td>
                <td><?=$medication['MedType']?></td>
                <td><?=$medication['Enzyme']?></td>
                <td class="actions">
                    <a href="medication-update.php?MedID=<?= $medication['MedID'] ?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                    <a href="medication-delete.php?MedID=<?= $medication['MedID'] ?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
	<div class="pagination">
		<?php if ($page > 1): ?>
		<a href="medication-portal.php?page=<?=$page-1?>"><i class="fas fa-angle-double-left fa-sm"></i></a>
		<?php endif; ?>
		<?php if ($page*$records_per_page < $num_medications): ?>
		<a href="medication-portal.php?page=<?=$page+1?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
		<?php endif; ?>
	</div>
</div>

<?=template_footer()?>