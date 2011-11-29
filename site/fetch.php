<?php 
	define("APIKEY", "BWXBWVY34MOEXP2CG");
	require_once 'libraries/echonest/lib/EchoNest/Autoloader.php';
	require_once 'database.php';
	EchoNest_Autoloader::register();
	
	$echonest = new EchoNest_Client();
	$echonest->authenticate(APIKEY);
	$ike = new IkeMusicDb();

	if($_GET['songsformood']){
		$songApi = $echonest->getSongApi();
		$songs = $songApi->search(array('mood'=>$_GET['songsformood'], 'sort'=> 'song_hotttnesss-desc', 'bucket'=>'audio_summary', 'results'=>100));
		foreach($songs as $s){
			$s = (object) $s;
			$ike->store_nestsong($s->id, $s->artist_id, $s->artist_name, $s->title, $s->audio_summary);
		}
	} else {
		echo '<a href="?songsformood=happy">Fetch songs</a>';
	}
	
	$echonest->deAuthenticate();
?>