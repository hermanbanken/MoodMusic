<?php 
header("Content-type: text/json");
define("APIKEY", "BWXBWVY34MOEXP2CG");

require('database.php');

$db = new IkeMusicDb();

// Store PREVIOUS SONG
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	if(isset($_POST['remove'])){
		$db->query("UPDATE audio_summary SET ike_mood = '-1' WHERE echonest_id = '".$_POST['id']."'");
	}else{
		$db->query("UPDATE audio_summary SET ike_mood = '".$_POST['mood']."' WHERE echonest_id = '".$_POST['id']."'");
	}
}

// Fetch NEXT SONG
$song = $db->getNextSong();
$id = $song->{'echonest.id'};

echo json_encode($song);
?>