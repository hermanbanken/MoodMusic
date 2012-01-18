$(function(){
	
	//Declare variables
	var APIKEY = "BWXBWVY34MOEXP2CG",
		upload_field 		= $('#upload-field'), 	//Cache upload field
		files  				= new Object(),			//Object to store all files
		default_status 		= "Drag the audio files that you want to add to the program into this box and press the 'Upload and Analyze' button",	//Default status message
		xhr,
		echonest_url = "http://developer.echonest.com/api/v4/track/upload?api_key="+APIKEY+"&bucket=audio_summary&filetype=",
		NN = new brain.NeuralNetwork();
	
	//The files are separated into three sections, the ones that are uploaded and analyzed, the oea that have failed and the ones that are only locally linked
	files.local = new Object();
	files.uploaded = new Object();
	files.failed = new Object();

	//Check if the required API's are available
	if (typeof window.FileReader == undefined || typeof window.FormData == undefined) {
		setStatus("Your browser doesn't support the features required for this app. Please update your browser.", true);
	}
	
	//Disable the user interaction until the dependencies are loaded
	disableSubmit();
	disableCancel();
	
	//Load the text file that contains the neural network and read it into an object
	$.ajax({
		url: "../resources/neuralnetwork.txt",
		success: function(e){ 
			NN.fromJSON(JSON.parse(e));

			//Bind the handlers (for interaction)
			upload_field.bind({
			    dragover : addDraggingStyle,
			    dragend	 : removeDraggingStyle,
			    drop	 : getFiles 
			});
		},
		error: function(e){
			setStatus("The neural network could not be loaded.", true);
		}
	});
	
	function enableSubmit(){
		$("#submit").unbind('click');
		$("#submit").click(startUpload);
		$("#submit").removeAttr("disabled");
	}
	
	function disableSubmit(){
		$("#submit").unbind('click');
		$("#submit").attr("disabled","true");
	}
	
	function enableCancel(){
		$("#cancel").unbind('click');
		$("#cancel").click(cancelUpload);
		$("#cancel").removeAttr("disabled");
	}
	
	function disableCancel(){
		$("#cancel").unbind('click');
		$("#cancel").attr("disabled","true");
	}

	//Displays a message to the user for 1.5 seconds or permanently
	function setStatus(status, permanent){
		$("#status").hide();
		$("#status").html(status);
		$("#status").fadeIn();

		if(!permanent){
			setTimeout(function(){
				$("#status").fadeOut(function(){
					$("#status").html(default_status);
				});
			},1500);	
		}
	}

	//Changes the appearance of the upload area when a file is dragged over
	function addDraggingStyle(){
		upload_field.parent().addClass("dragging"); 
		return false;
	}

	//Changes the appearance back to normal when dragging outside of the upload field
	function removeDraggingStyle(){
		upload_field.parent().removeClass("dragging"); 
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
	
	// Try to match ID3v1 tags from mp3 to Echonest
	function tagsToEchonest(tags, cb){
		var s = tagsToEchonest.status;
		if(!tags.artist){
			cb(s.NO_ARTIST, null);
			return;
		}
		var url = "http://developer.echonest.com/api/v4/" + (tags.title && "song" || "artist") + "/search";
		var data = {
		    api_key: APIKEY, format: "jsonp", results: 1,
		    artist: tags.artist,
		};
		if(tags.title){
			data.title = tags.title;
			data.bucket = "audio_summary";
		}
		
		$.ajax(url, {
			data: data, 
			dataType: 'jsonp',
			success: function(info, t, xhr){
				if(info.response.status.code == 0){
					if(info.response.songs && info.response.songs.length > 0)
						cb(s.SUCCESS, info.response.songs[0]);
					if(info.response.artists && info.response.artists.length > 0)
						cb(s.SUCCESS, info.response.artists[0]);
				} else cb(s.UNKNOWN_ERROR, null);
			},
			error: function(){
				cb(s.AJAX_ERROR, null);
			}
		});
	}
	tagsToEchonest.status = {
		SUCCESS: 0,
		UNKNOWN_ERROR: 1,
		NO_ARTIST: 2,
		NOT_FOUND: 3,
		AJAX_ERROR: 4,
	};
	//tagsToEchonest({ title: "On The Floor", artist: "Jennifer Lopez"}, function(s,d){
	//	console.log(s, d);
	//});
	
	//Adds the file to the files
	function addFile(file){
		if(filetype = isAudio(file)){
			//Add the extension to the file
			file["extension"] = filetype;
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
		
		//First add all failed files, then the finished files, then the local files
		if(Object.keys(files.failed).length > 0){
			for(index in files.failed){
				file = files.failed[index];

				//Add the content
				reason = file.reason ? "("+file.reason+")" : "";
				$("ul", upload_field).append("<li name=\"failed-"+index+"\">Failed to analyze <em>"+file.name+"</em> "+reason+" </li>");
			}

			$("ul", upload_field).append("<hr>");
		}
		
		if(Object.keys(files.uploaded).length > 0){
			for(index in files.uploaded){
				file = files.uploaded[index];
			
				//Add the content
				$("ul", upload_field).append("<li name=\"uploaded-"+index+"\">Done uploading and analyzing <em>"+file.response.track.title+"</em> by <em>"+file.response.track.artist_name+"</em></li>");
			}
		
			$("ul", upload_field).append("<hr>");
		}
		
		if(Object.keys(files.local).length > 0){
			//Loop through all the files
			for(index in files.local){
				file = files.local[index];
			
				//Add the content
				$("ul", upload_field).append("<li name=\""+index+"\"><span>"+file.name+"</span><a class=\"delete\">delete</a></li>");

				//Bind the click handler for the delete button
				$("ul li[name='"+index+"'] a.delete", upload_field).click(index, deleteFileHandler);
			}
			
			//Remove the status
			$("#status").fadeOut();
			enableSubmit();
			disableCancel();
		}else{
			$("#status").fadeIn();
			disableSubmit();
			disableCancel();
		}
	}
	
	//Start uploading the files to echonest
	function startUpload(){
		console.log("Start Upload");
		//Ask the user if he or she wants to leave (and abort the upload process)
		leaveMessage(true);
		
		//Change the handlers
		enableCancel();
		disableSubmit();
		
		//Upload the first file
		for(index in files.local) {
			// Alternative analyse method: uploading to EchoNest
			var file = files.local[index],
				cb_alt = function(){ upload(file, index); };
				cb_suc = function(echo_data){
					file.response = {track: echo_data};
					syncResult(file, index);
				};
			// ID3 analyse method
			ID3.loadTags(files.local[index], function(){
				// Try to get loaded tags
				var tags = ID3.getAllTags(file.name);
				// Search on Echonest with these tags
				tagsToEchonest(tags, function(code, data){
					if(code == 0)
						cb_suc(data);
					else
						cb_alt();
				});
			});
			break;
		}
		
		if(Object.keys(files.local).length == 0) leaveMessage(false);
	}
	
	function leaveMessage(toggle){
		if(toggle){
			$(window).unbind('beforeunload').bind('beforeunload', function() { return "Leaving the page will abort the current upload" });
		}else{
			$(window).unbind('beforeunload');
		}
	}
	
	//Upload the file to echonest
	function upload(file, index){
		if(file != undefined){
			console.log("upload(",file,index,")");
			var	url 	 = echonest_url + file.extension,
				formData = new FormData();
				
			//Add the file to the data that will be sent to echonest
			formData.append('track', file);
			
			//Create a new HTTPRequest to upload the files
			xhr = new XMLHttpRequest();
			xhr.open('POST', url, true);

			//Update the progress bar
			xhr.upload.onprogress = function(e){
				setProgress(index, (e.loaded / e.total) * 100);
			}
			
			//The file is uploaded to echonest
			xhr.upload.onload = function(e){
				setResult(index, 'uploaded', file);
			}
			
			//The file is analyzed and returned by echonest
			xhr.onload = function(e){
				//read the response by echonest and store it in the file
				json 			= JSON.parse(xhr.responseText);
				file.response 	= json.response;

				//Check if the analysis was successful
				if(file.response.status.message == "Success"){
					console.log("Uploaded and analyzed successfully!");
					//Sync the results with the database
					syncResult(file, index);
				}else{
					console.log("Uploading and analyzing failed");
					newIndex = Object.keys(files.uploaded).length;
					files.failed[newIndex] = files.local[index];
					files.failed[newIndex]['reason'] = "analyzing failed at EchoNest";
					delete(files.local[index]);
					redrawUploadField();
					startUpload();
				}
			}
			
			xhr.onabort = function(){
				redrawUploadField();
			}
			
			//Try to send the data
			try{
				xhr.send(formData);			
			}catch(e){
				//move the file from the local to the failed section of the files object
				newIndex = Object.keys(files.uploaded).length;
				files.failed[newIndex] = files.local[index];
				files.failed[newIndex]['reason'] = "error while uploading the song to EchoNest "+e.responseText;
				delete(files.local[index]);
				
				redrawUploadField();
				startUpload();
			}
		}
	}
	
	//Show a progressbar that indicates the progress of an upload
	function setProgress(index, perc){
		perc = Math.round(perc*10)/10;
		$("li[name='"+index+"']", upload_field).html('<div class="progressbar"><span>'+perc+'%</span><div></div></div>');
		$("li[name='"+index+"'] div div").css("width", perc + "%");
	}

	//Cancel the current upload
	function cancelUpload(){
		leaveMessage(false);
		disableCancel();
		enableSubmit();
		xhr.abort();
	}
	
	//Displays a message about the status of the current upload
	function setResult(index, type, file){	
		console.log("setResult: "+type,file);
		if(type == "uploaded"){
			$("li[name='"+index+"']", upload_field).html('Analyzing Audio... <img src="../resources/ajax-loader.gif" />');
		}else if(type == "sync"){
			$("li[name='"+index+"']", upload_field).html('Syncing results with database... <img src="../resources/ajax-loader.gif" />');
		}else if(type == "nn"){
			$("li[name='"+index+"']", upload_field).html('Passing through Neural Network... <img src="../resources/ajax-loader.gif" />');
		}
	}
	
	//Save the results to the database
	function syncResult(file, index){
		console.log("syncResult(",file,index,")");
		
		//Pass the results through the Neural Network
		setResult(index, "nn", file);
		as = file.response.track.audio_summary;
		res = NN.run({"audiokey": as.key/11, "mode": as.mode, "time_signature": as.time_signature, "loudness": (as.loudness+100)/200, "energy": as.energy, "tempo": as.tempo/500, "danceability": as.danceability});

		//Sync the results with the database
		setResult(index, 'sync', file);
		console.log("Sent to php:",{"res": res, "file": file.response});
		$.ajax({
			type: "POST",
			url: "../php/save.php?mode=upload", 
			data: {"res": res, "file": file.response.track},
			success: function(e){ //Everything is done
				console.log("Synced With DB");
				
				//move the file from the local to the uploaded section of the files object
				newIndex = Object.keys(files.uploaded).length;
				files.uploaded[newIndex] = files.local[index];
				delete(files.local[index]);
				
				redrawUploadField();
				startUpload();
			},
			error: function(e){
				//move the file from the local to the failed section of the files object
				newIndex = Object.keys(files.uploaded).length;
				files.failed[newIndex] = files.local[index];
				files.failed[newIndex]['reason'] = "error while syncing with the database: "+e.responseText;
				delete(files.local[index]);
				
				redrawUploadField();
				startUpload();
			}
		});
	}
});