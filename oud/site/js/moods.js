$(function(){	
	//Add moods to the cloud
	var moods = ["happy", "angry","sad", "relaxing", "excited", "happy", "angry","sad", "relaxing", "excited"];
	
	for(i in moods){
		$("#globe ul").append('<li><a class="mood" name='+i+' href="#">'+moods[i]+'</a></li>');
	}
	
	//Render the cloud
	$('#globe').tagcanvas({textColour : '#000000'});
		if(!$('#globe').tagcanvas({
			textColour : '#ffffff',
			textHeight : 25,
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
			$('#globe ul').hide();
		}
		
	
	//Bind handlers
	$("#now-playing").hide();
	$("#globe ul li a.mood").click(function(){
		index = $(this).attr("name");
		mood = moods[index];
		playMood(mood);
	})
	
	//Plays song of a certain mood
	function playMood(mood){
		$("#now-playing").show();
		$("#welcome").hide();
		$("#mood").html(mood);
	}
	
	//Gets one song of a certain mood
	function getSong(mood){
		
	}
	
	
	
});