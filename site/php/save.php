<?php
//Make it a JSON file and require config
header("Content-type: text/json");
require_once('config.php');

if($_GET['mode'] == "upload"){
	//Escape the recieved data
	$file['id']					= mysql_real_escape_string($_POST['file']['id']);
	$file['artist_id']			= mysql_real_escape_string($_POST['file']['artist_id']);
	$file['artist']				= mysql_real_escape_string($_POST['file']['artist']);
	$file['title']				= mysql_real_escape_string($_POST['file']['title']);
	$info['audiokey']			= mysql_real_escape_string($_POST['file']['audio_summary']['key']);
	$info['mode']				= mysql_real_escape_string($_POST['file']['audio_summary']['mode']);
	$info['time_signature']		= mysql_real_escape_string($_POST['file']['audio_summary']['time_signature']);
	$info['duration']			= mysql_real_escape_string($_POST['file']['audio_summary']['duration']);
	$info['loudness']			= mysql_real_escape_string($_POST['file']['audio_summary']['loudness']);
	$info['energy']				= mysql_real_escape_string($_POST['file']['audio_summary']['energy']);
	$info['tempo']				= mysql_real_escape_string($_POST['file']['audio_summary']['tempo']);
	$info['audio_md5']			= mysql_real_escape_string($_POST['file']['audio_md5']);
	$info['analysis_url']		= mysql_real_escape_string($_POST['file']['audio_summary']['analysis_url']);
	$info['danceability']		= mysql_real_escape_string($_POST['file']['audio_summary']['danceability']);
	
	//Save the song
	mysql_query("INSERT INTO `echonest` VALUES ('".$file['id']."','".$file['artist_id']."','".$file['artist']."','".$file['title']."')");
	mysql_query("INSERT INTO `audio_summary` VALUES ('".$file['id']."','".$info['audiokey']."','".$info['mode']."','".$info['time_signature']."','".$info['duration']."','".$info['loudness']."','".$info['energy']."','".$info['tempo']."','".$info['audio_md5']."','".$info['analysis_url']."','".$info['danceability']."')");
	
	//Save the mood(s)
	foreach($_POST['res'] as $mood => $value)
	{
		if($value >= MOOD_SAVETRIGGER)
			mysql_query("INSERT INTO `audio_moods` VALUES ('".$file['id']."','".mysql_real_escape_string($mood)."','0')");
	}
}
else if($_GET['mode'] == "neuralnetwork"){
	//Save the neural netwok to a text file
	$fp		= fopen("../resources/neuralnetwork.txt", "w+");
	fwrite($fp, $_POST['network']);
	fclose($fp);
}
else if($_GET['mode'] == "training")
{
	//Check if the song needs to be removed
	if(isset($_POST['remove']))
	{
		//Escape the strings
		$escape_id			= mysql_real_escape_string($_POST['id']);

		//Remove the song from the database
		mysql_query("DELETE FROM `echonest` WHERE `id`='".$escape_id."'");
		mysql_query("DELETE FROM `audio_summary` WHERE `echonest_id`='".$escape_id."'");
	}
	else
	{
		//Escape the strings
		$escape_id			= mysql_real_escape_string($_POST['id']);
		$escape_mood		= mysql_real_escape_string($_POST['mood']);
		
		//Add mood to database
		mysql_query("INSERT INTO `audio_moods` VALUES ('".$escape_id."','".$escape_mood."','1')");
	}
}