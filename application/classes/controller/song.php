<?php
class Controller_Song extends Ike_Controller {
	public function action_index(){
		$this->action_list();
	}
	
	public function action_id(){
		$song = ORM::factory('song')->find($this->request->param('id'));
		$this->_single($song);
	}
	
	public function action_list(){
		$items = array();
		$songs = ORM::factory('song')->find_all();
		foreach($songs as $s){
			$items[] = $s;
		}
		$this->_list($items);
	}
	
	public function action_spotifyid(){
		$song = ORM::factory('song')->where('spotify_id', $this->request->param('id'))->find();
		$this->_single($song);
	}
	
	public function _single($song){
		$this->response->view = View::factory('song');
		$this->response->view->model = $song;
	}
	public function _list($items){
		$this->response->view = View::factory('list', array('item'=>'song'));
		$this->response->view->items = $items;
	}
}
?>