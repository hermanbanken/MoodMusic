<?php
class View_Page extends Kostache_Layout {
	protected $_partials = array(
	    'header' => 'header', // Loads templates/header.mustache
	    'footer' => 'footer', // Loads templates/footer/default.mustache
	);
}
?>