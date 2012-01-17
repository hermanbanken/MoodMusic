$(function(){	
	var NN = new brain.NeuralNetwork();
	$("#error-table-container").hide();
	$("#error").click(function(){
		setStatus("");
		$("#error-table-container").slideUp();
		displayLoader(true);
		loadNeuralNetwork();
	});	
		
	function loadNeuralNetwork(){
			setStatus("Loading neural network");
			//Load the text file that contains the neural network and read it into an object
			$.ajax({
				url: "../resources/neuralnetwork.txt",
				success: function(e){ 
					NN.fromJSON(JSON.parse(e));
					//Load the testset
					loadTestSet();
				},
				error: function(e){
					setStatus("The neural network could not be loaded. "+e.responseText, true);
				}
			});
		}

	function loadTestSet(){
			setStatus("Gathering trainingset from the database...");

			// Fetch the trainingset from the database
			$.ajax({
				type: "GET",
				url: "../php/get.php?mode=trainingset",
				success: runTests,
				error: function(e){
					setStatus("Could not assemble the trainingset, please try reloading the page", true);
				}
			});
	}

	//Runs the test set through the neural network
	function runTests(testSet){
		setStatus("Running tests");
		
		var res = new Array();
		var errors = new Object();
		var n = 0; //total number of entries
		var m = 0; //total number of tests
		
		//Loop through the testset
		for(index in testSet){
			test = testSet[index];
			//Pass the test trough the network and save the result
			res[index] = NN.run(test.input);

			//Loop through the results and substitute them with the MSE (so comparing with the desired output)
			for(j in res[index]){
				res[index][j] = Math.pow((res[index][j] - test['output'][j]), 2);
				n++;
			}
			m++;
		}
		
		//Init errors object
		for(mood in res[0]){
			errors[mood] = 0;
		}
				
		//Loop through res and store mse per mood
		for(index in res){
			for(mood in res[index]){
				errors[mood] += res[index][mood];
			}
		}
		
		//Calculate the MSE per category and globally
		var mse = 0;
		for(mood in errors){
			mse += errors[mood];
			errors[mood] = errors[mood]/m;
		}
		mse = mse/n;
		
		console.log(mse,errors);
		displayMSE(mse, errors);
	}
	
	function displayMSE(mse, errors){
		displayLoader(false);
		setStatus("");
		$("#error-table-container").slideDown();
		
		$("#error-table").html("");
		$("#error-table").append("<tr><td>Global MSE</td><td>"+mse+"</td></tr>");
		
		for(mood in errors){
			$("#error-table").append("<tr><td>"+mood+" MSE</td><td>"+errors[mood]+"</td></tr>");
		}
	}
});
