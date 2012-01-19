<?php
//Make it a JSON file and require config
header("Content-type: text/json");
require_once('config.php');

//Handle the request
if($_GET['mode'] == "trainingset"){
	//Create the moods return set
	$moods		= array();
	foreach($MOOD_LIST as $mood)
		$moods[$mood]	= (float)0;

	//Get all the mooded songs which are done by a person
	$query		= mysql_query("SELECT DISTINCT `audio_moods`.`echonest_id`,`audiokey`,`mode`,`time_signature`,`loudness`,`energy`,`tempo`,`danceability` FROM `audio_moods` JOIN `audio_summary` ON `audio_moods`.`echonest_id`=`audio_summary`.`echonest_id` WHERE `by_person`= '1'");
	//$query		= mysql_query("SELECT * FROM `audio_moods` JOIN `audio_summary` ON `audio_moods`.`echonest_id`=`audio_summary`.`echonest_id` AND `by_person`='1'");
	$songs		= array();
	
	while($song = mysql_fetch_assoc($query))
	{
		$input						= array();
		$input['audiokey']			= (float)$song['audiokey']/11;
		$input['mode']				= (float)$song['mode'];
		$input['time_signature']	= (float)$song['time_signature'];
		$input['loudness']			= (float)($song['loudness']+100)/200;
		$input['energy']			= (float)$song['energy'];
		$input['tempo']				= (float)$song['tempo']/500;
		$input['danceability']		= (float)$song['danceability'];
		
		//Get all the moods for that song
		$m_query					= mysql_query("SELECT `mood`, AVG(`rating`) AS `rating` FROM `audio_moods` WHERE `echonest_id`='".$song['echonest_id']."' AND `by_person`='1' GROUP BY `mood`");
		$output						= $moods;
		
		//Set all the moods
		while($mood = mysql_fetch_assoc($m_query))
			$output[$mood['mood']]		= (float)$mood['rating'];
		
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
	$query		= mysql_query("SELECT * FROM `echonest` JOIN `audio_summary` ON `echonest`.`id`=`audio_summary`.`echonest_id` WHERE `echonest`.`id` NOT IN (SELECT `echonest_id` FROM `audio_moods` WHERE `by_person` = '1') LIMIT 10");
	$songs = array();
	while($songs[] = mysql_fetch_object($query)){}
	shuffle($songs);
	$song		= $songs[0];
	
	//Return the song
	print json_encode($song);
}
else if($_GET['mode'] == "moods"){
	//Return a list of moods (JSON)
	print json_encode($MOOD_LIST);
}
else if($_GET['mode'] == "playlist"){
	//Return a playlist with a mood that is in $_POST['mood']
	$escape_mood	= mysql_real_escape_string($_POST['mood']);
	$query			= mysql_query("SELECT DISTINCT `id`,`artist_name`,`title`,AVG(`rating`) as `avg_rating` FROM `echonest` JOIN `audio_moods` ON `echonest`.`id`=`audio_moods`.`echonest_id` WHERE `mood`='".$escape_mood."'
GROUP BY `echonest_id`");
	$playlist		= array();
	
	//Make the playlist
	while($song = mysql_fetch_assoc($query))
	{
		if($song['avg_rating'] >= MOOD_TRESHOLD)
			$playlist[]		= $song;
	}
	
	//Shuffle the playlist
	shuffle($playlist);
	
	//Return the playlist
	print json_encode($playlist);
}
else if($_GET['mode'] == "testset"){
	//Dit is nu een copy van de trainingset code, dus dit kan allemaal weg
	//Create the moods return set
	$moods		= array();
	foreach($MOOD_LIST as $mood)
		$moods[$mood]	= (float)0;

	//Get all the mooded songs which are done by a person
	$query		= mysql_query("SELECT DISTINCT `audio_moods`.`echonest_id`,`audiokey`,`mode`,`time_signature`,`loudness`,`energy`,`tempo`,`danceability` FROM `audio_moods` JOIN `audio_summary` ON `audio_moods`.`echonest_id`=`audio_summary`.`echonest_id` WHERE `by_person`= '1' LIMIT 100");
	//$query		= mysql_query("SELECT * FROM `audio_moods` JOIN `audio_summary` ON `audio_moods`.`echonest_id`=`audio_summary`.`echonest_id` AND `by_person`='1'");
	$songs		= array();
	
	while($song = mysql_fetch_assoc($query))
	{
		$input						= array();
		$input['audiokey']			= (float)$song['audiokey']/11;
		$input['mode']				= (float)$song['mode'];
		$input['time_signature']	= (float)$song['time_signature'];
		$input['loudness']			= (float)($song['loudness']+100)/200;
		$input['energy']			= (float)$song['energy'];
		$input['tempo']				= (float)$song['tempo']/500;
		$input['danceability']		= (float)$song['danceability'];
		
		//Get all the moods for that song
		$m_query					= mysql_query("SELECT `mood`, AVG(`rating`) AS `rating` FROM `audio_moods` WHERE `echonest_id`='".$song['echonest_id']."' AND `by_person`='1' GROUP BY `mood`");
		$output						= $moods;
		
		//Set all the moods
		while($mood = mysql_fetch_assoc($m_query))
			$output[$mood['mood']]		= (float)$mood['rating'];
		
		$songs[]				= array(
			'input' => $input,
			'output' => $output
			);
	}
	
	//Return the trainingset
	print json_encode($songs);
}