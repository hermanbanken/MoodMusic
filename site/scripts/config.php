<?php
//Database settings
define('MYSQL_SERVER', '127.0.0.1');
define('MYSQL_USERNAME', 'ike');
define('MYSQL_PASSWORD', 'supermooi');
define('MYSQL_DATABASE', 'ike');

//Echonest settings
define("ECHONEST_APIKEY", "BWXBWVY34MOEXP2CG");

//Connect to the database
mysql_connect(MYSQL_SERVER, MYSQL_USERNAME, MYSQL_PASSWORD);
mysql_select_db(MYSQL_DATABASE);
?>