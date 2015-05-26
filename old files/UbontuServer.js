Pong = {};


Pong.TournamentType = {
    MINI:2,
    MEGA:1,
    PLAYFORFUN:0
}

Pong.userStatus = {
    NEW:1,
    OLD:0
}

Pong.Sockets = {};
Pong.Sockets.GameState = {
    START: 0,
    PAUSE: 1
}
Pong.Sockets.MessageType = {
    CONNECT: 0,
    PADDLEPOSITION: 1,
    GameState: 2,
    CONTROLPOSITION: 3,
    DISCONNECT: 4,
    RESULT:5,
	KEEPALIVE: 6,
	ALREADYCONNECTED:7,
	TOTALACTIVEUSER:8,
	DISCONNECTINFO:9
}
Pong.Sockets.PlayerPosition =
{
    LEFT: 0,
    RIGHT: 1,
    DOWN:2,
    UP:3
}
Pong.Sockets.PaddlePosition =
{
    LEFT: 0,
	MIDDLE:1,
    RIGHT: 2,
	OTHER:4
}

 var yDirectionValues = [-0.25,2.1,1.2,1.8,3.8,1.9,3.0];
 var xDirectionValues = [-0.1,2.3,0.2,1.3,0.9,0.75,3.7];
var socketUserMapping = {};
//var currentPos = Pong.Sockets.PaddlePosition.OTHER;
var touchFlag ="none";
var currentPos = Pong.Sockets.PaddlePosition.OTHER;
var oMatch =[];
var paddleFixval = 17; 
//var BallSpeed = 0;

