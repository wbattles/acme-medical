<?php
@include_once ('../../app_config.php');
@include_once (APP_ROOT.APP_FOLDER_NAME . '/scripts/functions.php');
// Connect to MySQL database
$pdo = pdo_connect_mysql();
// Get the page via GET request (URL param: page), if non exists default the page to 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
// Number of records to show on each page
$records_per_page = 5;
// Prepare the SQL statement and get records from our visits table, LIMIT will determine the page
$stmt = $pdo->prepare('SELECT * FROM Visits ORDER BY VisitID LIMIT :current_page, :record_per_page');
$stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();
// Fetch the records so we can display them in our template.
$visits = $stmt->fetchAll(PDO::FETCH_ASSOC);
// Get the total number of visits, this is so we can determine whether there should be a next and previous button
$num_visits = $pdo->query('SELECT COUNT(*) FROM Visits')->fetchColumn();
?>
<?=template_header('Read')?>

<div class="content read">
	<h2>Read Visits</h2>
	<a href="visit-add.php" class="create-entry">Create Visit</a>
	<table>
        <thead>
            <tr>
                <th>Visit ID</th>
                <th>Patient ID</th>
                <th>Doctor ID</th>
                <th>Visit Date</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($visits as $visit): ?>
            <tr>
                <td><?=$visit['VisitID']?></td>
                <td><?=$visit['PatientID']?></td>
                <td><?=$visit['DoctorID']?></td>
                <td><?=$visit['VisitDate']?></td>
                <td class="actions">
                    <a href="visit-update.php?VisitID=<?=$visit['VisitID']?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                    <a href="visit-delete.php?VisitID=<?=$visit['VisitID']?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
	<div class="pagination">
		<?php if ($page > 1): ?>
		<a href="visit-read.php?page=<?=$page-1?>"><i class="fas fa-angle-double-left fa-sm"></i></a>
		<?php endif; ?>
		<?php if ($page*$records_per_page < $num_visits): ?>
		<a href="visit-read.php?page=<?=$page+1?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
		<?php endif; ?>
	</div>
</div>

<?= template_footer() ?>