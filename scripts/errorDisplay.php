<?php

function echoError($errMsg, $jsFile, $cssFile){
    // require_once ('../../app_config.php');;
    require_once (APP_ROOT . '/' . APP_FOLDER_NAME . '/scripts/echoHTML.php');

    echoHead("Acme Medical", $jsFile, $cssFile);
    echoHeader("Oops!");
    echo "<h3>$errMsg </h3>";
    echoFooter();
}