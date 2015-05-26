<!-- login panel -->
    <article class="alluser_top clearfix">
        <h2>Admin - All Users</h2>
        <div class="clear"></div>
    </article>
	<div class="user_list_cont">
		<article class="mini_tour">
			<ul class="top_extr_links_new">
				<li><a  class="<?php echo ($current_user_role == 'user') ? 'top_extr_select_new' : '';  ?>" href="<?php echo base_url('admin/users'); ?>">Players</a></li>
				<li><a class="<?php echo ($current_user_role == 'admin') ? 'top_extr_select_new ' : '';  ?>" href="<?php echo base_url('admin/adminusers'); ?>">Admins</a></li>
			</ul>
			<article class="alluser_bot clearfix">		
			<table cellpadding="0" cellspacing="0" border="0" class="allusers_table">
				<tr>
					<th><p class="width_one">USER NAME</p></th>
					<th><p class="width_one">FULL NAME</p></th>
					<th><p class="width_three">EMAIL</p></th>
					<th><?php if($current_user_role == "admin"){ ?><p class="width_fout add_new_admin"><a class="add_new_admin_user_btn" href="<?php echo base_url('admin/createadmin/');?>"></a></p><?php } ?></th>
					<th><p class="width_fout">&nbsp;</p></th>
				</tr>
				<?php
				$counter = 0;
				if(count($users) > 0){
				foreach($users as $val){
					if($val->id != $this->session->userdata('id')){
				?>
				<tr>
					<td><p class="width_one"><?php echo character_limiter($val->username,12);?></p></td>
					<td><p class="width_one"><?php echo character_limiter($val->name,10);?></p></td>
					<td><p class="width_three"><?php echo limit_string($val->email,25);?></p></td>
					<td><p class="width_fout"><a class="del_tour_anchor" href="<?php echo base_url('admin/userdelete/'.$val->id.'/'.$page);?>">Delete</a></p></td>
					<td><p class="width_fout"><a href="<?php echo base_url('admin/edituser/'.$val->id.'/'.$page);?>">Edit</a></p></td>
					<?php if(!(isset($current_user_role) AND $current_user_role == "admin")){ ?><td><p class="width_fout resp_history" id="<?php echo $val->id; ?>" rel="<?php echo $val->id; ?>"><a href="javascript:void(0);" >History</a></p><span class="loader_img" id="loader_img_<?php echo $val->id; ?>" style="display:none;"><img src="<?php echo base_url('images/loader_img.gif'); ?>" /></span></td><?php } ?>
				</tr>
				<?php
				$counter++;
					}
				 }
				}
				?>
			</table>
			<?php
			if($counter == 0)
			{
				echo '<div class="clear"></div><div class="norecord_msg">Currently No Admin user created, You may create by clicking on Add New Admin User button.</div>';	
			}
			?>
		</article>
		<?php
			echo $this->pagination->create_links();
		?>
		<div class="clear"></div>
		</article>
	</div>
<?php if(!(isset($current_user_role) AND $current_user_role == "admin")){ ?>
	<!-- light box panel -->
		<script>
		$(document).ready(function(){
			$('.resp_history').click(function(){
				var current_user = $(this).attr('id');
				var image_url = "<?php echo base_url('upload'); ?>";
				var url = "<?php echo base_url('ajax/show_history'); ?>/"+ current_user;
				var count;
				$("#loader_img_"+current_user).css('display','block');
				$.ajax({
					url: url
				}).done(function(response) {
					count = response.split("___");
					$("#username").html(count[0]);
					$("#name").html(count[1]);
					$("#email").html(count[2]);
					$("#totalmatchwins").html(count[3]);
					$("#account_balance").html(count[4]);
					$("#status").html(count[5]);
					if(count[6] != ''){
						var image_path = image_url +'/'+count[6];
						$("#user_image").attr('src',image_path);
					}else{
						var image_path = "<?php echo base_url('images/avtaar_img.png'); ?>";
						$("#user_image").attr('src',image_path);
					}
					$("#loader_img_"+current_user).css('display','none');
					$('.contbdlght').css('display','block');	
					$('.mainbodylightbox').css('display','block');
				});
			});	
			$('.close_button,.mainbodylightbox').click(function(){
				$('.contbdlght').css('display','none');	
				$('.mainbodylightbox').css('display','none');
			});
		});
		</script>
		<div class="mainbodylightbox" style="display:none">&nbsp;</div>
		<div class="contbdlght" style="display:none">
			<div class="contpanellight">
				<div class="lhtcontbody">
					<span class="close_button"><img src="<?php echo base_url('images/close_btn.png'); ?>" alt="" border="0"  /></span>
					<article class="loginpanel clearfix">
						<h2 class="h2_his_class">History</h2>
						<div class="contlog_left  profiler_top_margin">
							<div class="form_div clearfix botm_margn">
								<label>user name :</label>
								<p class="show_value" id="username">
								</p> 
							</div>
							<div class="form_div clearfix botm_margn">
								<label>full name :</label>
								<p class="show_value" id="name">
							  
								</p>
							</div>
							<div class="form_div clearfix botm_margn">
								<label>email :</label>
								<p class="show_value" id="email">
							   
								</p>
						    </div>
							<div class="form_div clearfix botm_margn">
								<label>Total Wins :</label>
								<p class="show_value" id="totalmatchwins">
								
								</p>
							</div>
							<div class="form_div clearfix botm_margn">
								<label>Account Balance :</label>
								<p class="show_value" id="account_balance">
									
								</p>
							</div>	
							<div class="form_div clearfix botm_margn">
								<label>User Status:</label>
								<p class="show_value" id="status">
									
								</p>
							</div>								
						    <div class="clear"></div>						
						</div>
						<div class="contlog_right clearfix botm_margn">
								<label>avatar</label>
								<span class="avatar_img">
									<?php /*
										$id = sessionData('id');
										$img = userData($id,'profileimg');
										if( $img && file_exists("upload/".$img)){
											echo '<img src="'.base_url('upload/'.$img).'" alt="" border="0"  />';
										}else{*/
									?>
											<img src="<?php echo base_url('images/avtaar_img.png'); ?>" alt="" border="0" id="user_image" />
									<?php //} ?>
								</span>
							</div>
					</article>
				</div>
			</div>
		</div>
	<!-- light box panel -->
<?php } ?>
<script type="text/javascript">
	$('.del_tour_anchor').click(function(e){
		if(confirm("Do you really want to delete user?")){
			return true;
		}else{
			return false;
		}
	});
</script>