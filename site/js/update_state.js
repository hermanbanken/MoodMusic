/*function init() {
	var host = "ws://live:81337/hoi";
	try {
		socket = new WebSocket(host);
		socket.onopen = function(msg){ };
		socket.onmessage = function(msg){
			eval('var data = ' + msg.data + ';');
			for (userId in data) {
				if (data[userId].position) {
					var pos = data[userId].position.split(',');
					var color = data[userId].color;
					render(userId, pos[0], pos[1], color);
				}
			}
			dump(data);
		};
		socket.onclose = function(msg){ };
	} catch(ex){ console.log(ex); }
 
	$('body').bind('mousemove', function(evt){
		send(evt.clientX, evt.clientY);
	});
}
init();*/
var history = {'list':[], 'level': -1};
function update_state(state){
	var keys = ['i', 'total', 'level', 'title', 'message'];
	var current = {};
	for(n in state['state']){
		current[keys[n]] = state['state'][n];
	}
	history.total = state.totals;
	history['list'].push(current);
	
	// Change levels
	if(history.level < current.level){
	  state_open(current);
	} else if(current.level < history.level) {
		for(var i = history.level - current.level; i >= 0; i--) state_close();
	} 
	// Add progress
	if(history.list.length > 30) debugger;
	bar(~~((current.i+1) / current.total * 100), current.total, current.message, 'bar' + current.title, current.title);
	state_progress(current);
	
	history.level = current.level;
}

function bar(percentage, totals, message, id, name){
	var bar = document.getElementById(id ? id : 'bar');
	if(!bar){
		var h = document.body.appendChild(document.createElement('h2'));
		h.innerHTML = name;
		bar = document.body.appendChild(document.createElement('div'));
		bar.innerHTML = "<div class='done'></div><div class='status'></div>";
		bar.className = 'progressbar';
		bar.id = id;
	}else{
		bar.getElementsByClassName('status')[0].innerHTML = percentage + '% of '+totals+' items. <span>'+message+'</span>';
		if(typeof percentage == 'number' && totals > 0)
		bar.getElementsByClassName('done')[0].style.left = (-100 + percentage) + '%';
		if(percentage == 100){
			bar.className += ' complete';
			bar.previousSibling.className += ' complete';
		}
	}	
}

function state_open(state){
	var states = document.getElementsByClassName('state');
	if(states.length == 0){
		document.body.innerHTML += "<div id='current-state' class='state'></div>";
	} else {
		var current = document.getElementById('current-state');
		current.id = '';
		current.innerHTML += "<div class='state' id='current-state'></div>";
	}
}
function state_close(){
	var current = document.getElementById('current-state');
	current.id = '';
	current.parentNode.id = 'current-state';
}
function state_progress(progress){
	var current = document.getElementById('current-state');
	var h = "<div class='progress'><h3>"+progress.message+"</h3>";
	h +=    "<div class='percentage'>"+ (progress.i) + "</div><div class='total'>/ "+progress.total+"</div></div>";
	
	current.innerHTML += h;
}