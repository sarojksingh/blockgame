<!-- login panel -->
<article class="loginpanel clearfix">
	<h2>Forgot Password</h2>
	<form method="post" action="<?php echo base_url('login/forgot_password'); ?>" id="from_forgot_password" name="from_forgot_password">
	<div class="contlog_left_login contact_center" id="forget_div">
	  <div class="forms1 clearfix"> 
	  <span id="email-errors" class="error_show_out demo_class"><?php echo form_error('email'); ?>&nbsp;</span>
		<div class="clear"></div>
		<label class="labl_padd">Email<span class="req_red">*</span> :</label>
		<span class="inout_box">
		<input id="email" class="" type="text" name="email" value="<?php echo $email; ?>"/>
		</span> </div>
	  <div class="forms1 clearfix">
		<div class="submit_btn_align">
		  <input type="submit" class="submit_button_pwd" value="" />
		</div>
	  </div>
	</div>
	 <div class="clear"></div>  
	</form>
</article>