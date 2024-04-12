<?php
@include_once ('../../app_config.php');
@include_once (APP_ROOT.APP_FOLDER_NAME . '/scripts/functions.php');
// Connect to MySQL database
$pdo = pdo_connect_mysql();
// Get the page via GET request (URL param: page), if non exists default the page to 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
// Number of records to show on each page
$records_per_page = 5;
// Prepare the SQL statement and get records from our PatientInformation table, LIMIT will determine the page
$stmt = $pdo->prepare('SELECT * FROM PatientInformation ORDER BY PatientID LIMIT :current_page, :record_per_page');
$stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();
// Fetch the records so we can display them in our template.
$patients = $stmt->fetchAll(PDO::FETCH_ASSOC);
// Get the total number of contacts, this is so we can determine whether there should be a next and previous button
$num_patients = $pdo->query('SELECT COUNT(*) FROM PatientInformation')->fetchColumn();

template_header('Read');

echo "
<div class='content read'>
	<h2>Patient Info</h2>
	<a href='patient-add.php' class='create-entry'>Add Patient</a>
    <table>
    <thead>
        <tr>
            <th>Patient ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Gender</th>
            <th>Birthdate</th>
            <th>Genetics</th>
            <th>Diabetes</th>
            <th>Other Conditions</th>
        </tr>
        <thead>
        <tbody>";
    
foreach ($patients as $patient) {
    echo "<tr>";
    echo "<td>" . $patient["PatientID"] . "</td>";
    echo "<td>" . $patient["FirstName"] . "</td>";
    echo "<td>" . $patient["LastName"] . "</td>";
    echo "<td>" . $patient["Gender"] . "</td>";
    echo "<td>" . $patient["Birthdate"] . "</td>";
    echo "<td>" . $patient["Genetics"] . "</td>";
    echo "<td>" . $patient["Diabetes"] . "</td>";
    echo "<td>" . $patient["OtherConditions"] . "</td>";
};


echo "</tbody>
    </table>
<div class='pagination'>";
if ($page > 1):
    echo "<a href='patient-portal.php?page=<?=$page-1?>'><i class='fas fa-angle-double-left fa-sm'></i></a>";
endif;
if ($page*$records_per_page < $num_patients):
    echo "<a href='patient-portal.php?page=<?=$page+1?>'><i class='fas fa-angle-double-right fa-sm'></i></a>";
endif;

echo "
</div>
</div>";

template_footer();