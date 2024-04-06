<?php
require_once ('../app_config.php');
require_once (APP_ROOT . '/' . APP_FOLDER_NAME . '/scripts/echoHTML.php');

$jsFile = APP_FOLDER_NAME . '/clientScripts/dash_client_checks.js';
$cssFile = APP_FOLDER_NAME . '/styles/main.css';

echoHead("Acme Medical", $jsFile, $cssFile);
echoHeader("ACME MEDICAL");

// login page
echo "
";

echoFooter();