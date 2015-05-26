
    <link href="<?php echo base_url(); ?>css/styles.css" rel="stylesheet">
    <title>BrikBrok - my brick breaker HTML 5</title>
    <style>
        .game_canvas { 
            background-image:url('<?php echo base_url('images/gamebg5_12_1.png');?>'); 
            background-repeat:no-repeat; 
            width:420px; 
            height:420px; 
            padding-left:90px; 
            padding-top:80px; 
            padding-right:80px; 
            padding-bottom:90px;
            /*cursor: url("../images/white_cursor.png"), auto;*/

        }

        .bottom-Bg{    bottom: 131px;
            left: 117px;
            position: absolute;
            width: 415px;}
        .game_canvas{padding: 80px 80px 0px 90px;height: auto; position: relative;}

        svg#svgRoot {
            height: 489px;
            position: absolute;
            left: 60px;
            top: 31px;
            width: 478px;
        }
        .bottom-Bg img{display: inline-block;margin-left: -4px;width: 118px}
        #gameZone, .grid{height: auto !important;}
        .topCounter{text-align: center;margin: 15px 0px;}
        .topCounter {font-family: 'gnuolane_rgregular';color: #8a530b;font-size: 40px;font-weight: bold}
       .play_css {position: absolute;z-index: 999;right: 464px;bottom: 360px;}

        /*#start_show img {float: right;margin-right: 172px;margin-top: 110px;}*/
    </style>

            <audio id="audiotag1" src="<?php echo base_url('SoundFile/Blop-Mark_DiAngelo-79054334.mp3')?>" preload="auto" type ="audio/wav"></audio>
            
            <script type="text/javascript">
                function play_single_sound() {
                    document.getElementById('audiotag1').play();
                }
            </script>

            <audio id="game_over" src="<?php echo base_url('SoundFile/1.Button Click.mp3')?>" preload="auto" type ="audio/wav"></audio>
            
            <script type="text/javascript">
                function game_over_sound() {
                    document.getElementById('game_over').play();
                }
            </script>


        <div id="totalActiveUserID">
            <!-- <p>Total Active User for <b><span id="tounramentName" >tournament</span></b>  is : <span id="totalActiveUser" >0</span></p>
         --></div>
        <div class="topCounter" id="topcount"><span>0</span></div>
        <div class="ballinsert" id="ballinsert">
            <img id="loadingimage" src="images/loader_img.gif" style="display:none;">
            <!-- <img id="ball_image"  src="<?php echo base_url(); ?>images/ball.png" /> -->
        </div>
        <div id="playerid0" class="player_two player0 ">
            <p class="player_img">
                <img id="imgplayer0" src="<?php echo $gamedata['user_avatar']; ?>" alt="" width="45" height="45" />
            </p> 
            <span id="player0" class="player_name"></span>  
            <span id="playerscore0" class="player_win_points"><?php echo $gamedata['user_name']; ?><br/>WINS <div class="scorea"></div> </span>
        </div>
        <?php // Play Button ?>
        <div id="start_show">
         <a href="javascript:void(0)" class="play_css"><img src="<?php echo base_url('images/play2.png'); ?>" onclick="countdown('countdown')" height="80px" width="80px" /></a>
         </div>
        <?php // Play Button ?>
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
                    <!-- <img  src="<?php echo base_url(); ?>images/ball.png" id="ball"/> -->
                    <circle cx="242.465" cy="439" r="10" id="ball"/>
                    <rect id="pad" height="15px" width="110px" y="468" x="190"/>
                     <!-- <rect id="pad" height="15px" width="120px" x="10" y="10" rx="10" ry="20"/> -->
                </svg>
                <?php // Shashank added code ?>
                <div id='countdown' style=" display: block; position: absolute;top: 40%;font-size: 40px;left: 50%;color:#E3AC72;font-weight: bold;font-family: Verdana;"></div> </center> <br><br>
                <?php // Shashank added code ?>
                <div id="stats">
                </div>

                <div id="message">Victory!</div>
                <div id="message2">Victory!</div>
                <div id="message3">Victory!</div>
            </div>
           <div class="bottom-Bg">
              <img src="<?php echo base_url('images/green_brick.1.png'); ?>" class="123" name="123" data-uid="hello" style="float: left; margin-left: -53px;">
              <img src="<?php echo base_url('images/green_brick.1.png'); ?>" class="123" name="123" data-uid="he">
              <img src="<?php echo base_url('images/green_brick.1.png'); ?>" class="123" name="123" data-uid="hel">
              <img src="<?php echo base_url('images/green_brick.1.png'); ?>" class="1234" name="123" data-uid="hllo">
           </div>
        </div>
    </div>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/mouse1.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/background.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/game.js"></script>

<?php // Shashank added code ?>

   <script type="text/javascript">


    var interval;

    var minutes = 0;

    var seconds = 5; 

       window.onload = function() 

        {
         show_play_button();
        //countdown('countdown');

       }


       function show_play_button(){

        jQuery("#start_show").show();

        //countdown('countdown');

       }


       function countdown(element) 
         {
            jQuery("#start_show").hide();
    interval = setInterval(function() {

        var el = document.getElementById(element);

        if(seconds == 0) {
               
            if(minutes == 0) {
                
              //(el.innerHTML = "Start!");                    
              jQuery("#countdown").slideUp('slow');
                clearInterval(interval);
                startGame();
                return;

            } else {
                minutes--;

                seconds = 60;

            }

        }

        if(minutes > 0) {
            var minute_text = minutes + (minutes > 1 ? ' minutes' : ' minute');

        } else {

            var minute_text = '';

        }

        var second_text = seconds > 1 ? '' : '';

        if(el.innerHTML<=4 && el.innerHTML!=0){
            play_single_sound();
        }

        el.innerHTML = minute_text + ' ' + seconds + ' ' + second_text + '';


        seconds--;

    }, 1000);

}
   </script> 

   

 <!--  <div id='countdown'></div> </center> <br><br> -->

  
<?php // Shashank added code ?>
