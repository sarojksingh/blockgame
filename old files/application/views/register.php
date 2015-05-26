<!-- login panel -->
<article class="loginpanel clearfix">
  <h2>Register</h2>
	<?php if(isset($current) AND $current == "admin"){ ?>
		<form method="post" action="<?php echo base_url('admin/reg_insert');?>" name="register_form" id="register_form" enctype="multipart/form-data">
	<?php }else{ ?> 
		<form method="post" action="<?php echo base_url('register/reg_insert');?>" name="register_form" id="register_form" enctype="multipart/form-data">
	<?php } ?>
	<div class="contlog_left">
	<div class="forms1 clearfix">
	  <span id="username-errors" class="error_show11 right"><?php echo form_error('username'); ?>&nbsp;</span>
      <div class="clear"></div>
	  <label class="labl_padd">user name<span class="req_red">*</span> :</label>
	  <span class="inout_box"><input id="username" class="" type="text" name="username" value="<?php echo $username; ?>" maxlength="15"/></span> </div>
	<div class="forms1 clearfix"> 
		<span id="name-errors" class="error_show1 right"><?php echo form_error('name'); ?>&nbsp;</span>
        <div class="clear"></div>
	  <label class="labl_padd">full name<span class="req_red">*</span> :</label>
	  <span class="inout_box"><input id="name" class="" type="text" name="name" value="<?php echo $name; ?>" maxlength="100"/></span> </div>
	<div class="forms1 clearfix">
		<span id="email-errors" class="error_show1 right"><?php echo form_error('email'); ?>&nbsp;</span>
        <div class="clear"></div>
	  <label class="labl_padd">email<span class="req_red">*</span> :</label>
	  <span class="inout_box"><input id="email" class="" type="text" name="email" value="<?php echo $email; ?>" maxlength="100"/></span> </div>
	<div class="forms1 clearfix">
		<span id="confirm_email-errors" class="error_show1 right"><?php echo form_error('confirm_email'); ?>&nbsp;</span>
        <div class="clear"></div>
	  <label class="labl_padd">Confirm email<span class="req_red">*</span> :</label>
	  <span class="inout_box"><input id="confirm_email" class="" type="text" name="confirm_email" value="<?php echo $confirm_email; ?>" maxlength="100"/></span> </div>
	<div class="forms1 clearfix">
		<span id="password-errors" class="error_show1 right"><?php echo form_error('password'); ?>&nbsp;</span>
        <div class="clear"></div>
	  <label class="labl_padd">password<span class="req_red">*</span> :</label>
	  <span class="inout_box"><input id="password" class="" type="password" name="password" /></span> </div>
	  <div class="forms1 clearfix">
		  <span id="confirm_password-errors" class="error_show1 right"><?php echo form_error('confirm_password'); ?>&nbsp;</span>
          <div class="clear"></div>
	  <label class="labl_padd">Confirm password<span class="req_red">*</span> :</label>
	  <span class="inout_box"><input  id="confirm_password"class="" type="password" name="confirm_password" /></span> </div>
	 <!-- <div class="forms1 clearfix">
	  <label class="labl_padd">&nbsp;</label>
	  <span class="left">
		<input type="button" class="paypal_button" value="" />
	  </span></div>-->
	  <?php 
	  if(isset($current) AND $current == "admin"){ 
	  }else{ ?>
	  <div class="clearfix forms1 terms_cond_cont">
	   <span id="residence_confirm-errors" class="error_show1 right">&nbsp;</span>
	   <label class="labl_padd">&nbsp;</label>
       <input class="chk_box" type="checkbox" name="residence_confirm" id="residence_confirm" /> <span class="iaccpt_line">I confirm that I am a resident of Australia</span>
		<div class="clear"></div>
	   <span id="term_accept-errors" class="error_show1 right">&nbsp;</span>
       <div class="clear"></div>
       <label class="labl_padd">&nbsp;</label>
       <input class="chk_box" type="checkbox" name="term_accept" id="term_accept" /> <span class="iaccpt_line">I have read, understand and accept the <a href="<?php echo base_url('home/termsandconditions'); ?>" target="_blank" ><!--onclick="MM_openBrWindow('<?php // echo base_url('home/termsandconditions#terms_and_condition'); ?>','','width=500,height=500')" --><em>Terms Of Use </em></a> and <a target="_blank" href="<?php echo base_url('home/privacypolicy'); ?>"><em>Privacy Policy</em></a></span>
	  <div class="clear"></div>
      <label class="labl_padd">&nbsp;</label>
	  <span class="term_condtions">
	  <!--<a target="_blank" href="<?php //echo base_url('home/termsandconditions'); ?>">Terms and Conditions</a>-->
	  </span></div>
	  <?php } ?>
  </div>
  
  <div class="contlog_right clearfix">
  	<!--<div class="avtar_loader_div"><img src="<?php //echo base_url(); ?>images/ajax-loader.gif" alt="" border="0"  /></div>
  	<div class="avtar_hover_div">&nbsp;</div>-->
	<label>avatar</label>
	<span class="avatar_img"><img src="<?php echo base_url(); ?>images/avtaar_img.png" alt="" border="0"  /></span>
    <span class="avtar_name" id="profile_img-errors"></span>
	<div class="upload_img"><input id="profile_img" class="uploadimg_button" type="file" size="2" name="profile_img"/></div>
	</div>
  <div class="clear"></div>
  <div class="clearfix buttons_div_inner">
		<div class="right"><input type="submit" class="register_button" value="" /></div>
  </div>
  </form>
 
</article>
<script>
$("#profile_img").change(function(){
	var proimageval = $(this).val();
 if(!$.browser.msie) {
	var type = this.files[0].type;
	var size = this.files[0].size;
	var split = type.split('/');	
	if(size<'2097152' && split['0']=='image')
	{
		var img = $(this).val();
		$("#profile_img-errors").html(img);
	}
 } else {
	var arrayproimage =  proimageval.split('.')
		var exttype =arrayproimage[arrayproimage.length-1].toLowerCase();
		if(exttype == 'jpg' || exttype == 'jpeg' || exttype == 'png' || exttype == 'gif') { 
			var img = $(this).val();
			$("#profile_img-errors").html(img);
			return true;
		} else {
			return false;
		}
 
 }
});
</script>
