<?php

require_once ('../app_config.php');
require_once (APP_ROOT . '/' . APP_FOLDER_NAME . '/scripts/echoHTML.php');
require_once (APP_ROOT . '/' . APP_FOLDER_NAME . '/scripts/errorDisplay.php');
require_once (APP_ROOT . '/' . APP_FOLDER_NAME . '/scripts/tools.php');
require_once (APP_ROOT . '/' . APP_FOLDER_NAME . '/scripts/dbConnection.php');

$jsFile = APP_FOLDER_NAME . '/clientScripts/customerRegistration.js';
$cssFile = APP_FOLDER_NAME . '/styles/customerRegistration.css';

// application checks
if (isset($_POST['email'])) {
    $email = cleanIO($_POST['email']);
};

if (isset($_POST['password'])) {
    $cust_password = cleanIO($_POST['password']);
};

if (isset($_POST['verify_password'])) {
    $verify_password = cleanIO($_POST['verify_password']);
};

if (isset($_POST['fname'])) {
    $fname = cleanIO($_POST['fname']);
};

if (isset($_POST['state'])) {
    $state = cleanIO($_POST['state']);
};

if (isset($_POST['zip'])) {
    $zip = cleanIO($_POST['zip']);
};

if (isset($_POST['phone'])) {
    $phone = cleanIO($_POST['phone']);
};

if (isset($_POST['member_type'])) {
    $member_type = cleanIO($_POST['member_type']);
};

if (isset($_POST['start_date'])) {
    $start_date = cleanIO($_POST['start_date']);
};

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echoError("Email not valid");
};

if ($cust_password !== $verify_password) {
    echoError("Password fields do not match");
};

if (!is_string($fname)) {
    echoError("Name not valid");
};

if (strlen($state) !== 2) {
    echoError("State not valid");
};

if (!preg_match('/^[0-9]{5}$/', $zip)) {
    echoError("ZIP code not valud");
};

if (!preg_match('/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/', $phone)) {
    echoError("Phone number not valud");
};

//encrypt the password
$encryptedPasswd = md5($cust_password);

//try to insert row into database
// connect to DB
// try {
//     $db = new PDO(DSN1, USER1, PASSWD1);
//     $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// } catch (Exception $e) {
//     $error_message = $e->getMessage();
//     echoError($error_message);
//     exit(1);
// }

$db = getDB(DSN1, USER1, PASSWD1);

// try to insert row into database
try {
    $insertStmt = "INSERT INTO customers_main (email, password, first_name, state, zip, phone, membership_type, starting_date) 
                    VALUES (:emailB, :passwordB, :first_nameB, :stateB, :zipB, :phoneB, :membership_typeB, :starting_dateB)";

    $statement = $db->prepare($insertStmt);
    $statement->bindValue(':emailB', $email);
    $statement->bindValue(':passwordB', $encryptedPasswd); // Use the correct parameter name here
    $statement->bindValue(':first_nameB', $fname);
    $statement->bindValue(':stateB', $state); // Corrected parameter name
    $statement->bindValue(':zipB', $zip);
    $statement->bindValue(':phoneB', $phone);
    $statement->bindValue(':membership_typeB', $member_type);
    $statement->bindValue(':starting_dateB', $start_date);
    $statement->execute();
    $statement->closeCursor();

} catch (Exception $e) {
    $error_message = $e->getMessage();
    echoError($error_message);
    exit(1);
}

echoHead($jsFile, $cssFile);
echoHeader("Thank You");

echo "
        <fieldset class='return-box'>
            <label>E-mail:</label>
            <span> $email </span><br>
    
            <label>First Name:</label>
            <span> $fname </span><br>
    
            <label>State:</label>
            <span> $state </span><br>
                
            <label>ZIP Code:</label>
            <span> $zip </span><br>
                
            <label>Phone Number:</label>
            <span> $phone </span><br>

            <label>Membership Type:</label>
            <span> $member_type </span><br>

            <label>Starting Date:</label>
            <span> $start_date </span><br>
        </fieldset><br>    
";

echoFooter();