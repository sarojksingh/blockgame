// Our main global objects get defined here
var mouse = {};

/**
 * Records the position of the mouse relative to the canvas whenever it moves.
 *
 * @since Canvas Pong 1.0
 */
mouse.onmove = function( ev ) {
	"use strict";
	
	// IE get's the mouse position differently
	if ( browser.isInternetExplorer ) { 
		mouse.x = event.clientX + document.body.scrollLeft;
		mouse.y = event.clientY + document.body.scrollTop;
	} else {
		mouse.x = ev.pageX;
		mouse.y = ev.pageY;
	}
	
	// Convert the mouse position relative to the canvas now
	if ( mouse.y < document.getElementById('canvas').offsetTop ) {
		mouse.y = 0;
	} else {
		mouse.y -= document.getElementById('canvas').offsetTop;

		if ( mouse.y > canvas.instance.clientHeight ) {
			mouse.y = canvas.instance.clientHeight;
		}
	}
	
	// Catch possible negative values in older browsers
	if ( mouse.x < 0 ) {
		mouse.x = 0;
	}
	
	if ( mouse.y < 0 ) {
		mouse.y = 0;
	}
	
	return true
};

/**
 * Initializes mouse tracking functions that record the position of the mouse
 * whenever it moves.
 *
 * @since Canvas Pong 1.0
 */
mouse.init = function() {
	"use strict";
	
	this.x = 0;
	this.y = 0;

	// If NS -- that is, !IE -- then set up for mouse capture
	if ( ! browser.isInternetExplorer ) {
		document.captureEvents( Event.MOUSEMOVE )
	}

	// Set-up to use getMouseXY function onMouseMove
	document.onmousemove = this.onmove;
};