<!DOCTYPE html>
<head>
<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Play Pong!</title>
	<!--style type="text/css">
	body{
		width: 980px; /* how wide to make your web page */
		background-color: purple; /* what color to make the background */
		margin: 0 auto;
		padding: 0;
		font:12px/16px Verdana, sans-serif; /* default font */
	}
	div#main{
		background-color: #9c8468;
		margin: 0;
		padding: 10px;
	}
	#gameContainer{
		margin: 0 auto;
		width: 960px;
		height: 500px;
	}
	#controls{
		height: 20px;
		text-align: center;
	}
	#game{
		width: 960px;
		height: 480px;
		border: 1px solid black;
	}
	#gameMessage{
		font-size: 30px;
	}
	h1 {
	        text-shadow: -1px -1px 1px #fff, 1px 1px 1px #000;
	        color: #9c8468;
	        opacity: 0.3;
	        font: 80px 'Museo700';
	        text-align: center;
	}
	#matchMaking {
		text-align: center;
	}
	#chat {
		text-align: center;
	}
	#chat.messages {
		text-align: center;
	}
	<style type="text/css">
		#gameContainer{
		margin: 0 auto;
		width: 960px;
		height: 500px;
	}
	#game{
		width: 960px;
		height: 480px;
		border: 1px solid black;
		margin: 0px auto;
	}
	</style>

	</style-->
	
	<link href="../css/style.css" rel="stylesheet" type="text/css">
	<link href="../css/styles.css" rel="stylesheet" type="text/css">
</head>
<body>
<section id="mainbody">
<script> var myParam = location.search.split('token=')[1]; 
			var newvar = "string" + myParam;
