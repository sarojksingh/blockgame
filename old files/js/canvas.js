// Our main global objects get defined here
//var canvas = {};
//var bg_image = document.getElementById("canvas_bg");
/**
* Initial function to setup the canvas
*
* @since Canvas Pong 1.0
*/
var canvasTimer; 
canvas.init = function () {
    "use strict";
	clearInterval(canvasTimer);
    this.instance = document.getElementById('canvas');
    this.context = canvas.instance.getContext('2d'); 
};

/**
* Initial canvas draw and set an interval so the canvas can redraw itself every
* 20 milliseconds.
*
* @since Canvas Pong 1.0
*/
canvas.start = function () {
    "use strict";
    canvas.redraw(canvas.context, canvas.instance);

    canvasTimer = setInterval(canvas.redraw, 2);
    //setTimeout(canvas.redraw, 5000);
};

/**
* Draws a single frame for the canvas
*
* @since Canvas Pong 1.0
*/
canvas.redraw = function () {
    "use strict";

    var context = canvas.context;
    var instance = canvas.instance;

    // Clear the canvas so we can redraw it
    context.fillStyle = "#000";
	context.clearRect(gameObjects.ball.x,gameObjects.ball.y,gameObjects.ball.width,gameObjects.ball.width);
    context.clearRect(0, 0, instance.clientWidth, instance.clientHeight);

    // Make the background black
    //context.fillStyle = "#000";
    //context.drawImage(bg_image, 0, 0, instance.clientWidth, instance.clientHeight);
	
	//Ashish added form setting context start
    context.fillStyle = '#5272b2';
    context.font = '34px hvd_comic_serif_proregular';
    context.textAlign = 'center';
	
	//Ashish added form setting context end
	
    gameObjects.paddle1.redraw(context, instance);
    gameObjects.paddle2.redraw(context, instance);
    gameObjects.paddle3.redraw(context, instance);
    gameObjects.paddle4.redraw(context, instance);
    gameObjects.ball.redraw(context, instance);
	if(gameObjects.isLooser == false){
       gameObjects.bricks.redraw(context, instance);
	}
};