function GamePhysics() {
    this.count = 0;
    this.BallSpeed = 0;    
    this.roomKey = "";
    this.Paddle1Position = {};
    this.Paddle2Position = {};
    this.Paddle3Position = {};
    this.Paddle4Position = {};
    this.BallPosition = {};
    this.ControlPostion = {};
    //this.ControlPostion.LBricks = [];
    this.middleLine = {};
    this.paddle1 = {};
    this.paddle2 = {};
    this.paddle3 = {};
    this.paddle4 = {};
    this.ball = {};
    this.bricks = {};
    this.LCornerbrick = [];
    this.BricksLeft = [];
    this.BricksRight = [];
    this.BricksTop = [];
    this.BricksBottom = [];
    this.bCorn = 46;
    this.gameSpan = 428;
    this.groundW = 520;
    this.groundH = 520;
    this.groundX = 40;
    this.groundY = 40;
    this.bWallW = 30;
    this.bWallH = 30;
    this.bLX = this.groundX;
    this.bLY = this.groundY + this.bCorn;
    this.bLW = 30;
    this.bLH = 107;
    this.bYCorn = 10;
    this.maxbCorn = 400;
    //==================For Right======
    this.bRW = 30;
    this.bRH = 107;
    this.bRX = this.groundX + this.groundW - this.bWallW;
    this.bRY = this.groundY + this.bCorn;

    //==================For Top======
    this.bTX = this.groundX + this.bCorn;
    this.bTY = this.groundY;
    this.bTW = 107;
    this.bTH = 30;
    //==================For Bottom======
    this.bBW = 107;
    this.bBH = 30;
    this.bBX = this.groundX + this.bCorn;
    this.bBY = this.groundY + this.groundH - this.bWallH;
    this.paddel1Control;
    this.paddel2Control;
    this.paddel3Control;
    this.paddel4Control;
    this.hideLefftbricks;
    this.hideRightbricks;
    this.hideTopbricks;
    this.hideBottombricks;
    this.leftBricks = [];
    this.rightBricks = [];
    this.topBricks = [];
    this.bottomBricks = [];
    this.initComplate = false;	
    /**
    * Initialization function for our gameObjects class, setup the various game
    * objects like paddles and such.
    *
    * @since Canvas Pong 1.0
    */
    this.init = function () {
        "use strict";
        var self = this;		 
		self.ball.height = 19;
        self.ball.width = 19;
        self.ball.speed = 0;
        self.ball.speedX = 0;
        self.ball.speedY = 0;
        self.ball.minSpeed = 5;
        self.ball.maxSpeed = 25;
        self.ball.moveToX = 0;
        self.ball.moveToY = 0;
        self.ball.x = canvas_instance_width / 2;
        self.ball.y = canvas_instance_height / 2;
        // Reset the scores
        self.player1Score = 0;
        self.player2Score = 0;
        self.isPaused = true;
        self.paddle1.width = 17;
        self.paddle1.height = 107;
		self.paddle1.left = 36;
		self.paddle1.middle = 35;
		self.paddle1.right = 36;
		self.paddle1.flag = false;		
		self.paddle1.reflect = false;
        self.paddle1.x = self.groundX + self.bWallW;
        self.paddle1.y = (canvas_instance_height / 2) - (self.paddle1.height / 2);
        self.paddle1.controlMode = 'mouse';
        // Reset the paddles
        self.paddle2.width = 17;
        self.paddle2.height = 107;
		self.paddle2.left = 36;
		self.paddle2.middle = 35;
		self.paddle2.right = 36;
		self.paddle2.flag= false;	
		self.paddle1.reflect = false;		
        self.paddle2.x = (self.groundX + self.groundW - self.bWallW - self.paddle2.width);
        self.paddle2.y = (canvas_instance_height / 2) - (self.paddle2.height / 2);
        self.paddle2.controlMode = 'mouse';
        self.paddle3.width = 107;
        self.paddle3.height = 17;
		self.paddle3.left = 36;
		self.paddle3.middle = 35;
		self.paddle3.flag= false;	
		self.paddle3.reflect = false;
		self.paddle4.right = 36;
        self.paddle3.x = (canvas_instance_width/2) - (self.paddle3.width/2);
        self.paddle3.y = (self.groundY + self.groundW - self.bWallH - self.paddle3.height);
        self.paddle3.controlMode = 'mouse';
        self.paddle4.width = 107;
        self.paddle4.height = 17;
		self.paddle4.left = 36;
		self.paddle4.middle = 35;
		self.paddle4.right = 36;
		self.paddle4.flag= false;	
		self.paddle4.reflect = false;
        self.paddle4.x = (canvas_instance_width/2) - (self.paddle3.width/2);
        self.paddle4.y = self.groundY + self.bWallH;
        self.paddle4.controlMode = 'mouse';
        self.paddel1Control = (canvas_instance_height / 2) - (self.paddle1.height / 2);
        self.paddel2Control = (canvas_instance_height / 2) - (self.paddle2.height / 2);
        self.paddel3Control = (canvas_instance_width / 2) - (self.paddle3.width / 2);
        self.paddel4Control = (canvas_instance_width / 2) - (self.paddle4.width / 2);
        //bricks addtion
        self.LCornerbrick[0] = [self.groundX, self.groundY, self.bCorn, self.bCorn];
        self.LCornerbrick[1] = [self.groundX, self.groundY + self.bCorn + self.gameSpan, self.bCorn, self.bCorn];
        self.LCornerbrick[2] = [self.groundX + self.bCorn + self.gameSpan, self.groundY, self.bCorn, self.bCorn];
        self.LCornerbrick[3] = [self.groundX + self.bCorn + self.gameSpan, self.groundY + self.bCorn + self.gameSpan, self.bCorn, self.bCorn];
        self.BricksLeft[0] = [self.bLX, self.bLY, self.bLW, self.bLH];
        self.BricksRight[0] = [self.bRX, self.bRY, self.bRW, self.bRH];
        self.BricksTop[0] = [self.bTX, self.bTY, self.bTW, self.bTH];
        self.BricksBottom[0] = [self.bBX, self.bBY, self.bBW, self.bBH];
        for (var i = 0; i <= 2; i++) {
            self.bLY = self.bLY + self.bLH;
            self.BricksLeft[i + 1] = [self.bLX, self.bLY, self.bLW, self.bLH];

            self.bRY = self.bRY + self.bRH;
            self.BricksRight[i + 1] = [self.bRX, self.bRY, self.bRW, self.bRH];

            self.bTX = self.bTX + self.bTW;
            self.BricksTop[i + 1] = [self.bTX, self.bTY, self.bTW, self.bTH];

            self.bBX = self.bBX + self.bBW;
            self.BricksBottom[i + 1] = [self.bBX, self.bBY, self.bBW, self.bBH];
        }
        
        //30-Oct-2012 Ashish Added to create solid wall if no player exists start
        for(var i = 4; i > rooms[self.roomKey].Players.length ; i --)
        {
            switch(i)
            {
                case 4:
                self.BricksTop.push([86,40,428,30]);
                break;
                case 3:
                self.BricksBottom.push([86,530,428,30]);
                break;
                case 2:
                self.BricksRight.push([530,86,30,428]);
                break;
                case 1:
                self.BricksLeft.push([40,86,30,428]);
                break;
            }
        }
        //30-Oct-2012 Ashish Added to create solid wall if no player exists end 
        //console.log(JSON.stringify(rooms));
        for(var i = 0; i < rooms[self.roomKey].Players.length ; i ++)
        {   
            try
            {  
                var position = rooms[self.roomKey].Players[i].playerInfo.position;
                var isDisconnected = false;
                isDisconnected = rooms[self.roomKey].Players[i].playerInfo.isDisconnected;                 
                if(isDisconnected != undefined && isDisconnected == true)
                {
                    if(parseInt(position) == 0)
                    {
					 
                         self.BricksLeft.push([40,86,30,428]);
						 
                    }
                    else if(parseInt(position) == 1)
                    {
					 
                        self.BricksRight.push([530,86,30,428]);
                    }
                    else if(parseInt(position) == 2)
                    {
						 
                        self.BricksBottom.push([86,530,428,30]);
                    }
                    else if(parseInt(position) == 3)
                    {
 
                        self.BricksTop.push([86,40,428,30]);
                    } 
                }
				else if(isDisconnected == false)
				{
					if(parseInt(position) == 0)
                    {
						self.BricksLeft.splice(4);
                    }
                    else if(parseInt(position) == 1)
                    {
						self.BricksRight.splice(4);                 
                    }
                    else if(parseInt(position) == 2)
                    {
						self.BricksBottom.splice(4);                   
                    }
                    else if(parseInt(position) == 3)
                    {
						self.BricksTop.splice(4);                  
                    } 
				}
            }
            catch(ex1){
                console.log("Error in : ", ex1);
            }                     
        }         
        self.initComplate = true;
    };
    
    /**
    * Draw player 1's paddle (Left)
    *
    * @since Canvas Pong 1.0
    */
    this.paddle1.redraw = function (_obj) {
        "use strict";
        var self = _obj;

        this.controlMode = 'mouse';
        // Calculate the actual position of the paddle
        if (this.controlMode == 'mouse') {
            if (self.BricksLeft[4] == "40,86,30,428") {
               this.height = 0;
               this.width = 0;
			   self.paddle1.width = 0;
			   self.paddle1.height = 0;
            }
			this.y = self.paddel1Control;
			if(this.y < (canvas_instance_height / 2))
			{
				if (this.y <= 86) {
                    this.y = 86;
                } 
			}	
			else if(this.y > (canvas_instance_height / 2))
			{
				if ((this.y) > 407) {
                    this.y = 407;
                }				
			}
			/*
			else if (Math.floor(this.y) !== self.paddel1Control) {
                var playerPaddleHalf = Math.floor(this.y);
                // Move the paddle up towards the mouse
                if(playerPaddleHalf < self.bCorn + self.groundX + self.bYCorn){
                }
                else if (playerPaddleHalf > (self.paddel1Control + 12)) {
                    this.y -= 12;
                } else if (playerPaddleHalf >= (self.paddel1Control + 7)) {
                    this.y -= 7;
                } else if (playerPaddleHalf >= (self.paddel1Control + 3)) {
                    this.y -= 3;
                } else if (playerPaddleHalf >= (self.paddel1Control + 1)) {
                    this.y -= 1;
                }

                // Move the paddle down towards the mouse
                if(playerPaddleHalf > self.maxbCorn){
                }
                else if (playerPaddleHalf < (self.paddel1Control - 12)) {
                    this.y += 12;
                } else if (playerPaddleHalf <= (self.paddel1Control - 7)) {
                    this.y += 7;
                } else if (playerPaddleHalf <= (self.paddel1Control - 3)) {
                    this.y += 3;
                } else if (playerPaddleHalf <= (self.paddel1Control - 1)) {
                    this.y += 1;
                }

                // Don't let the paddle go above or below the screen 
                if (this.y < 0) {
                    this.y = 0;
                } else if ((this.y + this.height) > canvas_instance_height) {
                    this.y = canvas_instance_height - this.height;
                }
            }
        } else if (this.controlMode == 'keyboard') {            
            if (this.moveUp) {
                if ((this.y - 10) >= 0) {
                    this.y -= 10;
                } else {
                    this.y = 0;
                }
            } else if (this.moveDown) {

                if ((this.y + 10 + this.height) <= canvas_instance_height) {
                    this.y += 10;
                } else {
                    this.y = canvas_instance_height - this.height;
                }
            } */
        }        
        self.Paddle1Position.x = this.x;
        self.Paddle1Position.y = this.y;        
    };

    /**
    * Draw player 2's paddle (Right)
    *
    * @since Canvas Pong 1.0
    */
    this.paddle2.redraw = function (_obj) {
        "use strict";
        var self = _obj;
        this.controlMode = 'mouse';
        // Calculate the actual position of the paddle
        if (this.controlMode == 'mouse') {
            if (self.BricksRight[4] == "530,86,30,428") {
               this.height = 0;
               this.width = 0;
			   self.paddle2.width = 0;
			   self.paddle2.height = 0;
            }
			this.y = self.paddel2Control;			
			if(this.y < (canvas_instance_height / 2))
			{
				if (this.y <= 86) {
                    this.y = 86;
                } 
			}	
			else if(this.y > (canvas_instance_height / 2))
			{
				if ((this.y) > 407) {
                    this.y = 407;
                }				
			}
        /*    
        else if (Math.floor(this.y) !== self.paddel2Control) {
                var playerPaddleHalf = Math.floor(this.y);

                // Maove the paddle up towards the mouse
				if(playerPaddleHalf < self.bCorn + self.groundX + self.bYCorn){
                }
                else if (playerPaddleHalf > (self.paddel2Control + 12)) {
                    this.y -= 12;

                } else if (playerPaddleHalf >= (self.paddel2Control + 7)) {
                    this.y -= 7;
                } else if (playerPaddleHalf >= (self.paddel2Control + 3)) {
                    this.y -= 3;
                } else if (playerPaddleHalf >= (self.paddel2Control + 1)) {
                    this.y -= 1;
                }

                // Move the paddle down towards the mouse
                if(playerPaddleHalf > self.maxbCorn){
                }
                else if (playerPaddleHalf < (self.paddel2Control - 12)) {
                    this.y += 12;
                } else if (playerPaddleHalf <= (self.paddel2Control - 7)) {
                    this.y += 7;
                } else if (playerPaddleHalf <= (self.paddel2Control - 3)) {
                    this.y += 3;
                } else if (playerPaddleHalf <= (self.paddel2Control - 1)) {
                    this.y += 1;
                }

                // Don't let the paddle go above or below the screen 
                if (this.y < 0) {
                    this.y = 0;
                } else if ((this.y + this.height) > canvas_instance_height) {
                    this.y = canvas_instance_height - this.height;
                }
            }
        } else if (this.controlMode == 'keyboard') {
            if (this.moveUp) {
                if ((this.y - 10) >= 0) {
                    this.y -= 10;
                } else {
                    this.y = 0;
                }
            } else if (this.moveDown) {

                if ((this.y + 10 + this.height) <= canvas_instance_height) {
                    this.y += 10;
                } else {
                    this.y = canvas_instance_height - this.height;
                }
            } */
        }        
        self.Paddle2Position.x = this.x;
        self.Paddle2Position.y = this.y;        
    };
	
    //paddle 3 (Bottom)
    this.paddle3.redraw = function (_obj) {
        "use strict";
        var self = _obj;
        // Calculate the actual position of the paddle
        this.controlMode = 'mouse';
        if (this.controlMode == 'mouse') {
            if (self.BricksBottom[4] == "86,530,428,30") {
               this.height = 0;
               this.width = 0;
			   self.paddle3.width = 0;
			   self.paddle3.height = 0;
             }
			 
			this.x = self.paddel3Control;
			if(this.x < (canvas_instance_width / 2))
			{
				if (this.x <= 86) {
                    this.x = 86;
                } 
			}	
			else if(this.x > (canvas_instance_width / 2))
			{
				if ((this.x) > 407) {
                    this.x = 407;
                }				
			}
			/*
            // Calculate the actual position of the paddle
            else if (Math.floor(this.x) !== self.paddel3Control) {
                var playerPaddleHalf = Math.floor(this.x);
                // Maove the paddle up towards the mouse
                if(playerPaddleHalf < self.bCorn + self.groundX + self.bYCorn){
                }
                else if (playerPaddleHalf > (self.paddel3Control + 12)) {
                    this.x -= 12;
                } else if (playerPaddleHalf >= (self.paddel3Control + 7)) {
                    this.x -= 7;
                } else if (playerPaddleHalf >= (self.paddel3Control + 3)) {
                    this.x -= 3;
                } else if (playerPaddleHalf >= (self.paddel3Control + 1)) {
                    this.x -= 1;
                }

                // Move the paddle down towards the mouse
                if(playerPaddleHalf > self.maxbCorn){
                }
                else if (playerPaddleHalf < (self.paddel3Control - 12)) {
                    this.x += 12;
                } else if (playerPaddleHalf <= (self.paddel3Control - 7)) {
                    this.x += 7;
                } else if (playerPaddleHalf <= (self.paddel3Control - 3)) {
                    this.x += 3;
                } else if (playerPaddleHalf <= (self.paddel3Control - 1)) {
                    this.x += 1;
                }

                // Don't let the paddle go above or below the screen 
                if (this.x < 0) {
                    this.x = 0;
                } else if ((this.x + this.width) > canvas_instance_width) {
                    this.x = canvas_instance_width - this.width;
                }
            } */
        }
        self.Paddle3Position.x = this.x;
        self.Paddle3Position.y = this.y;     
    };

    //paddle 4 (Top)
    this.paddle4.redraw = function (_obj) {
        "use strict";
        var self = _obj;
        // Calculate the actual position of the paddle
        this.controlMode = 'mouse';
        if (this.controlMode == 'mouse') {
            if (self.BricksTop[4] == "86,40,428,30") {
               this.height = 0;
               this.width = 0;
			   self.paddle4.width = 0;
			   self.paddle4.height = 0;
            }
			this.x = self.paddel4Control;
			if(this.x < (canvas_instance_width / 2))
			{
				if (this.x <= 86) {
                    this.x = 86;
                } 
			}	
			else if(this.x > (canvas_instance_width / 2))
			{
				if ((this.x) > 407) {
                    this.x = 407;
                }				
			}	
			
			 /*
            // Calculate the actual position of the paddle
            else if (Math.floor(this.x) !== self.paddel4Control) {
                var playerPaddleHalf = Math.floor(this.x);
                // Maove the paddle up towards the mouse
                if(playerPaddleHalf < self.bCorn + self.groundX + self.bYCorn){
                }
                else if (playerPaddleHalf > (self.paddel4Control + 12)) {
                    this.x -= 12;
                } else if (playerPaddleHalf >= (self.paddel4Control + 7)) {
                    this.x -= 7;
                } else if (playerPaddleHalf >= (self.paddel4Control + 3)) {
                    this.x -= 3;
                } else if (playerPaddleHalf >= (self.paddel4Control + 1)) {
                    this.x -= 1;
                }
                // Move the paddle down towards the mouse
                if(playerPaddleHalf > self.maxbCorn){
                }
                else if (playerPaddleHalf < (self.paddel4Control - 12)) {
                    this.x += 12;
                } else if (playerPaddleHalf <= (self.paddel4Control - 7)) {
                    this.x += 7;
                } else if (playerPaddleHalf <= (self.paddel4Control - 3)) {
                    this.x += 3;
                } else if (playerPaddleHalf <= (self.paddel4Control - 1)) {
                    this.x += 1;
                }
				
                // Don't let the paddle go above or below the screen 
                if (this.x <= 70) {
                    this.x = 60;
                } else if ((this.x + this.width) > canvas_instance_width) {
                    this.x = canvas_instance_width - this.width;
                }
            } */
        }
        self.Paddle4Position.x = this.x;
        self.Paddle4Position.y = this.y;       
    };
   this.ball.redraw = function (_obj) {
        "use strict";						
        var self = _obj;
		//console.log("this.speed"+ this.speed) ;
        if (this.speed === 0) {
		
		//console.log(" call this.speed") ;
            // Set the initial speed
            this.speed = this.minSpeed;
            // Randomly decide whether to start the ball on player 1 or 2's side            
            this.moveToX = Math.floor(_obj.GetRandomXDirection() * 2) * canvas_instance_width;            
            // Randomly determine a point on the Y axis to move the ball towards
            this.moveToY = Math.floor(_obj.GetRandomYDirection() * canvas_instance_height);            
            // Calculate the speed to move in the X and Y axis
            if(this.moveToX > this.moveToY ){
               var distanceX = Math.abs(this.moveToX - this.x);
               var distanceY = Math.abs(this.y - this.moveToY);
            }
            else if(this.moveToY > this.moveToX ){
               var distanceX = Math.abs(this.x  -this.moveToX );
               var distanceY = Math.abs(this.moveToY - this.y);
            }
            var speedX = distanceX / this.speed;
            var speedY = distanceY / this.speed;

            if (speedX > speedY) {
                speedY = distanceY / speedX;
                speedX = (distanceX / speedX);
            } else if (speedY > speedX) {
                speedX = distanceX / speedY;
                speedY = (distanceY / speedY);
            }

            if ((this.y - this.moveToY) > 0) {
                speedY *= -1;
            }

            if ((this.moveToX - this.x) < 0) {
                speedX *= -1;
            }

            this.speedX = speedX;
            this.speedY = speedY;			
        }        		
        // Only move the ball along the x axis if it isn't going past a player's paddle
		if ((this.x > (self.paddle1.x )) && ((this.x + this.height) < (self.paddle2.x + self.paddle2.width)) && self.paddle1.flag==false && self.paddle2.flag==false)
		{ 
			if (self.paddle1.reflect == true || self.paddle2.reflect == true )
			{				
				this.x += this.speedX;		
				self.paddle1.reflect = false;	 
				self.paddle2.reflect = false;	 
			}
			else if(((this.x + this.speedX) < (self.paddle1.width + self.paddle1.x)) && self.paddle1.width > 0 && ((this.y + this.height + this.speedY) > self.paddle1.y && (this.y + this.speedY) < (self.paddle1.y + self.paddle1.height )))
			{
				self.paddle1.reflect = true;	 
				self.paddle1.flag = true;
				this.x = (self.paddle1.width + self.paddle1.x);													
			}			
			else if(((this.x + this.height + this.speedX ) >  (self.paddle2.x)) && self.paddle2.width > 0 && ((this.y + this.height + this.speedY ) > self.paddle2.y && (this.y + this.speedY) < (self.paddle2.y + self.paddle2.height)))
			{													
				self.paddle2.reflect = true;
				self.paddle2.flag = true;
				this.x = (self.paddle2.x - this.height);
			}
			else
			{		 
				this.x += this.speedX;
			}						
        }
        else 
		{
			self.paddle1.flag = false; 
			self.paddle2.flag = false; 
            var bReflectBall = true;			
            // Did the ball hit the edge or did it hit a player's paddle?
            //if (((this.y + this.width) < self.paddle1.y || this.y > (self.paddle1.y + self.paddle1.height)) && this.x < (canvas_instance_width / 2)) {
			if (((this.y + this.height) < self.paddle1.y || this.y > (self.paddle1.y + self.paddle1.height)) && this.x < (canvas_instance_width / 2)) {
                bReflectBall = true;				
                //To check where ball has touch the paddle form back start
                //if ((this.x > (self.paddle1.x + this.width))) {
				if ((this.x > (self.paddle1.x +self.paddle1.width))) {
                    bReflectBall = false;
                }
                //To check where ball has touch the paddle form back end
                else
                {   
					currentPos =  Pong.Sockets.PaddlePosition.OTHER;
                    if (self.ball.y > 86 && self.ball.y <= 192) {
                        self.BricksLeft[0].splice(self.BricksLeft[0], 1);
                        self.hideLefftbricks = self.BricksLeft[0].splice(self.BricksLeft[0], 1);
                    }
                    else if (self.ball.y >= 193 && self.ball.y <= 299) {
                        self.BricksLeft[1].splice(self.BricksLeft[1], 1);
                        self.hideLefftbricks = self.BricksLeft[1].splice(self.BricksLeft[1], 1);
                    }
                    else if (self.ball.y >= 300 && self.ball.y < 406) {
                        self.BricksLeft[2].splice(self.BricksLeft[2], 1);
                        self.hideLefftbricks = self.BricksLeft[2].splice(self.BricksLeft[2], 1);
                    }
                    else if (self.ball.y >= 407 && self.ball.y < 514) {
                        self.BricksLeft[3].splice(self.BricksLeft[3], 1);
                        self.hideLefftbricks = self.BricksLeft[3].splice(self.BricksLeft[3], 1);
                    }
                    if (self.hideLefftbricks == "") {
                        if (self.ball.y > 86 && self.ball.y <= 514) {
						//console.log("paddel 1 x" + self.ball.x);
                            self.BricksLeft[4] = [40, 86, 30, 428];
							self.paddle1.width = 0;
							self.paddle1.height = 0;
							// self.paddle1.x=0;
							// self.paddle1.y=0;
                        }
                    }
					self.leftBricks = self.BricksLeft;
                }
            }
            //else if (((this.y + this.width) < self.paddle2.y || this.y > (self.paddle2.y + self.paddle2.height)) && this.x > (canvas_instance_width / 2)) {
			else if (((this.y + this.height) < self.paddle2.y || this.y > (self.paddle2.y + self.paddle2.height)) && this.x > (canvas_instance_width / 2)) {
                bReflectBall = true;
				
                //Added By Ashish To test only Start
				//if ((this.x  < (self.paddle2.x  - this.width))) {				
                if (((this.x +this.height) < self.paddle2.x )) {
                    bReflectBall = false;
                }
                //Added By Ashish To Test only End
                else
                {   
					currentPos =  Pong.Sockets.PaddlePosition.OTHER;
                    if (self.ball.y > 86 && self.ball.y < 192) {
                        self.BricksRight[0].splice(self.BricksRight[0], 1);
                        self.hideRightbricks = self.BricksRight[0].splice(self.BricksRight[0], 1);
                    }
                    else if (self.ball.y >= 193 && self.ball.y < 299) {
                        self.BricksRight[1].splice(self.BricksRight[1], 1);
                        self.hideRightbricks = self.BricksRight[1].splice(self.BricksRight[1], 1);
                    }
                    else if (self.ball.y >= 300 && self.ball.y < 406) {
                        self.BricksRight[2].splice(self.BricksRight[2], 1);
                        self.hideRightbricks = self.BricksRight[2].splice(self.BricksRight[2], 1);
                    }
                    else if (self.ball.y >= 407 && self.ball.y < 514) {
                        self.BricksRight[3].splice(self.BricksRight[3], 1);
                        self.hideRightbricks = self.BricksRight[3].splice(self.BricksRight[3], 1);
                    }
                    if (self.hideRightbricks == "") {
                        if (self.ball.y > 86 && self.ball.y <= 514) {
						// console.log("paddel 2 x" + self.ball.x);
                            self.BricksRight[4] = [530, 86, 30, 428];
							self.paddle2.width = 0;
							self.paddle2.height = 0;
							self.paddle2.x = self.groundX + self.groundW - self.bWallW;
							// self.paddle2.y=0;
                        }						
                    }
                    self.rightBricks = self.BricksRight;
                }
            }
            else if((this.speedX > 0 && this.x < (canvas_instance_width / 2)) || (this.speedX < 0 && this.x > (canvas_instance_width / 2)))
            {	
				bReflectBall = false; 
            }			
			//Added By Ashish To test only start
			var bVerticalReflect = false;			
			if(self.paddle1.height == 0)
			{
			}
			//else if((((this.y + (this.width * 4) ) >= self.paddle1.y) && (this.y <= (self.paddle1.y + self.paddle1.height)) && (this.x < (self.paddle1.x + self.paddle1.width))))
			else if((((this.y + this.height ) >= self.paddle1.y) && (this.y <= (self.paddle1.y + self.paddle1.height)) && (this.x < (self.paddle1.x + self.paddle1.width))))
			{
				bVerticalReflect = true;
				
				//if((this.y + (this.width * 4) ) >= (self.paddle1.y + (self.paddle1.height/2) ))
				if((this.y + this.height) >= (self.paddle1.y + (self.paddle1.height/2) ))
				{
					if((this.speedY > 0))
					{
						bVerticalReflect = false;
					}
				}
				else if((this.speedY < 0) || self.paddle1.width ==0)
				{
					bVerticalReflect = false;
				}
			}
			if(self.paddle2.height == 0)
			{}
			//else if((((this.y + (this.width * 4) ) >= self.paddle2.y) && (this.y <= (self.paddle2.y + self.paddle2.height)) && ((this.x + (this.width * 3)) > self.paddle2.x)))
			else if((((this.y + this.height ) >= self.paddle2.y) && (this.y <= (self.paddle2.y + self.paddle2.height)) && ((this.x + this.height) > self.paddle2.x)))
			{
				bVerticalReflect = true;				
				//	if((this.y + (this.width * 4) ) >= (self.paddle2.y + (self.paddle2.height/2) ))
				if((this.y + this.height ) >= (self.paddle2.y + (self.paddle2.height/2) ))		
				{
					if((this.speedY > 0))
					{
						bVerticalReflect = false;
					}
				}
				else if((this.speedY < 0) || self.paddle2.width ==0)
				{
					bVerticalReflect = false;
				}
			}
			if(bVerticalReflect)
			{
				if (Math.abs(this.speedX * 1.1) < this.maxSpeed && Math.abs(this.speedY * 1.1) < this.maxSpeed) {
					self.BallSpeed = self.BallSpeed + 1;
					if (self.BallSpeed == 15) {
						this.speedX *= 1.3;
						this.speedY *= 1.3;
						self.BallSpeed = 0;
					}
				}
				//code ended for paddel 1 and paddel 2 end					
				this.speedY *= -1;
				this.y += this.speedY;											
			}
			//Added By Ashish To test only end
            if(bReflectBall)
            {
				if (Math.abs(this.speedX * 1.1) < this.maxSpeed && Math.abs(this.speedY * 1.1) < this.maxSpeed) {
					self.BallSpeed = self.BallSpeed + 1;
					if (self.BallSpeed == 15) {
						this.speedX *= 1.3;
						this.speedY *= 1.3;
						self.BallSpeed = 0;
					}
				}
				// The ball hit a paddle, so let's increment the speed (Only if the new speed is under the maximum speed for the ball)				
				if (this.x < (canvas_instance_width / 2)) {                    
					// Calculate where the ball hit on player 1's paddle					 
					 if (((this.y + this.height) > self.paddle1.y && this.y < (self.paddle1.y + self.paddle1.height)) && this.x < (canvas_instance_width / 2) && self.paddle1.height>0) {
						 if ( Math.abs(self.paddle1.y - this.y) < Math.abs(self.paddle1.left))
						 {
							
							currentPos = Pong.Sockets.PaddlePosition.LEFT;
							touchFlag = "Vertical";							
						 }				 
						 else if ((Math.abs(self.paddle1.y - this.y) > Math.abs(self.paddle1.left))&& (Math.abs(self.paddle1.y - this.y) < (Math.abs(self.paddle1.middle)+Math.abs(self.paddle1.left)))){
							
							 currentPos = Pong.Sockets.PaddlePosition.MIDDLE;							 							 							 
						}
						else if ((Math.abs(self.paddle1.y - this.y) > Math.abs(self.paddle1.middle)) && (Math.abs(self.paddle1.y - this.y) < (Math.abs(self.paddle1.right) +Math.abs(self.paddle1.left) +Math.abs(self.paddle1.middle)))){
							
							 currentPos = Pong.Sockets.PaddlePosition.RIGHT;
							 touchFlag = "Vertical";							 
						 }		
						else{
							currentPos =  Pong.Sockets.PaddlePosition.OTHER;							
						}					 
					}else{
							currentPos =  Pong.Sockets.PaddlePosition.OTHER;							
					}
				}
				else {
					// Calculate where the ball hit on player 2's paddle					  
					  if (((this.y + this.height) > self.paddle2.y && this.y < (self.paddle2.y + self.paddle2.height)) && this.x > (canvas_instance_width / 2) && self.paddle2.height>0) {
						 if ( Math.abs(self.paddle2.y - this.y) < Math.abs(self.paddle2.left))
						 {
							
							currentPos = Pong.Sockets.PaddlePosition.LEFT;
							touchFlag = "Vertical";							
						 }
						else if ((Math.abs(self.paddle2.y - this.y) > Math.abs(self.paddle2.left))&& (Math.abs(self.paddle2.y - this.y) < (Math.abs(self.paddle2.middle)+Math.abs(self.paddle2.left)))){
							 currentPos = Pong.Sockets.PaddlePosition.MIDDLE;							 
							 
						}
						else if ((Math.abs(self.paddle2.y - this.y) > Math.abs(self.paddle2.middle)) && (Math.abs(self.paddle2.y - this.y) < (Math.abs(self.paddle2.right) +Math.abs(self.paddle2.left) +Math.abs(self.paddle2.middle)))){
							 currentPos = Pong.Sockets.PaddlePosition.RIGHT;
							 
							 touchFlag = "Vertical";							 
						 }		
						else{
							currentPos =  Pong.Sockets.PaddlePosition.OTHER;							
						}
					}else{
						currentPos =  Pong.Sockets.PaddlePosition.OTHER;						 
					}					
				}							
				this.speedX *= -1;
				// Move the ball a bit to prevent an infinite loop					 				
				 if((Math.abs(currentPos) == Math.abs(Pong.Sockets.PaddlePosition.MIDDLE))){
					this.x += this.speedX;						
				 }
				 else if((((Math.abs(currentPos) == Math.abs(Pong.Sockets.PaddlePosition.LEFT)) || (Math.abs(currentPos) == Math.abs(Pong.Sockets.PaddlePosition.RIGHT))) && (touchFlag == "Vertical")) || (Math.abs(currentPos) == Math.abs(Pong.Sockets.PaddlePosition.OTHER)))
				 {
					if (this.speedY >= 0 )
					{
						this.speedY = Math.sqrt((Math.abs(((this.speedY*this.speedY) + (this.speedX*this.speedX)) - ((this.speedX/2)*(this.speedX/2)))));
						//this.y += Math.sqrt(Math.abs(((this.speedY*this.speedY) + (this.speedX*this.speedX)) - ((this.speedX/2)*(this.speedX/2))));
					}else
					{						
						this.speedY = -Math.abs(Math.sqrt(Math.abs(((this.speedY*this.speedY) + (this.speedX*this.speedX)) - ((this.speedX/2)*(this.speedX/2)))));
						//this.y +=  -Math.sqrt(Math.abs(((this.speedY*this.speedY) + (this.speedX*this.speedX)) - ((this.speedX/2)*(this.speedX/2))));
					}
					this.speedX = (this.speedX)/2;
					this.x += this.speedX;					
				 }
				 else{
					 this.x += this.speedX;					
				 }			
            }
            else
            {	
				this.x += this.speedX;
            }
		}		
        if ((((this.y + this.width) < (self.paddle3.y + self.paddle3.height) && this.y  > (self.paddle4.y + self.paddle4.height))) && self.paddle3.flag== false && self.paddle4.flag== false) 		
		{				 
			if (self.paddle3.reflect == true || self.paddle4.reflect == true )
			{							
				this.y += this.speedY;			
				self.paddle3.reflect = false;	 
				self.paddle4.reflect = false;	 
			}			
			else if(((this.y + this.speedY + this.height) > self.paddle3.y) && self.paddle3.width > 0 && (((this.x + this.height + this.speedX) > self.paddle3.x) && ( (this.x + this.speedX) < (self.paddle3.x + self.paddle3.width))))			
			{
				this.y = (self.paddle3.y - this.height);									
				self.paddle3.reflect = true;
				self.paddle3.flag =true;			
			}
			else if((this.y + this.speedY) < (self.paddle4.y + self.paddle4.height) && self.paddle4.height > 0 && (((this.x + this.height + this.speedX) > self.paddle4.x) && ((this.x + this.speedX)< (self.paddle4.x + self.paddle4.width))))
			{				
				this.y = (self.paddle4.y + self.paddle4.height);
				self.paddle4.reflect = true;
				self.paddle4.flag =true;
			}
			else
			{			
				this.y += this.speedY;					
			}						
        }
        else {
			self.paddle3.flag =false;
			self.paddle4.flag =false;
            var bReflectBall = true;
            //if ((((this.x + this.width) < self.paddle3.x) || (this.x > (self.paddle3.x + self.paddle3.width))) && (this.y > (canvas_instance_height / 2))) { 
			if ((((this.x + this.height) < self.paddle3.x) || (this.x > (self.paddle3.x + self.paddle3.width))) && (this.y > (canvas_instance_height / 2))) { 
                bReflectBall = true;
                //Added By Ashish To test only Start
                //if ((((this.y + this.width) < (self.paddle3.y)))) {
				if ((((this.y + this.height) < (self.paddle3.y)))) {
                    bReflectBall = false;
                }
                //Added By Ashish To Test only End
                else
                {
					currentPos =  Pong.Sockets.PaddlePosition.OTHER;
					if (self.ball.x > 86 && self.ball.x < 192) {
						self.BricksBottom[0].splice(self.BricksBottom[0], 1);
						self.hideBottombricks = self.BricksBottom[0].splice(self.BricksBottom[0], 1);
					}
					else if (self.ball.x >= 193 && self.ball.x < 299) {
						self.BricksBottom[1].splice(self.BricksBottom[1], 1);
						self.hideBottombricks = self.BricksBottom[1].splice(self.BricksBottom[1], 1);
					}
					else if (self.ball.x >= 300 && self.ball.x < 406) {
						self.BricksBottom[2].splice(self.BricksBottom[2], 1);
						self.hideBottombricks = self.BricksBottom[2].splice(self.BricksBottom[2], 1);
					}
					else if (self.ball.x >= 407 && self.ball.x <= 514) {
						self.BricksBottom[3].splice(self.BricksBottom[3], 1);
						self.hideBottombricks = self.BricksBottom[3].splice(self.BricksBottom[3], 1);
					}
					if (self.hideBottombricks == "") {
						if (self.ball.x > 86 && self.ball.x <= 514) {
						 //console.log("paddel 3 x" + self.ball.y);
							self.BricksBottom[4] = [86, 530, 428, 30];
							self.paddle3.width = 0;
							self.paddle3.height = 0;							 
							// self.paddle3.x=0;
							 self.paddle3.y = self.groundY + self.groundW - self.bWallH ;
						}
					}
					self.bottomBricks = self.BricksBottom;
                }
            }
		//else if ((((this.x + this.width) < self.paddle4.x) || (this.x > (self.paddle4.x + self.paddle4.width))) && (this.y < (canvas_instance_height / 2))) {
		else if ((((this.x + this.height) < self.paddle4.x) || (this.x > (self.paddle4.x + self.paddle4.width))) && (this.y < (canvas_instance_height / 2))) {
                bReflectBall = true;
                //Added By Ashish To test only Start
                //if (((this.y) > (self.paddle4.y + this.width))) {
				if (((this.y) > self.paddle4.y )) {
                    bReflectBall = false;
                }
                //Added By Ashish To Test only End
                else
                {
					currentPos =  Pong.Sockets.PaddlePosition.OTHER;
					if (self.ball.x > 86 && self.ball.x <= 192) {
						self.BricksTop[0].splice(self.BricksTop[0], 1);
						self.hideTopbricks = self.BricksTop[0].splice(self.BricksTop[0], 1);
					}
					else if (self.ball.x >= 193 && self.ball.x <= 299) {
						self.BricksTop[1].splice(self.BricksTop[1], 1);
						self.hideTopbricks = self.BricksTop[1].splice(self.BricksTop[1], 1);
					}
					else if (self.ball.x >= 300 && self.ball.x <= 406) {
						self.BricksTop[2].splice(self.BricksTop[2], 1);
						self.hideTopbricks = self.BricksTop[2].splice(self.BricksTop[2], 1);
					}
					else if (self.ball.x >= 407 && self.ball.x <= 514) {
						self.BricksTop[3].splice(self.BricksTop[3], 1);
						self.hideTopbricks = self.BricksTop[3].splice(self.BricksTop[3], 1);
					}
					if (self.hideTopbricks == "") {
						if (self.ball.x > 86 && self.ball.x <= 514) {
						 //console.log("paddel 4 x" + self.ball.y);
							self.BricksTop[4] = [86, 40, 428, 30];
							self.paddle4.width = 0;
							self.paddle4.height = 0;	
							// self.paddle4.x=0;
							// self.paddle4.y=0;	
						}
					}
					self.topBricks = self.BricksTop;
                }
            }
            else if((this.speedY > 0 && (this.y < (canvas_instance_height / 2))) ||  (this.speedY < 0 && (this.y > (canvas_instance_height / 2))))
            {
                bReflectBall = false;
            }			
			//Added By Ashish To test only start
			var bHorizontalReflect = false;
			if(self.paddle3.width == 0)
			{}
			else if((((this.x + this.height ) >= self.paddle3.x) && (this.x <= (self.paddle3.x + self.paddle3.width)) && (((this.y + this.height) > self.paddle3.y))))
			{
				bHorizontalReflect = true;
				if((this.x + this.height ) >= (self.paddle3.x + (self.paddle3.width/2) ))
				{
					if((this.speedX > 0))
					{
						bHorizontalReflect = false;	
					}
				}
				else if((this.speedX < 0) ||  self.paddle3.width == 0)
				{
					bHorizontalReflect = false;	
				}
			}
			
			if(self.paddle4.width == 0)
			{}
			//else if((((this.x + (this.width * 4) ) >= self.paddle4.x) && (this.x <= (self.paddle4.x + self.paddle4.width)) && ( this.y < self.paddle4.y + self.paddle4.height)))
			else if((((this.x + this.height ) >= self.paddle4.x) && (this.x <= (self.paddle4.x + self.paddle4.width)) && ( this.y < self.paddle4.y + self.paddle4.height)))
			{
				//bHorizontalReflect = true;
				bHorizontalReflect = false;
				//if((this.x + (this.width * 4) ) >= (self.paddle4.x + (self.paddle4.width/2) ))
				if((this.x + this.height ) >= (self.paddle4.x + (self.paddle4.width/2) ))
				{
					if((this.speedX > 0))
					{
						bHorizontalReflect = false;	
					}
				}
				else if((this.speedX < 0) || self.paddle4.width == 0)
				{
					bHorizontalReflect = false;	
				}
			}			
			if(bHorizontalReflect)
			{
				if (Math.abs(this.speedX * 1.1) < this.maxSpeed && Math.abs(this.speedY * 1.1) < this.maxSpeed) 
				{
					self.BallSpeed = self.BallSpeed + 1;
					if (self.BallSpeed == 15) {
						this.speedX *= 1.3;
						this.speedY *= 1.3;
						self.BallSpeed = 0;
					}
				}
				// Reverse the horizontal direction of the ball
				this.speedX *= -1;
				// Move the ball a bit to prevent an infinite loop
				this.x += this.speedX;
            }
			//Added By Ashish To test only end
            if(bReflectBall)
            {
				if (Math.abs(this.speedX * 1.1) < this.maxSpeed && Math.abs(this.speedY * 1.1) < this.maxSpeed) {
					self.BallSpeed = self.BallSpeed + 1;
					if (self.BallSpeed == 15) {
						this.speedX *= 1.3;
						this.speedY *= 1.3;
					   self.BallSpeed = 0;
					}
				}
				if (this.y < (canvas_instance_height / 2)) {
					currentPos = Pong.Sockets.PaddlePosition.OTHER;
					// Calculate where the ball hit on player 4's paddle                 					 
					 if ((((this.x + this.height) > self.paddle4.x) && (this.x < (self.paddle4.x + self.paddle4.width))) && (this.y < (canvas_instance_height / 2)) && self.paddle4.width >0) {
						if (Math.abs(self.paddle4.x - this.x) < Math.abs(self.paddle4.left))
						{					  					  
							currentPos = Pong.Sockets.PaddlePosition.LEFT;
							touchFlag = "Horizontal";
							//console.log("paddle 4  left" +currentPos);	
						}
						else if ((Math.abs(self.paddle4.x - this.x) > Math.abs(self.paddle4.left))&& (Math.abs(self.paddle4.x - this.x) < (Math.abs(self.paddle4.middle)+Math.abs(self.paddle4.left)))){					  
							currentPos = Pong.Sockets.PaddlePosition.MIDDLE;							
						}
						else if ((Math.abs(self.paddle4.x - this.x) > Math.abs(self.paddle4.middle)) && (Math.abs(self.paddle4.x - this.x) < (Math.abs(self.paddle4.right) +Math.abs(self.paddle4.left) +Math.abs(self.paddle4.middle)))){	
							currentPos = Pong.Sockets.PaddlePosition.RIGHT;
							touchFlag = "Horizontal";
							//console.log("paddle 4  right" +currentPos);	
						 }
						 else
						 {
							currentPos =  Pong.Sockets.PaddlePosition.OTHER;
						 }				 		
					 }
					 else{
					 	currentPos =  Pong.Sockets.PaddlePosition.OTHER;							
					 }
					 //console.log("paddle 4  " +currentPos);
				} else {
				// Calculate where the ball hit on player 3's paddle
					currentPos = Pong.Sockets.PaddlePosition.OTHER;					 
					if ((((this.x + this.height) > self.paddle3.x) && (this.x < (self.paddle3.x + self.paddle3.width))) && (this.y > (canvas_instance_height / 2))&& self.paddle3.width >0) { 					 
						if ( Math.abs(self.paddle3.x - this.x) < Math.abs(self.paddle3.left))
						{					  					  
							currentPos = Pong.Sockets.PaddlePosition.LEFT;
							touchFlag = "Horizontal";
							//console.log("paddle 3  left" +currentPos);	
						}
						else if ((Math.abs(self.paddle3.x - this.x) > Math.abs(self.paddle3.left))&& (Math.abs(self.paddle3.x - this.x) < (Math.abs(self.paddle3.middle)+Math.abs(self.paddle3.left)))){					  
							currentPos = Pong.Sockets.PaddlePosition.MIDDLE;							
						}				
						else if ((Math.abs(self.paddle3.x - this.x) > Math.abs(self.paddle3.middle)) && (Math.abs(self.paddle3.x - this.x) < (Math.abs(self.paddle3.right) +Math.abs(self.paddle3.left) +Math.abs(self.paddle3.middle)))){
							currentPos = Pong.Sockets.PaddlePosition.RIGHT;		
							touchFlag = "Horizontal";							
							//console.log("paddle 3  right" +currentPos);	
						 }
						 else
						 {
							currentPos =  Pong.Sockets.PaddlePosition.OTHER;														
						 }					 
					}else{
							currentPos =  Pong.Sockets.PaddlePosition.OTHER;							
					}
					 //console.log("paddle 3  " +currentPos);										 
				}				 
				//code ended for paddel 3 and paddel 4 end				
				this.speedY *= -1;
				//this.y += this.speedY;
				 if(Math.abs(currentPos) == Math.abs(Pong.Sockets.PaddlePosition.MIDDLE))
				 {
					 this.y += this.speedY;					
				 }
				 else if((((Math.abs(currentPos) == Math.abs(Pong.Sockets.PaddlePosition.LEFT)) || (Math.abs(currentPos) == Math.abs(Pong.Sockets.PaddlePosition.RIGHT))) && (touchFlag == "Horizontal"))|| (Math.abs(currentPos) == Math.abs(Pong.Sockets.PaddlePosition.OTHER)))
				 {	
					if(this.speedX >= 0 )
					{
						this.speedX = Math.abs(Math.sqrt(Math.abs(((this.speedX*this.speedX) + (this.speedY*this.speedY)) - ((this.speedY/2)*(this.speedY/2)))));
						this.x += this.speedX;
						//this.x +=   Math.sqrt(Math.abs(((this.speedX*this.speedX) + (this.speedY*this.speedY)) - ((this.speedY/2)*(this.speedY/2))));
						//this.x += Math.sqrt(Math.abs((Math.abs(this.speedX)*Math.abs(this.speedX)) + (Math.abs(this.speedY)*Math.abs(this.speedY))) - ((Math.abs(this.speedY)/2)*(Math.abs(this.speedY)/2)));
					}
					else{
						this.speedX = -Math.abs(Math.sqrt(Math.abs(((this.speedX*this.speedX) + (this.speedY*this.speedY)) - ((this.speedY/2)*(this.speedY/2)))));
						this.x += this.speedX;
						//this.x += -Math.sqrt(Math.abs((Math.abs(this.speedX)*Math.abs(this.speedX)) + (Math.abs(this.speedY)*Math.abs(this.speedY))) - ((Math.abs(this.speedY)/2)*(Math.abs(this.speedY)/2)));						
					}
					this.speedY=(this.speedY)/2;
					this.y += this.speedY;					
					//this.y += (this.speedY)/2;					
				 }
				 else
				 {
					 this.y += this.speedY;					 
				 }
			//	console.log(" finale p3.y:: " + this.y + "  speedx "+ this.speedX + "  speedy "+ this.speedY) ;

            }
            else
            {
				 this.y += this.speedY;				  
            }
		}
		 if(this.x < (self.groundX + self.bWallW))
		 {		
			 this.x = self.groundX + self.bWallW; 
		 }
		 else if(this.x > (self.groundX + self.groundW - self.bWallW - this.height))
		 {
			 this.x= (self.groundX + self.groundW - self.bWallW - this.height);
		 }
		 else if(this.y < (self.groundX + self.bWallW)){
			 this.y = self.groundX + self.bWallW;
		  }
		  else if(this.y > ((self.groundX + self.groundW - self.bWallW - this.height))){			
			 this.y = (self.groundX + self.groundW - self.bWallW - this.height);			 
		 }		  
		// console.log(" call this.y" + this.y + " call this.x" + this.x + "this.speedY" + this.speedY + "this.speedX"  + this.speedX) ;
		self.GetWinner();
        self.BallPosition.x = parseInt(this.x);
        self.BallPosition.y = parseInt(this.y);
    };

    
	//===============Added by Diksha=======================
    this.GetWinner = function() {
        var self = this;
		//console.log(rooms[self.roomKey] + "  rooms[self.roomKey].GameEnded" + JSON.stringify(rooms[self.roomKey].GameEnded))
        if(rooms[self.roomKey] == undefined || rooms[self.roomKey] == null || rooms[self.roomKey].GameEnded)
        {
            return;
        }
        else
        {		
            var msg = {} ;
            msg.Type = Pong.Sockets.MessageType.RESULT;
            if (self.BricksRight[4] == "530,86,30,428" &&  self.BricksTop[4] == "86,40,428,30" &&  self.BricksBottom[4] == "86,530,428,30") {
               msg.value = 'Paddle 1 Winner';
               msg.PlayerPosition = Pong.Sockets.PlayerPosition.LEFT;
               socketio.sockets.in(self.roomKey).emit('message', msg);
               // try
               // {
                    // rooms[self.roomKey].SelfSocket.emit('message', msg);
               // }
               // catch(ex)
               // {
                    // console.log("SelfSocket Not defind: ", ex);
               // }
			   this.LeaveRoom(self.roomKey); 
               rooms[self.roomKey].GameEnded = true;
               this.StopRoom(self.roomKey);
            }
            else if ( this.BricksRight[4] == "530,86,30,428" &&  this.BricksTop[4] == "86,40,428,30" &&  this.BricksLeft[4] == "40,86,30,428") {
              msg.value = 'Paddle 3 Winner';
              msg.PlayerPosition = Pong.Sockets.PlayerPosition.DOWN;
              socketio.sockets.in(self.roomKey).emit('message', msg);
              // try
               // {
                    // rooms[self.roomKey].SelfSocket.emit('message', msg);
               // }
               // catch(ex)
               // {
                    // console.log("SelfSocket Not defind: ", ex);
               // }
			  this.LeaveRoom(self.roomKey); 
              rooms[self.roomKey].GameEnded = true;
              this.StopRoom(self.roomKey);
            }
            else if ( this.BricksLeft[4] == "40,86,30,428" &&  this.BricksTop[4] == "86,40,428,30" &&  this.BricksBottom[4] == "86,530,428,30") {
              msg.value = 'Paddle 2 Winner';
              msg.PlayerPosition = Pong.Sockets.PlayerPosition.RIGHT;
              socketio.sockets.in(self.roomKey).emit('message', msg);
              // try
               // {
                    // rooms[self.roomKey].SelfSocket.emit('message', msg);
               // }
               // catch(ex)
               // {
                    // console.log("SelfSocket Not defind: ", ex);
               // }
			  this.LeaveRoom(self.roomKey); 
              rooms[self.roomKey].GameEnded = true;
              this.StopRoom(self.roomKey);
            }
            else if (this.BricksLeft[4] == "40,86,30,428" &&  this.BricksRight[4] == "530,86,30,428" &&  this.BricksBottom[4] == "86,530,428,30") {
              msg.value = 'Paddle 4 Winner';
              msg.PlayerPosition = Pong.Sockets.PlayerPosition.UP;
              socketio.sockets.in(self.roomKey).emit('message', msg);
              // try
               // {
                    // rooms[self.roomKey].SelfSocket.emit('message', msg);
               // }
               // catch(ex)
               // {
                    // console.log("SelfSocket Not defind: ", ex);
               // }
			  this.LeaveRoom(self.roomKey); 
              rooms[self.roomKey].GameEnded = true;  
              this.StopRoom(self.roomKey);
            }
        }
    }
	
	this.LeaveRoom = function(_roomKey)
    {
        setTimeout(function(){
            var clients = socketio.sockets.clients(_roomKey);   
            for(var i = 0; i < clients.length; i++)
            {
                clients[i].leave(_roomKey);
            }
        },1000);
    }

    this.StopRoom = function(_roomKey)
    {
        setTimeout(function(){
            //console.log("_roomKey: ",_roomKey);
            delete rooms[_roomKey];    
            delete socketio.sockets.manager.rooms['/'+_roomKey];      

            try
            {
                var key = roomKeyMatchMapping[_roomKey];
                var values = key.split(",");
                var matchKey = "T" + values[0] + ":R" + values[1];
                if(matches[matchKey].activeRoomCount <= 0)
                {
                    matches[matchKey].activeRoomCount = 0;
                }
                else
                {   
                    matches[matchKey].activeRoomCount--;
                }
            }
            catch(ex)
            {
                console.log("Error in Stop room decreament activeRoomCount");
            }
            //delete roomKeySocketMapping[_roomKey];
            //delete roomKeyMatchMapping[_roomKey];
        },1000);
    }

    this.GetRandomYDirection = function()
    {
        return yDirectionValues[Math.floor(Math.random()*yDirectionValues.length)];
    }
    this.GetRandomXDirection = function()
    {
        return xDirectionValues[Math.floor(Math.random()*xDirectionValues.length)];
    }
}

