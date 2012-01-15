<?php
//Make it a JSON file and require config
header("Content-type: text/json");
require_once('config.php');

/*
Array
(
    [res] => Array
        (
            [lol] => 0.0067932125810299376
            [happy] => 0.0068638205197277214
        )

    [file] => Array
        (
            [status] => complete
            [song_id] => SOPPBIX130516E2202
            [artist] => Jessie J
            [title] => Price Tag
            [artist_id] => ARWWTYW11F4C842642
            [analyzer_version] => 3.08d
            [audio_summary] => Array
                (
                    [key] => 5
                    [analysis_url] => https://echonest-analysis.s3.amazonaws.com:443/TR/TRAMDTA134CE9F8B9D/3/full.json?Signature=g%2BcJ4Bga3gQb%2Fq9SUsX%2BAabZ6bs%3D&Expires=1326631113&AWSAccessKeyId=AKIAJRDFEY23UEVW42BQ
                    [energy] => 0.5660849093860845
                    [tempo] => 175.05
                    [speechiness] => 0.3033574934374937
                    [mode] => 1
                    [time_signature] => 4
                    [duration] => 221.04122
                    [loudness] => -14.533
                    [danceability] => 0.5996660108524636
                )

            [release] => Who You Are
            [audio_md5] => 39974e628cbc10bf0911232f59ebef8d
            [bitrate] => 320
            [id] => TRAMDTA134CE9F8B9D
            [samplerate] => 48000
            [md5] => 27604ef03cbd600bae6e4d29c0c35ec2
        )

)
*/

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
	
	//Save the moods
	foreach($_POST['res'] as $mood => $value)
		mysql_query("INSERT INTO `audio_moods` VALUES ('".$file['id']."','".mysql_real_escape_string($mood)."','".mysql_real_escape_string($value)."','0')");
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