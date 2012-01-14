<?php

//Handle the file that has been analyzed and uploaded
if($_GET['mode'] == "upload"){
	//Save the uploaded song to the DB
	print_r($_POST);
}

if($_GET['mode'] == "neuralnetwork"){
	//Save the neural netwok to a text file or DB
	echo "save.php";
	print_r($_POST);
}