<?php
define('ADMIN_USERNAME','williamg');     // Admin Username
define('ADMIN_PASSWORD','report2014');      // Admin Password

////////// END OF DEFAULT CONFIG AREA /////////////////////////////////////////////////////////////

///////////////// Password protect ////////////////////////////////////////////////////////////////
if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW']) ||
           $_SERVER['PHP_AUTH_USER'] != ADMIN_USERNAME ||$_SERVER['PHP_AUTH_PW'] != ADMIN_PASSWORD) {
            Header("WWW-Authenticate: Basic realm=\"User name or password is not correct.\"");
            Header("HTTP/1.0 401 Unauthorized");

            echo <<<EOB
                <html><body>
                </body></html>
EOB;
            exit;
}

define('DOMAIN','sweepsadmin.hypster.com');
define('CONFIG_DIR',dirname(__FILE__).DIRECTORY_SEPARATOR);
define('ROOT_DIR',CONFIG_DIR.'..'.DIRECTORY_SEPARATOR);
define('DOWNLOAD_DIR',ROOT_DIR .'download'.DIRECTORY_SEPARATOR);
define('TEMPLATES_DIR',ROOT_DIR.'templates'.DIRECTORY_SEPARATOR);
define('APPS',ROOT_DIR.'apps'.DIRECTORY_SEPARATOR);
define('LIB_DIR',ROOT_DIR .'lib'.DIRECTORY_SEPARATOR);

$user_ip = trim($_SERVER['REMOTE_ADDR']);
$_SESSION['user_ip'] = $user_ip;


$result1 = mysql_connect ("127.0.0.1", "root", "rd112358");
$result2 = mysql_select_db ("dailysweeps");
