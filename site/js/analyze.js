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
				url: "../php/get.php?mode=testset",
				success: runTests,
				error: function(e){
					setStatus("Could not assemble the trainingset, please try reloading the page. "+e.responseText, true);
				}
			});
	}

	//Runs the test set through the neural network
	function runTests(testSet){
		setStatus("Running Mean Squared Error + Effective Error Test");
		
		mseres = findMSE(testSet);
		err = effectiveError(testSet);
		
		displayErrors(err, mseres.mse, mseres.errors);
	}
	
	function findMSE(testSet){
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

			//Loop through res and store the sum of all mse's per mood
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
			
			return {mse: mse, errors: errors};
	}
	
	//Find the percentage of false moods from the network
	function effectiveError(testSet){
		win = 0; //Amount of good outputs of the network
		fail = 0; //aMount of bad outputs of the network
		res = new Array();

		//feed the testset to the network and store the results
		//Loop through the testset
		for(index in testSet){
			test = testSet[index];
			//Pass the test trough the network and save the result
			res[index] = NN.run(test.input);
			
			//Calculate the resulting mood that the network would choose vs the mood that is given by our trainingset
			netwin = calcWinner(res[index]);
			outputwin = calcWinner(test.output);
						
			//Loop rhoguh one array of winners and chek if there is a matching value (testset output: [happy,sad] and network output: [sad] should result in a positive result since sad is in the acceptable results from the testset)
			correct = false;
			for(index in netwin){
				if($.inArray(netwin[index],outputwin) != -1){
					correct = true;
					break;
				}
			}
			
			//Add the result to the appropriate counter
			correct ? win++ : fail++;
		}
		return fail/(win+fail);
	}
	
	//Calculate the resulting mood from an output of the neural network
	function calcWinner(output){		
		winners = new Array();
		for(mood in output){
			if(output[mood] > 0.3){
				winners.push(mood);
			}
		}
		return winners;
	}
	
	function displayErrors(err, mse, errors){
		displayLoader(false);
		setStatus("");
		$("#error-table-container").slideDown();
		
		$("#error-table").html("");
		$("#error-table").append("<tr><td>Effective Error</td><td>"+err*100+"%</td></tr>");
		$("#error-table").append("<tr><td>Global MSE</td><td>"+mse+"</td></tr>");

		for(mood in errors){
			$("#error-table").append("<tr><td>"+mood+" MSE</td><td>"+errors[mood]+"</td></tr>");
		}
	}
});
