        <?php $userdata = userData(sessionData('id')); 
			  $totalmatchwins = totalmatchwins(sessionData('id'));
			  $user_role = sessionData('user_role')
		?>
		
		<!-- login panel -->
        <article class="loginpanel clearfix">
          <h2>profile</h2>
          <div class="middle-form  profiler_top_margin">
          	<form action="">
          		<ul>
          			<li><label><input type="checkbox"> 1 $</label></li>
          			<li><label><input type="checkbox"> 2 $</label></li>
          		</ul>
          		<div style="margin-top:30px;text-align:center;">
          			<a class="paypal_btn" href="<?php echo base_url(); ?>tournament/payment"><img src="<?php echo base_url('images/paypal_btn_new.png'); ?>" alt="" border="0"  /></a> 
          		</div>
          	</form>
          </div>
        </article>

        <style>
        	.middle-form  ul{text-align: center;}
			.middle-form  ul li{list-style: none; color: #1f345c;font-size: 14px;font-family: Arial,Helvetica,sans-serif;margin-bottom: 25px;text-align: center;}
			.middle-form  ul li input{text-align: center;}
			.middle-form  ul li label{font-size: 18px;font-weight: bold;}
        </style>
