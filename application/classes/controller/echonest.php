<?php
class Controller_Echonest extends Controller {
	private $API = "BWXBWVY34MOEXP2CG";
	
	public function search_artist($artist){
		$result = $this->query("http://developer.echonest.com/api/v4/artist/search", array(
			'results' => 1,
			'name' => $artist,
		));
		
		if($result && count($result->artists) > 0){
			$artist = ORM::factory('artist')->where('echonest_id', "=", $result->artists[0]->id)->find();
			if($artist->loaded()){
				$song->artist_id = $artist->id;
			} else {
				$artist->echonest_id = $result->songs[0]->artist_id;
				$artist->name = $result->songs[0]->artist_name;
				$artist->save();
				$song->artist_id = $artist->id;
				var_dump($result->songs[0]->artist_id);
				var_dump($artist);	
			}
		}
	}
	
	public function action_search_song($artist = 'Coldplay', $title = 'X & Y'){
		$result = $this->query("http://developer.echonest.com/api/v4/song/search", array(
			'results' => 1,
			'artist' => $artist,
			'title' => $title,
			'bucket' => "audio_summary"
		));
		
		if($result && count($result->songs) > 0){
			$song = ORM::factory('song')->where('echonest_id', '=', $result->songs[0]->id)->find();
			if($song->loaded()){
				echo "Song exists.";
			} else {
				$song->echonest_id = $result->songs[0]->id;
				$song->title = $result->songs[0]->title;
				$artist = ORM::factory('artist')->where('echonest_id', "=", $result->songs[0]->artist_id)->find();
				if($artist->loaded()){
					$song->artist_id = $artist->id;
				} else {
					$artist->echonest_id = $result->songs[0]->artist_id;
					$artist->name = $result->songs[0]->artist_name;
					$artist->save();
					Kohana::$log->add(Kohana::INFO, "Saved artist(:artist) from Echonest.", array(":artist"=>$artist->echonest_id));
					$song->artist_id = $artist->id;
				}
				$song->save();
				Kohana::$log->add(Kohana::INFO, "Saved song(:song) from Echonest.", array(":song"=>$song->echonest_id));
			}
		}
	}

	private function query($url, $get = array()){
		$req = Request::factory($url . URL::query(array_merge(array('api_key'=>$this->API, 'format'=>'json'), $get), false));
		
		if($result = $req->execute()){
			$body = json_decode($result->body());
			if($body->response->status->code !== 0)
				throw new Kohana_Exception(print_r($body->response->status, true));
			else 
				return $body->response;
		} else {
			throw new Kohana_Exception("Request to <$url> failed");
		}
		return false;
	}
}

?>