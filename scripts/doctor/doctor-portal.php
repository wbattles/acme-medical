<?php
@include_once ('../../app_config.php');
@include_once (APP_ROOT.APP_FOLDER_NAME . '/scripts/functions.php');

$pdo = pdo_connect_mysql();

$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;

$records_per_page = 5;

$stmt = $pdo->prepare('SELECT * FROM Doctors ORDER BY DoctorID LIMIT :current_page, :record_per_page');
$stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();

$doctors = $stmt->fetchAll(PDO::FETCH_ASSOC);

$num_doctors = $pdo->query('SELECT COUNT(*) FROM Doctors')->fetchColumn();
?>

<?= template_header('Doctor Read') ?>

<div class="content read">
    <h2>Doctor Info</h2>
    <a href="doctor-add.php" class="create-entry">Add Doctor</a>
    <table>
        <thead>
            <tr>
                <th>Doctor ID</th>
                <th>Doctor First Name</th>
                <th>Doctor Last Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($doctors as $doctor): ?>
                <tr>
                    <td><?= $doctor['DoctorID'] ?></td>
                    <td><?= $doctor['DFirstName'] ?></td>
                    <td><?= $doctor['DLastName'] ?></td>
                    <td class="actions">
                        <a href="doctor-update.php?DoctorID=<?= $doctor['DoctorID'] ?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                        <a href="doctor-delete.php?DoctorID=<?= $doctor['DoctorID'] ?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="pagination">
        <?php if ($page > 1): ?>
            <a href="doctor-portal.php?page=<?= $page - 1 ?>"><i class="fas fa-angle-double-left fa-sm"></i></a>
        <?php endif; ?>
        <?php if ($page * $records_per_page < $num_doctors): ?>
            <a href="doctor-portal.php?page=<?= $page + 1 ?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
        <?php endif; ?>
    </div>
</div>

<?= template_footer() ?>