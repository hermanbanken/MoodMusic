$(function(){
	
	var upload_field 		= $('#upload-field'), 	//Cache upload field
		files  				= new Object(),			//Object to store all files
		default_status 		= "Please drag your audio files to the box below.",	//Default status message
		xhr,
		echonest_url = "http://developer.echonest.com/api/v4/track/upload?api_key=BWXBWVY34MOEXP2CG&filetype=";
		
	//Check if the required API's are available
	if (typeof window.FileReader == undefined || typeof window.FormData == undefined) {
		setStatus("Your browser doesn't support the features required for this app. Please update your browser.", true);
	}
	
	//Handlers
	upload_field.bind({
	    dragover : addDragging,
	    dragend	 : removeDragging,
	    drop	 : getFiles 
	});
	
	$("#submit").click(initUpload);
	$("#cancel").click(cancelUpload);
	$("#cancel").attr("disabled","true");
	
	//Functions
	//Set a status message
	function setStatus(status, permanent){
		$("#status").html(status);
		
		if(!permanent){
			setTimeout(function(){
				$("#status").html(default_status);
			},1500);	
		}
	}
	
	//Changes the appearance of the upload area when a file is dragged over
	function addDragging(){
		upload_field.addClass("dragging"); 
		return false;
	}
	
	//Changes the appearance back to normal when dragging outside of the upload field
	function removeDragging(){
		upload_field.removeClass("dragging"); 
		return false;
	}
	
	//Handles the files when they are dropped into the upload field
	function getFiles(e){
		e = e || window.event;
        e.preventDefault();

        // jQuery wraps the originalEvent, so we try to detect that here...
        e = e.originalEvent || e

		//Remove the dragging class
		removeDragging();

		//Get the files that were dropped
		var droppedFiles = (e.files || e.dataTransfer.files)

		//Loop through the files and store them
		for (var i = 0, f; f = droppedFiles[i]; i++) {
			addFile(f);
		}

		return false;
	}
	
	//Adds a file to the files object and marks it as unuploaded and unanalyzed
	function addFile(file){
		if(filetype = validateType(file)){
			index = Object.keys(files).length;
			
			//Set attributes of files
			file["extension"] = filetype;
			file["uploaded"]  = false;
			file["analyzed"]  = false;
			file["index"]	  = index;
			
			//Add the file to the end of the files array
			files[index] = file;
			
			//Add file to GUI
			$("ul", upload_field).append("<li name=\""+index+"\"><span>"+file.name+"</span><a class=\"delete\">delete</a></li>");
			$("ul li[name='"+index+"'] a.delete", upload_field).click(file, removeFile);

			//Checks if a file is an audio file
			function validateType(file){
				res = file.type.split("/");
				return (res[0] == "audio") ? res[1] : false;
			}
		}else{
			setStatus("You can only add audio files");
		}
	}
	
	//Remove a file form the files list
	function removeFile(e){
		delete(files[e.data.index]);
		
		//Update GUI
		$("li[name='"+e.data.index+"']", upload_field).remove();
	}
	
	//Upload the next file
	function initUpload(){		
		for (var file in files) {
			if(file != undefined && files[file].uploaded == false){
				$("#submit").attr("disabled","true");
				$("#cancel").removeAttr("disabled");
				upload(files[file]);
				break;
			}
		}
	}
	
	function cancelUpload(){
		$("#submit").removeAttr("disabled");	
		$("#cancel").attr("disabled","true");		
		xhr.abort();
	}
	
	//Upload the files
	function upload(file){
		if(file != undefined){
			var	url 	 = echonest_url + file.extension,
				formData = new FormData();

			formData.append('track', file);
			
			xhr = new XMLHttpRequest();
			xhr.open('POST', url, true);

			//GUI
			$("li[name='"+file.index+"']", upload_field).html('<div class="progressbar"><span>0%</span><div></div></div>');
			
			//Update the progress bar
			xhr.upload.onprogress = function(e){
				setProgress(file, (e.loaded / e.total) * 100);
			}

			xhr.upload.onload = function(e){
				//Set the result
				files[file.index].uploaded = true;
				setResult(file, 'uploaded');
				
				//Upload the next file
				// initUpload();
			}
			
			//Set the callback for results returned by the server
			xhr.onload = function(e){
				file.analyzed 	= true;
				json 			= JSON.parse(xhr.responseText);
				file.response 	= json.response;
				
				if(file.response.status.message == "Success"){
					syncResult(file);
				}else{
					setResult(file, 'analyzed');
				}
				
				//Upload the next file
				initUpload();
				
				//Ask the user if he or she wants to leave
				leaveMessage(true);
			}
			
			xhr.onabort = function(){
				$("li[name='"+file.index+"']").html("<span>"+file.name+"</span><a class=\"delete\">delete</a>");
				$("ul li[name='"+file.index+"'] a.delete", upload_field).click(file, removeFile);
			}
			
			//Send the data
			xhr.send(formData);	
		}
	}
	
	function setProgress(file, perc){
		perc = Math.round(perc*10)/10;
		$("li[name='"+file.index+"'] span").html(perc + "%");
		$("li[name='"+file.index+"'] div div").css("width", perc + "%");
	}
	
	function setResult(file, type){	
		if(type == "uploaded"){
			$("li[name='"+file.index+"']", upload_field).html('Analyzing Audio... <img src="ajax-loader.gif" />');
		}else if(type == "analyzed"){
			if(file.response.status.message == "Success"){
				$("li[name='"+file.index+"']").html("Done uploading and analyzing "+file.response.track.title+" by "+file.response.track.artist);
			}else{
				$("li[name='"+file.index+"']").html("Analyzing failed: "+file.response.status.message);
			}
		}else if(type == "sync"){
			$("li[name='"+file.index+"']", upload_field).html('Syncing results with database... <img src="ajax-loader.gif" />');
		}
	}
	
	function leaveMessage(on){
		if(on){
			window.onbeforeunload = leavePage;
		}else{
			window.onbeforeunload = null;
		}
	}
	
	function leavePage(){
		if(!e) e = window.event;
		e.cancelBubble = true;
		e.returnValue = 'If you leave this page, the analyzed data will be lost. Please first process the results. Click cancel to stay on the current page'; //This is displayed on the dialog

		if (e.stopPropagation) {
			e.stopPropagation();
			e.preventDefault();
		}
	}
	
	//Sync teh results with our database
	function syncResult(file){
		setResult(file, 'sync');
		console.log("SyncResult:",file);
		
		setTimeout(function(){
			setResult(file, 'analyzed');
		},3000);
	}
	
});