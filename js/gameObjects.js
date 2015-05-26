// Our main global objects get defined here
var gameObjects = {};
gameObjects.middleLine = {};
gameObjects.paddle1 = {};
gameObjects.paddle2 = {};
gameObjects.paddle3 = {};
gameObjects.paddle4 = {};
gameObjects.ball = {};
gameObjects.bricks = {};
gameObjects.halfPaddelwidth = 53.5;
gameObjects.LCornerbrick = [];
gameObjects.BricksLeft = [];
gameObjects.BricksRight = [];
gameObjects.BricksTop = [];
gameObjects.BricksBottom = [];

var bCorn = 46;
var gameSpan = 428;
var groundW = 520;
var groundH = 520;
var groundX = 40;
var groundY = 40;
var bWallW = 30;
var bWallH = 30;
var bLX = groundX;
var bLY = groundY + bCorn;
var bLW = 30;
var bLH = 107;
//==================For Right======
var bRW = 30;
var bRH = 107;
var bRX = groundX + groundW - bWallW;
var bRY = groundY + bCorn;

//==================For Top======
var bTX = groundX + bCorn;
var bTY = groundY;
var bTW = 107;
var bTH = 30;
//==================For Bottom======
var bBW = 107;
var bBH = 30;
var bBX = groundX + bCorn;
var bBY = groundY + groundH - bWallH;

var hideLefftbricks;
var hideRightbricks;
var hideTopbricks;
var hideBottombricks;
var verti_paddle = document.getElementById("vert_paddle");
var horizo_paddle = document.getElementById("horiz_paddle");
var ballImage = document.getElementById("ball_image");
var process_Loader = document.getElementById("process_loader");	


gameObjects.reset = function () {
    //gameObjects.middleLine = {};
    //gameObjects.paddle1 = {};
    //gameObjects.paddle2 = {};
    //gameObjects.paddle3 = {};
    //gameObjects.paddle4 = {};
    //gameObjects.ball = {};
    //gameObjects.bricks = {};

    //gameObjects.LCornerbrick = [];
    //gameObjects.BricksLeft = [];
    //gameObjects.BricksRight = [];
    //gameObjects.BricksTop = [];
    //gameObjects.BricksBottom = [];
   
    bCorn = 46;
    gameSpan = 428;
    groundW = 520;
    groundH = 520;
    groundX = 40;
    groundY = 40;
    bWallW = 30;
    bWallH = 30;
    bLX = groundX;
    bLY = groundY + bCorn;
    bLW = 30;
    bLH = 107;
    //==================For Right======
    bRW = 30;
    bRH = 107;
    bRX = groundX + groundW - bWallW;
    bRY = groundY + bCorn;

    //==================For Top======
    bTX = groundX + bCorn;
    bTY = groundY;
    bTW = 107;
    bTH = 30;
    //==================For Bottom======
    bBW = 107;
    bBH = 30;
    bBX = groundX + bCorn;
    bBY = groundY + groundH - bWallH;

    hideLefftbricks;
    hideRightbricks;
    hideTopbricks;
    hideBottombricks;
    verti_paddle = document.getElementById("vert_paddle");
	
    horizo_paddle = document.getElementById("horiz_paddle");
    gameObjects.init();

}


