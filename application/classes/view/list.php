<?php
class View_List extends Ike_Kostache {
	public $items = array();
	public function add($item){ 
		$this->items[] = $item;
	}
	public function remove($item){
		foreach($this->items as $key => $one){
			if($one === $item) unset($this->items[$key]);
		}
	}
}
?>