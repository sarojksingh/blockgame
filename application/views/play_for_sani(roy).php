<?php 
header("Access-Control-Allow-Origin: *");
?>
<!DOCTYPE html>  
<!--
Developed by : SANI HYNE
Developed on : 9/25/2014
Skype:         delickate
Email:         delickate@hotmail.com
Hello:         +92 332 7399488

-->      
    <html>  
        <head>  
            <title>funandwinprizes | delickate</title>  
            <meta charset="utf-8">  
      		<style>
				#myCanvas { background-image:url('images/gamebg.png'); background-repeat:no-repeat; width:420px; height:420px; padding-left:90px; padding-top:80px; 
				            padding-right:80px; padding-bottom:90px;
				            cursor: url("../images/white_cursor.png"), auto;
				          }
				#losttext { padding:20px; font-weight:bold; color:#FF0000;  } 

        .ballinsert {
            left: 100px;
            position: relative;
            top: 290px;
            z-index: 100000;
        }
				/*canvas.white_cursor {
    				cursor: url("../images/white_cursor.png"), auto;
				}*/
			</style>
            <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>  
            <link href='http://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css' />
  <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css' />
  <!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script> -->
  <script type="text/javascript" src="http://localhost/game_blocker/node_modules/socket.io/node_modules/socket.io-client/socket.io.js"></script>
				
	  
 <script>  
    function AdddCursurClass(position) {
      $(canvas).removeClass("yellow_cursor red_cursor green_cursor blue_cursor white_cursor");
      switch (position)
      {
        case 0:
          $(canvas).addClass("yellow_cursor");
          Y = gameObjects.paddle1.y;
          break;
        case 1:
          $(canvas).addClass("blue_cursor");
          Y = gameObjects.paddle2.y;
          break;
        case 2:
          $(canvas).addClass("green_cursor");
          X = gameObjects.paddle3.x;
          break;
        case 3:
          $(canvas).addClass("red_cursor");
          X = gameObjects.paddle4.x;
          break;
        default:
          $(canvas).addClass("white_cursor");
          break;
      }
    }

    function RemoveCursurClass()
    {
      $(canvas).removeClass("yellow_cursor red_cursor green_cursor blue_cursor white_cursor");
      $(canvas).addClass("white_cursor");
    }

    //SANI: read & clean code by SANI
    function showCanvasPop(target, num) {
      if (num == 1) {
        $(target).show();
        var cpHt = $(target).height();
        var curTopPos = ((600 - cpHt) / 2);
        $(target).css('top', curTopPos + 'px');
      } else if (num == 0){
        $(target).hide();
      }
    }
			
		  $(document).ready(function() {
        $("#ballinsert").click(function()
				{   
            $("#ball_image").hide();
            
            var myDiv = document.getElementById("loadingimage");

            var show = function(){
              myDiv.style.display = "block";
              setTimeout(hide, 1000);  // 5 seconds
            }
            var hide = function(){
              myDiv.style.display = "none";
              showCanvasPop('.convas_game_end', 0);
              showCanvasPop('.canvas_form_block', 0);
              
          //BEGIN LIBRARY CODE
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
          
          //END LIBRARY CODE

          function draw() {
              clear();
              circle(x, y, radius);
              //move the paddle if left or right is currently pressed
              
              if (rightDown) {
                  if(paddlex + paddlew + 5 <= WIDTH) {
                    paddlex += 5;
                  }
              }
              
              else if (leftDown) {
                if(paddlex - 5 >= 0) {
                  paddlex -= 5;
                }
              }
              
              followBallAI();
              
              drawSideLines();
              rect(paddlex, HEIGHT-paddleh, paddlew, paddleh);
              rect(paddlexAI, 0, paddlew, paddleh);
             
              if (x + dx + radius > WIDTH || x + dx - radius < 0)
              dx = -dx;

              //upper lane
              if (y + dy - radius <= 0) {
              
                if (x <= paddlexAI || x >= paddlexAI + paddlew) {
                  clearInterval(intervalId);
                  alert('You WIN ! :)');
                  init();
                }
              
              else {
                dy = -dy;
              }
              
              }
              
              //lower lane
              else if (y + dy + radius > HEIGHT) {
              
              if (x > paddlex && x < paddlex + paddlew) {
                dx = 8 * ((x-(paddlex+paddlew/2))/paddlew);
                dy = -dy;
              } else {
                  clearInterval(intervalId);
                  //alert('You Lose ! :(');
                  //$('#losttext').html('You Lose ! :(');
                  exit();
                  init();
                }
              }
              
              x += dx;
              y += dy;
            }

            init();
            }
            show();


            
          });
	     });  
    
            </script>  

        </head>  
      
        <body onkeydown="javascript:keyboard.handler(event);" onkeyup="javascript:keyboard.handlerRelease(event);">  
        <div id="totalActiveUserID">
    		<p>Total Active User for <b><span id="tounramentName" >tournament</span></b>  is : <span id="totalActiveUser" >0</span></p>
  		</div>
  		<div class="game_zone">
  		 <aside id="left_players">
      <div id="playerid0" class="player_two player0 " style="display:none;">
        <p class="player_img">
          <img id="imgplayer0" src="" alt="" width="45" height="45" />
        </p> <span id="player0" class="player_name"></span>  <span id="playerscore0"
                                                                   class="player_win_points">WINS: 2</span>
      </div>
  
      <div id="playerid3" class="player_one player3" style="display:none;">
        <p class="player_img">
          <img id="imgplayer3" src="" alt="" width="45" height="45" />
        </p> <span id="player3" class="player_name"></span>  <span id="playerscore3"
                                                                   class="player_win_points">WINS: 5</span>
      </div>
    </aside>
          <center>
          <div class="ballinsert" id="ballinsert">
            <img id="loadingimage" src="images/loader_img.gif" style="display:none;">
            <img id="ball_image"  src="<?php echo base_url(); ?>images/ball.png" />
          </div>
            <div id="playerid0" class="player_two player0 ">
        <p class="player_img">
          <img id="imgplayer0" src="<?php echo $gamedata['user_avatar']; ?>" alt="" width="45" height="45" />
        </p> <span id="player0" class="player_name"></span>  <span id="playerscore0"
                                                                   class="player_win_points"><?php echo $gamedata['user_name']; ?><br/>WINS: 0 </span>

          </div>
          
          	<div class="game_canvas">
            <canvas id="myCanvas" width="720" height="500">  
                <!-- Insert fallback content here -->  
            </canvas>
            <img id="process_loader" style="display:none;" src="<?php echo base_url(); ?>images/loader_img.gif" />
      <img id="vert_paddle" src="<?php echo base_url(); ?>images/vert_paddle.png" style="display:none;" />
      <img id="horiz_paddle" src="<?php echo base_url(); ?>images/horiz_paddle.png" style="display:none;" />
      <img id="right_brick_image" style="display:none;" src="<?php echo base_url(); ?>images/blue_brick.png" />
      <img id="bottom_brick_image" style="display:none;" src="<?php echo base_url(); ?>images/green_brick.png" />
      <img id="top_brick_image" style="display:none;" src="<?php echo base_url(); ?>images/red_brick.png" />
      <img id="left_brick_image" style="display:none;" src="<?php echo base_url(); ?>images/yellow_brick.png" />
      <img id="horiz_brick_image" style="display:none;" src="<?php echo base_url(); ?>images/wood_horiz_wall.png" />
      <img id="vert_brick_image" style="display:none;" src="<?php echo base_url(); ?>images/wood_vert_wall.png" />
      <img id="wood_corner" style="display:none;" src="<?php echo base_url(); ?>images/wood_corners.png" />
      <!--<img id="canvas_bg" style="display:none;" src="<?php echo base_url(); ?>images/game_bg.png" />-->
      <img id="ball_image" style="display:none;" src="<?php echo base_url(); ?>images/ball.png" />

      <div class="canvas_popups canvas_pop_msgs"></div>

      <div class="canvas_popups canvas_form_block">
        <div class="canvas_form_title">
          CONGRATULATIONS! YOU HAVE<br /> WON! FILL OUT THE FORM TO<br /> RECEIVE YOUR PRIZE!
        </div>
        <div class="canvas_form_error"></div> <!-- cf_error -->
        <div class="canvas_form_row">
          <div class="canvas_form_left">USER NAME</div>
          <div class="canvas_form_right"><?php echo sessionData('name'); ?></div>
        </div>
        <div class="canvas_form_row">
          <div class="canvas_form_left">ADDRESS<span class="req_red">*</span></div>
          <div class="canvas_form_right"><input id="txtAdd" type="text" size="35" /></div>
        </div>
        <div class="canvas_form_row">
          <div class="canvas_form_left">CITY<span class="req_red">*</span></div>
          <div class="canvas_form_right"><input id= "txtCity" type="text" size="20" /></div>
        </div>
        <div class="canvas_form_row">
          <div class="canvas_form_left">POSTCODE<span class="req_red">*</span></div>
          <div class="canvas_form_right"><input id="txtPostCode" type="text" size="10" /></div>
        </div>
        <div class="canvas_form_row">
          <div class="canvas_form_left">EMAIL<span class="req_red">*</span></div>
          <div class="canvas_form_right"><input id ="txtEmail" type="text" size="35" /></div>
        </div>
        <div class="canvas_form_row">
          <div class="canvas_form_left">TEL NO<span class="req_red">*</span></div>
          <div class="canvas_form_right"><input id="txtTelNo" type="text" size="16" /></div>
        </div>
        <div class="canvas_form_row_btm">
          <input type="button" class="claim_your_prize_btn" onclick= "IsValidPage();" />
        </div>
      </div>
      </div>
      <aside id="right_players">
      <div id="playerid1" class="player_three player1" style="display:none;">
        <p class="player_img">
          <img id="imgplayer1" src="" alt="" width="45" height="45" />
        </p> <span id="player1" class="player_name"></span>  <span id="playerscore1"
                                                                   class="player_win_points">WINS: 7</span>
      </div>
      <div id="playerid2" class="player_four player2" style="display:none;">
        <p class="player_img">
          <img id="imgplayer2" src="" alt="" width="45" height="45" />
        </p> <span id="player2" class="player_name"></span>  <span id="playerscore2"
                                                                   class="player_win_points">WINS: 1</span>
      </div>
    </aside>
     <span  style="display:none;" id="totalActiveUserhide" >0</span>
  </div>
  <script src="<?php echo base_url(); ?>js/browser.js"></script>
  <script src="<?php echo base_url(); ?>js/canvas.js"></script>
  <script src="<?php echo base_url(); ?>js/gameObjects.js"></script>
  <script src="<?php echo base_url(); ?>js/keyboard.js"></script>
  <!--<script src="<?php echo base_url(); ?>js/mouse.js"></script> -->
  <script type="text/javascript">
            canvas.init();
            browser.init();
            // mouse.init();
            gameObjects.init();
            canvas.start();
            AdddCursurClass(-1);
            document.onkeydown = function (e) {
              var k = e.keyCode;

              if (k >= 37 && k <= 40 && !gameObjects.isWinner) {
                return false;
              }
            }
  </script>
  <audio id="audio_id" preload="auto">
    <source  src="http://localhost/game_blocker/SoundFile/593325210.wav" type ="audio/wav"></source>
<!--<source  src="http://ec2-54-252-99-185.ap-southeast-2.compute.amazonaws.com/SoundFile/593325210.wav" type ="audio/wav"></source>-->
	  </audio>
            <p id="losttext"></p>
            </center>
            </div>
        </body>  
    </html>  