/**
* Initialization function for our gameObjects class, setup the various game
* objects like paddles and such.
*
* @since Canvas Pong 1.0
*/
gameObjects.init = function () {
    "use strict";
    
    this.isPaused = true;
    this.player1Score = "";
    this.player2Score = "";
	this.isLoader = false;
    this.isWinner = false;
	this.isLooser = false;
	this.isRoundsMsg = true;


    this.ball.x = canvas.instance.width / 2;
    this.ball.y = canvas.instance.height / 2;
    //this.ball.width = 5;
    this.ball.width = this.ball.height = 19;
    this.ball.speed = 0;
    this.ball.speedX = 0;
    this.ball.speedY = 0;
    this.ball.minSpeed = 4;
    this.ball.maxSpeed = 4;
    this.ball.moveToX = 0;
    this.ball.moveToY = 0;
    gameObjects.LCornerbrick[0] = [groundX, groundY, bCorn, bCorn];
    gameObjects.LCornerbrick[1] = [groundX, groundY + bCorn + gameSpan, bCorn, bCorn];
    gameObjects.LCornerbrick[2] = [groundX + bCorn + gameSpan, groundY, bCorn, bCorn];
    gameObjects.LCornerbrick[3] = [groundX + bCorn + gameSpan, groundY + bCorn + gameSpan, bCorn, bCorn];
    gameObjects.BricksLeft[0] = [bLX, bLY, bLW, bLH];
    gameObjects.BricksRight[0] = [bRX, bRY, bRW, bRH];
    gameObjects.BricksTop[0] = [bTX, bTY, bTW, bTH];
    gameObjects.BricksBottom[0] = [bBX, bBY, bBW, bBH];
    
    for (var i = 0; i <= 2; i++) {
        bLY = bLY + bLH;
        gameObjects.BricksLeft[i + 1] = [bLX, bLY, bLW, bLH];

        bRY = bRY + bRH;
        gameObjects.BricksRight[i + 1] = [bRX, bRY, bRW, bRH];

        bTX = bTX + bTW;
        gameObjects.BricksTop[i + 1] = [bTX, bTY, bTW, bTH];

        bBX = bBX + bBW;
        gameObjects.BricksBottom[i + 1] = [bBX, bBY, bBW, bBH];
    }

    gameObjects.BricksRight[4] = "";
    gameObjects.BricksTop[4] = "";
    gameObjects.BricksBottom[4] = "";
    gameObjects.BricksLeft[4] = "";

    this.paddle1.width = 17;
    this.paddle1.height = 107;
    this.paddle1.x = groundX + bWallW;
    this.paddle1.y = (canvas.instance.height / 2) - (this.paddle1.height / 2);
    this.paddle1.controlMode = 'mouse';

    this.paddle2.width = 17;
    this.paddle2.height = 107;
    this.paddle2.x = groundX + groundW - bWallW - this.paddle2.width;
    this.paddle2.y = (canvas.instance.height / 2) - (this.paddle2.height / 2);
    this.paddle2.controlMode = 'mouse';

    this.paddle3.width = 107;
    this.paddle3.height = 17;
    //this.paddle3.x = groundX+bCorn;
    this.paddle3.x = (canvas.instance.width / 2) - (this.paddle3.width / 2);
    this.paddle3.y = groundY + groundW - bWallH - this.paddle3.height;
    //this.paddle3.y = (canvas.instance.width / 2) - (this.paddle3.width / 4);
    this.paddle3.controlMode = 'mouse';

    this.paddle4.width = 107;
    this.paddle4.height = 17;
    //this.paddle4.x = 10;
    //this.paddle4.x = groundX+bCorn;
    this.paddle4.x = (canvas.instance.width / 2) - (this.paddle4.width / 2);
    this.paddle4.y = groundY + bWallH; ;
    //this.paddle4.y = (canvas.instance.height / 20) - (this.paddle4.height / 20);

    this.paddle4.controlMode = 'mouse';

};

/**
* Draws the dotted line in the middle of the canvas that signifies which
* player's side the ball is on.
*
* @since Canvas Pong 1.0 
*/
gameObjects.middleLine.redraw = function (context, canvas) {
    "use strict";
    // Draw the dotted line in the middle
    var currentPoint = 0;
    context.beginPath();
    context.strokeStyle = '#aaa';
    context.lineWidth = 5;
    context.moveTo(canvas.width / 2, 0);

    while (currentPoint < canvas.height) {
        currentPoint += 6;
        context.lineTo(canvas.width / 2, currentPoint);

        currentPoint += 10;
        context.moveTo(canvas.width / 2, currentPoint);
    }

    context.stroke();
};

