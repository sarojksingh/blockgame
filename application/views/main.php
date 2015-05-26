<?php
//Set no caching
//header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
//header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
header("Cache-Control: no-store, no-cache, must-revalidate"); 
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>
<!DOCTYPE html>
<html>
<head>
<!--<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />-->
<title><?php echo $title;?></title>
<link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url(); ?>images/fav.ico">
<!--<link type="image/x-icon" href="<?php //echo base_url(); ?>images/favicon.ico" rel="icon">-->
<link href="<?php echo base_url(); ?>css/style.css" rel="stylesheet" type="text/css" >

<link href='http://fonts.googleapis.com/css?family=Lobster+Two:400,400italic,700' rel='stylesheet' type='text/css'>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-1.7.2.js"></script>  
<script>
var SITE_URL = "<?php echo base_url(); ?>";
</script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/validate.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/custom-validate.js"></script>
<!-- Internet Explorer HTML5 enabling code: -->
<!--[if IE]>
        <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        
        <style type="text/css">
        .clear {
          zoom: 1;
          display: block;
        }
        </style>       
        <![endif]-->
</head>
<body>
<section id="mainbody">
  <div id="wraper">
    <div id="contbody">
      <header class="hdcont clearfix">
        <hgroup class="logo"> <a href="<?php echo base_url(); ?>"><img src="<?php echo base_url(); ?>images/pong_logo.png" border="0" alt="" /></a> </hgroup>
        <div  class="clear"></div>
      </header>
      <!-- header navigation panel -->
      <nav>
        <div class="nav_menu">
          <ul class="menu_left">
            <li><a class="<?php echo ($nav_act == 'home')  ? 'select_bg' : ''; ?>" href="<?php echo base_url(); ?>">home</a></li>
            <li><a class="<?php echo ($nav_act == 'profile')  ? 'select_bg' : ''; ?>" href="<?php echo $user_role==2 ? base_url('admin'): base_url('profile'); ?>">Profile</a></li>
           
            <li><a class="<?php echo ($nav_act == 'how_to_play')  ? 'select_bg' : ''; ?>" href="<?php echo base_url('how_to_play'); ?>">How to Play</a></li>
            <li><a class="<?php echo ($nav_act == 'register')  ? 'select_bg' : ''; ?>" href="<?php echo base_url(); ?>register">Register</a></li>
            <?php if(!$logged_in){?>
            <li><a class="<?php echo ($nav_act == 'login')  ? 'select_bg' : ''; ?>" href="<?php echo base_url(); ?>login">Login</a></li>
            <?php }else{ ?>
             <li><a href="<?php echo base_url(); ?>logout">Logout</a></li>
             <?php } ?>
          </ul>
          <ul class="menu_right">
            <li><a id="newGame" class="<?php echo ($nav_act == 'play_for_fun')  ? 'select_bg' : ''; ?>" href="<?php echo base_url('play_game'); ?>">play for fun </a></li>
            <!--<li><a class="<?php //echo ($nav_act == 'tournament')  ? 'select_bg' : ''; ?>" href="<?php //echo $user_role==2 ? base_url('admin/tournament') : base_url('tournament'); ?>">Tournament</a></li>-->
            <li><a class="<?php echo ($nav_act == 'cash_game')  ? 'select_bg' : ''; ?>" href="<?php echo base_url('cash_game'); ?>">Cash Game</a></li>
          
             <li><a class="<?php echo ($nav_act == 'tournament')  ? 'select_bg' : ''; ?>" href="<?php echo $user_role==2 ? base_url('tournament/tournamentlisting') : base_url('tournament'); ?>">Tournament</a></li>
             <li><a class="<?php echo ($nav_act == 'shop')  ? 'select_bg' : ''; ?>" href="<?php echo base_url('shop')?>">Shop</a></li>
            <li><a class="<?php echo ($nav_act == 'contact')  ? 'select_bg' : ''; ?>" href="<?php echo base_url('contact'); ?>">Contact</a></li>
          </ul>
        </div>
      </nav>
      <div class="clear"></div>
      <!-- middle content panel -->
      <section id="article">
		  <?php 		
		 if($msg)
		   {
			if($type=="success")
			{
			$class = "success_msg";   
			}else{
			$class = "wrong_msg";  
			}
		  ?>
            <div class="<?php echo $class; ?>" id="msg_flashdata"><?php echo $msg; ?>
                <span class="close_btn"><a href="javascript:void(0);" id="msg_close">X</a></span>
                <div class="clear"></div>
            </div>
          <?php } ?>	 
        <?php echo $sign.$contents; ?>
      </section>
    </div>
    <script>
	function MM_openBrWindow(theURL,winName,features) { //v2.0
	  var winPosL = ($(document).width() - 700)/2;
	  var winPosT = ($(document).height() - 700)/2;
	  var option='left='+winPosL+',top='+winPosT+',height=' + 700 + ',width=' + 700 + ',scrollbars=yes,toolbar=no,resizable=no,statusbar=no,menubar=no';
	 // url=url.substr(3,url.length)
	  window.open(theURL,'Coupon',option)//
	  //window.open(theURL,winName,'width='+winPosL+',height='+winPosT);
	}
    </script>
    <!-- start footer panel -->
    <footer id="footer">
      	<ul class="footermain">
        	<li>&copy; Copyright <?php echo date("Y"); ?> Fun and Prizes Ltd</li>
            <li><a href="<?php echo base_url('home/sitemap'); ?>">Site Map</a></li>
            <li><a href="<?php echo base_url('home/termsandconditions'); ?>" target="_blank">Terms and Conditions</a></li>
            <li><a href="<?php echo base_url('home/privacypolicy'); ?>" target="_blank">Privacy Policy</a></li>
        </ul>
    </footer>
    <div class="clear"></div>
  </div>
</section>
    <script>
        jQuery("#msg_close").click(function(){
            jQuery("#msg_flashdata").slideUp('slow');
        });
    </script>
</body>
</html>

