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
			
		        $(document).ready(function() 
				{  
                    
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
					     //ctx.fill();
						 
						 ctx.beginPath();
						 ctx.rect(WIDTH - 10,0,10,HEIGHT);
					     ctx.closePath();
					     //ctx.fill();
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
							}
							   
							else {
							  clearInterval(intervalId);
							  //alert('You Lose ! :(');
							  $('#losttext').html('You Lose ! :(');
							  exit();
							  init();
							}
						  }
						  
						  x += dx;
						  y += dy;
						}

						init();
	
				});  
Pong = {};
    var data = '<?php echo json_encode($gamedata); ?>';
    //console.log(data);
    Pong.GameData = data;
    Pong.TournamentType = {
      MINI: 2,
      MEGA: 1,
      PLAYFORFUN: 0
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
      RESULT: 5,
      KEEPALIVE: 6,
      ALREADYCONNECTED: 7,
      TOTALACTIVEUSER: 8,
      DISCONNECTINFO: 9
    }
    Pong.Sockets.PlayerPosition = {
      LEFT: 0,
      RIGHT: 1,
      DOWN: 2,
      UP: 3
    }
    Pong.userStatus = {
      NEW: 1,
      OLD: 0
    }
    var roomKey = "";
  </script>
  <script type="text/javascript">
    var X = 0;
    var Y = 0;
    var userStatus = 1;   // 0 means old and 1 means new user
    var userid = 0;
    var username = "";
    var user_name = "";
    var userimage = "";
    var userscore = 0;
    var startTime = "";
    var tournamentID = 0;
    var RoundNumber = 0;
    var iosocket = null;
    var tournament_type = 0;
    var isConnected = false;
    var session_id = "";
    var isGameStarted = false;
    var total_register = 0;
    var tournament_name = "";
    var keyRoomID = -1;
    var gameServerURL = "<?php echo $this->config->item('gameserver_url') ?>/node_modules/socket.io/node_modules/socket.io-client/";
    function generateHexString(length) {
      var ret = "";
      while (ret < length) {
        ret += Math.random().toString(16).substring(2);
      }
      return ret.substring(0, length);
    }
    var GUID = generateHexString(30);

    //function toggleConnection() {
    //if ($("#btnConnectDisconnect").val() == "Disconnect") {
    //	 var msgToSend = "{'key':'" + GUID + "', 'Type':" + Pong.Sockets.MessageType.DISCONNECT + "}";
    //   iosocket.send(msgToSend);
    //}
    //else {-->

    $(function () {
      data = JSON.parse(data);
      //console.log(data);
      if (username == "" || username == undefined) {
        username = data.user_name;
      }
      userStatus = data.flag;
      userid = data.user_id;
      userimage = data.user_avatar;
      if (data.user_wins != "" || data.user_wins != undefined) {
        userscore = data.user_wins;
      }
      if (data.start_time != "")
      {
        startTime = data.start_time;
      }
      session_id = data.session_id;
      //startTime = "December 25, 2012 17:38:00";
      //console.log("Start time: ",startTime);
      total_register = data.total_register;
      tournament_name = data.tournament_name;
      tournamentID = data.tournament_id;
      //tournamentID = 3; //For Mega
      //tournamentID = 8;   //For Mini
      RoundNumber = data.round;
      tournament_type = data.tournament_type;
      if (tournament_type == undefined || tournament_type == "")
      {
        tournament_type = Pong.TournamentType.PLAYFORFUN;
      }
      //tournament_type = 1; // For Mega
      //tournament_type = 2;   // For Mini
      // if(tournament_type == "MINI")
      // {
      // tournament_type = 0;
      // }
      // else if (tournament_type == "MEGA")
      // {
      // tournament_type = 1;
      // }
      // else{
      // tournament_type = 2;
      // }
      function SendDelayedMessage(delay, msgToSend) {
        //var count = 30;
        var count = 5;
	      console.log('sss');

        var t = setInterval(function () {
          gameObjects.Count = count;
          count--;
        }, 1000);
        setTimeout(function () {
	             gameObjects.Count = null;
          clearInterval(t);
          canvas.init();
          browser.init();
          gameObjects.reset();
          canvas.start();
          iosocket.send(msgToSend);
        }, delay);
      }
      try
      {
        iosocket = io.connect(gameServerURL);
      }
      catch (ex)
      {
        //alert("<?php echo base_url(); ?>play_game/retournament/"+tournamentID+"?session_id="+session_id);
        console.log("Error connecting to Server: ", ex);
        if (tournament_type != Pong.TournamentType.PLAYFORFUN)
        {
          window.location.href = "<?php echo base_url(); ?>play_game/retournament/" + tournamentID + "?session_id=" + session_id;
        }
      }
      iosocket.on('connect', function () {
        iosocket.on('message', function (message) {
          var timer;
          //console.log("message.Type :-- " + message.Type);
          switch (message.Type) {
            case Pong.Sockets.MessageType.RESULT:
              console.log("RESULT" + JSON.stringify(message));
              RemoveCursurClass();
              if (parseInt($('#Position').val()) == parseInt(message.PlayerPosition)) {

                $(".player0").removeClass("player_left_disabled");
                $(".player1").removeClass("player_right_disabled");
                $(".player2").removeClass("player_right_disabled");
                $(".player3").removeClass("player_left_disabled");
                $(".player0").addClass("player_two");
                $(".player1").addClass("player_three");
                $(".player2").addClass("player_four");
                $(".player3").addClass("player_one");
                $(".player0").hide();
                $(".player1").hide();
                $(".player2").hide();
                $(".player3").hide();
                gameObjects.isWinner = true;


                isGameStarted = false;
                if (tournament_type == Pong.TournamentType.PLAYFORFUN) {
                  var msgToSend = "{'key':'" + GUID + "', 'Type':" + Pong.Sockets.MessageType.CONNECT + ", 'TournamentID' :" + tournamentID + ",'RoundNumber': " + RoundNumber + ",'UserId':" + userid + ",'UserName':'" + username + "','UserImage':'" + userimage + "','UserScore':" + userscore + " , 'TournamentType':" + tournament_type + " }";

                  $('.canvas_pop_msgs').html("Congratulations you won!<br />Play again?<br/><a class=\"enter_tournament_btn\" onclick=\"window.location.href ='<?php echo base_url() ?>tournament';\">&nbsp;</a>&nbsp;<a class=\"play_for_fun_btn\" onclick=\"window.location.href ='<?php echo base_url() ?>play_game';\">&nbsp;</a>")
                  gameObjects.ball.width = 0;
                  showCanvasPop('.canvas_pop_msgs', 1);
                  $('#totalActiveUserID').hide();
                  gameObjects.isLoader = false;
                }
                else
                {
                  gameObjects.isLoader = true;
                }
                setTimeout(function () {
                  if (tournament_type == Pong.TournamentType.MINI || tournament_type == Pong.TournamentType.MEGA)
                  {
                    if (tournament_type == Pong.TournamentType.MINI)
                    {
                      if (parseInt($("#totalActiveUserhide").html()) < 2 && parseInt(RoundNumber) == 1)
                      {
                        //console.log("call 1");
                        RoundNumber = 2;
                      }

                    }
                    if (tournament_type == Pong.TournamentType.MEGA)
                    {
                      //console.log("call : " + parseInt($("#totalActiveUserhide").html()) + "  RoundNo: " + RoundNumber);
                      if (parseInt($("#totalActiveUserhide").html()) < 2 && parseInt(RoundNumber) == 1)
                      {
                        //console.log("call 1");
                        RoundNumber = 3;
                      }
                      else if (parseInt($("#totalActiveUserhide").html()) < 2 && parseInt(RoundNumber) == 2)
                      {
                        //console.log("call 2");
                        RoundNumber = 3;
                      }
                    }
                    gameObjects.isWinner = true;
                    //console.log(" userid: ",userid);
                    //console.log(" tournamentID: ",tournamentID);
                    //console.log("Service RoundNumber: ",RoundNumber);
                    //console.log(" WinnerID: ",userid);
                    var ajaxurl = "<?php echo base_url() ?>ajax/SaveWinner";
                    $.ajax({
                      url: ajaxurl,
                      type: "POST",
                      data: {UsersID: userid, TournamentID: tournamentID, RoundNumber: RoundNumber, WinnerID: userid},
                      success: function (result) {
                        //console.log("Service response SaveWinner: ",JSON.stringify(result));
                        //console.log("Service response SaveWinner: ",result);
                        result = JSON.parse(result);

                        RoundNumber = result.NextRoundNumber;
                        if (result.Result == "success")
                        {
                          gameObjects.isLoader = false;
                          userscore++;
                          if (RoundNumber != -1)
                          {
                            var msgToSend = "{'key':'" + GUID + "', 'Type':" + Pong.Sockets.MessageType.CONNECT + ", 'TournamentID' :" + tournamentID + ",'RoundNumber': " + RoundNumber + ",'UserId':" + userid + ",'UserName':'" + username + "','UserImage':'" + userimage + "','UserScore':" + userscore + " , 'TournamentType':" + tournament_type + " }";
                            if (!isConnected)
                            {
                              SendDelayedMessage(5000, msgToSend);
                              isConnected = true;
                              setTimeout(function () {
                                isConnected = false
                              }, 5000);
                            }
                          }
                          else
                          {
                            setTimeout(function () {
                              showCanvasPop('.canvas_form_block', 1);
                              iosocket.disconnect();
                            }, 5000);
                            //console.log("Error in client code: ",result)
                          }
                        }
                        else
                        {
                          gameObjects.isLoader = false;
                          console.log("Error in service SaveWinner: ", result)
                        }
                      },
                      error: function () {
                        console.log("Error in service SaveWinner: ", result)
                      }
                      //else
                      //{
                      //console.log("Error in service SaveWinner: ",result)
                      //}
                    });
                    $('#totalActiveUserID').hide();

                    //RoundNumber = 2;
                    //	gameObjects.init();
                    //var msgToSend = "{'key':'" + GUID + "', 'Type':" + Pong.Sockets.MessageType.CONNECT + ", 'TournamentID' :" + tournamentID + ",'RoundNumber': " + RoundNumber + ",'UserId':" + userid + ",'UserName':'" + username + "','UserImage':'" + userimage + "','UserScore':" + userscore + " , 'TournamentType':" + tournament_type   + " }";
                    //  iosocket.send(msgToSend);
                  }
                }, 7000);
              }


              break;
            case Pong.Sockets.MessageType.CONNECT:
              var name = "";
              $('#Position').val("-1");
              //console.log(JSON.stringify(message));
              if (tournament_type == Pong.TournamentType.PLAYFORFUN)
              {
                $('#totalActiveUserID').show();
                $("#totalActiveUser").html(message.currentRoom.length);
                $("#tounramentName").html("Play For Fun");

              }
              else if (tournament_type == Pong.TournamentType.MINI && RoundNumber != 1) {
                $('#totalActiveUserID').show();
                $("#totalActiveUser").html(message.currentRoom.length);
                if (tournament_name == "") {
                  $("#tounramentName").html("MINI tournament");
                } else {
                  $("#tounramentName").html(tournament_name);
                }
              }
              else if (tournament_type == Pong.TournamentType.MEGA && RoundNumber == 3) {
                $('#totalActiveUserID').show();
                $("#totalActiveUser").html(message.currentRoom.length);
                if (tournament_name == "") {
                  $("#tounramentName").html("MEGA tournament");
                } else {
                  $("#tounramentName").html(tournament_name);
                }
              }
              // else{
              // $('#totalActiveUserID').show();
              // $("#tounramentName").html("Play For Fun");
              // $("#totalActiveUser").html(message.currentRoom.length);
              // }
              var tempflag = false;
              for (var i = 0; i < message.currentRoom.length; i++) {
                //console.log("isDisconnected :" +message.currentRoom[i].playerInfo.isDisconnected);
                roomKey = message.currentRoom[i].playerInfo.roomkey;
                if (GUID == message.currentRoom[i].playerInfo.key) {
                  $('#Position').val(message.currentRoom[i].playerInfo.position);
                  AdddCursurClass(message.currentRoom[i].playerInfo.position);
                }
                $(".player" + i).show();
                if (message.currentRoom[i].playerInfo.username == "" || message.currentRoom[i].playerInfo.username == undefined) {
                  $("#player" + i).text('user' + message.currentRoom[i].playerInfo.position);
                } else {
                  $("#player" + i).attr("title", message.currentRoom[i].playerInfo.username);
                  name = message.currentRoom[i].playerInfo.username
                  if (name.length > 6)
                  {
                    name = name.substring(0, 6) + "..";
                  }
                  $("#player" + i).text(name);
                }
                //console.log("tempflag 1" +tempflag);
                if ((parseInt($('#Position').val()) == parseInt(message.currentRoom[i].playerInfo.position)) && tempflag == false)
                {

                  tempflag = true;
                  keyRoomID = roomKey;
                  $("#player" + i).text('You');
                  //console.log("tempflag" +tempflag);
                }
                //console.log("tempflag new" +tempflag + " po:  " + parseInt($('#Position').val()));
                $("#playerscore" + i).text("WINS: " + message.currentRoom[i].playerInfo.userscore);
                $("#imgplayer" + i).attr("src", message.currentRoom[i].playerInfo.userimage);
                if (message.currentRoom[i].playerInfo.isDisconnected == true && tournament_type != Pong.TournamentType.PLAYFORFUN)
                {
                  if (message.currentRoom[i].playerInfo.position == 0 || message.currentRoom[i].playerInfo.position == 3) {
                    if (message.currentRoom[i].playerInfo.position == 0) {
                      $("#playerid" + i).removeClass("player_two");
                    }
                    if (message.currentRoom[i].playerInfo.position == 3) {
                      $("#playerid" + i).removeClass("player_one");
                    }
                    $("#playerid" + i).addClass("player_left_disabled");
                  } else {
                    if (message.currentRoom[i].playerInfo.position == 2) {
                      $("#playerid" + i).removeClass("player_four");
                    }
                    if (message.currentRoom[i].playerInfo.position == 1) {
                      $("#playerid" + i).removeClass("player_three");
                    }
                    $("#playerid" + i).addClass("player_right_disabled");
                  }
                  //$("#player" + i).text("Disconnected");
                }
                else
                {
                  if (message.currentRoom[i].playerInfo.position == 0 || message.currentRoom[i].playerInfo.position == 3) {
                    if ($("#playerid" + i).hasClass("player_left_disabled"))
                    {
                      $("#playerid" + i).removeClass("player_left_disabled");
                      if (message.currentRoom[i].playerInfo.position == 0) {
                        $("#playerid" + i).addClass("player_two");
                      }
                      if (message.currentRoom[i].playerInfo.position == 3) {
                        $("#playerid" + i).addClass("player_one");
                      }
                    }
                  } else {
                    if ($("#playerid" + i).hasClass("player_right_disabled"))
                    {
                      $("#playerid" + i).removeClass("player_right_disabled");
                      if (message.currentRoom[i].playerInfo.position == 2) {
                        $("#playerid" + i).addClass("player_four");
                      }
                      if (message.currentRoom[i].playerInfo.position == 1) {
                        $("#playerid" + i).addClass("player_three");
                      }
                    }
                  }
                }
                isGameStarted = false;
              }
              //$("#totalActiveUserhide").html($("#totalActiveUser").html());
              //$('.canvas_pop_msgs').html("waiting");
              //showCanvasPop('.canvas_pop_msgs',1);
              break;
            case Pong.Sockets.MessageType.PADDLEPOSITION:
              //console.log("Paddle postion received.", message);

              if (message.PaddlePosition == Pong.Sockets.PlayerPosition.LEFT) {
                gameObjects.paddle1.y = message.value;
              }
              if (message.PaddlePosition == Pong.Sockets.PlayerPosition.RIGHT) {
                gameObjects.paddle2.y = message.value;
              }
              if (message.PaddlePosition == Pong.Sockets.PlayerPosition.DOWN) {
                gameObjects.paddle3.x = message.value;
              }
              if (message.PaddlePosition == Pong.Sockets.PlayerPosition.UP) {
                gameObjects.paddle4.x = message.value;
              }

              break;
            case Pong.Sockets.MessageType.GameState:
              //console.log("GameState");

              console.log('CurrentRoomUser : ', message.CurrentRoomUser + '  CurrentActiveUser : ', message.CurrentActiveUser);
              //console.log('Start Game : ', JSON.stringify(message));
              //paddel1Control = (canvas.instance.height / 2) - (gameObjects.paddle1.height / 2);
              //paddel2Control = (canvas.instance.height / 2) - (gameObjects.paddle2.height / 2);
              if (message.CurrentActiveUser)
              {
                //console.log('CurrentActiveUser : ', message.CurrentActiveUser);
                $("#totalActiveUserhide").html(message.CurrentActiveUser);
                if (message.CurrentActiveUser != 1 && message.CurrentRoomUser != 1)
                {
                  //console.log("call ");
                  var countdown = 10;
                  var beepCount = 3;
                  var mediaElement = document.getElementById('audio_id');
                  timer = setInterval(function () {
                    gameObjects.Countdown = countdown;
                    countdown--;
                    if (beepCount > 0)
                    {
                      mediaElement.play();
                    }
                    beepCount--;
                  }, 1000);

                  setTimeout(function () {
                    gameObjects.Countdown = null;
                    clearInterval(timer);
                    gameObjects.isPaused = !gameObjects.isPaused;
                    isGameStarted = true;
                  }, 12000);
                }
                else if (message.CurrentActiveUser == 1 || message.CurrentRoomUser == 1)
                {
                  var mediaElement = document.getElementById('audio_id');
                  //var beepCount =3;
                  //console.log("call 1");
                  setTimeout(function () {
                    $(".player0").hide();
                    $(".player1").hide();
                    $(".player2").hide();
                    $(".player3").hide();
                    $('#totalActiveUserID').hide();
                    gameObjects.isRoundsMsg = false;
                    gameObjects.isWinner = true;
                    gameObjects.isLoader = true;
                    showCanvasPop('.canvas_pop_msgs', 0);
                  }, 5000);
                  //$('.canvas_pop_msgs').html("CONGRATULATIONS!<br />YOU HAVE WON.");
                  setTimeout(function () {
                    gameObjects.Countdown = null;
                    clearInterval(timer);
                    gameObjects.isPaused = !gameObjects.isPaused;
                    isGameStarted = true;
                    // if (beepCount >0 )
                    // {
                    // mediaElement.play();
                    // }
                    // beepCount--;
                  }, 12000);
                }
              }
              else
              {
                var mediaElement = document.getElementById('audio_id');
                var beepCount = 3;
                var countdown = 10;
                var mediaElement = document.getElementById('audio_id');
                timer = setInterval(function () {
                  gameObjects.Countdown = countdown;
                  countdown--;
                  if (beepCount > 0)
                  {
                    mediaElement.play();
                  }
                  beepCount--;
                }, 1000);
                setTimeout(function () {
                  gameObjects.Countdown = null;
                  clearInterval(timer);
                  gameObjects.isPaused = !gameObjects.isPaused;
                  isGameStarted = true;
                }, 12000);
              }

              break;
            case Pong.Sockets.MessageType.CONTROLPOSITION:
              //console.log("controlPos", JSON.stringify(message));
              clearInterval(timer);
              gameObjects.isPaused = !gameObjects.isPaused;

              // Reset paddel 1 position
              //gameObjects.paddle1.x = message.Paddle1Position.x;
              //gameObjects.paddle1.y = messagesPaddle1Position.y;

              // Reset paddel 2 position
              //gameObjects.paddle2.x = message.Paddle2Position.x;
              //gameObjects.paddle2.y = message.Paddle2Position.y;

              // Reset paddel 3 position
              //gameObjects.paddle3.x = message.Paddle3Position.x;
              //gameObjects.paddle3.y = message.Paddle3Position.y;

              // Reset paddel 4 position
              //gameObjects.paddle4.x = message.Paddle4Position.x;
              //gameObjects.paddle4.y = message.Paddle4Position.y;

              // Reset Ball position and player score
              //gameObjects.player2Score = message.BallPosition.player2Score;
              //gameObjects.player1Score = message.BallPosition.player1Score;
              gameObjects.ball.x = parseInt(message.xy.x);
              gameObjects.ball.y = parseInt(message.xy.y);
              //gameObjects.ball.speedX = message.BallPosition.speedX;
              //gameObjects.ball.speedY = message.BallPosition.speedY;
              //gameObjects.ball.moveToX = message.BallPosition.moveToX;
              //gameObjects.ball.moveToY = message.BallPosition.moveToY;
              //gameObjects.ball.speed = message.BallPosition.speed;

              //console.log("Client BricksLeft", gameObjects.BricksLeft);
              //console.log("Sever BricksLeft", message.BricksLeft);

              if (message.BL)
              {
                gameObjects.BricksLeft = message.BL;
                gameObjects.BricksRight = message.BR;
                gameObjects.BricksTop = message.BT;
                gameObjects.BricksBottom = message.BB;
              }
              //canvas.redraw(canvas.context, canvas.instance);
              //console.log("Messge Received...");
              break;
            case Pong.Sockets.MessageType.DISCONNECT:
              iosocket.disconnect();
              break;
            case Pong.Sockets.MessageType.ALREADYCONNECTED:
              alert("You are already connected to game. Please disconnect the other instance to re-join the game.");
              window.location.href = "<?php echo base_url() ?>profile";
              break;
            case Pong.Sockets.MessageType.TOTALACTIVEUSER:
              //console.log("message.activeUser" +JSON.stringify(message));
              if (tournament_type == Pong.TournamentType.MINI) {
                $('#totalActiveUserID').show();
                $("#totalActiveUser").html(message.noOfUser);
                if (tournament_name == "") {
                  $("#tounramentName").html("MINI tournament");
                } else {
                  $("#tounramentName").html(tournament_name);
                }
              }
              if (tournament_type == Pong.TournamentType.MEGA) {
                $('#totalActiveUserID').show();
                $("#totalActiveUser").html(message.noOfUser);
                if (tournament_name == "") {
                  $("#tounramentName").html("MEGA tournament");
                } else {
                  $("#tounramentName").html(tournament_name);
                }
              }
              $("#totalActiveUserhide").html($("#totalActiveUser").html());
              break;
            case Pong.Sockets.MessageType.DISCONNECTINFO:
              //console.log("DISCONNECTINFO" + JSON.stringify(message));
              if (message.roomkey == keyRoomID)
              {
                // if(tournament_type == Pong.TournamentType.PLAYFORFUN)
                // {
                // $(".player"+message.position).hide();
                // }else{
                if (message.position == 0 || message.position == 3) {
                  if (message.position == 0) {
                    $("#playerid" + message.position).removeClass("player_two");
                  }
                  if (message.position == 3) {
                    $("#playerid" + message.position).removeClass("player_one");
                  }
                  $("#playerid" + message.position).addClass("player_left_disabled");
                } else {
                  if (message.position == 1) {
                    $("#playerid" + message.position).removeClass("player_three");
                  }
                  if (message.position == 2) {
                    $("#playerid" + message.position).removeClass("player_four");
                  }
                  $("#playerid" + message.position).addClass("player_right_disabled");
                }
                //}
              }
              if (tournament_type == Pong.TournamentType.PLAYFORFUN) {
                var userCount = parseInt($("#totalActiveUser").html());
                $("#totalActiveUser").html(userCount - 1);
              } else
              {
                var userCount = parseInt($("#totalActiveUserhide").html());
                //$("#totalActiveUser").html(userCount -1);
                $("#totalActiveUserhide").html(userCount - 1);
              }

              break;
          }
        });

        try
        {
          var msgToSend = "{'key':'" + GUID + "', 'Type':" + Pong.Sockets.MessageType.CONNECT + ", 'TournamentID' :" + tournamentID + ",'RoundNumber': " + RoundNumber + ",'UserId':" + userid + ",'UserName':'" + username + "','UserImage':'" + userimage + "','UserScore':" + userscore + " , 'TournamentType':" + tournament_type + ", 'userStatus':" + userStatus + ", 'StartTime':'" + startTime + "'  }";
          //console.log("msgToSend::" +msgToSend);
          iosocket.send(msgToSend);
          setInterval(function () {
            try
            {
              var sendAliveMsg = "{'key':'" + GUID + "', 'Type':" + Pong.Sockets.MessageType.KEEPALIVE + " }";
              iosocket.send(sendAliveMsg);
            }
            catch (ex1)
            {
              console.log("Error sending Alive msg.");
            }
          }, 30000);
        }
        catch (ex)
        {
          console.log("Error connecting to socket: ", ex);
          if (tournament_type != Pong.TournamentType.PLAYFORFUN)
          {
            window.location.href = "<?php echo base_url(); ?>play_game/retournament/" + tournamentID + "?session_id=" + session_id;
          }
          //window.location.href = "<?php echo base_url(); ?>play_game/retournament/"+tournamentID+"?session_id="+session_id;
        }
      });

      iosocket.on('disconnect', function () {
        $("#btnConnectDisconnect").val("Connect");
        iosocket = null;
      });

      var timer;
      var gameContainer = $("canvas");
      $("body").mousemove(function (event) {
        //event.preventDefault();
        clearTimeout(timer);
        timer = setTimeout(function () {
          if (!gameObjects.isPaused) {
            var offset = gameContainer.offset();
            X = (event.pageX - offset.left) - gameObjects.halfPaddelwidth;
            Y = (event.pageY - offset.top) - gameObjects.halfPaddelwidth;
            if (X < 0) {
              X = 0;
            }
            if (Y < 0) {
              Y = 0;
            }
            var posValue;
            if ($('#Position').val() == Pong.Sockets.PlayerPosition.LEFT) {
              //posValue = mouse.y;
              posValue = Y;
            } else if ($('#Position').val() == Pong.Sockets.PlayerPosition.RIGHT) {
              posValue = Y;
              //posValue = mouse.y;
            } else if ($('#Position').val() == Pong.Sockets.PlayerPosition.DOWN) {
              //posValue = mouse.x;
              posValue = X;
            } else if ($('#Position').val() == Pong.Sockets.PlayerPosition.UP) {
              //posValue = mouse.x;
              posValue = X;
            }
            var msgToSend = "{'key':'" + GUID + "','roomKey':'" + roomKey + "','value':" + posValue + ",'Type':" + Pong.Sockets.MessageType.PADDLEPOSITION + ",'PaddlePosition':" + $('#Position').val() + "}";
            iosocket.send(msgToSend);
          }
        }, 1);

      });
      //canvas.addEventListener('mousemove', ev_mousemove, false);
      //Added to enable keyboard start
      //$(document).keydown(MovePaddle);
      //Added to enable keyboard end
    });
 function isNumeric(value) {
      if (value != null && !value.toString().match(/^[-]?\d*\.?\d*$/))
        return false;
      return true;
    }

    function showLooserMessage()
    {
      iosocket.disconnect();
      isGameStarted = false;
      if ((tournament_type == Pong.TournamentType.MINI) || (tournament_type == Pong.TournamentType.MEGA))
      {
        $('.canvas_pop_msgs').html("You lost! Bad luck!<br />Play again?<br/><a class=\"yes_btn\" onclick=\"window.location.href ='<?php echo base_url() ?>tournament';\">&nbsp;</a><a class=\"no_btn\" onclick=\"window.location.href ='<?php echo base_url() ?>profile';\">&nbsp;</a>");
        showCanvasPop('.canvas_pop_msgs', 1);
        $('#totalActiveUserID').hide();
      }
      else
      {
        $('.canvas_pop_msgs').html("You lost! Bad luck!<br />Play again?<br/><a class=\"yes_btn\" onclick=\"window.location.href ='<?php echo base_url() ?>play_game';\">&nbsp;</a><a class=\"no_btn\" onclick=\"window.location.href ='<?php echo base_url() ?>profile';\">&nbsp;</a>");
        showCanvasPop('.canvas_pop_msgs', 1);
        $('#totalActiveUserID').hide();
      }

    }


    function isValidEmailAddress(emailAddress) {
      var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
      return pattern.test(emailAddress);
    }