/**
* Draw player 1's paddle (Left)
*
* @since Canvas Pong 1.0
*/
gameObjects.paddle1.redraw = function (context, canvas) {
    "use strict";
    if (gameObjects.BricksLeft[4] == "40,86,30,428") {
        this.width = 0;
        this.height = 0;       
        if ($('#Position').val() == "0") {
            
			//context.fillStyle = '#5272b2';
            //context.font = '34px hvd_comic_serif_proregular';
            //context.textAlign = 'center';
            RemoveCursurClass();
             $(".player0").hide();
             $(".player1").hide();
             $(".player2").hide();
             $(".player3").hide();  
			gameObjects.ball.width = 0;
			gameObjects.paddle1.height = 0;
			gameObjects.paddle1.width = 0;
			gameObjects.paddle2.height = 0;
			gameObjects.paddle2.width = 0;
			gameObjects.paddle3.height = 0;
			gameObjects.paddle3.width = 0;
			gameObjects.paddle4.height = 0;
			gameObjects.paddle4.width = 0;
			
			if(gameObjects.isLooser == false)
			{
				//gameObjects.raiseEvent ("GameLost", {});
				gameObjects.isRoundsMsg = false;
				showLooserMessage();
				
			}
			gameObjects.isLooser = true;
            gameObjects.isPaused = true                                                                                                                                                                 }
    }
    context.drawImage(verti_paddle, this.x, this.y, this.width, this.height);
};
/**
* Draw player 2's paddle (Right)
*
* @since Canvas Pong 1.0
*/
gameObjects.paddle2.redraw = function (context, canvas) {
    "use strict";
    if (gameObjects.BricksRight[4] == "530,86,30,428") {
        this.width = 0;
        this.height = 0;        
        if ($('#Position').val() == "1") {
            
			//context.fillStyle = '#5272b2';
            //context.font = '34px hvd_comic_serif_proregular';
            //context.textAlign = 'center';
			RemoveCursurClass();
			 $(".player0").hide();
			 $(".player1").hide();
			 $(".player2").hide();
			 $(".player3").hide();   
			gameObjects.ball.width = 0;
		    gameObjects.paddle1.height = 0;
			gameObjects.paddle1.width = 0;
			gameObjects.paddle2.height = 0;
			gameObjects.paddle2.width = 0;
			gameObjects.paddle3.height = 0;
			gameObjects.paddle3.width = 0;
			gameObjects.paddle4.height = 0;
			gameObjects.paddle4.width = 0;
			if(gameObjects.isLooser == false)
			{
				//gameObjects.raiseEvent ("GameLost", {});
				gameObjects.isRoundsMsg = false;
				showLooserMessage();
				
			}
            gameObjects.isLooser = true;   
            gameObjects.isPaused = true;            
        }
    }
    context.drawImage(verti_paddle, this.x, this.y, this.width, this.height);
};

//paddle 3 (Bottom)
gameObjects.paddle3.redraw = function (context, canvas) {
    "use strict";
    if (gameObjects.BricksBottom[4] == "86,530,428,30") {
        this.width = 0;
        this.height = 0;
        if ($('#Position').val() == "2") {
            
			//context.fillStyle = '#5272b2';
            //context.font = '34px hvd_comic_serif_proregular';
            //context.textAlign = 'center';
			RemoveCursurClass();
             $(".player0").hide();
             $(".player1").hide();
             $(".player2").hide();
             $(".player3").hide();   
			gameObjects.ball.width = 0;
			gameObjects.paddle1.height = 0;
			gameObjects.paddle1.width = 0;
			gameObjects.paddle2.height = 0;
			gameObjects.paddle2.width = 0;
			gameObjects.paddle3.height = 0;
			gameObjects.paddle3.width = 0;
			gameObjects.paddle4.height = 0;
			gameObjects.paddle4.width = 0;
			if(gameObjects.isLooser == false)
			{
				//gameObjects.raiseEvent ("GameLost", {});
				gameObjects.isRoundsMsg = false;
				showLooserMessage();
				
			}
            gameObjects.isLooser = true;
            gameObjects.isPaused = true;
               
        }
    }
    context.drawImage(horizo_paddle, this.x, this.y, this.width, this.height);
};

gameObjects.paddle4.redraw = function (context, canvas) {
    "use strict";
    if (gameObjects.BricksTop[4] == "86,40,428,30") {
        this.width = 0;
        this.height = 0;
        if ($('#Position').val() == "3") {
            
			//context.fillStyle = '#5272b2';
            //context.font = '34px hvd_comic_serif_proregular';
            //context.textAlign = 'center';
			RemoveCursurClass();
             $(".player0").hide();
             $(".player1").hide();
             $(".player2").hide();
             $(".player3").hide();    
			gameObjects.ball.width = 0;
			gameObjects.paddle1.height = 0;
			gameObjects.paddle1.width = 0;
			gameObjects.paddle2.height = 0;
			gameObjects.paddle2.width = 0;
			gameObjects.paddle3.height = 0;
			gameObjects.paddle3.width = 0;
			gameObjects.paddle4.height = 0;
			gameObjects.paddle4.width = 0;
			
            if(gameObjects.isLooser == false) {	
				gameObjects.isRoundsMsg = false;
				showLooserMessage();
			}
            
            gameObjects.isLooser = true;
            gameObjects.isPaused = true;
                 
        }
    }
    context.drawImage(horizo_paddle, this.x, this.y, this.width, this.height);
};
//gameObjects.addEventListener("GameLost", showLooserMessage);