function startRoom(_roomkey,_socket, _Match, _delete ,_TID, _TType, _matchKey)
{
	setTimeout(function(){
		if((rooms[_roomkey] == undefined || rooms[_roomkey] == null) && (tournaments["T"+_TID] != undefined && tournaments["T"+_TID] != null) && !matches[_matchKey].started)
		{
			try
			{
				var room = {};				
				_Match = matches[_matchKey];
				matches[_matchKey].started = true;
				// objGamePhysics.roomKey = _roomkey;
				// room.GameObj = objGamePhysics;			
				// room.Players = _Match.currentRoom;
				// room.roomkey = _roomkey;
				// room.isInit = true;
				// var d = GetAustralianTime();
				// d = d.setSeconds(d.getSeconds()+ 12); 
				// room.StartTime = d;
				// rooms[_roomkey] = room;
				JSON.stringify("_TID "+ _TID + "_Match" + JSON.stringify(_Match));
				for(var prop in _Match.rooms)
				{
					room = _Match.rooms[prop];
					var objGamePhysics = new GamePhysics();
					objGamePhysics.roomKey = room.roomkey;
					var d = GetAustralianTime();
					d = d.setSeconds(d.getSeconds()+ 12); 
					room.isInit = true;
					room.StartTime = d;
					room.GameObj = objGamePhysics;
					rooms[room.roomkey] = room;
				}
				//console.log("call start rooom");
				SendStartMessageForMega(_matchKey,1,_Match);
				_Match.currentRoomObj = null;
				room = null;				
				if(_delete)
				{
					deleteObjects(_TID,_TType);
				}
			}
			catch(ex)
			{
				console.log("Error in starting room: ", ex);
			}

		//need to delete roomKeyMatchMapping here
		//delete roomKeySocketMapping[_roomkey];

		}
	},40000);   
}

