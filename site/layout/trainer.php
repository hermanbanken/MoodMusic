<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
	"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<title>MoodMusic</title>
	<link rel="stylesheet" href="../css/main.css" type="text/css" charset="utf-8">
	<link rel="stylesheet" href="../css/trainer.css" type="text/css" charset="utf-8">
	<script src="../js/jquery.js" type="text/javascript" charset="utf-8"></script>
	<script src="../js/brain.js" type="text/javascript" charset="utf-8"></script>
	<script src="../js/networktrainer.js" type="text/javascript" charset="utf-8"></script>
	<script src="../js/analyze.js" type="text/javascript" charset="utf-8"></script>
</head>

<body>
	<?php include("menu.php"); ?>
	<div id="site-container">
		<div id="submit">Click here to train the neural network with the trainingset from the database</div>
		<div id="error">Click here to calculate the error made by the network</div>
		<div id="status"></div>
		<img id="loader" src="../resources/ajax-loader.gif" />
	</div>
</body>
</html>
