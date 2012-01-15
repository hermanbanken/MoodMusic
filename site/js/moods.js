
$(function(){
	//Load the moods
	getMoods();
	$('#feedback-container').hide();
	$("#moods").change(changeMood);
	$("#feedback-moods").change(feedbackMood);
});

var moods = new Array();
var playlist = new Array();
var ytplayer;
var currentId;

//Get the moods from the DB
function getMoods(){
	$.get("../php/get.php?mode=moods", populateCombobox);
}

//Load the moods into a combobox
function populateCombobox(mds){
	moods = mds;
	
	$("#moods").html('<option value="-1">Please select a mood to listen to</option>');
	$("#feedback-moods").html('<option value="-1">Doesn\'t this song have this mood? Please select it here!</option>');
	
	for(i in moods){
		$("#moods").append('<option value="'+i+'">'+moods[i]+'</option>');
		$("#feedback-moods").append('<option value="'+i+'">'+moods[i]+'</option>');
	}
}	

//Handler that detects a mood change
function changeMood(e){
	mood = getSelectedValue();
	if(mood != undefined){
		loadPlaylist(mood);
		redrawMoods(mood);	
		$("#feedback-moods").children().first().attr("selected","selected");
	}
}

//Returns the currently selected mood
function getSelectedValue(){
	return moods[$("#moods").val()];
}

//Loads a plalist from the databse with a certain mood
function loadPlaylist(mood){
	$.ajax({
		type: "POST",
		url: "../php/get.php?mode=playlist",
		data: {mood: mood},
		success: function(e){
			playlist = e;
			playPlaylist();
		}
	});
}

//Plays the first song in the playlist
function playPlaylist(){
	if(playlist.length > 0){
		//Get the first element of the array and add it to the end
		current = playlist.shift();
		playlist.push(current);
		//Set the current id
		currentId = current.id;
		//Embed and play the youtube movie
		playYoutube(current.artist_name, current.title);
		//Show the feedback section
		$('#feedback-container').show();
	}else{
		setStatus("The playlist for the selected mood is empty");
	}
}

//Plays a youtube video with a certain artist and title
function playYoutube(artist, title){
	//Search youtube for a video with a certain artist and title
	id = $.get(
		'https://gdata.youtube.com/feeds/api/videos?q='+artist+'+'+title+'&alt=json', 
		function(e){
			id  = e.feed.entry[0].id.$t.replace("http://gdata.youtube.com/feeds/api/videos/","");
			url = "http://www.youtube.com/v/"+id+"?enablejsapi=1&playerapiid=ytplayer&version=3";
			var params = { allowScriptAccess: "always" };
		    var atts = { id: "youtube-player" };
		    swfobject.embedSWF(url, "youtube-player", "425", "356", "8", null, null, params, atts);
		}
	);
}

//Callback to detect if a video has ended
function onytplayerStateChange(code){
	if(code == 0){
		//If the move has ended, start a new one
		playPlaylist();
	}
}

//Callback for the change event on the fedback mood combobox
function feedbackMood(e){
	feedback = getSelectedFeedback();
	$.ajax({
		type: "POST",
		url: "../php/save.php?mode=feedback",
		data: {mood: feedback, id: currentId},
		success: function(e){
			setStatus("Your submission (<em>"+feedback+"</em>) has been registered, thanks for contributing!");
			$("#feedback-moods").val(-1);
		}
	})
}

//Returns the selected feedback mood
function getSelectedFeedback(){
	return moods[$("#feedback-moods").val()];
}

//Displays a message to the user for 1.5 seconds or permanently
function setStatus(status, permanent){
	$("#status").hide();
	$("#status").html(status);
	$("#status").slideDown();

	if(!permanent){
		setTimeout(function(){
			$("#status").slideUp();
			$("#status").html("");
		},3000);	
	}
}

//This function redraws all the occurences of the mood as text on the page (e.g: the current mood is: ... )
function redrawMoods(mood){
	$("#feedback-moods:first-child").remove();
	$("#feedback-moods").html('<option value="-1">Doesn\'t this song have a '+mood+' mood? Please select it here!</option>')
}