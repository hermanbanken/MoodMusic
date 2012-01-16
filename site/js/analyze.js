$(function(){	
	$("#error").click(function(){
		displayLoader(true);
		loadNeuralNetwork();
	});	
	
	
	function loadNeuralNetwork(){
		//Load the text file that contains the neural network and read it into an object
		$.ajax({
			url: "../resources/neuralnetwork.txt",
			success: function(e){ 
				var NN = new brain.NeuralNetwork();
				NN.fromJSON(e);
				console.log(NN);
			},
			error: function(e){
				setStatus("The neural network could not be loaded.", true);
			}
		});
	}
	
	// function loadNeuralNetwork(){
	// 		setStatus("Loading neural network");
	// 		//Load the text file that contains the neural network and read it into an object
	// 		$.ajax({
	// 			url: "../resources/neuralnetwork.txt",
	// 			success: function(e){ 
	// 				//Generate the network
	// 				net.fromJSON({"layers":{"1":{"nodes":[{"weights":{"audiokey":"-2.193289436369808","mode":"-9.182152628938086","time_signature":"6.672549958938793","loudness":"-12.654211992248042","energy":"-39.34757683524137","tempo":"4.149075588543718","danceability":"37.86734798634846"},"bias":"-10.83983495421021"},{"weights":{"audiokey":"10.395757370686544","mode":"10.754233182143505","time_signature":"-6.947439307229101","loudness":"31.159104734991143","energy":"26.657737451795345","tempo":"-24.531554433887255","danceability":"-30.24914833706438"},"bias":"7.432965359051905"},{"weights":{"audiokey":"-12.770953968472773","mode":"16.83249376940891","time_signature":"-4.8705034504966065","loudness":"-5.991173803482026","energy":"22.31519474294793","tempo":"6.071034998552022","danceability":"-22.708582948092978"},"bias":"8.59924748971907"},{"weights":{"audiokey":"1.9437715692666275","mode":"-1.571445787993288","time_signature":"-4.146141142427611","loudness":"1.3318466212954816","energy":"1.1381575474290926","tempo":"0.49067029266884943","danceability":"-0.48349701498945824"},"bias":"2.717872979259389"}]},"2":{"nodes":{"happy":{"weights":["-23.58929451307868","-9.21754469590136","-19.328662034616155","-1.6031180340946385"],"bias":"22.761794681365124"},"sad":{"weights":["5.828256675726147","5.738371268191686","5.756490529475079","-5.5290057194597"],"bias":"-8.203736831958416"},"cheerful":{"weights":["-0.616737396560912","-21.225702848574034","15.807507212116601","-2.145896956201944"],"bias":"1.1386316265590963"},"funny":{"weights":["10.96494982044179","1.913988487465586","-5.573766615657597","-1.6547693624523767"],"bias":"-12.557428603346338"}}}}});
	// 				res = net.run({"audiokey":0.545454545455,"mode":0,"time_signature":4,"loudness":0.476705,"energy":0.596926,"tempo":0.180036,"danceability":0.674453});
	// 				// console.log(res);
	// 				//Load the testset
	// 				// loadTestSet();
	// 			},
	// 			error: function(e){
	// 				setStatus("The neural network could not be loaded. "+e.responseText, true);
	// 			}
	// 		});
	// 	}

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
		console.log(JSON.stringify(testSet[0].input));
		// {"audiokey":0.545454545455,"mode":0,"time_signature":4,"loudness":0.476705,"energy":0.596926,"tempo":0.180036,"danceability":0.674453}
		// res = net.run(testSet[0].input);
		
		// for(index in testSet){
		// 	test = testSet[index];
		// 	console.log(JSON.stringify(test.input));
		// 	// console.log(NN);
		// 	res = NN.run(test.input);
		// 			// console.log(res);
		// 	// 		console.log(test.output);
		// }

		// console.log("runtTEsts");
		// console.log(testSet);
		// setStatus("Testing network 0/0");
	}
});
