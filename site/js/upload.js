$(function(){
	
	//Declare variables
	var upload_field 		= $('#upload-field'), 	//Cache upload field
		files  				= new Object(),			//Object to store all files
		default_status 		= "Please drag your audio files to the box below.",	//Default status message
		xhr,
		echonest_url = "http://developer.echonest.com/api/v4/track/upload?api_key=BWXBWVY34MOEXP2CG&bucket=audio_summary&filetype=",
		NN = new brain.NeuralNetwork();
	
	//The files are separated into two sections, the ones that are uploaded and analyzed, and the ones that are only locally linked
	files.local = new Object();
	files.uploaded = new Object();
	
	//Check if the required API's are available
	if (typeof window.FileReader == undefined || typeof window.FormData == undefined) {
		setStatus("Your browser doesn't support the features required for this app. Please update your browser.", true);
	}
	
	//Disable the user interaction until the dependencies are loaded
	disableSubmit();
	disableCancel();
	
	//Bind the handlers (for interaction)
	upload_field.bind({
	    dragover : addDraggingStyle,
	    dragend	 : removeDraggingStyle,
	    drop	 : getFiles 
	});
	
	//Load the text file that contains the neural network and read it into an object
	$.ajax({
		url: "../resources/neuralnetwork.txt",
		success: function(e){ 
			NN.fromJSON($.parseJSON(e));
		},
		error: function(e){
			setStatus("The neural network could not be loaded.", true);
		}
	});
	
	function enableSubmit(){
		if(!$("#submit").click()){
			$("#submit").click(startUpload);
			$("#submit").removeAttr("disabled");
		}
	}
	
	function disableSubmit(){
		if(!$("#submit").attr("disabled")){
			$("#submit").unbind('click');
			$("#submit").attr("disabled","true");
		}
	}
	
	function enableCancel(){
		if($("#cancel").attr("disabled")){
			$("#cancel").click(cancelUpload);
			$("#cancel").removeAttr("disabled");
		}
	}
	
	function disableCancel(){
		if(!$("#cancel").attr("disabled")){
			$("#cancel").unbind('click');
			$("#cancel").attr("disabled","true");
		}
	}
	

	//Displays a message to the user for 1.5 seconds or permanently
	function setStatus(status, permanent){
		$("#status").html(status);

		if(!permanent){
			setTimeout(function(){
				$("#status").html(default_status);
			},1500);	
		}
	}

	//Changes the appearance of the upload area when a file is dragged over
	function addDraggingStyle(){
		upload_field.addClass("dragging"); 
		return false;
	}

	//Changes the appearance back to normal when dragging outside of the upload field
	function removeDraggingStyle(){
		upload_field.removeClass("dragging"); 
		return false;
	}

	//Handles the files when they are dropped into the upload field
	function getFiles(e){
		//Depends on jQuery which var holds the actual files
	    e = e.originalEvent || e

		//Remove the dragging style
		removeDraggingStyle();

		//Get the files that were dropped
		var droppedFiles = (e.files || e.dataTransfer.files)

		//Loop through the files and store them
		for (var i = 0, f; f = droppedFiles[i]; i++) {
			addFile(f);
		}

		return false;
	}
	
	//Adds the file to the files
	function addFile(file){
		if(filetype = isAudio(file)){
			//Calculate the index of the new song (all songs have indecis 0-n, so this songs' index will be n+1)
			index = Object.keys(files.local).length;
			//Add the file to the files object
			files.local[index] = file;
			//Redraw the upload field so that the file is displayed to the user
			redrawUploadField();
			//Enable the submit button
			enableSubmit();
		}else{
			setStatus("You can only add audio files");
		}
		
		//Checks if a file is an audio file
		function isAudio(file){
			res = file.type.split("/");
			return (res[0] == "audio") ? res[1] : false;
		}
	}
	
	//Handler which gets fired when deleting a file from the upload field
	function deleteFileHandler(event){
		removeFile(event.data);
		redrawUploadField();
	}
	
	//Removes a file with a certain index from the files object
	function removeFile(index){
		delete(files.local[index]);
	}
	
	//Redraws the list of songs to be uploaded in the upload field
	function redrawUploadField(){
		//Delete the content in the upload field
		$("ul", upload_field).html("");
		
		//Loop through all the files
		for(index in files.local){
			file = files.local[index];
			
			//Add the content
			$("ul", upload_field).append("<li name=\""+index+"\"><span>"+file.name+"</span><a class=\"delete\">delete</a></li>");

			//Bind the click handler for the delete button
			$("ul li[name='"+index+"'] a.delete", upload_field).click(index, deleteFileHandler);
		}
	}
	
	//Start uploading the files to echonest
	function startUpload(){
		//Loop through the files that need to be uploaded
		for (index in files.local) {
			upload(files.local[index]);
		}
	}

	function cancelUpload(){
		
	}
});



