<?php
// error_reporting(0);
require_once("libraries/metatune/config.php");
$res = "noquery";

if(isset($_GET["query"])){
	$res = array();
	$query = $_GET["query"];
	$spotify = MetaTune::getInstance();
	
	try {
	    $tracks = $spotify->searchTrack($query);
	    
  	    // Check for hits. MetaTune#searchTrack returns empty array in case of no result. 
  	    if (count($tracks) < 1){
  			$res = array();
  	    } else {
  			$res['query'] = $query;
 		
  			foreach($tracks as $track){
  				if(is_array($track->getArtist())){ //If multiple artists
  					foreach($track->getArtist() as $artist){
  						if(strpos(strtolower($artist), strtolower($query)))
  							$res['suggestions'][] = $track->getTitle() . " | " . $artist;
  					}
  				}else{
  					$res['suggestions'][] = $track->getTitle() . " | " . $track->getArtist();
  				}	
  				$res['data'][] = $track->getURL();
  			}
  	    }
	} catch (MetaTuneException $ex) {
		$res = "error";
	}
}
echo json_encode($res);