var rooms = {};
var matches = {};
var tournaments = {};
var broadcastMsg = {};
var rejoinMsg={};
var iCount = 0;
var roomKeyMatchMapping = {};
var roomKeySocketMapping = {};
var roomkey = "";
var canvas_instance_height = 600;
var canvas_instance_width = 600;
var oGamePhysics = new GamePhysics();

function Match() {
    this.currentRoom = [];
    this.currentRoomObj = null;
    this.startTime = GetAustralianTime();
    this.rooms = {};
    this.activeRoomCount = 0;
}

function Tournament()
{
    this.noOfUser = 0;
    this.type = "";
    this.tournamentID = 0;
    this.rooms = [];
}
function generateHexString(length) {
    var ret = "";
    while (ret < length) {
        ret += Math.random().toString(16).substring(2);
    }
    return ret.substring(0, length);
} // <reference path="http://localhost:51441/Pong/js/gameObjects.js" />

  
	  var fs = require('fs'), http = require('http'), socketio = require('/home/ec2-user/node/npm/node_modules/socket.io/index.js');
var server = http.createServer(function (req, res) {
    res.header('Access-Control-Allow-Origin', '*');
    res.header('Access-Control-Allow-Methods', 'GET,PUT,POST,DELETE,OPTIONS');
    res.header('Access-Control-Allow-Headers', 'Content-Type, Authorization, Content-Length, X-Requested-With');
    res.writeHead(200, { 'Content-type': 'text/html' });
    res.end(fs.readFile(__dirname + '/index.html'));
	}).listen(55555, function () {
});
function SendTotalActiveUserMessage(msg, key)
{
	setTimeout(function(){
     socketio.sockets.in(key).emit('message', msg);
	},100);
}
function SendDelayedMessage(timer, msg, key)
{
	//console.log( "key" + key +"last " + JSON.stringify(msg));
    setTimeout(function(){
	//console.log("key" + key + "last " + JSON.stringify(msg));
         socketio.sockets.in(key).emit('message', msg);
    },timer);
}
function SendDisconnectUserMessage(timer, msg, key)
{
    setTimeout(function(){
         socketio.sockets.in(key).emit('message', msg);
    },timer);
}
// function SendDelayedMessageToSelfSocket(timer, msg, key)
// {
	// setTimeout(function(){
		// try
		// {				
			// rooms[key].SelfSocket.emit('message', msg);         
		// }
		// catch(ex)
		// {
			// console.log("SelfSocket not found: ", ex);
		// }
	// },timer);
