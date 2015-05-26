        
        <?php $userdata = userData(sessionData('id')); 
			  $totalmatchwins = totalmatchwins(sessionData('id'));
			  $user_role = sessionData('user_role')
		?>
		<!-- login panel -->
        <article class="loginpanel clearfix">
          <h2>profile</h2>
          <div class="contlog_left  profiler_top_margin">
            <div class="form_div clearfix botm_margn">
              <label>user name :</label>
              <p class="show_value"><?php echo $userdata['username']; ?></p> </div>
            <div class="form_div clearfix botm_margn">
              <label>full name :</label>
              <p class="show_value"><?php echo $userdata['name']; ?></p> </div>
            <div class="form_div clearfix botm_margn">
              <label>email :</label>
              <p class="show_value"><?php echo $userdata['email']; ?></p> </div>
		<?php if($user_role == 1){ ?>
            <div class="form_div clearfix botm_margn">
              <label>Total Wins :</label>
              <p class="show_value"><?php echo $totalmatchwins; ?></p> </div>
			<div class="form_div clearfix botm_margn">
              <label>Account Balance :</label>
              <p class="show_value"><?php echo $userdata['account_balance']; ?></p> </div>
		<?php } ?>
			<div class="form_div clearfix botm_margn">
              <label>password :</label>
              <p class="show_value">*******</p> </div>
          </div>
          <div class="contlog_right clearfix botm_margn">
            <label>avatar</label>
            <span class="avatar_img">
			<?php
			$id = sessionData('id');
			$img = userData($id,'profileimg');
			if( $img && file_exists("upload/".$img)){
				echo '<img src="'.base_url('upload/'.$img).'" alt="" border="0"  />';
			}else{
			?>
			<img src="<?php echo base_url('images/avtaar_img.png'); ?>" alt="" border="0"  />
			<?php } ?>
			</span> </div>
          <div class="clear"></div>
          <div class="clearfix buttons_div">
            <div class="left">
				<?php
				if($user_role == 2){
				?>
				<a class="list_user_btn left" href="<?php echo base_url('admin/users'); ?>"><img src="<?php echo base_url('images/list_user_btn.png'); ?>" alt="" border="0"  /></a> 
				<a class="list_tournament_btn" href="<?php echo base_url('tournament/tournamentlisting'); ?>"><img src="<?php echo base_url('images/list_tournament_btn.png'); ?>" alt="" border="0"  /></a>
				<!--
				<a class="list_tournament_btn" href="<?php //echo base_url('admin/tournament'); ?>"><img src="<?php //echo base_url('images/list_tournament_btn.png'); ?>" alt="" border="0"  /></a>
				-->
				<?php } ?>				
			</div>
            <div class="right">
			<?php if($user_role == 1){ ?>
				<a class="left paypal_btn left" href="<?php echo base_url(); ?>tournament/payment"><img src="<?php echo base_url('images/paypal_btn.png'); ?>" alt="" border="0"  /></a> 
			<?php } ?>
				<a class="edit_btn left space_left" href="<?php echo base_url('profile/edit'); ?>"><img src="<?php echo base_url('images/edit_btn.png'); ?>" alt="" border="0"  /></a></div>
          </div>
        </article>
