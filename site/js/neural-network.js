$(function(){
	
	var net = new brain.NeuralNetwork();
	
	function fetchTrainingset(){
		$.ajax({
			url: "../scripts/gettrainingset.php",
			success: function(e){
				console.log($.parseJSON(e));
				net.train($.parseJSON(e));
				saveNN();
				// console.log(net.toJSON());
				// console.log(net.run({audio_key: 7, mode: 1, time_signature: 4, loudness: -3.586000, energy: 0.584840, tempo: 203.752000, danceability: 0.424816}));
			}
		});
	}
		
	function saveNN(){
		$("p").html("ready");
		
		nn = JSON.stringify(net.toJSON());
		console.log(nn);
	}
		
	fetchTrainingset();
	
	
});

