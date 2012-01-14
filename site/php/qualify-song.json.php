<?php
//Make it a JSON file
header("Content-type: text/json");

//Require the config file
require_once('config.php');

//When the user has posted a mood
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])){
	//Escape the strings
	$escape_id			= mysql_real_escape_string($_POST['id']);
	$escape_mood		= mysql_real_escape_string(json_encode($_POST['mood']));
	
	//Check if the file needs to be removed
	if(isset($_POST['remove']))
		mysql_query("UPDATE `audio_summary` SET `ike_mood` = '-1' WHERE `echonest_id` = '".$escape_id."'");
	else if(isset($_POST['mood']))
		mysql_query("UPDATE `audio_summary` SET `ike_mood` = '".$escape_mood."' WHERE `echonest_id` = '".$escape_id."'");
}

//Fetch the next song
$query		= mysql_query("SELECT * FROM `echonest`, `audio_summary` WHERE `audio_summary`.`echonest_id` = `echonest`.`id` AND `ike_mood` IS NULL LIMIT 1");
$song		= mysql_fetch_object($query);

//Return the next song
print json_encode($song);
?>