<?php
require_once ('../../app_config.php');
require_once (APP_ROOT . '/' . APP_FOLDER_NAME . '/scripts/echoHTML.php');
require_once (APP_ROOT . '/' . APP_FOLDER_NAME . '/scripts/errorDisplay.php');
require_once (APP_ROOT . '/' . APP_FOLDER_NAME . '/scripts/tools.php');
require_once (APP_ROOT . '/' . APP_FOLDER_NAME . '/scripts/dbConnection.php');

$jsFile = APP_FOLDER_NAME . '/clientScripts/fev_client_checks.js';
$cssFile = APP_FOLDER_NAME . '/styles/main.css';

$db = getDB(DSN1, USER1, PASSWD1);

echoHead("Acme Medical", $jsFile, $cssFile);
echoHeader("ACME MEDICAL");

// login page
echo "
";

echoFooter();