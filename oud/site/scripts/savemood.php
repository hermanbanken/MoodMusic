<?
require_once("database.php");

if(isset($_POST)){
	$song = json_decode(stripslashes($_POST['song']));
	$res = substr($_POST['result'],1,-2);
		
	$track = $song->response->track;
	$as = $track->audio_summary;

	echo "INSERT INTO echonest VALUES ('".$track->song_id."','".$track->artist_id."','".$track->artist."','".$track->title."')";
	echo "INSERT INTO audio_summary VALUES ('".$track->song_id."','".$as->key."','".$as->mode."','".$as->time_signature."','".$as->duration."','".$as->loudness."','".$as->energy."','".$as->tempo."','".$track->audio_md5."','".$as->analysis_url."','".$as->danceability."','".$res."')";
	
	// $db = new IkeMusicDb();
	// $db->query("INSERT INTO echonest VALUES ('".$track->song_id."','".$track->artist_id."','".$track->artist_name."','".$track->title."')");
	// $db->query("INSERT INTO audio_summary VALUES ('".$track->song_id."','".$as->key."','".$as->mode."','".$as->time_signature."','".$as->duration."','".$as->loudness."','".$as->energy."','".$as->tempo."','".$as->audio_md5."','".$as->analysis_url."','".$as->danceability."','".$res."')");
	
}