<?php
class Rating_Model extends ORM  {
	protected $_belongs_to = array('user' => array('foreign_key' => 'user_id'));
	protected $_belongs_to = array('song' => array('foreign_key' => 'song_id'));
	
	public User_Model $user;
	public Song_Model $song;
	public $mood = "";
	public $rating = -1;
}
?>