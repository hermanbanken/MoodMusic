<?php
class Ike_Kostache extends Kostache {
	const dynamic_function_regex = "/^(?<func>_[a-z]+)(?<params>_[a-z0-9\-\_]+)$/";
	const dynamic_variable_regex = "/_(?<var>[a-z0-9\-]+)/";
	private $_date_full;
	protected $_model;
	
	public function __get($name){
		// Smart function call
		if(self::is_dynamic_function($name, $m))
			return call_user_func(array($this, $m['func']), (array) $m['params']);
		else
			return 'Incorrect call';
	}
	
	public function __isset($name){
		if(isset($this->{$name})) return true;
		if(self::is_dynamic_function($name)) return true;
		// Else
		return false;
	}
	
	private static function is_dynamic_function($name, &$m = array()){
		if(preg_match(self::dynamic_function_regex, $name, $m)){
			if(in_array($m['func'], array('_num', '_fmt', '_get'))){
				preg_match_all(self::dynamic_variable_regex, $m['params'], $m['params']);
				$m['params'] = @$m['params']['var'];
				return true;
			}
			else 
				return false;
		}
	}
		
	private function _fmt($params){
		list($type, $name) = $params;
		$val = $this->{$name};
		
		// Switch formats
		switch($type){
			case 'date':
				return date("Y-m-d H:i:s", $val);
			case 'ago':
				$dd = new Datetime_Diff("@$val");
				return $dd;
			default: return $val;
		}		
	}
	private function _num($params){
	//	trigger_error("Num: ".print_r($params, true).' '.print_r($this, true));
		if(method_exists($this, $params[0]))
			$var = call_user_func(array($this, $params[0]));
		elseif(isset($this->{$params[0]})) 
			$var = $this->{$params[0]};
		// Return count
		return is_array($var) ? count($var) : 0;
	}
	
	private function _get($params){
		return $_GET[$params[0]];
	}
	
	public function model($model = array()){
		foreach($model as $k => $v){
			$this->{$k} = $v;
		}
		return $this;
	}
	/*public function render(){
		// Add page layout
		if ( Request::current()->is_initial() ) {
			return parent::render();
		} elseif( Request::initial()->param('accept') === 'json' ) {
			
		} elseif( Request::initial()->param('accept') === 'hmvc' ) {

		}
	}*/
}
?>