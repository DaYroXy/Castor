
<?php
    // Database Params
    // Global named constant for DB
    define('DB_HOST', 'localhost');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', '');
    define('DB_NAME', 'castor');

    // App Root
    // Go back 2 directories to get /app directory
    $appDirectory = dirname(dirname(__FILE__));
    define('APPROOT', $appDirectory);

    // URL Root
    $urlRoot = "http://localhost/Castor";
    define("URLROOT",  $urlRoot);

    // Site Name
    $siteName = "Castor";
    define("SITENAME", $siteName);

    // App Version
    define("VERSION", "1.0.0");

    // You might face redireciton error, make sure to edit .htaccess to the correct path.
