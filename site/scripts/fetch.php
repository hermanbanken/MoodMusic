<?php 
	define("APIKEY", "BWXBWVY34MOEXP2CG");
	require_once 'libraries/echonest/lib/EchoNest/Autoloader.php';
	require_once 'database.php';
	require_once 'socket.php';
	
	echo "<html><head><style type='text/css'>"; 
		include 'state.css'; 
	echo "</style><script>"; 
		include 'update_state.js'; 
	echo "</script></head><body>";
	
	EchoNest_Autoloader::register();
	
	$echonest = new EchoNest_Client();
	$echonest->authenticate(APIKEY);
	$ike = new IkeMusicDb();
	
	echo "<html><head><style type='text/css'>"; 
		include 'state.css'; 
	echo "</style><script>"; 
		include 'update_state.js'; 
	echo "</script></head><body>";

	function notify_js($state){
		echo "<script type='text/javascript'>update_state(".json_encode((object)$state).");</script>";
	}

	if($_GET['songsformood']){
		$songApi = $echonest->getSongApi();
		$songs = $songApi->search(array('mood'=>$_GET['songsformood'], 'sort'=> 'song_hotttnesss-desc', 'bucket'=>'audio_summary', 'results'=>100));
		foreach($songs as $s){
			$s = (object) $s;
			$ike->store_nestsong($s->id, $s->artist_id, $s->artist_name, $s->title, $s->audio_summary);
		}
	} elseif($_GET['all'] == '1') {
		$songApi = $echonest->getSongApi();
		$json = file_get_contents("http://developer.echonest.com/api/v4/artist/list_terms?api_key=".APIKEY."&format=json&type=mood");
		$o = json_decode($json);
		$c = 0;
		foreach($o->response->terms as $tk => $term){ 
			notify_js(array("state"=>array($tk, count($o->response->terms), 0, "Moods", $term->name), "totals"=>$c));
			//if($c > 230) continue;
			$songs = $songApi->search(array('mood'=>$term->name, 'sort'=> 'song_hotttnesss-desc', 'bucket'=>'audio_summary', 'results'=>100));
			foreach($songs as $k => $s){
				$c++;
				$s = (object) $s;
				notify_js(array("state"=>array($k, count($songs), 1, $term->name, $s->artist_name .' - '. $s->title), "totals"=>$c));
				$ike->store_nestsong($s->id, $s->artist_id, $s->artist_name, $s->title, $s->audio_summary);
				flush();
			}
		}
	} else {	
		echo '<a href="?songsformood=happy">Fetch songs</a>';
	}
	
	$echonest->deAuthenticate();
	echo "</body></html>";
?>