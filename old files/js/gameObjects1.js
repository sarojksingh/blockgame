var x;
          var y;
          var dx;
          var dy;
          var WIDTH;
          var HEIGHT;
          var ctx;
          var paddlex;
          var paddleh;
          var paddlew;
          var intervalId;
          var rightDown = false;
          var leftDown = false;
          var radius;
          var paddlexAI;
          
          var canvas = document.getElementById( 'myCanvas' );
          // paddlexAI.clearRect ( 0 , 0 , canvas.width, canvas.height );
          //set rightDown or leftDown if the right or left keys are down
          function onKeyDown(evt) {
            if (evt.keyCode == 39) rightDown = true;
            else if (evt.keyCode == 37) leftDown = true;
          }
          
          //and unset them when the right or left key is released
          function onKeyUp(evt) {
            if (evt.keyCode == 39) rightDown = false;
            else if (evt.keyCode == 37) leftDown = false;
          }
          
          $(document).keydown(onKeyDown);
          $(document).keyup(onKeyUp);
  
          function init_paddles() 
          {
            paddlex = WIDTH / 2;
            paddlexAI = paddlex;
            paddleh = 17;
            paddlew = 107;
              
          }

          function init() {
            ctx = canvas.getContext("2d");  
            WIDTH = canvas.width;
            HEIGHT = canvas.height;
            x = 150;
            y = 150;
            dx = 2;
            dy = 4;
            radius = 10;
            rightDown = false;
            leftDown = false;
            intervalId = 0;
            
            intervalId = setInterval(draw, 10);
            init_paddles();
             
          }
        
          function circle(x,y,r) {
            var img = new Image();
            img.src = 'images/balllbg.png';
            var pat=ctx.createPattern(img,"repeat");
            
            ctx.beginPath();
            ctx.arc(x, y, r, 0, Math.PI*2, true);
            ctx.closePath();
            ctx.fillStyle=pat;
            ctx.fill();
          }

          function rect(x,y,w,h) {
            var img = new Image();
            img.src = 'images/horiz_paddle_bg.png';
            var pat=ctx.createPattern(img,"repeat");
            ctx.beginPath();
            ctx.rect(x,y,w,h);
            ctx.closePath();
            ctx.fillStyle=pat;
            ctx.fill();
          }

          function clear() {
            ctx.clearRect(0, 0, WIDTH, HEIGHT);
          }

          function followBallAI() {
          
            //randomly pick number beteween 0 and 1
            var delayReaction = Math.random();

            
            //25% chance of reaction delay
            if(delayReaction >= 0.25) {
            
              if(x > paddlexAI + paddlew) {
                if(paddlexAI + paddlew + 5 <= WIDTH) {
                  paddlexAI += 5;
                }
              }
              
              else if(x < paddlexAI) {
                if(paddlexAI - 5 >= 0) {
                  paddlexAI -= 5;
                }
              }
              
              else {
              
                var centerPaddle = Math.random();

              
                //80% chance of better centering the paddle
                //otherwise the paddleAI will most of the times
                //hit the ball in one of its extremities
                if(centerPaddle > 0.2) {
                    
                  //if ball closer to left side of computer paddle
                  if( Math.abs(x - paddlexAI) < Math.abs(x - paddlexAI - paddlew) ) {
                    if(paddlexAI - 5 >= 0) {
                      paddlexAI -= 5;
                    }
                  }
                      
                  else {  
                    if(paddlexAI + paddlew + 5 <= WIDTH) {
                      paddlexAI += 5;
                    }
                  }
                }
              
              }
              
            }
            
          }
          
          function drawSideLines() {
             ctx.beginPath();
             ctx.rect(0,0,10,HEIGHT);
             ctx.closePath();
             ctx.fill();
             
             ctx.beginPath();
             ctx.rect(WIDTH - 10,0,10,HEIGHT);
             ctx.closePath();
             ctx.fill();
          }