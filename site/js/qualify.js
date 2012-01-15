$(function(){
	//Get the first song to qualify
	$.get('../php/get.php?mode=training', show_song);
	
	//Populate the combobox
	getMoods();
	
	//Bind handlers
	$("#do-store").click(store_song);
	$("#do-delete").click(delete_song);
});

var currentId;

//Get the moods from the DB
function getMoods(){
	$.get("../php/get.php?mode=moods", populateCombobox);
}

//Load the moods into a combobox
function populateCombobox(mds){
	moods = mds;
	$("#moods").html("");

	for(i in moods){
		$("#moods").append('<option value="'+i+'">'+moods[i]+'</option>');
	}
}

//Returns the currently selected mood
function getSelectedMood(){
	return moods[$("#moods").val()];
}

//Store the song information in the database
function store_song(){
	$.post('../php/save.php?mode=training', {id: currentId, mood: getSelectedMood()}, function(data) {
		$.get('../php/get.php?mode=training', show_song);
	});
}

//Delete the song in the database
function delete_song(){
	$.post('../php/save.php?mode=training', {id: currentId, remove: "ok"}, function(data) {
		$.get('../php/get.php?mode=training', show_song);
	});
}

//Show the song
function show_song(song){
	currentId = song['echonest_id'];
	$('#title').text(song['title']);
	$("#name").text(song['artist_name']);
	
	$.get('https://gdata.youtube.com/feeds/api/videos?q='+song['artist_name']+'+'+song['title']+'&alt=json', function(ret){
		document.getElementById("ytvideo").src = "http://www.youtube.com/embed/"+ret.feed.entry[0].id.$t.replace("http://gdata.youtube.com/feeds/api/videos/","");
	});
}



