<?php
//Own settings
define('MOOD_SAVETRIGGER', 0.8); //Add the mood if it is bigger then this value

//Database settings
define('MYSQL_SERVER', 'vps1.bluecode.nl');
define('MYSQL_USERNAME', 'ike');
define('MYSQL_PASSWORD', 'supermooi');
define('MYSQL_DATABASE', 'ike');

//Echonest settings
define("ECHONEST_APIKEY", "BWXBWVY34MOEXP2CG");

//Connect to the database
mysql_connect(MYSQL_SERVER, MYSQL_USERNAME, MYSQL_PASSWORD);
mysql_select_db(MYSQL_DATABASE);
?>