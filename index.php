<?php

require_once("app_config.php");
$landingPage = WEB_ROOT.APP_FOLDER_NAME."/scripts/landing-page.php";
// echo $landingPage;
// exit();
header("location:$landingPage");