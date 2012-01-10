var q;
$(function($){
	var postUrl = "../scripts/nextsong.json.php",
		getUrl = "";
		
	Function.prototype.bind = function(scope) {
		var _function = this;
    	
		return function() {
			return _function.apply(scope, arguments);
		}
	}
	
	$.fn.Qualify = function Qualify(){
		for(n in {'next':1, 'button':1}) this[n] = this[n].bind(this);
	
		this.element = $("<div><div class='song'></div><form><input type='button' value='Opslaan' id='do-store' /><input type='button' value='Delete' id='do-delete' /></form></div>").appendTo("body");
    
		$("#do-store").click(this.button);
		$("#do-delete").click(this.button);
    	
		// First song
		$.get('../scripts/nextsong.json.php', this.next);
		
		// Rotation stuff
		var rotation = 0;
		var speed = 0;
		var timeout = 0;
		$(window).keydown(hold);
		function hold(e){
			console.log(speed, rotation, e.keyCode);
			speed+=4;
			if(e.keyCode == 37)
				rotation += speed;
			else if(e.keyCode == 39)
				rotation -= speed;
			q.rotate(rotation%360);
		}
		$(window).keyup(function(){
			speed = 0;
			console.log("Stop");
		});
		
		//this.element.delegate(".features .mood", "hover", function(){
		//	q.rotate(this.dataset.i*360);
		//});
	}
    
	$.fn.Qualify.prototype.next = function(data){
		this.song = new $.fn.Song(data, this);
		$(this.element).find('.song').replaceWith(this.song.element());
	}
	$.fn.Qualify.prototype.button = function(data){
		if(data == false)
			this.song.del();
		else 
			this.song.qualify();
	}
	$.fn.Qualify.prototype.rotate = function(deg){
		$('.features').css('webkitTransform', 'rotate('+deg+'deg)').children().css('webkitTransform', 'rotate('+(-1*deg)+'deg)');
	}
	
	$.fn.Song = function Song(data, box){
		for(n in {'qualify':1, 'del':1, 'element':1}) this[n] = this[n].bind(this);
	
		for(n in data){
			this[n] = data[n];
		}
		this.moods = {};
		this.box = box;
	}
	
	$.fn.Song.prototype.qualify = function(){
		var box = this.box;
		$.post(postUrl, {id: this['echonest.id'], mood: this.moods }, function(data) {
			box.next(data);
		});
	}
	$.fn.Song.prototype.del = function(){
		var box = this.box;
		$.post(postUrl, {id: this['echonest.id'], remove: "ok"}, function(data) {
			box.next(data);
		});
	}
	$.fn.Song.prototype.element = function(){
		var el = $("<div class='song'><div class='preview'><h1><span id='title'></span> - <span id='name'></span></h1>"+
				"<iframe id='ytvideo' width='300' height='300' src='' frameborder='0' allowfullscreen></iframe>"+
        		"</div><div class='features'></div></div>");
		var feat = [
			{"name": "aggressive"}, {"name": "ambient"}, {"name": "angst-ridden"}, {"name": "bouncy"}, {"name": "calming"}, {"name": "carefree"}, 
			{"name": "cheerful"}, {"name": "cold"}, {"name": "complex"}, {"name": "cool"}, {"name": "dark"}, {"name": "disturbing"}, {"name": "dramatic"}, 
			{"name": "dreamy"}, {"name": "elegant"}, {"name": "energetic"}, {"name": "enthusiastic"}, {"name": "epic"}, {"name": "fun"}, {"name": "funky"}, 
			{"name": "futuristic"}, {"name": "gentle"}, {"name": "gloomy"}, {"name": "groovy"}, {"name": "happy"}, {"name": "harsh"}, 
			{"name": "humorous"}, {"name": "hypnotic"}, {"name": "intense"}, {"name": "intimate"}, {"name": "joyous"}, 
			{"name": "light"}, {"name": "lively"}, {"name": "meditation"}, 
			{"name": "mystical"}, {"name": "party music"}, {"name": "passionate"}, {"name": "peaceful"}, 
			{"name": "playful"}, {"name": "quiet"}, {"name": "relax"}, {"name": "romantic"}, {"name": "sad"}, 
			{"name": "sentimental"}, {"name": "sexy"}, {"name": "smooth"}, {"name": "sophisticated"}, {"name": "spacey"}, {"name": "spiritual"}, {"name": "strange"}, 
			{"name": "sweet"}, {"name": "trippy"}, {"name": "warm"}];
		var table = el.find(".features");
		$.each(feat, function(i, ob){
			var r = 300;
			var x = Math.cos(Math.PI*2/feat.length*i)*r;
			var y = Math.sin(Math.PI*2/feat.length*i)*r;
			var span = $("<span class='mood' data-id='"+ob.name+"' data-i='"+(i/feat.length)+"'>"+ob.name+" (0)</span>").css({'left':x+'px', 'top':y+'px'});
			table.append(span);
		});
		var song = this;
		
		// Qualify
		el.delegate(".mood", "click", function(event){
			if(!song.moods[this.dataset.id]) song.moods[this.dataset.id] = 0;
			song.moods[this.dataset.id] += event.shiftKey ? -1 : 1;
			this.innerHTML = this.dataset.id + " ("+song.moods[this.dataset.id]+")";
			if(song.moods[this.dataset.id] != 0) $(this).addClass('sel');
			else $(this).removeClass('sel');
		});
		
		// Details
		$('#title', el).text(this['echonest.title']);
		$("#name", el).text(this['echonest.artist_name']);
		// Vid
		$.get('https://gdata.youtube.com/feeds/api/videos?q='+song['echonest.artist_name']+'+'+this['echonest.title']+'&alt=json', function(ret){
			el.find("#ytvideo").attr('src', "http://www.youtube.com/embed/"+ret.feed.entry[0].id.$t.replace("http://gdata.youtube.com/feeds/api/videos/",""));
		});
		
		return el;
	}

	q = new $.fn.Qualify();
	
});