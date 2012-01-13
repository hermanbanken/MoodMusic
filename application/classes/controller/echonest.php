<?php
class Controller_Echonest extends Controller {
	$API = "";
	
	public function search_song($artist, $title){
		$url = "http://developer.echonest.com/api/v4/song/search";
		$update = Request::factory($url);
		$update->method = 'GET';
		$update->get = array(
			'api_key' => $this->API,
			'format' => 'json',
			'results' => 1,
			'artist' => $artist,
			'title' => $title,
			'bucket' => array("audio_summary")
		    );

		$update->execute();
		$data = @json_decode($update->response);
		$echo = @$data->response->songs[0]
		if($echo){
			$song = ORM::factory('song');
			$song->echonest_id = $echo->id;
			$song->title = $echo->title;
			
			$artist = ORM::factory('artist')->where('echonest_id', $echo->artist_id)->find();
		
			// Link to artist.
			// TODO
			
			/*
			"artist_id": "ARH6W4X1187B99274F",
		        "id": "SOCZZBT12A6310F251",
		        "artist_name": "Radiohead",
		        "title": "Karma Police"*/
		}
	}
}

?>