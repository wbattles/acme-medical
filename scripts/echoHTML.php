<?php

function echoHead($jsFile, $cssFile){
    echo "<head>
            <title>Customer Registration</title>
            <link rel='stylesheet' type='text/css' href='" . $cssFile . "'>
            <script src= '" . $jsFile . "'></script>
        </head>";
};

function echoHeader($title){
    echo "<body>
    <div class='big-box'>
        <header>
            <h2> $title </h2>
            <nav>
                <ul class='menu'>
                    <li><button>Home</button></li>
                    <li><button class='current'>Account</button>
                            <ul class='submenu'>
                                <li>Login</li>
                                <li><a href='landingPage.php'>Register</a></li>
                                <li>Manage</li>
                            </ul>
                    </li>
                    <li><button>Email Us</button></li>
                    <li><button>Logout</button></li>
                    <li><button></button></li>
                </ul>
            </nav>
        </header><br>
        <main>";
};

function echoFooter(){
    date_default_timezone_set('America/Chicago');
    $currDate = date('l jS \of F Y h:i:s A');

    echo "<footer>
                $currDate &copy; Copyright by Wiley Battles
            </footer>
    
        </div>
        </main>  
        </body>";
}