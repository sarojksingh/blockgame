// Our main global objects get defined here
var keyboard = {};
var timer1;
var paddletimer;
 keyboard.MovePaddle = function(keyCode) {
		//clearTimeout(timer1);		
		//timer1 = setTimeout(function () {
			// if (X < 0) {
				// X = 0;
			// }			
			// if (Y < 0) {
				// Y = 0;
			// }
			var pos = 0;				
		   // window.onscroll = function () { window.scrollTo(0, 0); };		
			if(isGameStarted)
			{			   
			   switch(keyCode)
			   {
					case 39: 
						if ($('#Position').val() == Pong.Sockets.PlayerPosition.UP || $('#Position').val() == Pong.Sockets.PlayerPosition.DOWN) {
							//event.preventDefault();
							// if(X < 407)
							// {
								// X = X + 20;
								// if(X > 407)
								// {	
									// X = 407;
								// }
							// }	
							SendPaddlePosition('RIGHT');
							pos = X;
							//var msgToSend = "{'key':'" + GUID + "','roomKey':'" + roomKey + "','value':" + X + ",'Type':" + Pong.Sockets.MessageType.PADDLEPOSITION + ",'PaddlePosition':" + $('#Position').val() + "}";
							//iosocket.send(msgToSend);
						}
					break;
					case 37 :
						if ($('#Position').val() == Pong.Sockets.PlayerPosition.UP || $('#Position').val() == Pong.Sockets.PlayerPosition.DOWN) {
							//event.preventDefault();
							// if(X > 86)
							// {	
								// X = X - 20;
								// if(X < 86)
								// {
									// X = 86;
								// }
							// }
							SendPaddlePosition('LEFT');
							pos = X;
							//var msgToSend = "{'key':'" + GUID + "','roomKey':'" + roomKey + "','value':" + X + ",'Type':" + Pong.Sockets.MessageType.PADDLEPOSITION + ",'PaddlePosition':" + $('#Position').val() + "}";
							//iosocket.send(msgToSend);
						}
					break;
					case 38 : 
						if ($('#Position').val() == Pong.Sockets.PlayerPosition.LEFT || $('#Position').val() == Pong.Sockets.PlayerPosition.RIGHT) {
							//event.preventDefault();
							// if(Y > 86)
							// {
								// Y = Y - 20;
								// if(Y < 86)
								// {
									// Y = 86;
								// }
							// }
							SendPaddlePosition('DOWN');							
							pos = Y;								
							//var msgToSend = "{'key':'" + GUID + "','roomKey':'" + roomKey + "','value':" + Y + ",'Type':" + Pong.Sockets.MessageType.PADDLEPOSITION + ",'PaddlePosition':" + $('#Position').val() + "}";
							//iosocket.send(msgToSend);
						}					
					break;
					case 40 : 
						if ($('#Position').val() == Pong.Sockets.PlayerPosition.LEFT || $('#Position').val() == Pong.Sockets.PlayerPosition.RIGHT) {
							//event.preventDefault();
							// if(Y < 407)
							// {
								// Y = Y + 20;
								// if(Y > 407)
								// {	
									// Y = 407;
								// }
							// }							
							SendPaddlePosition('UP');														
							pos = Y;
							//var msgToSend = "{'key':'" + GUID + "','roomKey':'" + roomKey + "','value':" + Y + ",'Type':" + Pong.Sockets.MessageType.PADDLEPOSITION + ",'PaddlePosition':" + $('#Position').val() + "}";
							//iosocket.send(msgToSend);
						}
					break;			
			   }
			
			// var msgToSend = "{'key':'" + GUID + "','roomKey':'" + roomKey + "','value':" + pos + ",'Type':" + Pong.Sockets.MessageType.PADDLEPOSITION + ",'PaddlePosition':" + $('#Position').val() + "}";
			// iosocket.send(msgToSend);
			if(gameObjects.isWinner)
			{
				removeError();
			}		
		   }
	  // },5);
	};
	
	
	function SendPaddlePosition(direction)
	{
		var pos;
		clearInterval(paddletimer);
		paddletimer = setInterval(function(){
			switch(direction)
			{
				case 'LEFT':
					if(X > 86)
					{	
						X -= 15;
						if(X < 86)
						{
							X = 86;
						}
					}
					pos = X;
				break;
				case 'RIGHT':
					if(X < 407)
					{
						X = X + 15;
						if(X > 407)
						{	
							X = 407;
						}
					}	
					pos = X;
				break;
				case 'UP':
					if(Y < 407)
					{
						Y += 15;
						if(Y > 407)
						{	
							Y = 407;
						}
					}							
					pos = Y;
				break;
				case 'DOWN':
					if(Y > 86)
					{
						Y -= 15;
						if(Y < 86)
						{
							Y = 86;
						}
					}
					pos = Y;
				break;
			}
			var msgToSend = "{'key':'" + GUID + "','roomKey':'" + roomKey + "','value':" + pos + ",'Type':" + Pong.Sockets.MessageType.PADDLEPOSITION + ",'PaddlePosition':" + $('#Position').val() + "}";
			iosocket.send(msgToSend);
		},20);
	}
	

/**
 * Listens for keyboard presses
 *
 * @since Canvas Pong 1.0
 */
keyboard.handler = function (e) {
    "use strict";
    var key_code;
    var key_char;

    if (window.event) {
        key_code = e.keyCode;
    } else if (e.which) {
        key_code = e.which;
    }
    keyboard.MovePaddle(key_code);
};

/**
 * Listens for keyup events so we can stop moving a paddle
 *
 * @since Canvas Pong 1.0
 */
keyboard.handlerRelease = function (e) {
    "use strict";
	clearInterval(paddletimer);
    // var key_code;
    // var key_char;

    // if (window.event) {        
        // key_code = e.keyCode;
    // } else if (e.which) {
        // key_code = e.which;        
    // }
    // keyboard.MovePaddle(key_code,0);
};