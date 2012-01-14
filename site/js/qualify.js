$(function(){
	//Get the first song to qualify
	$.get('../scripts/nextsong.json.php', show_song);
	
	//Store the song information in the database
	function store_song(){
		$.post('../scripts/qualify-song.json.php', {id: $('#nest-id').val(), mood: $('#nest-mood').val()}, function(data) {
			show_song(data);
		});
	}
	
	//Delete the song in the database
	function delete_song(){
		$.post('../scripts/qualify-song.json.php', {id: $('#nest-id').val(), remove: "ok"}, function(data) {
			show_song(data);
		});
	}
	
	//Show the song
	function show_song(song){
		$('.features').empty();
		$('#nest-id').val(song['echonest.id']);
		for(n in song){
			$('.features').append("<tr><th>"+n+"</th><td>"+song[n]+"</td></tr>");
		}
		
		$('#title').text(song['echonest.title']);
		$("#name").text(song['echonest.artist_name']);
		
		$("#do-store").click(store_song);
		$("#do-delete").click(delete_song);
		
		$.get('https://gdata.youtube.com/feeds/api/videos?q='+song['echonest.artist_name']+'+'+song['echonest.title']+'&alt=json', function(ret){
			document.getElementById("ytvideo").src = "http://www.youtube.com/embed/"+ret.feed.entry[0].id.$t.replace("http://gdata.youtube.com/feeds/api/videos/","");
	
		});
	}
});



