<?php

function echoError($errMsg){
    require_once ('../app_config.php');
    require_once (APP_ROOT . '/' . APP_FOLDER_NAME . '/scripts/echoHTML.php');

    $jsFile = '';
    $cssFile = APP_FOLDER_NAME . '/styles/main.css';

    echoHead("Acme Medical", $jsFile, $cssFile);
    echoHeader("Oops!");
    echo "<h3>$errMsg </h3>";
    echoFooter();
}