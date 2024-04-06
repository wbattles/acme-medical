<?php

function echoHead($title, $jsFile, $cssFile){
    echo "<head>
            <title>'" . $title . "'</title>
            <link rel='stylesheet' type='text/css' href='" . $cssFile . "'>
            <script src= '" . $jsFile . "'></script>
        </head>";
};

function echoHeader($title){
    $patient_path = APP_FOLDER_NAME . '/scripts/patient/patient-portal.php';
    $medication_path = APP_FOLDER_NAME . '/scripts/medication/medication-portal.php';
    $fev_path = APP_FOLDER_NAME . '/scripts/fev/fev-portal.php';

    echo "<body>
        <header>
            <h2> $title </h2>
            <nav>
                <ul class='menu'>
                    <li><a href='" . $patient_path . "'>Patients</a></li>
                    <li><a href='" . $medication_path . "'>Medication</a></li>
                    <li><a href='" . $fev_path . "'>FEV</a></li>
                </ul>
            </nav>
        </header><br>
        <main>";
};

function echoFooter(){
    date_default_timezone_set('America/Chicago');
    $currDate = date('l jS \of F Y h:i:s A');

    echo "<footer>
                $currDate
            </footer>
    
        </main>  
        </body>";
}