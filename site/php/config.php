<?php
//Own settings
define('MOOD_TRESHOLD', 0.3); //If the mood value is higher then the treshold return it

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

//Get the mood list
$query		= mysql_query("SELECT `mood` FROM `config_moods`");
while($mood = mysql_fetch_assoc($query))
	$MOOD_LIST[]	= $mood['mood'];
?>