$(function(){
	//Get the first song to qualify
	$.get('../php/get.php?mode=training', show_song);
	
	getMoods(0;)
	
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
	
	//Store the song information in the database
	function store_song(){
		$.post('../php/save.php?mode=training', {id: $('#nest-id').val(), mood: $('#nest-mood').val()}, function(data) {
			$.get('../php/get.php?mode=training', show_song);
		});
	}
	
	//Delete the song in the database
	function delete_song(){
		$.post('../php/save.php?mode=training', {id: $('#nest-id').val(), remove: "ok"}, function(data) {
			$.get('../php/get.php?mode=training', show_song);
		});
	}
	
	//Show the song
	function show_song(song){
		$('.features').empty();
		$('#nest-id').val(song['id']);
		for(n in song){
			$('.features').append("<tr><th>"+n+"</th><td>"+song[n]+"</td></tr>");
		}
		
		$('#title').text(song['title']);
		$("#name").text(song['artist_name']);
		
		$("#do-store").click(store_song);
		$("#do-delete").click(delete_song);
		
		$.get('https://gdata.youtube.com/feeds/api/videos?q='+song['artist_name']+'+'+song['title']+'&alt=json', function(ret){
			document.getElementById("ytvideo").src = "http://www.youtube.com/embed/"+ret.feed.entry[0].id.$t.replace("http://gdata.youtube.com/feeds/api/videos/","");
	
		});
	}
});



