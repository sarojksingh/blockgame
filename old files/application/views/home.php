
	<!-- login panel -->
	<article class="contlog_matter clearfix">
	  <h2>Welcome to Blocker! Fun and Prizes</h2>
	  <div class="welcome_matter">
		<p>Blocker is a game where you play against other Blocker fanatics to win heaps of prizes, 
		It's an easy game to learn but hard to master.</p>

		<p>Why spend your time playing games where winning is just a feeling? With Blocker, you can win Gift cards, iPods, iPads and other great prizes while still having fun!</p>

		<p>Blocker gives everyone the opportunity to win prizes both big and small!
		If you're serious about online gaming and interacting with other players, then blocker is the game for you.</p>
			<p>What other game provides you with good entertainment and good prizes?
		We are based in Australia, and prizes are only issued to Australian players at this time.</p>
		<p>So why wait?  Register now!!</p>
	  </div>
	  <div class="clear"></div>
	  <?php if(sessionData('id') == 0) { ?>
		  <div class="clearfix buttons_div_inner">
			<div class="btn_centr"><span class="left right_margn"><a href="<?php echo base_url(); ?>register" class="wel_register_button register_btn"><img src="images/register_btn.png" alt="" border="0"  /></a></span><span class="left right_margn"><a href="<?php echo base_url(); ?>login" class="wel_login_button login_btn"><img src="images/login_btn.png" alt="" border="0"  /></a></span></div>
		  </div>
	  <?php } ?>
	  <div class="clear"></div>
	  <h3 class="link_h3">Links</h3>
	  <div class="clear"></div>
	</article>
	 <div class="clearfix two_buttons">
	 	<p>Share us on:</p>
	 	<ul class="clearfix socialLink">
	 		<li><a target="blank" href="http://www.facebook.com/sharer.php?u=<?php echo base_url();?>"><img src="<?php echo base_url('images/face.png'); ?>"></a></li>
	 		<li><a target="blank" href="http://twitter.com/share?url=<?php echo base_url();?>&text=Blocker&hashtags=Blocker" ><img src="<?php echo base_url('images/twitter.png');?>"></a></li>
	 	</ul>
		<div class="inner_two_buttons">
			<a target="_blank" href="https://www.facebook.com/pages/Blocker/448673081895391?fref=ts" class="left link_one_btn">
				<img src="images/link_one_btn.png" alt="" border="0"  />
			</a>
			<!--<a href="" class="left link_two_btn">
				<img src="images/link_two_btn.png" alt="" border="0"  />
			</a>-->
		</div>
	</div>
	  <div class="clear"></div>


	<style type="text/css">
		.socialLink{margin: 5px 0px;text-align: center;}
	  	.socialLink li{display: inline-block;margin-right: 5px;}
	  	.two_buttons p{font-size:18px;color: #1D2143;font-family:'hvd_comic_serif_proregular';text-align:center}
	}
	</style>