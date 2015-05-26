    <?php $userdata = userData(sessionData('id')); 
			  $totalmatchwins = totalmatchwins(sessionData('id'));
			  $user_role = sessionData('user_role')
		?>
		
		<!-- login panel -->
        <article class="loginpanel clearfix">
          <!-- <h2>Add Fund to Cash Game</h2> -->
          <h2>Select Game</h2>
          <div class="middle-form  profiler_top_margin">
          	<form action="<?php echo base_url('cash_game/game_start');?>">
                    <ul>
                        <li>
                            <span>$1</span>
                            <!-- <input type="submit" value="BUY IN" onclick=''> -->
                            <a class="buyin" href="http://localhost:1234/game.php?id=123">BUY IN</a>
                        </li>
                        <li>
                            <span>$2</span>
                            <a class="buyin" href="http://localhost:1234/game.php">BUY IN</a>
<!--                            <input type="submit" value="BUY IN">-->
                        </li>
                    </ul>
                    <!-- <div style="margin-top:30px;text-align:center;">
                    <a class="paypal_btn" href="<?php echo base_url('cash_game'); ?>"><img src="<?php echo base_url('../images/paypal_btn_new.png'); ?>" alt="" border="0"  /></a> 
            </div> -->
          	</form>
          </div>
        </article>

        <style>
            .middle-form{font-family: 'Lobster Two', cursive;} 
            .middle-form  ul{text-align: center;}
            .middle-form  ul li{margin-right: 20px;display: inline-block;list-style: none; color: #1f345c;font-size: 14px;font-family: Arial,Helvetica,sans-serif;text-align: center;}
            .middle-form  ul li span{background: url(../images/ipad_img.png); color: #efe3b1;
                display: block;
                font-family: "gnuolane_rgregular";
                font-size: 35px;
                font-weight: 700;
                height: 28px;
                padding: 75px 0;
                text-align: center;
                width: 172px;
            }

            .middle-form  ul li:last-child{margin-right: 0px;}
            .middle-form ul li a.buyin {display: block; line-height: 60px;}
            .middle-form  ul li input[type="submit"], .middle-form  ul li a.buyin {
                border:none;font-family: "hvd_comic_serif_proregular";
                background: url(../images/disable_left.png); width:160px; height:62px; color:#4FA7CB; 
                border-radius: 5px; margin-top: 10px; font-size: 16px;
            }
            /*.middle-form  ul li input[type="submit"]:hover{ background: none repeat scroll 0 0 #1f345c;color: #fff;}*/
        </style>
