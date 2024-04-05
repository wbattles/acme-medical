<?php

require_once("app_config.php");
$landingPage = WEB_ROOT.APP_FOLDER_NAME."/scripts/landingPage.php";
// echo $landingPage;
// exit();
header("location:$landingPage");