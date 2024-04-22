<?php
@include_once('../../app_config.php');
@include_once(APP_ROOT.APP_FOLDER_NAME.'/scripts/functions.php');
$pdo = pdo_connect_mysql();

// Get the current page via GET request (URL param: page), if none exists default the page to 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
// Number of records to show on each page
$records_per_page = 5;

// Prepare the SQL statement to get records from our Tests table, LIMIT will determine the page
$stmt = $pdo->prepare('SELECT * FROM Tests ORDER BY TestRecordID LIMIT :current_page, :record_per_page');
$stmt->bindValue(':current_page', ($page-1) * $records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();
// Fetch the records so we can display them in our template.
$tests = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get the total number of tests, this is to determine whether there should be next and previous buttons
$num_tests = $pdo->query('SELECT COUNT(*) FROM Tests')->fetchColumn();
?>

<?= template_header('Test List') ?>

<div class="content read">
    <h2>Test Info</h2>
    <a href="fev-add.php" class="create-entry">Add Test</a>
    <table>
        <thead>
            <tr>
                <th>Test Record ID</th>
                <th>Visit ID</th>
                <th>FEV</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tests as $test): ?>
                <tr>
                    <td><?= $test['TestRecordID'] ?></td>
                    <td><?= $test['VisitID'] ?></td>
                    <td><?= $test['FEV'] ?></td>
                    <td class="actions">
                        <a href="fev-update.php?TestRecordID=<?= $test['TestRecordID'] ?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                        <a href="fev-delete.php?TestRecordID=<?= $test['TestRecordID'] ?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="pagination">
        <?php if ($page > 1): ?>
            <a href="fev-portal.php?page=<?= $page - 1 ?>"><i class="fas fa-angle-double-left fa-sm"></i></a>
        <?php endif; ?>
        <?php if ($page * $records_per_page < $num_tests): ?>
            <a href="fev-portal.php?page=<?= $page + 1 ?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
        <?php endif; ?>
    </div>
</div>

<?= template_footer() ?>
