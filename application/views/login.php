<!-- login panel -->
<article class="loginpanel clearfix">
  <form method="post" action="<?php echo base_url('login/loginCheck'); ?>" id="form_login" name="form_login">
    <h2>Login</h2>
	
    <div class="contlog_left_login contact_center">
      <div class="forms1 clearfix"> <span id="username-errors" class="error_show_out demo_class"><?php echo form_error('username'); ?>&nbsp;</span>
        <div class="clear"></div>
        <label class="labl_padd">user name<span class="req_red">*</span> :</label>
        <span class="inout_box">
        <input id="username" class="" type="text" name="username" maxlength="15" value="<?php echo $username; ?>"/>
        </span> </div>
      <div class="forms1 clearfix"> <span id="password-errors" class="error_show_out demo_class"><?php echo form_error('password'); ?>&nbsp;</span>
        <div class="clear"></div>
        <label class="labl_padd">Password<span class="req_red">*</span> :</label>
        <span class="inout_box">
        <input id="password" class="" type="password" name="password" />
        </span>
        </p>
      </div>
    </div>
    <div class="clear"></div>
    <div class="clearfix buttons_div_inner">
    	<span class="forget_pass"><a href="<?php echo base_url('login/forgotpassword'); ?>" id="forgot_pass">Forgot Password?</a></span>
      <div class="right send_btn_login">
        <input type="submit" class="login_button" value="" />
        <input type="hidden" name="tmz" id="tmz" value="" />
      </div>
	
    </div>
	  <span>For better gaming experience (Blocker fun and prizes) Advice all players to stop any streaming, downloading etc. before joining any tournament. 
</span>
  </form>
  <div class="clear"></div>  
</article>
<script>
$(document).ready(function() {
	 var dt = new Date(); // Expects date as m/d/y
     $("#tmz").val(dt.getTimezoneOffset()); // UTC    
});
</script>
