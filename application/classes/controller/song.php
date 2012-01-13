<?php
class Controller_Song extends Controller {
	public function action_index(){
		$this->action_list();
	}
	
	public function action_id($id){
		$song = ORM::factory('song')->find($ip);
		$this->response->body((string) $song);
	}
	
	public function action_list(){
		$list = View::factory('list');
		
		$songs = ORM::factory('song')->find_all();
		foreach($songs as $s){
			$v = View::factory('song')->fromModel($s);
			$list->add($v);
		}
		
		$this->response->body((string) $list);
	}
}
?>