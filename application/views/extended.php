<?php

class View_Extended extends Kostache {
	const dynamic_function_regex = "/^(?<func>_[a-z]+)(?<params>_[a-z0-9\-\_]+)$/";
	const dynamic_variable_regex = "/_(?<var>[a-z0-9\-]+)/";
	private $_date_full;
	
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
				$dd = new DateTime_Diff("@$val");
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
	
	public function renderTemplate($name){
		if(file_exists("templates/$name.mustache")){
			return $this->render(file_get_contents("templates/$name.mustache"));
		} else return "Template $name not found";
	}
	
	public function fromModel($model){
		$instance = $this;
		foreach($model as $key => $value){
			$instance->{$key} = $value;
		}
		return $instance;
	}
}

class DateTime_Diff extends DateTime {
    
    protected $strings = array(
        'y' => array('1 year ago', '%d years ago'),
        'm' => array('1 month ago', '%d months ago'),
        'd' => array('1 day ago', '%d days ago'),
        'h' => array('1 hour ago', '%d hours ago'),
        'i' => array('1 minute ago', '%d minutes ago'),
        's' => array('now', '%d seconds ago'),
    );
    
    /**
     * Returns the difference from the current time in the format X time ago
     * @return string
     */
    public function __toString() {
        $now = new DateTime('now');
        $diff = $this->diff($now);
        
        foreach($this->strings as $key => $value){
            if( ($text = $this->getDiffText($key, $diff)) ){
                return $text;
            }
        }
        return '';
    }
    
    /**
     * Try to construct the time diff text with the specified interval key
     * @param string $intervalKey A value of: [y,m,d,h,i,s]
     * @param DateInterval $diff
     * @return string|null
     */
    protected function getDiffText($intervalKey, $diff){
        $pluralKey = 1;
        $value = $diff->$intervalKey;
        if($value > 0){
            if($value < 2){
                $pluralKey = 0;
            }
            return sprintf($this->strings[$intervalKey][$pluralKey], $value);
        }
        return null;
    }
}
?>