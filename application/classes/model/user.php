<?php
class User_Model extends ORM {
	protected $has_and_belongs_to_many = array('roles');
 
	public function unique_key($id = NULL)
	{
		if ( ! empty($id) AND is_string($id) AND ! ctype_digit($id) )
		{
			return 'username';
		}
 
		return parent::unique_key($id);
	}
	
	public function login() {
		//Check if already logged in
		if (Auth::instance()->logged_in('login')) {
			url::redirect('index');
		} else if (Auth::instance()->logged_in()) {
			url::redirect('accessdenied'); //User hasn't confirmed account yet
		}
	 
		//Initialize template and form fields
		$view = new View('login');
		$view->username = '';
		$view->password = '';
	 
		//Attempt login if form was submitted
		if ($post = $this->input->post()) {
			if (ORM::factory('user')->login($post)) {
				url::redirect($this->session->get('requested_url'));
			} else {
				$view->username = $post['username']; //Redisplay username (but not password) when form is redisplayed.
				$view->message = in_array('required', $post->errors()) ? 'Username and password are required.' : 'Invalid username and/or password.';
			}
		}
	 
		//Display login form
		$view->render(TRUE);
	}
}
?>