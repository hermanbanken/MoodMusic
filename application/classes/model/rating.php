<?php
class Model_Rating extends ORM  {
	protected $_belongs_to = array('user' => array('foreign_key' => 'user_id'));
	protected $_belongs_to = array('song' => array('foreign_key' => 'song_id'));
}
?>