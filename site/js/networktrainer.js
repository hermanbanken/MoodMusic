$(function(){
	$("#loader").hide();
	$("#submit").click(function(){
			setStatus("Gathering trainingset from the database...");
			displayLoader(true);
			//Fetch the trainingset from the database
				$.ajax({
						type: "GET",
						url: "../php/get.php?mode=trainingset",
						success: trainNN,
						error: function(e){
							setStatus("Could not assemble the trainingset, please try reloading the page", true);
						}
					});
		});
	

	//Train the network with the loaded trainingset
	function trainNN(trainingset){
		setStatus("Training neural network...");
		
		//Use a webworker (new thread) to asynchronously train the neural network (else the browser freezes)
		var worker = new Worker('../js/trainer-worker.js');
		
		//Onmessage gets triggered when the worker is done training the network
		worker.onmessage = function(e) {
			//Create a new neural network (so that the methods are re-initialized)
			var NN = new brain.NeuralNetwork();
			//Save the neural network
			saveNN(NN.fromJSON(e.data));
		};
		
		//Pass the trainingset to the worker and let it do its thing (train the network)
		worker.postMessage(trainingset);
	}

	//Save the neural network
	function saveNN(NN){
		setStatus("Storing the updated version of the neural network...");
		
		//Set a timeout to show the message (saving mostly takes less than a second, but then the user won't be able to read what's going on)
		setTimeout(function(){
			$.ajax({
				type: "POST",
				url: "../php/save.php?mode=neuralnetwork",
				data: {"network": JSON.stringify(NN.toJSON())},
				success: function(e){
					setStatus("The neural network is trained and saved");
					displayLoader(false);
				},
				error: function(e){
					setStatus("An error occured while saving the neural network");
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
