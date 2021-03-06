<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
	"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<title>MoodMusic</title>
	<link rel="stylesheet" href="../css/main.css" type="text/css" charset="utf-8">
	<link rel="stylesheet" href="../css/moods.css" type="text/css" charset="utf-8">
	<script src="../js/jquery.js" type="text/javascript" charset="utf-8"></script>
	<script src="../js/swfobject.js" type="text/javascript" charset="utf-8"></script>
	<script src="../js/moods.js" type="text/javascript" charset="utf-8"></script>
	<script>
		function onYouTubePlayerReady(playerId) {
			//Register the player
			ytplayer = document.getElementById("youtube-player");
			//Play the video
			ytplayer.playVideo();
			//Add a state listener to detect when a movie has finished
			ytplayer.addEventListener("onStateChange", "onytplayerStateChange");
		}
	</script>
</head>

<body>
	<?php include("menu.php"); ?>
	<div id="site-container">
		<div id="moods-container">
			<select id="moods">
				<option value="loading">Loading moods</option>
			</select>
		</div>
		
		<div id="status"><em></em></div>
			
		<div id="youtube-player-container">
			<div id="youtube-player">
				Select a mood to listen to above! If nothing happens, please install the latest version of the adobe flash player.
			</div>
			<div id="previous" class="buttons"></div>
			<div id="next" class="buttons"></div>
		</div>

		<div id="feedback-container">
			<select id="feedback-moods">
				<option value="loading">Loading moods</option>
			</select>
		</div>
	</div>
</body>
</html>
