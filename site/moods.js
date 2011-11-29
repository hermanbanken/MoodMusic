$(function(){
	
$('#globe').tagcanvas({textColour : '#000000'});
	if(!$('#globe').tagcanvas({
		textColour : '#ffffff',
		textHeight : 35,
		textFont : "Lucida Sans Unicode, sans-serif",
		maxSpeed : 0.1,
		outlineColour : "#ffffff",
		outlineThickness : 2,
		frontSelect : true,
		reverse : true,
		shadowBlur : 1,
		shadowOffset : [1,1]
	})) {
		// TagCanvas failed to load
		$('#myCanvasContainer').hide();
	}
	
	var moods = ["happy", "angry","sad", "relaxing", "excited"];
	
	function moodbox(name, i){
		var b = $("<div class='mood mood-"+name+" mood-"+i+"'></div>");
	}
});