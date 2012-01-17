$(function(){
	$("#loader").hide();
	$("#submit").click(function(){
			setStatus("Gathering trainingset from the database...");
			setStatus("");
			$("#error-table-container").slideUp();
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
		
});

//Train the network with the loaded trainingset
function trainNN(trainingset){
	setStatus("Training neural network...");
	
	//Use a webworker (new thread) to asynchronously train the neural network (else the browser freezes)
	var worker = new Worker('../js/trainer-worker.js');
	
	//Onmessage gets triggered when the worker is done training the network
	worker.onmessage = function(e) {
		//Save the neural network
		saveNN(e.data);
	};
	
	//Pass the trainingset to the worker and let it do its thing (train the network)
	worker.postMessage(trainingset);
}

//Save the neural network
function saveNN(jsonNN){
	setStatus("Storing the updated version of the neural network...");
	
	//Set a timeout to show the message (saving mostly takes less than a second, but then the user won't be able to read what's going on)
	setTimeout(function(){
		$.ajax({
			type: "POST",
			url: "../php/save.php?mode=neuralnetwork",
			data: {"network": JSON.stringify(jsonNN)},
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