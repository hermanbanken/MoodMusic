<?php
abstract class Ike_Controller extends Controller {
	public $template = 'page';

	/**
	 * @var  boolean  auto render template
	 **/
	public $auto_render = TRUE;

	/**
	 * Loads the template [View] object.
	 */
	public function before()
	{
		parent::before();
		
		if ($this->auto_render === TRUE)
		{
			// Load the template
			$this->template = View::factory($this->template);
		}
	}

	/**
	 * Assigns the template [View] as the request response.
	 */
	public function after()
	{
		if ($this->auto_render === TRUE)
		{
			if ($this->request->is_initial() && $this->response->view)
			{
				$this->template->content = $this->response->view;
				$this->response->body( (string) $this->template );
			} else {
				$this->response->body( (string) $this->response->view );
			}
		}
		echo $this->response->body( (string) $this->response->view );
		var_dump($this->response->view->render());
		//echo Debug::vars($this->template);
		
		parent::after();
	}
}
?>