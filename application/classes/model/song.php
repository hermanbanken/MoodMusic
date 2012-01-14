<?php
class Model_Song extends ORM {
	protected $_belongs_to = array('artist' => array('foreign_key' => 'artist_id'));
	protected $_load_with = array('artist');
 
	public function unique_key($id = NULL)
	{
		if ( ! empty($id) AND is_string($id) AND ! ctype_digit($id) )
		{
			return 'id';
		}
 
		return parent::unique_key($id);
	}
}
?>