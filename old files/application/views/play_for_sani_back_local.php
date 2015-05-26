<!DOCTYPE HTML>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link href="<?php echo base_url(); ?>css/styles.css" rel="stylesheet">
    <title>BrikBrok - my brick breaker HTML 5</title>
    <style>
        .game_canvas { 
            background-image:url('images/gamebg3.png'); 
            background-repeat:no-repeat; 
            width:420px; 
            height:420px; 
            padding-left:90px; 
            padding-top:80px; 
            padding-right:80px; 
            padding-bottom:90px;
            cursor: url("../images/white_cursor.png"), auto;

        }
       
    </style>
</head>
<body>
        <div id="totalActiveUserID">
            <p>Total Active User for <b><span id="tounramentName" >tournament</span></b>  is : <span id="totalActiveUser" >0</span></p>
        </div>
        <div class="ballinsert" id="ballinsert">
            <img id="loadingimage" src="images/loader_img.gif" style="display:none;">
            <img id="ball_image"  src="<?php echo base_url(); ?>images/ball.png" />
        </div>
        <div id="playerid0" class="player_two player0 ">
            <p class="player_img">
                <img id="imgplayer0" src="<?php echo $gamedata['user_avatar']; ?>" alt="" width="45" height="45" />
            </p> 
            <span id="player0" class="player_name"></span>  
            <span id="playerscore0" class="player_win_points"><?php echo $gamedata['user_name']; ?><br/>WINS: <div class="score">0</div> </span>
        </div>
    <div class="game_canvas">
        <div class="grid">
           <!--  <header>
               
                <ul>
                    <li><a href="#gameZone" id="newGame">New game</a></li>
                    <li><a href="#gameZone" id="wormHole">Wormhole Mode</a></li>
                </ul>
            </header> -->
            <div id="gameZone">
                <canvas id="backgroundCanvas">
                    
                </canvas>
                <svg id="svgRoot">
                    <circle cx="100" cy="100" r="10" id="ball"/>
                    <rect id="pad" height="15px" width="130px" x="10" y="10" rx="10" ry="20"/>
                    
                </svg>
                <div id="stats">
                </div>
                <div id="message">Victory!</div>
            </div>
           
        </div>
    </div>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/mouse1.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/background.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/game.js"></script>
</body>
</html>