// }

function SendStartMessageForMega(key,startTimer,oMatch)
{		
    setTimeout( function()
    {
        var oMatch = matches[key];
        var GameState = {}; 
		var CurrentActiveUser = 0;
		var tempRoom=0;
		var tempflag = false ;
		
		for(var _roomKeys in oMatch.rooms)
		{
		 var roomkey =_roomKeys;							
			if(oMatch.rooms[roomkey].Players.length > 0) 
			{
				tempflag = false;
				tempRoom = tempRoom + 1;
				//roomkey = oMatch.currentRoom[0].roomkey;
				//console.log("call");
				for(var j = 0; j < oMatch.rooms[roomkey].Players.length; j++)
				{   if(!oMatch.rooms[roomkey].Players[j].playerInfo.isDisconnected)
					{	
						tempflag = true; 
						CurrentActiveUser = CurrentActiveUser + 1;
					}
				}				
			}						 							
		}
		if(tempRoom == 2 && CurrentActiveUser == 2 && tempflag == true)
		{
			//CurrentActiveUser = 3;
		}
       
		//console.log("CurrentActiveUser " +CurrentActiveUser);
		//console.log("SendStartMessageForMega " +JSON.stringify(GameState) );
		var CurrentRoomUser= 0;
        for(var matchRoom in oMatch.rooms)
        {    
			GameState = {}; 
			CurrentRoomUser= 0;
			GameState.Type = Pong.Sockets.MessageType.GameState;
			GameState.state = Pong.Sockets.GameState.START;		
			GameState.CurrentActiveUser = CurrentActiveUser;
			if(oMatch.rooms[matchRoom].Players.length > 0) 
			{
				for(var j = 0; j < oMatch.rooms[matchRoom].Players.length; j++)
				{   if(!oMatch.rooms[matchRoom].Players[j].playerInfo.isDisconnected)
					{						
						CurrentRoomUser = CurrentRoomUser + 1;
					}
				}
			}
			GameState.CurrentRoomUser = CurrentRoomUser;			
			//console.log("GameState" + JSON.stringify(GameState.CurrentRoomUser));
			SendDelayedMessage(100,GameState,matchRoom);
			 //SendDelayedMessageToSelfSocket(100,GameState,matchRoom);
        }        
    },startTimer);   
}

function deleteObjects(TID, TType){   
    setTimeout(function() {
        try{
               var arrMatches = ["T"+TID+":R1","T"+TID+":R2"];
               if(TType == Pong.TournamentType.MEGA)
               {   
                   arrMatches.push("T"+TID+":R3");    
               }
               for(var i = 0; i< arrMatches.length; i++)
               {
                   for(var roomKeys in matches[arrMatches[i]].rooms)
                   {
                        delete roomKeyMatchMapping[roomKeys];
                        delete roomKeySocketMapping[roomKeys];
                   }
                   delete matches[arrMatches[i]];
                }
                delete tournaments["T"+TID];
           }
           catch(ex)
           {
                console.log("Error deleting objects: ", ex);     
           }
    },50);
}

function GetAustralianTime()
{
	var australianTime;
    var localtime = new Date(); 
    var utc = localtime.getTime() + (localtime.getTimezoneOffset() * 60000);	
	var isDST = checkDST();	
	if(parseInt(isDST) == 1)
	{	
		australianTime = new Date(utc + (3600000*11));
	}
	else
	{	
		australianTime = new Date(utc + (3600000*10));
	}	
    //var australianTime = new Date(utc + (3600000*9.5) - 180000);
    return australianTime;
}

// function checkDST() {
	// var gmt = new Date();
	// var lsm = new Date();
	// var lso = new Date();
	// lsm.setMonth(2); // March
	// lsm.setDate(31);
	// var day = lsm.getDay();// day of week of 31st
	// lsm.setDate(31-day); // last Sunday
	// lso.setMonth(9); // October
	// lso.setDate(31);
	// day = lso.getDay();
	// lso.setDate(31-day);
	// if (gmt < lsm || gmt >= lso){ 
		// return 1;	
	// }
	// return 0;	
