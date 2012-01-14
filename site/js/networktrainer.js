$(function(){
	//Fetch the trainingset from the database
	$.ajax({
		type: "GET",
		url: "../php/get.php?mode=trainingset",
		success: trainNN
	});
	
	//Train the network with the loaded trainingset
	function trainNN(trainingset){
		//Make a new neural network that can be trained
		var NN = new brain.NeuralNetwork();
		//Train the neural network
		NN.train($.parseJSON(trainingset));
		//Save the neural network to a t
		saveNN(NN);
	}
	
	//Save the neural network
	function saveNN(NN){
		$.ajax({
			type: "POST",
			url: "../php/save.php?mode=neuralnetwork",
			data: NN.toJSON(),
			success: function(e){
				$("#status").html("Done training the network");
			}
		});
	}
});

