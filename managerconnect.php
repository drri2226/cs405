<?php
DEFINE ('DB_USER', 'manager');
DEFINE ('DB_PASSWORD', 'manager123');
DEFINE ('DB_HOST', 'localhost');
DEFINE ('DB_NAME', 'cs405project');

$dbc = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
OR die('Could not connect to MySQL');
?>