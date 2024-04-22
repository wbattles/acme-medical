<?php
@include_once ('../../app_config.php');
@include_once (APP_ROOT.APP_FOLDER_NAME . '/scripts/functions.php');
// Connect to MySQL database
$pdo = pdo_connect_mysql();
// Get the page via GET request (URL param: page), if non exists default the page to 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
// Number of records to show on each page
$records_per_page = 5;

// Prepare the SQL statement and get records from our Prescriptions table, LIMIT will determine the page
$stmt = $pdo->prepare('SELECT * FROM Prescriptions ORDER BY PrescriptionID LIMIT :current_page, :record_per_page');
$stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();
// Fetch the records so we can display them in our template.
$prescriptions = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get the total number of prescriptions, this is so we can determine whether there should be a next and previous button
$num_prescriptions = $pdo->query('SELECT COUNT(*) FROM Prescriptions')->fetchColumn();
?>

<?= template_header('Prescription List') ?>

<div class="content read">
    <h2>Prescription Info</h2>
    <a href="prescription-add.php" class="create-entry">Add Prescription</a>
    <table>
        <thead>
            <tr>
                <th>Prescription ID</th>
                <th>Medication ID</th>
                <th>Visit ID</th>
                <th>Dosage</th>
                <th>Quantity</th>
                <th>Date Received</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($prescriptions as $prescription): ?>
                <tr>
                    <td><?= $prescription['PrescriptionID'] ?></td>
                    <td><?= $prescription['MedID'] ?></td>
                    <td><?= $prescription['VisitID'] ?></td>
                    <td><?= $prescription['Dosage'] ?></td>
                    <td><?= $prescription['Quantity'] ?></td>
                    <td><?= $prescription['DateReceived'] ?></td>
                    <td class="actions">
                        <a href="prescription-update.php?PrescriptionID=<?= $prescription['PrescriptionID'] ?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                        <a href="prescription-delete.php?PrescriptionID=<?= $prescription['PrescriptionID'] ?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="pagination">
        <?php if ($page > 1): ?>
            <a href="prescription-portal.php?page=<?= $page - 1 ?>"><i class="fas fa-angle-double-left fa-sm"></i></a>
        <?php endif; ?>
        <?php if ($page * $records_per_page < $num_prescriptions): ?>
            <a href="prescription-portal.php?page=<?= $page + 1 ?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
        <?php endif; ?>
    </div>
</div>

<?= template_footer() ?>
