	$(function(){
	var value;
	var data;
		
	var defaulttext = "Type an artist or track";
	$("#nojs").hide();
	$("#content").show();
	$("#container").draggable({ 
				containment: 'parent',
				refreshPositions: true,
				stop: function(event, ui) {

	            },
				start: function(event, ui) {

	            }
		});
		
	$("#tracksearch").attr("value", defaulttext);
	$("#tracksearch").css("color","gray").css("font-style","italic");
	$("#tracksearch").click(function(){ 
		$(this).css("color","black").css("font-style","normal"); 
		if($(this).attr("value") == defaulttext) $(this).attr("value", "");
		$("#analyzebutton").attr("disabled","true");
		window.value = window.data = undefined;
	});
	
	var options = { 
		serviceUrl:'SpotifyAutoComplete.php', 
		maxHeight: 360,
		width: 300,
		onSelect: selectTrack
	};
	
	var a = $('#tracksearch').autocomplete(options);
	
	function selectTrack(value, data){
		$("#analyzebutton").removeAttr("disabled");
		
		window.value = value;
		window.data = data;
	}
	
	$("#analyzebutton").click(analyze);
	function analyze(){
		$("#analyzebutton").attr("disabled","true");
		$("#container").append("<p>Analyze:<br>Track: "+window.value+"<br>Link: "+window.data+"</p>");
		
		//Analyze code here!
	}
	
	function update(elem){
		console.log("update")
		elem.css("display","hidden").show("display","block");
	}
});