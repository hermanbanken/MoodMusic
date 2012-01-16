<?php
	function name($filename) {
	    $file = substr($filename, 0,strrpos($filename,'.'));   
	    return $file;
	}
?>

<script>
	$(function(){
		menu = $("#menu");
		height = - (menu.height() - $("li.menu").outerHeight() + 1);
		
		menu.css("top", height+"px").css("opacity","0.2");
		
		menu.hover(function(){
			menu.stop().animate({top: '0px', opacity: 1}, 600);
			$("li.menu").slideUp();
		},function(){
			menu.stop().animate({top: height, opacity: 0.2}, 400);
			$("li.menu").slideDown();
		});
		
	});
</script>

<ul id="menu">
	<?php foreach (glob("*.php") as $filename) { 
		if(basename($filename) != "menu.php"){ 
	?>
	    <li><a href="<?= $filename ?>"><?= ucfirst(name($filename)) ?></a></li>
	<?php }} ?>
	<li class="menu">Menu</li>
</ul>