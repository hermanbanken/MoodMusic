<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
	"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<title>MoodMusic</title>
	<link rel="stylesheet" href="../stylesheets/main.css" type="text/css" charset="utf-8">
	<style>
		a{
			color: white;
			text-decoration: none;
			font-weight: bold;
		}
		
		a:hover{
			color: gray;
		}
		
		h1{
			margin-bottom: 15px;
		}
	</style>
</head>

<body>
	<div id="site-container" class="page" style="height: auto">
		<h1>Navigate to:</h1>
		<?php
			foreach (glob("*.html") as $filename) {
			    echo '<h3><a href="'.$filename.'">'.$filename.'</a></h3>';
			}
		?>
	</div>
</body>
</html>
