<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
	"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<title>MoodMusic</title>
	<link rel="stylesheet" href="../css/main.css" type="text/css" charset="utf-8">
	<link rel="stylesheet" href="../css/upload.css" type="text/css" charset="utf-8">
	<script src="../js/jquery.js" type="text/javascript" charset="utf-8"></script>
	<script src="../js/brain.js" type="text/javascript" charset="utf-8"></script>
	<script src="../js/upload.js" type="text/javascript" charset="utf-8"></script>
	<script src="../js/binaryfile.js" type="text/javascript" charset="utf-8"></script>
	<script src="../js/id3.js" type="text/javascript" charset="utf-8"></script>
	
</head>


<body>
	<?php include("menu.php"); ?>
	<div id="site-container">
		<div id="upload-field-container">
			<div id="upload-field">
				<em><div id="status">Drag the audio files that you want to add to the program into this box and press the 'Upload and Analyze' button</div></em>
				<ul>
				</ul>
			</div>
		</div>
		<div id="buttons">
			<input id="submit" type="button" value="Upload and Analyze" />
			<input id="cancel" type="button" value="Cancel" />
		</div>
	</div>
</body>
</html>
