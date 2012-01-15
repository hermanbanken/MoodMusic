<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Welcome extends Controller {

	public function action_index()
	{
		$this->response->body(	
			'hello, world!<br />Songs via '.
		 	HTML::anchor('/song/list', '/song/list').
			'<br />Individual songs via '. HTML::anchor('/song/id/0', '/song/id/<id>'));
	}

} // End Welcome
