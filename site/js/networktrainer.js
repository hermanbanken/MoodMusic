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
		NN.train(trainingset);
		//Save the neural network to a t
		saveNN(NN);
	}
	
	//Save the neural network
	function saveNN(NN){
		setStatus("Storing the updated version of the neural network...");
				
		//Set a timeout to show the message (saving mostly takes less than a second, but then the user won't be able to read what's going on)
			setTimeout(function(){
				$.ajax({
					type: "POST",
					url: "../php/save.php?mode=neuralnetwork",
					data: {"network": NN.toJSON()},
					success: function(e){
						setStatus("The neural network is trained and saved");
						displayLoader(false);
					},
					error: function(e){
						setStatus("An error occured while saving the neural network "+e.responseText);
						displayLoader(false);
					}
				});
			}, 1000);
	}

	function setStatus(status, permanent){
		console.log(status);
		document.getElementById("status").innerHTML = "<em>"+status+"</em>";
	}
	
	function displayLoader(want){
		if(want){
			$("#loader").show();
		}else{
			$("#loader").hide();
		}
	}
});

