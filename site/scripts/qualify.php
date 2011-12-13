<?php if($_SERVER['REQUEST_METHOD'] == 'post'){
	echo $_POST['id'];
	echo $_POST['mood'];
} else { ?>
<div>
	<table class='features'>
	</table>
	<div class='preview'></div>
	<div class='form'>
		<input type='hidden' id='nest-id' name='id' />
		<input class='moods' id='nest-mood'  name='moods' />
	</div>
	<input type='button' value='Opslaan' id='do-store' />
	<script>
		function store(){
			$.post('qualify.php', {id: $('#nest-id').val(), mood: $('#nest-mood').val()}, function(data) {
				console.log(data);
			});
		}
			
		$.get('nextsong.json.php', function(song){
			$('.features').empty();
			$('#nest-id').val(song['echonest.id']);
			for(n in song){
				$('.features').append("<tr><th>"+n+"</th><td>"+song[n]+"</td></tr>");
			}
			$("#do-store").click(store);
			
			$.get('https://gdata.youtube.com/feeds/api/videos?q='+song['echonest.artist_name']+'+'+song['echonest.title']+'&alt=json', function(ret){
				console.log(ret);
			});
		});
	</script>
</div>
<?php } ?>