/**
* Draw the game ball
*
* @since Canvas Pong 1.0
*/
gameObjects.ball.redraw = function (context, canvas) {
    "use strict";
    //    context.fillStyle = '#00ff00';
    //    context.beginPath();
    //    context.arc(this.x, this.y, this.width, 0, Math.PI * 2, true);
    //    context.closePath();
    //    context.fill();


    //Added By Ashish to match the UI start 
	
	//Commented by Ashish start
	//Ball drawing is done using image draw
    //var gradObj = context.createLinearGradient((this.x - this.width), (this.y - this.height), (this.x - this.width), (this.y + this.height));
    //gradObj.addColorStop(0, "#f2eeee");
    //gradObj.addColorStop(1, "#787777");

    //context.fillStyle = gradObj;
    //context.fillStyle = '#00ff00';
    //context.beginPath();
    //context.arc(this.x, this.y, this.width, 0, Math.PI * 2, true);
	
    //context.closePath();
    //context.fill();
	//Commented by Ashish end

    //context.fillStyle = '#fff';
    //context.font = '44px Verdana';
    //context.textAlign = 'end';
	
	
    //context.fillText(gameObjects.player1Score, (canvas.width / 2) - 20, 50);
    if (gameObjects.Countdown) {
        //canvas.context.fillStyle = '#5272b2';
        //canvas.context.font = '34px hvd_comic_serif_proregular';
        //canvas.context.textAlign = 'end';				
		canvas.context.fillText(gameObjects.Countdown, 310, 260);
		canvas.context.font = '17px hvd_comic_serif_proregular';
		// canvas.context.fillText("For better gaming experience ",300,412)		
		// canvas.context.fillText("(Blocker fun and prizes)", 300, 442);
		// canvas.context.fillText("Advice all players to use the Key Arrows.", 300, 472);
		
    }else
	{
		canvas.context.font  = '34px hvd_comic_serif_proregular';
	}
	
	if(tournament_type == Pong.TournamentType.MINI && gameObjects.isRoundsMsg == true){
			canvas.context.font  = '34px hvd_comic_serif_proregular';
			if(RoundNumber == 1)
				{
					//canvas.context.fillStyle = '#5272b2';
					//canvas.context.font = '34px hvd_comic_serif_proregular';
					//canvas.context.textAlign = 'center';
					canvas.context.fillText("MINI GAME", 300, 300);
				    canvas.context.fillText("ROUND 1", 310, 340);
				}
			else if(RoundNumber == 2)
				{
					//canvas.context.fillStyle = '#5272b2';
					//canvas.context.font = '34px hvd_comic_serif_proregular';
					//canvas.context.textAlign = 'center';
					canvas.context.fillText("MINI GAME", 300, 300);
					canvas.context.fillText("ROUND 2", 310, 340);
				}
	}
	
	if(tournament_type == Pong.TournamentType.MEGA && gameObjects.isRoundsMsg == true){
		canvas.context.font  = '34px hvd_comic_serif_proregular';
			//canvas.context.fillStyle = '#5272b2';
			//canvas.context.font = '34px hvd_comic_serif_proregular';
			//canvas.context.textAlign = 'center';
			if(RoundNumber == 1)
				{
					//canvas.context.fillStyle = '#5272b2';
					//canvas.context.font = '34px hvd_comic_serif_proregular';
					//canvas.context.textAlign = 'center';
					canvas.context.fillText("MEGA GAME", 300, 300);
					canvas.context.fillText("ROUND 1", 310, 340);
				}
			else if(RoundNumber == 2)
				{
					//canvas.context.fillStyle = '#5272b2';
					//canvas.context.font = '34px hvd_comic_serif_proregular';
					//canvas.context.textAlign = 'center';
					canvas.context.fillText("MEGA GAME", 300, 300);
					canvas.context.fillText("ROUND 2", 310, 340);
				}
			else if(RoundNumber == 3)
				{
					//canvas.context.fillStyle = '#5272b2';
					//canvas.context.font = '34px hvd_comic_serif_proregular';
					//canvas.context.textAlign = 'center';
					canvas.context.fillText("MEGA GAME", 300, 300);
					canvas.context.fillText("ROUND 3", 310, 340);
				}
	}
		context.drawImage(ballImage,this.x, this.y, this.width, this.height);	
		//context.drawImage(process_Loader,this.x, this.y, this.width, this.height);
        // alert(gameObjects.isLoader == );
		if (gameObjects.isLoader) {		

		   	canvas.context.fillText("Loading...", 300, 300);
			  //  imageObj.onload = function() {
				 // context.drawImage(imageObj, 300, 300);
			  //  };
			  // imageObj.src = 'http://www.html5canvastutorials.com/demos/assets/darth-vader.jpg';
		}
		if (gameObjects.isWinner) {	 
		 
			if ((tournament_type == Pong.TournamentType.MINI || tournament_type == Pong.TournamentType.MEGA ) && RoundNumber == -1)
			{				
				canvas.context.fillText("Congratulations!", 300, 300);
				canvas.context.fillText("You won! Please wait.", 300, 335);
			}
			if((tournament_type == Pong.TournamentType.MINI && RoundNumber != -1) 
				|| (tournament_type == Pong.TournamentType.MEGA && RoundNumber != -1))
			{
			    gameObjects.isRoundsMsg = false;
				//canvas.context.fillStyle = '#5272b2';
				//canvas.context.font = '34px hvd_comic_serif_proregular';
				//canvas.context.textAlign = 'center';
				//canvas.context.fillText("CONGRATULATIONS!", 300, 300);
				//canvas.context.fillText("YOU HAVE WON.", 300, 330);
				//canvas.context.fillText("Please wait.", 300, 300);
				//canvas.context.fillText("Congratulations!", 300, 300);
				//canvas.context.fillText("You won! Please wait.", 300, 330);
							
				if (gameObjects.Count) {				
					if((tournament_type == Pong.TournamentType.MINI || tournament_type == Pong.TournamentType.MEGA )&& RoundNumber == 2 )
					{
						canvas.context.fillText("ROUND 1 Completed.", 300, 300);
						canvas.context.fillText("Please wait.", 300, 340);
					}
					if(tournament_type == Pong.TournamentType.MEGA && RoundNumber == 3)
					{					
						canvas.context.fillText("ROUND 2 Completed.", 300, 300);
						canvas.context.fillText("Please wait.", 300, 340);
					}
					//canvas.context.fillText("CONNECTING TO", 300, 370);
					if(tournament_type == Pong.TournamentType.MEGA && RoundNumber == 2)
					{
						//canvas.context.fillText("ROUND" + " " +  RoundNumber , 300, 400);    
					}
					else
					{
						//canvas.context.fillText("ROUND" + " " +  RoundNumber + " "  + "IN " + gameObjects.Count + " SEC", 300, 400);
						//canvas.context.fillText("FINAL ROUND", 300, 400);
					}
				}
			}
			this.width = 0;
			gameObjects.ball.width = 0;
			gameObjects.paddle1.height = 0;
			gameObjects.paddle1.width = 0;
			gameObjects.paddle2.height = 0;
			gameObjects.paddle2.width = 0;
			gameObjects.paddle3.height = 0;
			gameObjects.paddle3.width = 0;
			gameObjects.paddle4.height = 0;
			gameObjects.paddle4.width = 0;
			gameObjects.isLooser = true;
			
			gameObjects.isPaused = true;
		}
	
    //Added By Ashish to match the UI end



    //ontext.fillStyle = '#fff';
    //context.font = '34px hvd_comic_serif_proregular';
    //context.textAlign = 'end';
    //context.fillText(gameObjects.player1Score, (canvas.width / 2) - 20, 50);

    //context.textAlign = 'start';
    //context.fillText(gameObjects.player2Score, (canvas.width / 2) + 20, 50);


};

