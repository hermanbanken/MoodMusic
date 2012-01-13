<?php
class Role_Model extends ORM {
    protected $has_and_belongs_to_many = array('users');
 
	public function unique_key($id = NULL)
	{
		if ( ! empty($id) AND is_string($id) AND ! ctype_digit($id) )
		{
			return 'name';
		}
 
		return parent::unique_key($id);
	}
 
}
?>