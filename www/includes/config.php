<?php
error_reporting (E_ALL);

$absolute_path = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
$absolute_path = pathinfo($absolute_path);
define ('absolute_path',$absolute_path['dirname'] . '/');

define ('DBMS', 'mysql');

define ('host', 'localhost');

define ('login', 'root');

define ('password', '1234');

define ('DB', 'my_db');

?>
