<?php
//Own settings
define('MOOD_TRESHOLD', 0.7); //If the mood value is higher then the treshold return it
define('MOOD_LIST', array( //The mood list
		"happy",
		"sad",
		"cheerful",
		"funny"
		));

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