<?php
@include_once('../app_config.php');
@include_once(APP_ROOT.APP_FOLDER_NAME . '/scripts/functions.php');

$pdo = pdo_connect_mysql();
$sql = "
SELECT 
    pi.FirstName, 
    pi.LastName, 
    pi.Gender, 
    pi.Birthdate, 
    pi.Genetics, 
    pi.Diabetes, 
    pi.OtherConditions, 
    v.VisitDate, 
    d.DFirstName AS DoctorFirstName, 
    d.DLastName AS DoctorLastName, 
    t.MaxFEV AS HighestFEV,
    GROUP_CONCAT(
        DISTINCT CASE
            WHEN p.MedID IS NOT NULL THEN
                CONCAT_WS(
                    '  ',
                    'MedName:', m.MedName,
                    'Dosage:', p.Dosage,
                    'Quantity:', p.Quantity,
                    'DateReceived:', p.DateReceived
                )
        END ORDER BY p.DateReceived DESC SEPARATOR ', '
    ) AS Medications
FROM 
    PatientInformation pi
LEFT JOIN 
    Visits v ON pi.PatientID = v.PatientID
LEFT JOIN 
    Doctors d ON v.DoctorID = d.DoctorID
LEFT JOIN 
    (
        SELECT VisitID, MAX(CAST(FEV AS UNSIGNED)) AS MaxFEV
        FROM Tests 
        GROUP BY VisitID
    ) t ON v.VisitID = t.VisitID
LEFT JOIN 
    Prescriptions p ON v.VisitID = p.VisitID
LEFT JOIN 
    Medications m ON p.MedID = m.MedID
GROUP BY
    pi.PatientID
ORDER BY 
    pi.LastName, pi.FirstName, v.VisitDate;

";

$stmt = $pdo->query($sql);
$records = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?= template_header("Home") ?>

<body>
    <div class="content read">
        <h2>Medical Records</h2>
        <table>
            <thead>
                <tr>
                    <th>Patient Name</th>
                    <th>Gender</th>
                    <th>Birthdate</th>
                    <th>Genetics</th>
                    <th>Diabetes</th>
                    <th>Other Conditions</th>
                    <th>FEV</th>
                    <th>Medications</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($records as $record): ?>
                    <tr>
                        <td><?= $record['FirstName'] ?> <?= $record['LastName'] ?></td>
                        <td><?= $record['Gender'] ?></td>
                        <td><?= $record['Birthdate'] ?></td>
                        <td><?= $record['Genetics'] ?></td>
                        <td><?= $record['Diabetes'] ?></td>
                        <td><?= $record['OtherConditions'] ?></td>
                        <td><?php
                            if (!empty($record['HighestFEV'])) {
                                echo $record['HighestFEV'] . ' (' . $record['VisitDate'] . ')';
                            } else {
                                echo '';
                            };
                            ?>
                        </td>
                        <td><?= $record['Medications'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

<?= template_footer() ?>