</script>
	<div id="wraper">
		<div id="contbody">
	      <header class="hdcont clearfix">
	        <hgroup class="logo"> <a href="images/pong_logo.png" border="0" alt="" /><img src="images/pong_logo.png"></a> </hgroup>
	        <div  class="clear"></div>
	      </header>
	      <!-- header navigation panel -->
	      <nav>
	        <div class="nav_menu">
	         <!--  <ul class="menu_left">
	            <li><a class="<?php echo ($nav_act == 'home')  ? 'select_bg' : ''; ?>" href="<?php echo base_url(); ?>">home</a></li>
	            <li><a class="<?php echo ($nav_act == 'profile')  ? 'select_bg' : ''; ?>" href="<?php echo $user_role==2 ? base_url('admin'): base_url('profile'); ?>">Profile</a></li>
	           
	            <li><a class="<?php echo ($nav_act == 'how_to_play')  ? 'select_bg' : ''; ?>" href="<?php echo base_url('how_to_play'); ?>">How to Play</a></li>
	            <li><a class="<?php echo ($nav_act == 'register')  ? 'select_bg' : ''; ?>" href="<?php echo base_url(); ?>register">Register</a></li>
	            <?php if(!$logged_in){?>
	            <li><a class="<?php echo ($nav_act == 'login')  ? 'select_bg' : ''; ?>" href="<?php echo base_url(); ?>login">Login</a></li>
	            <?php }else{ ?>
	             <li><a href="<?php echo base_url(); ?>logout">Logout</a></li>
	             <?php } ?>
	          </ul> -->
	          <!-- <ul class="menu_right">
	            <li><a id="newGame" class="<?php echo ($nav_act == 'play_for_fun')  ? 'select_bg' : ''; ?>" href="<?php echo base_url('play_game'); ?>">play for fun </a></li>
				<<li><a class="<?php //echo ($nav_act == 'tournament')  ? 'select_bg' : ''; ?>" href="<?php //echo $user_role==2 ? base_url('admin/tournament') : base_url('tournament'); ?>">Tournament</a></li>
				     <li><a class="<?php echo ($nav_act == 'cash_game')  ? 'select_bg' : ''; ?>" href="<?php echo base_url('cash_game'); ?>">Cash Game</a></li>
	          
	             <li><a class="<?php echo ($nav_act == 'tournament')  ? 'select_bg' : ''; ?>" href="<?php echo $user_role==2 ? base_url('tournament/tournamentlisting') : base_url('tournament'); ?>">Tournament</a></li>
	             <li><a class="<?php echo ($nav_act == 'shop')  ? 'select_bg' : ''; ?>" href="<?php echo base_url('shop')?>">Shop</a></li>
	            <li><a class="<?php echo ($nav_act == 'contact')  ? 'select_bg' : ''; ?>" href="<?php echo base_url('contact'); ?>">Contact</a></li>
	          </ul> -->
	        </div>
	      </nav>
	      <div class="clear"></div>
	      <!-- middle content panel -->
	      <section id="article">
			  <div id="main">
			  	<span class="welcome" id="welcome_name"></span>
			  	<div class="socreboardOuter">
					<div id="hideWhilePlaying">
						<div id="scores" style="display:none;">
							<h2>Select Players who are online and give challenge</h2>
							<div id="playerList" style="display:none;">
								<div class="customSelect">
									<span></span>
									<select id="players">
										<option id="no_player">---Select Player---</option>
									</select>
								</div>
								<button id="challenge"></button>
							</div>
							<!-- <ul id="scoreboard">

							</ul> -->
						</div>
					</div>

					<div id="imagecontainer" style="display:none">
					<div class="left-img">
						<img src="images/yellow_bg.png">
						<label id="player_1"></label>
						<span>You</span>
					</div>
					<div class="right-img">
						<img src="images/blue_bg.png">
						<label id="player_2"></label>
					</div>
					</div>
					<div style="clear:both;"></div>
					<div id="gameContainer" style="display:none">
						<div class="leftBrick">
							<img src="images/1.2.png">
							<img src="images/1.2.png">
							<img src="images/1.2.png">
							<img src="images/1.2.png">
						</div>
						<div class="rightBrick">
							<img src="images/1.1.png">
							<img src="images/1.1.png">
							<img src="images/1.1.png">
							<img src="images/1.1.png">
						</div>
						<div id="game">
							<div class="middleScreen">
								
							</div>
						</div>
					</div>
					<div id="countdown" style="display: none; position: absolute;top: 44%;font-size: 47px;left: 47%;color:#E3AC72;font-weight: bold;font-family: Verdana;">10</div>
					<!-- <p>You'll be automatically redirected in <span id="count">10</span> seconds...</p> -->
					<div id="gameMessage"></div><br />
					<div id="matchMaking" style="display:none">
						<h2>Enter Your Name that will display to online players</h2>
						<div class="mathcMakingInnew">
							<label>Name:</label>
							<div class="makingForm">
								<input type="text" id="playerName" readonly=""><br>
								<button id="joinLobby"></button>
							</div>
						<button style="display:none;" id="lookForPlayer">Find Match</button><br />
						</div>
					</div>
					<button id="launchBall" style="display:none;">Launch Ball</button> <button id="newGame" style= "display:none;">New Game</button>
				</div>
				<!-- <div id="chat">
					<p>
						<textarea id="comment"></textarea>
						<button id="send">Send Comment</button>
					</p>
					<ul id="messages">
					</ul>			 
				</div> -->
				<!-- Include the Socket.IO and Ext libraries -->
				<!--script src="//cdn.sencha.io/ext-4.1.1-gpl/ext-all-dev.js"></script-->
				<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
				<script src="/socket.io/socket.io.js"></script>
				<script src="./pong-game.js"></script>
				<script src="./client.js"></script>
				<script src="./ext_cdn.js"></script>
				<script src="./jquery-1.7.2.js"></script>
				</div>             
	      </section>
	    </div>
	</div>
</section>
<footer id="footer">
  	<ul class="footermain">
    	<li>&copy; Copyright <?php echo date("Y"); ?> Fun and Prizes Ltd</li>
        <li><a href="<?php echo base_url('home/sitemap'); ?>">Site Map</a></li>
        <li><a href="<?php echo base_url('home/termsandconditions'); ?>" target="_blank">Terms and Conditions</a></li>
        <li><a href="<?php echo base_url('home/privacypolicy'); ?>" target="_blank">Privacy Policy</a></li>
    </ul>
    </footer>
    <div class="clear"></div>
</html>
</body>
