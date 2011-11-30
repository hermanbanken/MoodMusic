$(function(){
	var holder = document.getElementById('upload-field'),
	state = document.getElementById('status');
	counter = 0;
	
	//Var that holds the files flagged for upload
	upload_files = new Object();

	if (typeof window.FileReader === 'undefined' || typeof window.FormData == 'undefined') {
		//API available
	} else {
		//API unavailable
	}

	holder.ondragover = function () { $("#upload-field").addClass("dragging"); return false; };
	holder.ondragleave = function () { $("#upload-field").removeClass("dragging"); return false; };
	holder.ondrop = function (e) {
		$("#upload-field").removeClass("dragging");
		//Get the files dropped
		var files = e.dataTransfer.files;
		
		//Loop through the files and add them to the page (and store them)
		for (var i = 0, f; f = files[i]; i++) {
			addFile(f);
		}

		return false;
	};
	
	function addFile(file){
		//Add file to upload files
		upload_files[++counter] = file;
		console.log(upload_files);
		
		//Add filename to list
		$("#upload-field ul").append("<li>"+file.name+"<a name=\""+counter+"\" class=\"delete\">delete</a></li>");
		$("#upload-field ul a.delete").unbind('click').click(function(){
			cntr = $(this).attr("name");
			removeFile(cntr);
		})
	}
	
	function removeFile(counter){
		console.log("remove: "+counter);
		delete upload_files[counter];
		$('#upload-field ul a[name="'+counter+'"]').parent().remove();
		console.log(upload_files);
	}
	
	function upload(){
		formdata = new FormData(); 
		
	}
});