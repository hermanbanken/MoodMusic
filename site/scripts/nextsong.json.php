<?php 
header("Content-type: text/json");
define("APIKEY", "BWXBWVY34MOEXP2CG");

require('database.php');

$db = new IkeMusicDb();
$song = $db->getNextSong();
$id = $song->{'echonest.id'};

//$uri = "http://developer.echonest.com/api/v4/song/profile?api_key=".APIKEY."&format=json&results=1&id=".$id."&bucket=id:7digital-US&bucket=tracks";
//$song->{'profile'} = json_decode(file_get_contents($uri));

echo json_encode($song);
?>