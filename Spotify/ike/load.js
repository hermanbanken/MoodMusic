//var endpoint = "http://home.hermanbanken.nl/ike";
var sp = getSpotifyApi(1);
var storage = sp.require('sp://import/scripts/storage'),
	schema = sp.require('sp://import/hermes/discovery'),
	util = sp.require('sp://import/scripts/util'),
	dom = sp.require('sp://import/scripts/dom'),
	array = sp.require('sp://import/scripts/array'),
	fx = sp.require('sp://import/scripts/fx'),
	ui = sp.require('sp://import/scripts/ui'),
	cf = sp.require('sp://import/scripts/coverflow'),
	lang = sp.require('sp://import/scripts/language'),
	catalog = lang.loadCatalog('cef_views'),
	_ = partial(lang.getString, catalog, "What's New"),
	p = sp.require('sp://import/scripts/pager'),
	r = sp.require('sp://import/scripts/react'),
	models = sp.require("sp://import/scripts/api/models"),
	views = sp.require("sp://import/scripts/api/views"),
	presence = sp.require("sp://import/scripts/presence");
var player = models.player;

function IkeApp(){
	var self = this;
	this.endpoint = "http://live/ike";
	this.template = "app";
		
	self.updateAppView();

	player.observe(models.EVENT.CHANGE, function (e) {
		// Only update the page if the track changed
	    if (e.data.curtrack == true) {
	        self.updatePageTrackDetails();
	    }
	});
	
	this.col = new models.Album();
	//this.col.tracks[0] = player.track;
	
	//this.list = new views.List(this.col, false, false);
	//window.list = this.list;
	
	// Handle incoming links
	make_dropzone(window, function(links){
		if(typeof links !== 'object') links = [links];
		for(var i = 0; i < links.length; i++){
			links[i] = links[i].replace(/^.*\/([a-z]+)\/([A-Za-z0-9]+)$/, "spotify:$1:$2");
		}
		self.dropLinks(links);
	});
	sp.core.addEventListener('linksChanged', function(){
		self.dropLinks(sp.core.getLinks());
	});
}

IkeApp.prototype.dropLinks = function(links){
	var self = this;
	links.map(function(item){
		var type = sp.core.getLinkType(item);
		switch(type){
			case models.Link.TYPE.TRACK:
			console.log("Track");
			break;
		}
		debugger;
		console.log("Iterating over", item);
		
	});
	
	
};

IkeApp.prototype.exportCollections = function(songs, artists){
	$.post(this.endpoint + '/import/spotify_collection', {'songs':songs, 'artists':artists}, function(data){ console.debug('Imported', data); });
};
IkeApp.prototype.convertToRemoteObject = function(item){
	console.log("Local Object", item);
	
	if(typeof item.data != 'undefined')	
		item = item.data;
	
	if (item.type == 'track'){
		if(typeof item.id != 'undefined')	
 	   		delete item.id;
 	   
		if(typeof item.artists != 'undefined'){
			item.artist = this.convertToRemoteObject(item.artists[0]);
		}
 	   
		item.title = item.name;
	} else if (item.type == 'artist'){
		// Pretty much done already
	} else if (item.type == 'album'){
		var album = models.Album.fromURI(item.uri, function(album) {
		    var player = new v.Player();
		    player.track = trackObj;
		    album.get = function() {
		        return trackObj;
		    }
		    player.context = album;
		    document.body.appendChild(player.node);
		});
		window.alb = item;
		return null;
	} else {
		return null;
	}
 	item.spotify_id = item.uri.replace(/(.*:)/, "");

	return item;
};

IkeApp.prototype.moods = [{'mood': 'sensual'},{'mood': 'tender'},{'mood': 'happy'},{'mood': 'angry'},{'mood': 'tempo'}];

IkeApp.prototype.updateAppView = function(){
	this.get_template('app', function(template){
		$("body").html(Mustache.to_html(template, this));
	});
};
IkeApp.prototype.updatePageTrackDetails = function updatePageTrackDetails(){
	$(document.body).html("Updated page.");
	console.log(player);
};

IkeApp.prototype.import_links = function import_links(){
	var links = sp.core.getLinks();
	for(var i = 0; i < links.length; i++){
		var types = [0, 1, 2, 3, "track", "playlist", 6, 7, 8, 9, "user"];
		var type = types[sp.core.getLinkType(links[i])];
		$(document.body).append("<p>Dropped: "+sp.core.getLinkType(links[i])+" - "+links[i]+"</p>");
	}
};

IkeApp.prototype.get_template = function get_template(template, callback){
	var self = this;
	function get(name){
		localStorage.getItem("templates/"+name);
	}
	
	// Already saved
	if(get(template)) callback(get(template));
	
	// Update or fetch
	$.get(this.endpoint + '/static/templates/'+ template + '.mustache', function(data, status, xhr){
		var date = (new Date(xhr.getResponseHeader("Last-Modified"))).getTime();
		if(!get(template+"-date") || date > get(template+"-date")){
			localStorage.setItem("templates/"+template, data);
			localStorage.setItem("templates/"+template+"-date", date);
			callback(data);
		}
	});
};

function cancel(e) {
  if (e.preventDefault) {
    e.preventDefault();
  }
  return false;
}

function make_dropzone(drop, callback){
	var self = this;
	
	// Tells the browser that we *can* drop on this target
	drop.addEventListener('dragover', cancel);
	drop.addEventListener('dragenter', cancel);
	
	// Callback
	drop.addEventListener('drop', function (e) {
		if (e.preventDefault) e.preventDefault(); // stops the browser from redirecting off to the text.
		
		callback.call(self, e.dataTransfer.getData('Text'));
		return false;
	});
}

var app = new IkeApp();