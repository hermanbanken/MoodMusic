<?php
class Controller_Import extends Controller {
	public function action_index() {
		
	}
	
	public function action_spotify_collection(){
		if($this->request->method() === "POST"){
			$artists = $this->request->post('artists');
			$songs = $this->request->post('songs');
			
			if (is_array($artists)) 
			{
				$errors = array();
				foreach($artists as $item){
					$this->spotify_artist($item, $errors);
				}
			}
			
			if (is_array($songs)) 
			{
				$errors = array();
				foreach($songs as $item){
					$this->spotify_song($item, $errors);
				}
			}
		}
	}
	public function action_echonest_collection(){
		
	}
	
	public function spotify_artist($data, &$errors){
		$artist = ORM::factory('artist')->clear()->where("artist.spotify_id", '=', $data['spotify_id'])->find();
		if ( !$artist->loaded() )
		{
			if ( $artist->values($data)->check() )
				$artist->save();
			else
				$errors[] = $data;
		} 
		return $artist;
	}
	
	public function spotify_song($data, &$errors){
		if($data['artist']){
			$data['artist'] = $this->spotify_artist($data['artist'], $errors);
		}
		
		$song = ORM::factory('song')->clear()->where("song.spotify_id", '=', $data['spotify_id'])->find();
		if ( !$song->loaded() )
		{
			if ( $song->values($data)->check() )
				$song->save();
			else
				$errors[] = $data;
		}
		return $song;
	}
}
?>