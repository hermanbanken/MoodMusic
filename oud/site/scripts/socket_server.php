<?php
	require_once 'socket.php';
	
	function hoi($d){
		var_dump($d);
	}
	$server = new WebSocketServer('live', '81337', 'hoi');
?>