// }
function checkDST() {
	var today = new Date;
	var yr = today.getFullYear();
	var gmt = new Date();
	var lsm = new Date("April 06, " + yr + " 02:00:00"); // 1st Sunday in April
	var lso = new Date("October 06, " + yr + " 02:00:00"); // 1st Sunday in October
	lsm.setMonth(3); // March
	//lsm.setDate(31);
	var day = lsm.getDay();// day of week of 31st
	lsm.setDate(6-day); // last Sunday
	lso.setMonth(9); // October
	//lso.setDate(31);	
	day = lso.getDay();
	lso.setDate(6-day);
	//console.log("lsm ", lsm);
	//console.log("lso ", lso);
	if (gmt < lsm || gmt >= lso){ 
		return 1;	
	}
	return 0;	
}



 socketio = socketio.listen(server).on('connection', function (socket) {
    socket.on('message', function (msg) {
        var message = eval('(' + msg + ')');
        switch (message.Type) {
            case Pong.Sockets.MessageType.CONNECT:
			//console.log ("socket.id" +socket.id);
			//console.log("message.userStatus" + message.userStatus);
                socketUserMapping[socket.id] = message.key;
                var oTournament = tournaments["T" + message.TournamentID];
                if(oTournament == null)
                {
                    oTournament = new Tournament();
                }
                oTournament.noOfUser += 1;
                oTournament.type = message.TournamentType;
                oTournament.tournamentID = message.TournamentID;
                var matchKey = "T" + message.TournamentID + ":R" + message.RoundNumber;
				
				oMatch = [];
                oMatch = matches[matchKey];
				
                if(oMatch == null) 
                 {				   
                    oMatch = new Match();
                    if(oTournament.type == Pong.TournamentType.MEGA && message.RoundNumber == 1)
                    {						
                        var startTime = new Date(message.StartTime);                        
                        oMatch.startTime = startTime;
                        //console.log("oMatch.startTime: ", oMatch.startTime);
                        //console.log("GetAustralianTime() ", GetAustralianTime());
                        var startCounter = (startTime - (GetAustralianTime().getTime()));
						//console.log("startCounter" + startCounter);
                        startCounter  = startCounter - 12000;
                        SendStartMessageForMega(matchKey,startCounter,oMatch);
                    }
                    matches[matchKey] = oMatch;
                }

                var player = {};
                var startGame = {};
				var activeUser={};
                player.key = message.key;
				player.userid = message.UserId;
                player.username = message.UserName;
                player.userimage = message.UserImage;
                player.userscore = message.UserScore;
				if(oTournament.type == Pong.TournamentType.MEGA)
				{				
				//-------------------------
					var isReconnectedMEGA = false;
					if (message.userStatus == Pong.userStatus.OLD)
					{
						var roomkey;
						for(var _roomKeys in oMatch.rooms)
						{
							roomkey =_roomKeys;
							//console.log(_roomKeys + "count ++ " + oMatch.rooms[roomkey].Players.length +" === " + oMatch.currentRoom.length);
							if((oMatch.rooms[roomkey].Players.length > 0) && (oTournament.type == Pong.TournamentType.MEGA))
							{
								//roomkey = oMatch.currentRoom[0].roomkey;
								//console.log("call");								 
								for(var j = 0; j < oMatch.rooms[roomkey].Players.length; j++)
								{   if((oMatch.rooms[roomkey].Players[j].playerInfo.userid == player.userid) &&(!oMatch.rooms[roomkey].Players[j].playerInfo.isDisconnected))     
									{										
										var alreadyConnected = {};
										alreadyConnected.Type = Pong.Sockets.MessageType.ALREADYCONNECTED;
										//broadcastMsg.currentRoom = oMatch.currentRoom;
										oTournament.noOfUser = oTournament.noOfUser - 1;
										socket.emit('message', alreadyConnected);
										return;
									}
								}
								for(var j = 0; j < oMatch.rooms[roomkey].Players.length; j++)
								{
									//console.log("call inner" + JSON.stringify(oMatch.rooms[roomkey].Players[j].playerInfo.userid));
									if((oMatch.rooms[roomkey].Players[j].playerInfo.isDisconnected) && (oMatch.rooms[roomkey].Players[j].playerInfo.userid == player.userid))
									{										
										oMatch.currentRoomObj = {};
										//oMatch.currentRoom = oMatch.rooms[roomkey].Players;
										player.position = oMatch.rooms[roomkey].Players[j].playerInfo.position;
										player.isDisconnected = false;
										oMatch.currentRoomObj.roomkey = roomkey;
										player.roomkey = roomkey;
										oMatch.currentRoomObj.playerInfo = player;
										oMatch.rooms[roomkey].Players[j].playerInfo = player;
										//oMatch.currentRoom[oMatch.rooms[roomkey].Players[j].playerInfo.position] = 	oMatch.currentRoomObj;
										socket.join(oMatch.currentRoomObj.roomkey);
										isReconnectedMEGA = true;
										oTournament.noOfUser = oTournament.noOfUser - 1;										
										rejoinMsg.Type = Pong.Sockets.MessageType.CONNECT;
										rejoinMsg.currentRoom = oMatch.rooms[roomkey].Players;
										socketio.sockets.in(player.roomkey).emit('message',rejoinMsg);
										//oMatch.currentRoomObj = null;
										if(oTournament.type == Pong.TournamentType.MEGA && message.RoundNumber == 1)
										{
											  activeUser.Type = Pong.Sockets.MessageType.TOTALACTIVEUSER;
											  activeUser.state = Pong.TournamentType.MEGA;
											  activeUser.noOfUser = oTournament.noOfUser;
											  var plyercount = 0;					  
											  for(var _roomKeys in oMatch.rooms)
											  {
												 plyercount+= oMatch.rooms[_roomKeys].Players.length;
											  }
											  activeUser.noOfUser = plyercount;					  
											  for(var _roomKeys in oMatch.rooms)
											  {							  
												SendTotalActiveUserMessage(activeUser,_roomKeys);
											  }											  
										}		
											oMatch.currentRoomObj = null;	
										break;
									}
								}
							}
							if(isReconnectedMEGA)					
							{	
								return;							
								break;
							}							
						}
					}					
				//----------------------
					if(!isReconnectedMEGA)
					{
						if(oTournament.type == Pong.TournamentType.MEGA && message.RoundNumber == 1)
						{
							var room = {};
							if (oMatch.currentRoom.length == 3) {
								//room.SelfSocket = socket;
								oMatch.currentRoomObj = {};
								player.position = Pong.Sockets.PlayerPosition.UP;
								oMatch.currentRoomObj.playerInfo = player;
								oMatch.currentRoomObj.roomkey = oMatch.currentRoom[0].roomkey;
								player.roomkey = oMatch.currentRoomObj.roomkey;               
								socket.join(oMatch.currentRoomObj.roomkey);                                 
								startGame.Type = Pong.Sockets.MessageType.GameState;
								startGame.state = Pong.Sockets.GameState.START;
								oMatch.currentRoom.push(oMatch.currentRoomObj);
							}
							if (oMatch.currentRoom.length == 2) {
								oMatch.currentRoomObj = {};
								player.position = Pong.Sockets.PlayerPosition.DOWN;
								oMatch.currentRoomObj.playerInfo = player;
								oMatch.currentRoomObj.roomkey = oMatch.currentRoom[0].roomkey;
								player.roomkey = oMatch.currentRoomObj.roomkey;
								socket.join(oMatch.currentRoomObj.roomkey);                        
								oMatch.currentRoom.push(oMatch.currentRoomObj);
								oMatch.currentRoomObj = null;
							}
							if (oMatch.currentRoom.length == 1) {
								oMatch.currentRoomObj = {};
								player.position = Pong.Sockets.PlayerPosition.RIGHT;
								oMatch.currentRoomObj.playerInfo = player;
								oMatch.currentRoomObj.roomkey = oMatch.currentRoom[0].roomkey;
								player.roomkey = oMatch.currentRoomObj.roomkey;
								socket.join(oMatch.currentRoomObj.roomkey);
								oMatch.currentRoom.push(oMatch.currentRoomObj);
								oMatch.currentRoomObj = null;
							}
							if (oMatch.currentRoom.length == 0) {
								oMatch.activeRoomCount++;
								oMatch.currentRoomObj = {};
								player.position = Pong.Sockets.PlayerPosition.LEFT;
								oMatch.currentRoomObj.playerInfo = player;
								oMatch.currentRoomObj.roomkey = generateHexString(30);
								player.roomkey = oMatch.currentRoomObj.roomkey;						
								socket.join(oMatch.currentRoomObj.roomkey);
								startGame.state = Pong.Sockets.GameState.PAUSE;                        
								oMatch.currentRoom.push(oMatch.currentRoomObj);
								oMatch.currentRoomObj = null;
							}
							var objGamePhysics = new GamePhysics();
							objGamePhysics.roomKey = oMatch.currentRoom[0].roomkey;
							room.GameObj = objGamePhysics;
							room.Players = oMatch.currentRoom;
							//room.SelfSocket = socket;
							room.roomkey = oMatch.currentRoom[0].roomkey;
							room.isInit = true; 
							room.StartTime = oMatch.startTime;
							rooms[oMatch.currentRoom[0].roomkey] = room;
							oMatch.rooms[room.roomkey] = room;
						}
						else if(oTournament.type == Pong.TournamentType.MEGA && message.RoundNumber == 2)
						{
							var room = {};
							if (oMatch.currentRoom.length == 3) {
								oMatch.currentRoomObj = {};
								player.position = Pong.Sockets.PlayerPosition.UP;
								oMatch.currentRoomObj.playerInfo = player;
								roomkey = oMatch.currentRoomObj.roomkey;
								oMatch.currentRoomObj.roomkey = oMatch.currentRoom[0].roomkey;
								player.roomkey = oMatch.currentRoomObj.roomkey;
								socket.join(oMatch.currentRoomObj.roomkey);
								startGame.Type = Pong.Sockets.MessageType.GameState;
								startGame.state = Pong.Sockets.GameState.START;
								oMatch.currentRoom.push(oMatch.currentRoomObj);
								//var room = {};                    
								//var objGamePhysics = new GamePhysics();
								//objGamePhysics.roomKey = oMatch.currentRoom[0].roomkey;
								//room.GameObj = objGamePhysics;                    
								//room.Players = oMatch.currentRoom;
								//room.SelfSocket = socket;
								//room.roomkey = oMatch.currentRoomObj.roomkey;                        
								//var d = GetAustralianTime();
								//d = d.setSeconds(d.getSeconds()+ 12); 
								//room.StartTime = d;
								//room.isInit = true;
								//oTournament.rooms.push(room);
								//oMatch.rooms[room.roomKey] = room;
								//rooms[oMatch.currentRoomObj.roomkey] = room;
								oMatch.currentRoomObj = null;
								//room = null;
								//setTimeout(function () {
								//    socketio.sockets.in(player.roomkey).emit('message', startGame);
								//    rooms[player.roomkey].SelfSocket.emit('message', startGame);
								//},500);
								roomkey = "";
							} 
							else if (oMatch.currentRoom.length == 0) {
								oMatch.activeRoomCount++;
								oMatch.currentRoomObj = {};
								player.position = Pong.Sockets.PlayerPosition.LEFT;
								oMatch.currentRoomObj.playerInfo = player;
								oMatch.currentRoomObj.roomkey = generateHexString(30);
								player.roomkey = oMatch.currentRoomObj.roomkey;
								socket.join(oMatch.currentRoomObj.roomkey);
								startGame.state = Pong.Sockets.GameState.PAUSE;
								oMatch.currentRoom.push(oMatch.currentRoomObj);
								oMatch.currentRoomObj = null;
							}
							else if (oMatch.currentRoom.length == 1) {
								oMatch.currentRoomObj = {};
								player.position = Pong.Sockets.PlayerPosition.RIGHT;
								oMatch.currentRoomObj.playerInfo = player;
								oMatch.currentRoomObj.roomkey = oMatch.currentRoom[0].roomkey;
								player.roomkey = oMatch.currentRoomObj.roomkey;
								socket.join(oMatch.currentRoomObj.roomkey);
								oMatch.currentRoom.push(oMatch.currentRoomObj);
								oMatch.currentRoomObj = null;
							}
							else if (oMatch.currentRoom.length == 2) {
								oMatch.currentRoomObj = {};
								player.position = Pong.Sockets.PlayerPosition.DOWN;
								oMatch.currentRoomObj.playerInfo = player;
								oMatch.currentRoomObj.roomkey = oMatch.currentRoom[0].roomkey;
								player.roomkey = oMatch.currentRoomObj.roomkey;
								socket.join(oMatch.currentRoomObj.roomkey);
								oMatch.currentRoom.push(oMatch.currentRoomObj);
								oMatch.currentRoomObj = null;
							}
							var objGamePhysics = new GamePhysics();
							objGamePhysics.roomKey = oMatch.currentRoom[0].roomkey;
							room.GameObj = objGamePhysics;
							room.Players = oMatch.currentRoom;
							//room.SelfSocket = socket;
							room.roomkey = oMatch.currentRoom[0].roomkey;
							room.isInit = true;				   
							room.StartTime = oMatch.startTime;
							//rooms[oMatch.currentRoom[0].roomkey] = room;
							oMatch.rooms[room.roomkey] = room;
						}
						else if(oTournament.type == Pong.TournamentType.MEGA && message.RoundNumber == 3)
						{
							var room = {};
							if (oMatch.currentRoom.length == 1) {                        
								oMatch.currentRoomObj = {};
								player.position = Pong.Sockets.PlayerPosition.RIGHT;
								oMatch.currentRoomObj.playerInfo = player;
								oMatch.currentRoomObj.roomkey = oMatch.currentRoom[0].roomkey;
								player.roomkey = oMatch.currentRoomObj.roomkey;
								socket.join(oMatch.currentRoomObj.roomkey);
								startGame.Type = Pong.Sockets.MessageType.GameState;
								startGame.state = Pong.Sockets.GameState.START;
								oMatch.currentRoom.push(oMatch.currentRoomObj);
								//var room = {};                    
								//var objGamePhysics = new GamePhysics();
								//objGamePhysics.roomKey = oMatch.currentRoom[0].roomkey;
								//room.GameObj = objGamePhysics;                    
								//room.Players = oMatch.currentRoom;
								//room.SelfSocket = socket;
								//room.roomkey = oMatch.currentRoomObj.roomkey;
								//var d = GetAustralianTime();
								//d = d.setSeconds(d.getSeconds()+ 12); 
								//room.StartTime = d;
								//room.isInit = true;
								//oTournament.rooms.push(room);
								//oMatch.rooms[room.roomKey] = room;
								//rooms[oMatch.currentRoomObj.roomkey] = room;
								oMatch.currentRoomObj = null;
								//room = null;
								//setTimeout(function () {
								//    socketio.sockets.in(player.roomkey).emit('message', startGame);
								//    rooms[player.roomkey].SelfSocket.emit('message', startGame);
								//},500);
								roomkey = "";
							}
							if (oMatch.currentRoom.length == 0) {
								oMatch.activeRoomCount++;
								oMatch.currentRoomObj = {};
								player.position = Pong.Sockets.PlayerPosition.LEFT;
								oMatch.currentRoomObj.playerInfo = player;
								oMatch.currentRoomObj.roomkey = generateHexString(30);
								player.roomkey = oMatch.currentRoomObj.roomkey;
								socket.join(oMatch.currentRoomObj.roomkey);
								startGame.state = Pong.Sockets.GameState.PAUSE;
								oMatch.currentRoom.push(oMatch.currentRoomObj);
								oMatch.currentRoomObj = null;
							}
							var objGamePhysics = new GamePhysics();
							objGamePhysics.roomKey = oMatch.currentRoom[0].roomkey;
							room.GameObj = objGamePhysics;
							room.Players = oMatch.currentRoom;
							//room.SelfSocket = socket;
							room.roomkey = oMatch.currentRoom[0].roomkey;
							room.isInit = true;				   
							room.StartTime = oMatch.startTime;
							//rooms[oMatch.currentRoom[0].roomkey] = room;
							oMatch.rooms[room.roomkey] = room;
						}
					}
				}
                else
                {
					//Ashish 29-Dec-2012 Added for testing only to start
					var isReconnected = false;
					if((oMatch.currentRoom.length > 0) && (oTournament.type == Pong.TournamentType.PLAYFORFUN))
					{
						roomkey = oMatch.currentRoom[0].roomkey;
						for(var j = 0; j < oMatch.rooms[roomkey].Players.length; j++)
						{   if((oMatch.rooms[roomkey].Players[j].playerInfo.userid == player.userid) &&(!oMatch.rooms[roomkey].Players[j].playerInfo.isDisconnected))     
							{
								var alreadyConnected = {};
								alreadyConnected.Type = Pong.Sockets.MessageType.ALREADYCONNECTED;
								//broadcastMsg.currentRoom = oMatch.currentRoom;
								socket.emit('message', alreadyConnected);
								return;
							}
						}
						for(var j = 0; j < oMatch.rooms[roomkey].Players.length; j++)
						{
							if(oMatch.rooms[roomkey].Players[j].playerInfo.isDisconnected)
							{
								//console.log("Current Room: ", oMatch.rooms[roomkey].Players);
								oMatch.currentRoomObj = {};
								oMatch.currentRoom = oMatch.rooms[roomkey].Players;
								player.position = oMatch.rooms[roomkey].Players[j].playerInfo.position;
								player.isDisconnected = false;
								oMatch.currentRoomObj.roomkey = roomkey;
								player.roomkey = oMatch.currentRoomObj.roomkey;								
								oMatch.currentRoomObj.playerInfo = player;
								oMatch.rooms[roomkey].Players[j].playerInfo = player;
								oMatch.currentRoom[oMatch.rooms[roomkey].Players[j].playerInfo.position] = 	oMatch.currentRoomObj;
								socket.join(oMatch.currentRoomObj.roomkey);
								isReconnected = true;
								break;
							}
						}
					}
					
					if (message.userStatus == Pong.userStatus.OLD &&  (oTournament.type == Pong.TournamentType.MINI))
					{
						for(var _roomKeys in oMatch.rooms)
						{
							roomkey =_roomKeys;
							//console.log(_roomKeys + "count ++ " + oMatch.rooms[roomkey].Players.length +" === " + oMatch.currentRoom.length);
							if((oMatch.rooms[roomkey].Players.length > 0) && (oTournament.type == Pong.TournamentType.MINI))
							{
								//roomkey = oMatch.currentRoom[0].roomkey;
								//console.log("call");
								for(var j = 0; j < oMatch.rooms[roomkey].Players.length; j++)
								{   if((oMatch.rooms[roomkey].Players[j].playerInfo.userid == player.userid) &&(!oMatch.rooms[roomkey].Players[j].playerInfo.isDisconnected))     
									{
										//console.log("call  already connected");
										var alreadyConnected = {};
										alreadyConnected.Type = Pong.Sockets.MessageType.ALREADYCONNECTED;
										//broadcastMsg.currentRoom = oMatch.currentRoom;
										oTournament.noOfUser = oTournament.noOfUser - 1;
										socket.emit('message', alreadyConnected);
										return;
									}
								}
								for(var j = 0; j < oMatch.rooms[roomkey].Players.length; j++)
								{
									//console.log("call inner" + JSON.stringify(oMatch.rooms[roomkey].Players[j].playerInfo.userid));
									if((oMatch.rooms[roomkey].Players[j].playerInfo.isDisconnected) && (oMatch.rooms[roomkey].Players[j].playerInfo.userid == player.userid))
									{									 										
										oMatch.currentRoomObj = {};
										//oMatch.currentRoom = oMatch.rooms[roomkey].Players;
										player.position = oMatch.rooms[roomkey].Players[j].playerInfo.position;
										player.isDisconnected = false;
										oMatch.currentRoomObj.roomkey = roomkey;
										player.roomkey = roomkey;
										oMatch.currentRoomObj.playerInfo = player;
										oMatch.rooms[roomkey].Players[j].playerInfo = player;
										//console.log("22  :  "+ JSON.stringify(oMatch.rooms[roomkey].Players[j].playerInfo ));
										//oMatch.currentRoom[oMatch.rooms[roomkey].Players[j].playerInfo.position] = 	oMatch.currentRoomObj;
										socket.join(oMatch.currentRoomObj.roomkey);
										isReconnected = true;
										oTournament.noOfUser = oTournament.noOfUser - 1;										
										rejoinMsg.Type = Pong.Sockets.MessageType.CONNECT;
										rejoinMsg.currentRoom = oMatch.rooms[roomkey].Players;
										socketio.sockets.in(player.roomkey).emit('message',rejoinMsg);
										if(oTournament.type == Pong.TournamentType.MINI && message.RoundNumber == 1)
										{
											  activeUser.Type = Pong.Sockets.MessageType.TOTALACTIVEUSER;
											  activeUser.state = Pong.TournamentType.MINI;
											  activeUser.noOfUser = oTournament.noOfUser;
											  //activeUser.roomkey= roomkey ;
											  for(var _roomKeys in oMatch.rooms)
											  {							  
												//console.log(JSON.stringify(oMatch.rooms[_roomKeys]));
												SendTotalActiveUserMessage(activeUser,_roomKeys);							  	
											  }
											  //oMatch.currentRoomObj = null;
										}
										oMatch.currentRoomObj = null;									
										break;
									}
								}
							}
							if(isReconnected)					
							{			
								//
								return;
								break;								
							}							
						}
					}					
					if(!isReconnected)
					{					
					//Ashish 29-Dec-2012 Added for testing only to end
                    //START of MINI and PLAY FOR FUN
						if (oMatch.currentRoom.length == 3) {
							oMatch.currentRoomObj = {};
							player.position = Pong.Sockets.PlayerPosition.UP;
							oMatch.currentRoomObj.playerInfo = player;
							oMatch.currentRoomObj.roomkey = oMatch.currentRoom[0].roomkey;
							player.roomkey = oMatch.currentRoomObj.roomkey;						
							//added for room start 
							socket.join(oMatch.currentRoomObj.roomkey);
							//added for room end 
							startGame.Type = Pong.Sockets.MessageType.GameState;
							startGame.state = Pong.Sockets.GameState.START;
							oMatch.currentRoom.push(oMatch.currentRoomObj);
							var room = {};
							room.isInit = true;
							var objGamePhysics = new GamePhysics();
							objGamePhysics.roomKey = oMatch.currentRoom[0].roomkey;
							room.GameObj = objGamePhysics;                    
							room.Players = oMatch.currentRoom;
							//room.SelfSocket = socket;
							room.roomkey = oMatch.currentRoomObj.roomkey;
							var d = GetAustralianTime();
							d = d.setSeconds(d.getSeconds()+ 12); 
							room.StartTime = d;
							oMatch.rooms[room.roomkey] =  room;
							if(oTournament.type == Pong.TournamentType.MINI && message.RoundNumber != 1)
							{
								rooms[oMatch.currentRoomObj.roomkey] = room;
								room = null;                            								
								SendDelayedMessage(100,startGame, player.roomkey);
								//SendDelayedMessageToSelfSocket(100,startGame, player.roomkey);
							}
							else if(oTournament.type == Pong.TournamentType.PLAYFORFUN)
							{   
								rooms[oMatch.currentRoomObj.roomkey] = room;
								room = null;								
								SendDelayedMessage(100,startGame, player.roomkey);
								//SendDelayedMessageToSelfSocket(100,startGame, player.roomkey);
							}
							roomkey = "";
						}
						if (oMatch.currentRoom.length == 2) {
							oMatch.currentRoomObj = {};
							player.position = Pong.Sockets.PlayerPosition.DOWN;
							oMatch.currentRoomObj.playerInfo = player;
							//added for room start
							oMatch.currentRoomObj.roomkey = oMatch.currentRoom[0].roomkey;
							player.roomkey = oMatch.currentRoomObj.roomkey;
							socket.join(oMatch.currentRoomObj.roomkey);
							//added for room end                    
							oMatch.currentRoom.push(oMatch.currentRoomObj);
						}
						if (oMatch.currentRoom.length == 1) {
							oMatch.currentRoomObj = {};
							player.position = Pong.Sockets.PlayerPosition.RIGHT;
							oMatch.currentRoomObj.playerInfo = player;
							//added for room start
							oMatch.currentRoomObj.roomkey = oMatch.currentRoom[0].roomkey;
							player.roomkey = oMatch.currentRoomObj.roomkey;
							socket.join(oMatch.currentRoomObj.roomkey);
							//added for room end
							oMatch.currentRoom.push(oMatch.currentRoomObj);
						}
						if (oMatch.currentRoom.length == 0) {
							oMatch.activeRoomCount++;
							oMatch.currentRoomObj = {};
							player.position = Pong.Sockets.PlayerPosition.LEFT;
							oMatch.currentRoomObj.playerInfo = player;
							oMatch.currentRoomObj.roomkey = generateHexString(30);
							player.roomkey = oMatch.currentRoomObj.roomkey;
							socket.join(oMatch.currentRoomObj.roomkey);
							startGame.state = Pong.Sockets.GameState.PAUSE;
							oMatch.currentRoom.push(oMatch.currentRoomObj);
						}					
					}					
                    var room = {};
                    room.isInit = true;
                    var objGamePhysics = new GamePhysics();
                    objGamePhysics.roomKey = oMatch.currentRoom[0].roomkey;
                    room.GameObj = objGamePhysics;                    
                    room.Players = oMatch.currentRoom;
                    //room.SelfSocket = socket;
				
					room.roomkey = oMatch.currentRoomObj.roomkey;
                    var d = GetAustralianTime();
                    d = d.setSeconds(d.getSeconds()+ 12); 
                    room.StartTime = d;
                    oMatch.rooms[room.roomkey] =  room;
                    d = GetAustralianTime();
                    d = d.setSeconds(d.getSeconds()+ 12); 
                    oMatch.currentRoomObj = null;
					if(oTournament.type == Pong.TournamentType.MINI && message.RoundNumber == 1)
					{
						  activeUser.Type = Pong.Sockets.MessageType.TOTALACTIVEUSER;
						  activeUser.state = Pong.TournamentType.MINI;
						  activeUser.noOfUser = oTournament.noOfUser;
						  activeUser.roomkey= room.roomkey ;
						  for(var _roomKeys in oMatch.rooms)
						  {							  
						    //console.log(JSON.stringify(oMatch.rooms[_roomKeys]));
							SendTotalActiveUserMessage(activeUser,_roomKeys);							  	
						  }
						  //oMatch.currentRoomObj = null;
					}					
                    if(oTournament.type == Pong.TournamentType.MINI && message.RoundNumber == 1 && oTournament.noOfUser == 16)
                    {												
						var CurrentActiveUser = 0;
						var tempRoom=0;
						var tempflag = false ;

						for(var _roomKeys in oMatch.rooms)
						{							
							if(oMatch.rooms[_roomKeys].Players.length > 0) 
							{				
								tempflag = false;
								tempRoom = tempRoom + 1;
								for(var j = 0; j < oMatch.rooms[_roomKeys].Players.length; j++)
								{   if(!oMatch.rooms[_roomKeys].Players[j].playerInfo.isDisconnected)
									{		
										tempflag = true;
										CurrentActiveUser = CurrentActiveUser + 1;
									}
								}
							}
						}
						if(tempRoom == 2 && CurrentActiveUser == 2 && tempflag == true)
						{
							//CurrentActiveUser = 3;
						}
																	
                        var CurrentRoomUser = 0;
						for(var _roomKeys in oMatch.rooms)
						{   
							startGame = {};
							startGame.CurrentActiveUser = CurrentActiveUser;						
							startGame.Type = Pong.Sockets.MessageType.GameState;
							startGame.state = Pong.Sockets.GameState.START;	
							 CurrentRoomUser = 0;
							if(oMatch.rooms[_roomKeys].Players.length > 0) 
							{
								for(var j = 0; j < oMatch.rooms[_roomKeys].Players.length; j++)
								{   if(!oMatch.rooms[_roomKeys].Players[j].playerInfo.isDisconnected)
									{						
										CurrentRoomUser = CurrentRoomUser + 1;
									}
								}
							}
							startGame.CurrentRoomUser = CurrentRoomUser;
                            oMatch.rooms[_roomKeys].StartTime = d;
                            rooms[_roomKeys] = oMatch.rooms[_roomKeys];
							//console.log("startGame.CurrentRoomUser " + startGame.CurrentRoomUser );							
                            SendDelayedMessage(100,startGame,_roomKeys);
							//console.log("after.CurrentRoomUser " + startGame.CurrentRoomUser );
                              //SendDelayedMessageToSelfSocket(100,startGame,_roomKeys);
                        }
                        oMatch.currentRoomObj = null;
                    }
                }
				if(oTournament.type == Pong.TournamentType.MEGA && message.RoundNumber == 1)
				{
					  activeUser.Type = Pong.Sockets.MessageType.TOTALACTIVEUSER;
					  activeUser.state = Pong.TournamentType.MEGA;
					  activeUser.noOfUser = oTournament.noOfUser;
					  var plyercount = 0;					  
					  for(var _roomKeys in oMatch.rooms)
					  {						
						 plyercount+= oMatch.rooms[_roomKeys].Players.length;
					  }
					  activeUser.noOfUser = plyercount;					  
					  for(var _roomKeys in oMatch.rooms)
					  {							  
						SendTotalActiveUserMessage(activeUser,_roomKeys);
					  }
					  //oMatch.currentRoomObj = null;
				}
				if(oTournament.type == Pong.TournamentType.MEGA && message.RoundNumber == 2)
				{
					//console.log("round 2 lenth: " + matches[matchKey].rooms[player.roomkey].Players.length);
					//matches[matchKey].rooms[player.roomkey].Players.length
					  activeUser.Type = Pong.Sockets.MessageType.TOTALACTIVEUSER;
					  activeUser.state = Pong.TournamentType.MEGA;
					  activeUser.noOfUser = oTournament.noOfUser;
					  var plyercount = 0;					  
					  for(var _roomKeys in oMatch.rooms)
					  {						
						 plyercount+= oMatch.rooms[_roomKeys].Players.length;
					  }
					  activeUser.noOfUser = plyercount;					  
					  for(var _roomKeys in oMatch.rooms)
					  {
						SendTotalActiveUserMessage(activeUser,_roomKeys);
					  }
					  //oMatch.currentRoomObj = null;
				}			
				//console.log(JSON.stringify(oMatch.rooms));				
                //End of MINI and PLAY FOR FUN
				player.tournamentTotalUser=oTournament.noOfUser;
				// add by ram for get total no of user
                tournaments["T" + message.TournamentID] = oTournament;			
				//console.log("TournamentID" + message.TournamentID +"="+JSON.stringify(tournaments["T" + message.TournamentID]));
				matches[matchKey] = oMatch;
				broadcastMsg.Type = Pong.Sockets.MessageType.CONNECT;
                broadcastMsg.currentRoom = oMatch.currentRoom;
				//socket.emit('message', broadcastMsg);				 								
                socketio.sockets.in(player.roomkey).emit('message', broadcastMsg);
                roomKeyMatchMapping[player.roomkey] = message.TournamentID + "," + message.RoundNumber + "," + oTournament.type;
                var oRoomSocketMapping;				
                if(roomKeySocketMapping[player.roomkey] == undefined || roomKeySocketMapping[player.roomkey] == null)
                {
                    oRoomSocketMapping = {};
                    oRoomSocketMapping.count = 0;
                }
                else
                {
                    oRoomSocketMapping = roomKeySocketMapping[player.roomkey];
                }

                oRoomSocketMapping.count++; 
                oRoomSocketMapping.socket = socket;
                roomKeySocketMapping[player.roomkey] = oRoomSocketMapping;

					// change ram shah on 9 May 2013
						 //var key = roomKeyMatchMapping[player.roomkey];
						// console.log("key" + key);
                         //var values = key.split(",");
						 //console.log(values,+"==="+ values[0]);
                         //var matchKey = "T" + values[0] + ":R" + values[1]; 						
						 //console.log(" matchKey" +  matchKey);
						 //console.log(" matchKey" +  matches[matchKey].rooms[player.roomkey].Players.length);
						 //var oMatch = matches[matchKey];
						// for(var j = 0; j < matches[matchKey].rooms[player.roomkey].Players.length; j++)
                        // {        
                            // if(matches[matchKey].rooms[player.roomkey].Players[j].playerInfo.key == clientGUID)                            
							// {   
								// disonnectUser.Type = Pong.Sockets.MessageType.DISCONNECTINFO;
								// disonnectUser.position = matches[matchKey].rooms[prop].Players[j].playerInfo.position;
								// // when User disconnect then call this condition
								// if(values[0]  != Pong.TournamentType.PLAYFORFUN )
								// {	
									// disonnectUser.roomkey = prop;								
									// for(var _roomKeys in oMatch.rooms)
									// {										
										// //console.log("_roomKeys::"+ _roomKeys);
										// SendDisconnectUserMessage(100,disonnectUser,_roomKeys);
									// }
								// }else
								// {							
									// disonnectUser.roomkey = matches[matchKey].rooms[prop].Players[j].playerInfo.roomkey;
									// SendDisconnectUserMessage(100,disonnectUser,matches[matchKey].rooms[prop].Players[j].playerInfo.roomkey);
								// }
                                // matches[matchKey].rooms[prop].Players[j].playerInfo.isDisconnected = true;
                            // }
                        // }
					// change end by ram shah on 9 may 2013	
						
                if (oMatch.currentRoom.length == 4) {
                    oMatch.currentRoom = [];
                }
                break;
            case Pong.Sockets.MessageType.PADDLEPOSITION:
                msg = eval('(' + msg + ')');
                try
                {
                    if (msg.PaddlePosition == Pong.Sockets.PlayerPosition.LEFT) {
                        rooms[msg.roomKey].GameObj.paddel1Control = msg.value;
                        rooms[msg.roomKey].GameObj.paddle1.redraw(rooms[msg.roomKey].GameObj);
                        msg.value = rooms[msg.roomKey].GameObj.Paddle1Position.y;
                    }
                    else if (msg.PaddlePosition == Pong.Sockets.PlayerPosition.RIGHT) {
                        rooms[msg.roomKey].GameObj.paddel2Control = msg.value;
                        rooms[msg.roomKey].GameObj.paddle2.redraw(rooms[msg.roomKey].GameObj);
                        msg.value = rooms[msg.roomKey].GameObj.Paddle2Position.y;
                    }
                    else if (msg.PaddlePosition == Pong.Sockets.PlayerPosition.DOWN) {
                        rooms[msg.roomKey].GameObj.paddel3Control = msg.value;
                        rooms[msg.roomKey].GameObj.paddle3.redraw(rooms[msg.roomKey].GameObj);
                        msg.value = rooms[msg.roomKey].GameObj.Paddle3Position.x;
                    }
                    else if (msg.PaddlePosition == Pong.Sockets.PlayerPosition.UP) {
                        rooms[msg.roomKey].GameObj.paddel4Control = msg.value;
                        rooms[msg.roomKey].GameObj.paddle4.redraw(rooms[msg.roomKey].GameObj);
                        msg.value = rooms[msg.roomKey].GameObj.Paddle4Position.x;
                    }
                    socketio.sockets.in(msg.roomKey).volatile.emit('message', msg);
                    // if(rooms[msg.roomKey].SelfSocket != undefined && rooms[msg.roomKey].SelfSocket != null)
                    // {
                        // rooms[msg.roomKey].SelfSocket.volatile.emit('message', msg);
                    // }
                 }
                 catch(ex)
                 {
                    //console.log("Invalid control posision: "+ ex);
                 }
                break;
            case Pong.Sockets.MessageType.BALLPOSITION:
                // call below fun()  funBallPosition
                break;
            case Pong.Sockets.MessageType.PLAYERPOSITION:
                break;
            case Pong.Sockets.MessageType.DISCONNECT:
                //console.log('message disconnect:', msg);
                socket.emit('message', msg);
                socket.broadcast.emit('message', msg);
                oGamePhysics.isPaused = !oGamePhysics.isPaused;
                break;
        }

    });

    socket.on('disconnect', function () {	   
 
        var clientGUID = socketUserMapping[socket.id];
        delete socketUserMapping[socket.id];
		var disonnectUser = {};
        if(clientGUID != undefined)
        {
            for(var prop in socketio.sockets.manager.roomClients[socket.id])
            {
                try
				{	
					if(prop != undefined && prop != "")
					{						
                        prop = prop.replace("/", ""); 
						//console.log("prop  "+prop);
                        var key = roomKeyMatchMapping[prop];
						//console.log("key" + key);
                        var values = key.split(",");
						//console.log(values,+"==="+ values[0]);
                        var matchKey = "T" + values[0] + ":R" + values[1]; 						
						//console.log(" matchKey" +  matchKey);
						var oMatch = matches[matchKey];
						//console.log("oMatch " + JSON.stringify(oMatch));
						//console.log("length " + matches[matchKey].rooms[prop].Players.length);
						//console.log("count " + JSON.stringify(oMatch.rooms));
						roomKeySocketMapping[prop].count--;
						for(var j = 0; j < matches[matchKey].rooms[prop].Players.length; j++)
                        {      
							//console.log("key" + matches[matchKey].rooms[prop].Players[j].playerInfo.key);
                            if(matches[matchKey].rooms[prop].Players[j].playerInfo.key == clientGUID)                            
							{   
								disonnectUser.Type = Pong.Sockets.MessageType.DISCONNECTINFO;
								disonnectUser.position = matches[matchKey].rooms[prop].Players[j].playerInfo.position;
								// when User disconnect then call this condition
								if(values[0]  != Pong.TournamentType.PLAYFORFUN )
								{										
									disonnectUser.roomkey = prop;								
									for(var _roomKeys in oMatch.rooms)
									{										
										//console.log("_roomKeys::"+ _roomKeys);
										SendDisconnectUserMessage(100,disonnectUser,_roomKeys);
									}
								}else
								{	
									//console.log("playforfun"	+ j)								
									disonnectUser.roomkey = matches[matchKey].rooms[prop].Players[j].playerInfo.roomkey;
									SendDisconnectUserMessage(100,disonnectUser,matches[matchKey].rooms[prop].Players[j].playerInfo.roomkey);
								}
                                matches[matchKey].rooms[prop].Players[j].playerInfo.isDisconnected = true;
                            }
                        }						
                        if(roomKeySocketMapping[prop].count == 0)
                        {
                            //matches[matchKey].currentRoom = [];
                            matches[matchKey].activeRoomCount--;
                            if(matches[matchKey].activeRoomCount <= 0)
                            {
                                matches[matchKey].activeRoomCount = 0;
                            }
                            //delete matches[matchKey].rooms[prop];
                            //To do
                            //activeroomcount should be decreamented by 1 here
                        }
                        if(rooms[prop] != undefined)
                        {   
							//console.log("rooms[prop]::" + JSON.stringify(rooms[prop]));
                            for(var i = 0; i < rooms[prop].Players.length; i++)
                            {
                                if(rooms[prop].Players[i].playerInfo.key == clientGUID)
                                {                           
                                   if(rooms[prop].Players[i].playerInfo.position == 0)
                                   {                                
                                        rooms[prop].GameObj.BricksLeft[4] = [40, 86, 30, 428];                            										
										 //socketio.sockets.in(key).emit('message', msg);
                                        break;
                                   }
                                   else if(rooms[prop].Players[i].playerInfo.position == 1)
                                   {
                                        rooms[prop].GameObj.BricksRight[4] = [530, 86, 30, 428];                        
                                        break;
                                   }
                                   else if(rooms[prop].Players[i].playerInfo.position == 2)
                                   {
                                        rooms[prop].GameObj.BricksBottom[4] = [86, 530, 428, 30];                         
                                        break;
                                   }
                                   else if(rooms[prop].Players[i].playerInfo.position == 3)
                                   {
                                        rooms[prop].GameObj.BricksTop[4] = [86, 40, 428, 30];                       
                                        break;
                                   }
                                }
                            }                     
                        } 
					}						
				}                
                catch(ex)
                {
                    console.log("Error reading prop:", ex);
                }
            }      
        }
    });
});

