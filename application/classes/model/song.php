<?php
class Song_Model extends ORM {
	public $spotify_id;
	public $echonest_id;
	
	protected $_belongs_to = array('artist' => array('foreign_key' => 'artist_id'));
 
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