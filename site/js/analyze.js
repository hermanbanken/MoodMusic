$(function(){
	$("#loader").hide();
	$("#submit").click(function(){
			setStatus("Gathering trainingset from the database...");
			displayLoader(true);
			//Fetch the trainingset from the database
				$.ajax({
						type: "GET",
						url: "../php/get.php?mode=trainingset",
						success: crossValidate,
						error: function(e){
							setStatus("Could not assemble the trainingset, please try reloading the page", true);
						}
					});
		});
	
	function crossValidate(trainingset){
		var stats = brain.crossValidate(brain.NeuralNetwork, {}, trainingset, 5);
		console.log(stats);
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
