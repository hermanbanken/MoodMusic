<?php
abstract class Controller_Ikeobject extends Ike_Controller {
	protected $classname = 'object';
	
	public function action_index(){
		$this->action_list();
	}
	
	public function action_id(){
		$object = ORM::factory($this->classname)->where($this->classname.'.id', '=', $this->request->param('id'))->find();
		if($object->loaded())
			$this->_single($object);
		else throw new HTTP_Exception_404("Unable to find :class :id", array(":class"=>$this->classname, ":id"=>$this->request->param('id')));
	}
	
	public function action_list(){
		$items = array();
		$objects = ORM::factory($this->classname)->find_all();
		foreach($objects as $o){
			$items[] = $o;
		}
		$this->_list($items);
	}
	
	public function action_spotifyid(){
		$object = ORM::factory($this->classname)->where('spotify_id', $this->request->param('id'))->find();
		$this->_single($object);
	}
	
	public function _single($object){
		$this->response->view = Kostache::factory($this->classname);
		$this->response->view->model($object->as_array());
	}
	public function _list($items){
		$this->response->view = Kostache::factory('list', array('item'=>$this->classname));
		$this->response->view->items = $items;
	}
}
?>