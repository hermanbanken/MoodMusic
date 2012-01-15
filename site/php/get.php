<?php
//Make it a JSON file and require config
header("Content-type: text/json");
require_once('config.php');

//Handle the request
if($_GET['mode'] == "trainingset"){
	//Get the different avaiable moods in the database
	$query		= mysql_query("SELECT DISTINCT `mood` FROM `audio_moods`");
	$moods		= array();
	
	while($mood = mysql_fetch_assoc($query))
		$moods[$mood['mood']]	= 0;

	//Get all the mooded songs which are done by a person
	$query		= mysql_query("SELECT * FROM `audio_moods` JOIN `audio_summary` ON `audio_moods`.`echonest_id`=`audio_summary`.`echonest_id` AND `by_person`='1'");
	$songs		= array();
	
	while($song = mysql_fetch_assoc($query))
	{
		$input						= array();
		$input['audiokey']			= $song['audiokey']/11;
		$input['mode']				= $song['mode'];
		$input['time_signature']	= $song['time_signature'];
		$input['loudness']			= ($song['loudness']+100)/200;
		$input['energy']			= $song['energy'];
		$input['tempo']				= $song['tempo']/500;
		$input['danceability']		= $song['danceability'];
		
		$output					= $moods;
		$out[$song['mood']]		= 1;
		
		$songs[]				= array(
			'input' => $input,
			'output' => $output
			);
	}
	
	//Return the trainingset
	print json_encode($songs);
}
else if($_GET['mode'] == "training")
{
	//Find a song without a mood
	$query		= mysql_query("SELECT * FROM `echonest`,`audio_summary` WHERE `echonest`.`id` NOT IN (SELECT DISTINCT `echonest_id` FROM `audio_moods`) LIMIT 1");
	$song		= mysql_fetch_object($query);
	
	//Return the song
	print json_encode($song);
}