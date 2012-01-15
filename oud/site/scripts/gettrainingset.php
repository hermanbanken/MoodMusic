<?
// header("Content-type: text/json");
require_once("database.php");

//Get training set from the DB and return it as JSON string
$db = new IkeMusicDb();
$res = $db->query("SELECT audiokey, mode, time_signature, loudness, energy, tempo, danceability, ike_mood FROM audio_summary WHERE ike_mood <> -1 AND ike_mood IS NOT NULL");

$print = "[";

while($obj = $res->fetchObject()){
	$print .= "{\"input\":{\"audiokey\": ". ($obj->audiokey/11) .", \"mode\": $obj->mode, \"time_signature\": $obj->time_signature, \"loudness\": ".(($obj->loudness+100)/200).", \"energy\": $obj->energy, \"tempo\": ".($obj->tempo/500).", \"danceability\": $obj->danceability}, \"output\":{".stripslashes($obj->ike_mood)."}},";
}

$print = substr($print, 0, -1);
$print .= "]";

echo $print;

