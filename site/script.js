$(function(){
	
	$("#nojs").hide();
	$("#content").show();
	$("a.play").hide();
	
	$("li").hover(function(){
		$(".play", this).show();
	},function(){
		$(".play", this).hide();
	});
	
});