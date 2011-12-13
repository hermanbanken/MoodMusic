<?php 
header("Content-type: text/json");
define("APIKEY", "BWXBWVY34MOEXP2CG");

require('database.php');

$db = new IkeMusicDb();

// Store PREVIOUS SONG
if($_SERVER['REQUEST_METHOD'] == 'post'){
	if(isset($_POST['remove'])){
		$db->query("UPDATE audio_summary WHERE `id` = ".mysql_real_escape_string($_POST['id'])." SET `ike_mood` = '-1'");
	}else{
		$db->query("UPDATE audio_summary WHERE `id` = ".mysql_real_escape_string($_POST['id'])." SET `ike_mood` = '".mysql_real_escape_string($_POST['mood'])."'");
	}
}

// Fetch NEXT SONG
$song = $db->getNextSong();
$id = $song->{'echonest.id'};

echo json_encode($song);
?>