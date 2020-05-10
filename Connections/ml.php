<?php
error_reporting(0);
error_reporting(E_ERROR | E_PARSE);
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"

$hostname_ml = "localhost";
$database_ml = "thelogis_db";
$username_ml = "root";
$password_ml = "";

/*
$hostname_ml = "localhost";
$database_ml = "thelogis_db";
$username_ml = "thelogis_root";
$password_ml = "thelogis1234";
*/

$ml = mysql_pconnect($hostname_ml, $username_ml, $password_ml) or trigger_error(mysql_error(),E_USER_ERROR);
