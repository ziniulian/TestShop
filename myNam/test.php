<?php

echo "Hello" . " " . "World!<br/>" . getenv("OPENSHIFT_MYSQL_DB_URL") . " , " . getenv("OPENSHIFT_MYSQL_DB_PORT") . " , " . getenv("OPENSHIFT_MYSQL_DB_NAM") . " , " . getenv("OPENSHIFT_MYSQL_DB_USER") . " , " . getenv("OPENSHIFT_MYSQL_DB_PWD") . " !";

?>
