<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
	"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<title>MoodMusic</title>
	<link rel="stylesheet" href="../css/main.css" type="text/css" charset="utf-8">
	<link rel="stylesheet" href="../css/qualify.css" type="text/css" charset="utf-8">
	<script src="../js/jquery.js" type="text/javascript" charset="utf-8"></script>
	<script src="../js/qualify.js" type="text/javascript" charset="utf-8"></script>
</head>


<body>
	<?php include("menu.php"); ?>
	<div id="site-container">
    	<div class='preview'>
			<div id="song-heading">
	        	<span id="title"></span> - <span id="name"></span>
			</div>
        	<iframe id="ytvideo" width="775" height="400" src="http://www.youtube.com/embed/xiJThIUTvEw" frameborder="0" allowfullscreen></iframe>
        </div>
		<table class='features' style='display: none;'>
		</table>
		<div class='form'>
			<input type='hidden' id='nest-id' name='id' />
			<select id="moods">
				<option value="loading">Loading moods</option>
			</select>
			<input type='button' value='Opslaan' id='do-store' />
			<input type='button' value='Delete' id='do-delete' />
		</div>
	</div>
</body>
</html>
