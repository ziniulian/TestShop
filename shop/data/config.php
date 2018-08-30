<?php
// database host
$db_host   = (getenv("OPENSHIFT_MYSQL_DB_URL") ? getenv("OPENSHIFT_MYSQL_DB_URL") : "127.0.0.1") . ":" . (getenv("OPENSHIFT_MYSQL_DB_PORT") ? getenv("OPENSHIFT_MYSQL_DB_PORT") : "3306");

// database name
$db_name   = getenv("OPENSHIFT_MYSQL_DB_NAM") ? getenv("OPENSHIFT_MYSQL_DB_NAM") : "shop";

// database username
$db_user   = getenv("OPENSHIFT_MYSQL_DB_USER") ? getenv("OPENSHIFT_MYSQL_DB_USER") : "uShop";

// database password
$db_pass   = getenv("OPENSHIFT_MYSQL_DB_PWD") ? getenv("OPENSHIFT_MYSQL_DB_PWD") : "u111";

// table prefix
$prefix    = "tsp_";

$timezone    = "PRC";

$cookie_path    = "/";

$cookie_domain    = "";

$session = "1440";

define('EC_CHARSET','utf-8');

define('ADMIN_PATH','admin');

define('AUTH_KEY', 'this is a key');

define('OLD_AUTH_KEY', '');

define('API_TIME', '');

?>
