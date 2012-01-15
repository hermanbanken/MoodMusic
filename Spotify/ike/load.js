//var endpoint = "http://home.hermanbanken.nl/ike";
var sp = getSpotifyApi(1);
var models = sp.require('sp://import/scripts/api/models');
var player = models.player;

function IkeApp(){
	var self = this;
	this.endpoint = "http://live/ike";
	this.template = "app";
	this.templates = [];
    console.log("init()");

	$("*").bind('linksChanged', function(){ console.log(this); import_links(); });
	
	self.updateAppView();

	player.observe(models.EVENT.CHANGE, function (e) {
		// Only update the page if the track changed
	    if (e.data.curtrack == true) {
	        self.updatePageTrackDetails();
	    }
	});
	
	make_dropzone(window, function(data){ console.log(data); });
}

IkeApp.prototype.moods = [{'mood': 'sensual'},{'mood': 'tender'},{'mood': 'happy'},{'mood': 'angry'},{'mood': 'tempo'}];

IkeApp.prototype.updateAppView = function(){
	this.get_template('app', function(template){
		$("body").html(Mustache.to_html(template, this));
	});
}
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