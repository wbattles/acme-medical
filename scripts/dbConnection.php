<?php
require_once 'errorDisplay.php';

$jsFile = '';
$cssFile = APP_FOLDER_NAME . '/styles/main.css';

function getDB($dsn, $userName, $passwd) {
    require_once (APP_ROOT . APP_FOLDER_NAME . '/app_config.php');
    require_once (APP_ROOT . APP_FOLDER_NAME . '/scripts/errorDisplay.php');
    try {
        //DEBUG echo $dsn;
        $db = new PDO($dsn, $userName, $passwd);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // echo 'Successful connection to database ';
        return $db;
    } catch (Exception $e) {
        $error_message = $e->getMessage();
        echoError($error_message);
        exit (1);
    }
}
//getDB();