socketio.set('log level', 1);

function initializeGame(_obj)
{
	setTimeout(function () {
		_obj.init();
	},10);
}

function GameLoop()
{
    setInterval(function () {
    try{
        var d = GetAustralianTime();
        for (var prop in rooms) {
            if(rooms[prop].StartTime < d)
            {
                if(rooms[prop].isInit)
                {   
                    rooms[prop].isInit = false;
                    var oGamePhysics = rooms[prop].GameObj;
                    oGamePhysics.init();
					//initializeGame(rooms[prop].GameObj)
                }
                //To do need to implement MEGA tournament start counter condintion
                var oGamePhysics = rooms[prop].GameObj;
                if(oGamePhysics.initComplate)
                {
                    //oGamePhysics.paddle1.redraw(oGamePhysics);
                    //oGamePhysics.paddle2.redraw(oGamePhysics);
                    //oGamePhysics.paddle3.redraw(oGamePhysics);
                    //oGamePhysics.paddle4.redraw(oGamePhysics);					
                    oGamePhysics.ball.redraw(oGamePhysics);                            
                    oGamePhysics.ControlPostion.Type = Pong.Sockets.MessageType.CONTROLPOSITION;
                    //oGamePhysics.ControlPostion.Paddle1Position = oGamePhysics.Paddle1Position;
                    //oGamePhysics.ControlPostion.Paddle2Position = oGamePhysics.Paddle2Position;
                    //oGamePhysics.ControlPostion.Paddle3Position = oGamePhysics.Paddle3Position;
                    //oGamePhysics.ControlPostion.Paddle4Position = oGamePhysics.Paddle4Position;
                    oGamePhysics.ControlPostion.xy = oGamePhysics.BallPosition;                    
                    if(parseInt(oGamePhysics.count) == 10 || rooms[prop].GameEnded)
                    {
                        oGamePhysics.ControlPostion.BL = oGamePhysics.BricksLeft;
                        oGamePhysics.ControlPostion.BR = oGamePhysics.BricksRight;
                        oGamePhysics.ControlPostion.BT = oGamePhysics.BricksTop;
                        oGamePhysics.ControlPostion.BB = oGamePhysics.BricksBottom;
                        oGamePhysics.count = 0;
                    }
                    oGamePhysics.count++;
                    socketio.sockets.in(prop).volatile.emit('message', oGamePhysics.ControlPostion);
                    // if(rooms[prop].SelfSocket != undefined && rooms[prop].SelfSocket != null)
                    // {
                        // rooms[prop].SelfSocket.volatile.emit('message', oGamePhysics.ControlPostion);
                    // }
                    delete oGamePhysics.ControlPostion.BL;
                    delete oGamePhysics.ControlPostion.BR;
                    delete oGamePhysics.ControlPostion.BT;
                    delete oGamePhysics.ControlPostion.BB;
                }                
            }
         }
      }
      catch(ex)
      {
         console.log("Error in game loop: ", ex);
      }
    }, 20);
	//}, 30); // change by ram shah because on server ball is not redraw propelly
}

