        <!-- login panel -->
 <?php 
 	$session_user_id = sessionData('id');
	$userrole = sessionData('user_role');
?>
    <article class="loginpanel clearfix">
    	<h2>Edit Profile</h2>
        	<form method="post" action="<?php echo base_url('profile/update');?>" name="edit-profile" id="edit-profile" enctype="multipart/form-data">
          		<div class="contlog_left">
            		<p class="clearfix">
              			<span id="username-errors" class="error_show11 right error_fullwidth demo_class"><?php echo form_error('username');?>&nbsp;</span>
			 			<label class="labl_padd">user name<span class="req_red">*</span> :</label>
              			<span class="inout_box"><input id="username" style="background:#DDD;" disabled type="text" name="username" value="<?php echo $username; ?>" /></span> 
              		</p>
            		<p class="clearfix">
						<span id="name-errors" class="error_show11 right error_fullwidth demo_class"><?php echo form_error('name');?>&nbsp;</span>
              			<label class="labl_padd">full name<span class="req_red">*</span> :</label>
              			<span class="inout_box"><input id="name" class="" type="text" name="name" value="<?php echo $name; ?>" maxlength="100"/></span> 
              		</p>
            		<p class="clearfix">
						<span id="email-errors" class="error_show11 right error_fullwidth demo_class"><?php echo form_error('email');?>&nbsp;</span>
              			<label class="labl_padd">email<span class="req_red">*</span> :</label>
              			<span class="inout_box"><input id="email" class="" type="text" name="email" value="<?php echo $email; ?>" maxlength="100"/></span> 
              		</p>
			 		<p class="clearfix">
						<span id="confirm_email-errors" class="error_show11 right error_fullwidth demo_class"><?php echo form_error('confirm_email');?>&nbsp;</span>
              			<label class="labl_padd">Confirm email<span class="req_red">*</span> :</label>
              			<span class="inout_box"><input id="confirm_email" class="" type="text" name="confirm_email" value="<?php echo $email; ?>" maxlength="100"/></span> 
              		</p>
<?php
	$user_role = sessionData('user_role');
	
	if($user_role==1 || $session_user_id == $id){
?>
            		<p class="clearfix">
						<span id="password-errors" class="error_show11 right error_fullwidth demo_class"><?php echo form_error('password'); ?>&nbsp;</span>
              			<label class="labl_padd">New password<span class="req_red"></span> :</label>
              			<span class="inout_box"><input id="password" class="" type="password" name="password" /></span> 
              		</p>
            		<p class="clearfix">
			 			<span id="confirm_password-errors" class="error_show11 right error_fullwidth demo_class"><?php echo form_error('confirm_password'); ?>&nbsp;</span>
              			<label class="labl_padd">Confirm password<span class="req_red"></span> :</label>
              			<span class="inout_box"><input id="confirm_password" class="" type="password" name="confirm_password" /></span> 
              		</p>
<?php 
	} 
?>
          	</div>
          	<div class="contlog_right clearfix">
            	<label>avatar</label>
            	<span class="avatar_img">				
<?php
					/*	$pro_id = sessionData('id');
					$img = userData($pro_id,'profileimg');*/
					if( $img && file_exists("upload/".$img)){
						echo '<img src="'.base_url('upload/'.$img).'" alt="" border="0"  />';
					} else {
?>
						<img src="<?php echo base_url('images/avtaar_img.png'); ?>" alt="" border="0"  />
<?php 
					} 
?>				</span>
        		<p class="avtar_name" id="profile_img-errors"></p>
        		<div class="upload_img"><input class="uploadimg_button" type="file" size="2" id="profile_img" name="profile_img" /></div>
            </div>
          	<div class="clear"></div>
          	<div class="clearfix buttons_div_inner">
				<div class="right">
					<input  id="id" type="hidden" name="id" value="<?php echo $id; ?>"/>
					<input  id="page" type="hidden" name="page" value="<?php echo $page; ?>"/>
<?php 
					if($userrole == 2 && $session_user_id != $id) {
						$current_user_role = get_user_role($id);

						if($current_user_role == 2){
							$url = 	base_url('admin/adminusers/'.$page);					
						}else{
							$url = 	base_url('admin/users/'.$page);					
						}
					} else {
						$url = 	base_url('profile');
					}
?>
					<a class="cancel_btn left" href="<?php echo $url; ?>"><img src="<?php echo base_url('images/cancel_btn.png'); ?>" alt="" border="0"  /></a>		
					<input type="submit" class="save_button left space_left" value="" />
				</div>
          	</div>
          </form>
        </article>
        <script type="text/javascript">
			$("#profile_img").change(function(){
				var proimageval = $(this).val();
 				
 				if(!$.browser.msie) {
					var type = this.files[0].type;
					var size = this.files[0].size;
					var split = type.split('/');	
					
					if(size<'2097152' && split['0']=='image') {
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
