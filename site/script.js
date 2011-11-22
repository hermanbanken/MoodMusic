$(function(){
	var defaulttext = "Type an artist or track";
	$("#nojs").hide();
	$("#content").show();
	// 	$("a.play").hide();
	// 	
	// 	$("li").hover(function(){
	// 		$(".play", this).show();
	// 	},function(){
	// 		$(".play", this).hide();
	// 	});
	
	$("#tracksearch").attr("value", defaulttext);
	$("#tracksearch").css("color","gray").css("font-style","italic");
	$("#tracksearch").click(function(){ 
		$(this).css("color","black").css("font-style","normal"); 
		if($(this).attr("value") == defaulttext) $(this).attr("value", "");
	});
	
	var options = { 
		serviceUrl:'SpotifyAutoComplete.php', 
		maxHeight: 360,
		width: 300
		};
	var a = $('#tracksearch').autocomplete(options);
});