gameObjects.bricks.redraw = function (ctx, canvas) {    
var left_brick = document.getElementById("left_brick_image");
 var bottom_brick = document.getElementById("bottom_brick_image");
 var right_brick = document.getElementById("right_brick_image");
    var top_brick = document.getElementById("top_brick_image");
    var horiz_brick = document.getElementById("horiz_brick_image");
    var vert_brick = document.getElementById("vert_brick_image");
    var corner_brick = document.getElementById("wood_corner");
   
    for (var x = 0; x < gameObjects.LCornerbrick.length; x++) {
        ctx.drawImage(corner_brick, gameObjects.LCornerbrick[x][0], gameObjects.LCornerbrick[x][1], gameObjects.LCornerbrick[x][2], gameObjects.LCornerbrick[x][3]);
    }
    for (var x = 0; x < gameObjects.BricksLeft.length; x++) {
        if (x <= 3) {
            ctx.drawImage(left_brick, gameObjects.BricksLeft[x][0], gameObjects.BricksLeft[x][1], gameObjects.BricksLeft[x][2], gameObjects.BricksLeft[x][3]);
        }
        else {
            if (gameObjects.BricksLeft[4] == "40,86,30,428") {
                ctx.drawImage(vert_brick, gameObjects.BricksLeft[x][0], gameObjects.BricksLeft[x][1], gameObjects.BricksLeft[x][2], gameObjects.BricksLeft[x][3]);
				//$(".player0").hide();
				//$(".player0").show();				
				if($(".player0").is(":visible")){
					$(".player0").show();
					$(".player0").addClass("player_left_disabled");
				}
            }
        }
    }

    for (var x = 0; x < gameObjects.BricksRight.length; x++) {
        if (x <= 3) {
            ctx.drawImage(right_brick, gameObjects.BricksRight[x][0], gameObjects.BricksRight[x][1], gameObjects.BricksRight[x][2], gameObjects.BricksRight[x][3]);
        }
        else {
            if (gameObjects.BricksRight[4] == "530,86,30,428") {
                ctx.drawImage(vert_brick, gameObjects.BricksRight[x][0], gameObjects.BricksRight[x][1], gameObjects.BricksRight[x][2], gameObjects.BricksRight[x][3]);
				//$(".player1").hide();				
				//$(".player1").show();				
				if($(".player1").is(":visible")){
					$(".player1").show();
					$(".player1").addClass("player_right_disabled");					
				}
            }
        }
    }

    for (var x = 0; x < gameObjects.BricksTop.length; x++) {
        if (x <= 3) {
            ctx.drawImage(top_brick, gameObjects.BricksTop[x][0], gameObjects.BricksTop[x][1], gameObjects.BricksTop[x][2], gameObjects.BricksTop[x][3]);
        }
        else {
            if (gameObjects.BricksTop[4] == "86,40,428,30") {
                ctx.drawImage(horiz_brick, gameObjects.BricksTop[x][0], gameObjects.BricksTop[x][1], gameObjects.BricksTop[x][2], gameObjects.BricksTop[x][3]);
				//$(".player3").hide();				
				//$(".player3").show();				
				if($(".player3").is(":visible")){
					$(".player3").show();
					$(".player3").addClass("player_left_disabled");
					//$(".player3").removeClass("player_one");
				}
            }
        }
    }

    for (var x = 0; x < gameObjects.BricksBottom.length; x++) {
        if (x <= 3) {
            ctx.drawImage(bottom_brick, gameObjects.BricksBottom[x][0], gameObjects.BricksBottom[x][1], gameObjects.BricksBottom[x][2], gameObjects.BricksBottom[x][3]);
        }
        else {
            if (gameObjects.BricksBottom[4] == "86,530,428,30") {
                ctx.drawImage(horiz_brick, gameObjects.BricksBottom[x][0], gameObjects.BricksBottom[x][1], gameObjects.BricksBottom[x][2], gameObjects.BricksBottom[x][3]);
				//$(".player2").hide();				
				//$(".player2").show();				
				if($(".player2").is(":visible")){
					$(".player2").show();
					$(".player2").addClass("player_right_disabled");
				//	$(".player2").removeClass("player_four");
				}
            }
        }
    }
};