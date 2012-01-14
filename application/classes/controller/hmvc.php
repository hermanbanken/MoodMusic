<?php
class Controller_HMVC extends Controller {

	public function action_request(){
		print "Action_requesting: ".$this->request->param('uri');
		$hmvc = Request::factory('/'.$this->request->param('uri'))->execute();
	}

}

?>