function StartRoundLoop()
{	
    setInterval(function() {
        for(var roundRoomKey in roomKeyMatchMapping)
        {
           try
           { 
               var key = roomKeyMatchMapping[roundRoomKey];
               var values = key.split(",");
               var matchKey = "T" + values[0] + ":R" + values[1];
               var oMatch = matches[matchKey];
               var socket = roomKeySocketMapping[roundRoomKey].socket;
               switch(parseInt(values[2]))
               {
                    case Pong.TournamentType.MEGA :
                        if(parseInt(values[1]) == 2)
                        {   
                            if(matches["T" + values[0] + ":R1"] != undefined  && parseInt(matches["T"+values[0]+":R1"].activeRoomCount) == 0)
                            {   
                                //To do room start should be called only once if user <= 16.
                                if((!matches["T" + values[0] + ":R1"].Started && tournaments["T" + values[0]].noOfUser <= 16) || tournaments["T" + values[0]].noOfUser > 16)
                                {                                    
                                    startRoom(roundRoomKey,socket, oMatch, false,values[0], Pong.TournamentType.MEGA, matchKey);
                                    matches["T" + values[0] + ":R1"].Started = true;
                                }                                
                            }
                        }
                        else if(parseInt(values[1]) == 3)
                        {	
                            if(matches["T" + values[0] + ":R1"] != undefined  && parseInt(matches["T"+values[0]+":R1"].activeRoomCount) == 0 && parseInt(matches["T"+values[0]+":R2"].activeRoomCount) == 0)
                            {   
                                var currentTime = GetAustralianTime();
                                if(!matches["T"+values[0]+":R2"].checked)
                                {   
                                    var checkTime = new Date(currentTime);                                    
                                    checkTime.setSeconds(currentTime.getSeconds()+ 40);
                                    matches["T"+values[0]+":R2"].lastChecked = checkTime;
                                    matches["T"+values[0]+":R2"].checked = true;
                                }                                
                                if(matches["T"+values[0]+":R2"].checked &&  matches["T"+values[0]+":R2"].lastChecked < currentTime)
                                {   
                                    startRoom(roundRoomKey,socket, oMatch ,true,values[0], Pong.TournamentType.MEGA, matchKey);
                                }
                            }
                            else
                            {
                                matches["T"+values[0]+":R2"].checked = false;
                            }
                        }
                    break;
                    case Pong.TournamentType.MINI :
                        if(parseInt(values[1]) == 2)
                        {   
                            if(matches["T" + values[0] + ":R1"] != undefined  && parseInt(matches["T"+values[0]+":R1"].activeRoomCount) == 0)
                            {   
                                startRoom(roundRoomKey,socket, oMatch , true ,values[0], Pong.TournamentType.MINI, matchKey);
                            }
                        }
                    break;
               }
           }
           catch(ex)
           {
                console.log("Error in staring room: ", ex);
                
           }
        }
    },5000);
}
GameLoop();
StartRoundLoop();