function IsValidPage() {

      var Add = $("#txtAdd").val();
      var City = $("#txtCity").val();
      var Pcode = $("#txtPostCode").val();
      var Email = $("#txtEmail").val();
      var telNo = $("#txtTelNo").val();
      var flag = true;
      if (Add == "" || Add == null) {
        $("#txtAdd").addClass('cf_error');
        $('div.canvas_form_error').html('Please fill the required fields.');
        flag = false;
      }
      if (City == "" || City == null) {
        $("#txtCity").addClass('cf_error');
        $('div.canvas_form_error').html('Please fill the required fields.');
        flag = false;
      }
      if (Pcode == "" || Pcode == null) {
        $("#txtPostCode").addClass('cf_error');
        $('div.canvas_form_error').html('Please fill the required fields.');
        flag = false;
      }
      if (!isNumeric(Pcode)) {
        $("#txtPostCode").addClass('cf_error');
        $('div.canvas_form_error').html('Please Fill Numeric value in Post Code.');
        flag = false;
      }
      if (Email == "" || Email == null) {
        $("#txtEmail").addClass('cf_error');
        $('div.canvas_form_error').html('Please fill the required fields.');
        flag = false;
      }
      if (!isValidEmailAddress(Email)) {
        $("#txtEmail").addClass('cf_error');
        $('div.canvas_form_error').html('Please fill valid Email Address.');
        flag = false;
      }


      if (telNo == "" || telNo == null) {
        $("#txtTelNo").addClass('cf_error');
        $('div.canvas_form_error').html('Please fill the required fields.');
        flag = false;
      } else if (telNo.length <= 6) {
        $("#txtTelNo").addClass('cf_error');
        $('div.canvas_form_error').html('Please enter atleast 7 digit in Telephone No.');
        flag = false;
      }

      if (!isNumeric(telNo)) {
        $("#txtTelNo").addClass('cf_error');
        $('div.canvas_form_error').html('Please Fill Numeric value in Telephone No.');
        flag = false;
      }
      if (flag == true) {
        var ajaxurl = "<?php echo base_url() ?>ajax/saveWinnerDetails";
        $.ajax({
          url: ajaxurl,
          type: "POST",
          data: {tournament_id: tournamentID, address: Add, city: City, postcode: Pcode, email: Email, telephone: telNo},
          success: function (result) {
            
            showCanvasPop('.canvas_form_block', 0);
            $('.canvas_pop_msgs').html("THANK YOU, AN EMAIL HAS<br /> BEEN SENT TO YOU WITH<br /> DETAILS OF YOUR PRIZE.<br />PLAY AGAIN?<br/><a class=\"yes_btn\" onclick=\"window.location.href ='<?php echo base_url() ?>tournament';\" >&nbsp;</a><a class=\"no_btn\" onclick=\"window.location.href ='<?php echo base_url() ?>profile';\">&nbsp;</a>")
            gameObjects.ball.width = 0;
            showCanvasPop('.canvas_pop_msgs', 1);
          }
        });
      }
    }
    function removeError() {
      var Add = $("#txtAdd").val();
      var City = $("#txtCity").val();
      var Pcode = $("#txtPostCode").val();
      var Email = $("#txtEmail").val();
      var telNo = $("#txtTelNo").val();

      if (Add != "" || Add == null) {
        $("#txtAdd").removeClass('cf_error');
      }
      if (City != "" || City == null) {
        $("#txtCity").removeClass('cf_error');
      }
      if (Pcode != "" || Pcode == null) {

        $("#txtPostCode").removeClass('cf_error');
      }
      if (Email != "" || Email == null) {
        $("#txtEmail").removeClass('cf_error');
      }
      if (telNo != "" || telNo == null) {
        $("#txtTelNo").removeClass('cf_error');
      }
      if (Add != "" && City != "" && Pcode != "" && Email != "" && telNo != "") {
        $('div.canvas_form_error').html('');
      }
    }
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