//A HTML5 web worker that asynchronously trains a neural network
onmessage = function(e) {
	//Import the nerual network library
	importScripts('brain.js');
	//Make a new neural network that can be trained
	var NN = new brain.NeuralNetwork();
	//Train the neural network
	NN.train(e.data);
	//Return the neural network
	postMessage(NN.toJSON());
};