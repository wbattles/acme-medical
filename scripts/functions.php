<?php

function cleanIO($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
};

function pdo_connect_mysql() {
    @include_once ('../app_config.php');    
    try {
    	return new PDO(DSN1.';charset=utf8', USER1, PASSWD1);
    } catch (PDOException $exception) {
    	// If there is an error with the connection, stop the script and display the error.
    	exit('Failed to connect to database!');
    }
}
function template_header($title) {
    @include_once ('../app_config.php'); 
    echo'
    <!DOCTYPE html>
    <html>
	   <head>
		<meta charset="utf-8">
		<title>ACME Medical</title>
		<link href="'.WEB_ROOT.APP_FOLDER_NAME.'/styles/style.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
	   </head>
	   <body>
            <nav class="navtop">
    	       <div>
    		        <h1>ACME Medical</h1>
                        <a href="'.WEB_ROOT.APP_FOLDER_NAME.'/scripts/landing-page.php">Home</a>
    		            <a href="'.WEB_ROOT.APP_FOLDER_NAME.'/scripts/patient/patient-portal.php">Patient</a>
                        <a href="'.WEB_ROOT.APP_FOLDER_NAME.'/scripts/medication/medication-portal.php">Medications</a>
                        <a href="'.WEB_ROOT.APP_FOLDER_NAME.'/scripts/doctor/doctor-portal.php">Doctors</a>

    	       </div>
            </nav>
';
}
function template_footer() {
echo <<<EOT
    </body>
</html>
EOT;
}