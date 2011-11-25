<?php

define("API_KEY","BWXBWVY34MOEXP2CG");

class EchoNestModel{
	
	public static function getTrackById($id){
		return file_get_contents("http://developer.echonest.com/api/v4/track/profile?api_key=". API_KEY ."&format=json&id={$id}&bucket=audio_summary");
	}
	
	public static function search($query, $limit = 20){
		$query = urlencode($query);
		return file_get_contents("http://developer.echonest.com/api/v4/song/search?api_key=".API_KEY."&format=json&results=$limit&combined=$query");
	}
	
	public static function getTrackByName($name){
		$res = EchoNestModel::search($name, 1);
		$res = json_decode($res, true);		
		print_r($res);
		// $id  = $res['response']['songs'][0]['id'];
		// return $id;
		// return EchoNestModel::getTrackById($id);
	}
	
}

// echo EchoNestModel::getTrackbyId("TRXXHTJ1294CD8F3B3");
// echo EchoNestModel::search("mad");
echo "<pre>";
// echo EchoNestModel::getTrackByName("Karma police radiohead");
echo EchoNestModel::getTrackbyId("SOHJOLH12A6310DFE5");


// echo EchoNestModel::getTrackByName("Robbie williams angels");
// 
echo "</pre>";
