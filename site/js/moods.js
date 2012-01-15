




$(function(){
	var moods = new Array();
	
	//Get the moods from the DB
	function getMoods(){
		$.get("../php/get.php?mode=moods", function(e){console.log(e)});
	}
	
	// 
	// //Load the moods into a combobox
	// function populateCombobox(mds){
	// 	moods = JSON.parse(mds);
	// 	
	// 	$("#moods").html("");
	// 	$("#feedback-moods").html("");
	// 	
	// 	for(i in moods){
	// 		$("#moods").append('<option value="'+i+'">'+moods[i]+'</option>');
	// 		$("#feedback-moods").append('<option value="'+i+'">'+moods[i]+'</option>');
	// 	}
	// }	
	// 
	// //Get a playlist with a certain mood
	// function getPlaylist(mood){
	// 	$.ajax({
	// 		type: "POST",
	// 		url: "../php/get.php?mode=playlist",
	// 		data: {"mood": mood},
	// 		success: function(e){
	// 			console.log(e);
	// 		}
	// 	});
	// }
	// 
	// //Play the next song in the playlist
	// function play(){
	// 	// artist = playlist[currentIndex].artist;
	// 	// 		song = playlist[currentIndex].song;
	// 	// 		
	// 	// 		youtubeLoad(artist, song);
	// }
	// 
	// //Load a youtube song
	// function youtubeLoad(){
	// 	
	// }
	// 
	// function changeMood(e){
	// 	index = getSelectedValue();
	// 	getPlaylist(moods[index]);
	// 	currentMood = moods[index];
	// }
	// 
	// function getSelectedValue(){
	// 	return $("#moods option:selected").attr("value");
	// }
	// 
	// //Bind handlers
	// $("#moods").change(changeMood);
	// 
	//Start the app
	getMoods();
	$('#feedback').hide();
});
