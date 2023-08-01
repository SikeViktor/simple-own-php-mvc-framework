<?php

if($_SERVER["SERVER_NAME"] == "localhost") {
    define("ROOT", "http://localhost/mvc/public");
}
else {
    define("ROOT", "https://www.yourwebsite.com");
}

//database config
define('DBNAME', 'hens');
define('DBHOST', 'localhost');
define('DBUSER', 'root');
define('DBPASS', '');


define('APP_NAME', 'My Website');
define('APP_DESC', 'Best website on the planet');

//show errors if true
define('DEBUG', true);

