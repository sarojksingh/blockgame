 <?php
	$user_id = sessionData('id'); 
	$account_balance = sessionData('account_balance');
	$user_role = sessionData('user_role');
	$timezone_offset = sessionData('timezone_offset');
	$timeoffset_php_00gmt  = strtotime('today Europe/London');
	$timeoffset_php_11gmt = strtotime('today Australia/Sydney');
	$timeoffset_php = ($timeoffset_php_11gmt - $timeoffset_php_00gmt)/60;	   
 ?>
<div class="user_list_cont">
	<article class="loginpanel_new clearfix bord_bottom">
		<?php if($user_role == 2) {  ?>
		<div class="bordered_row_new bottom_none">
			<a href="<?php echo base_url('admin/addtournament'); ?>" class="right add_tournament_btn" href=""><img src="<?php echo base_url(); ?>images/add_tournament_btn.png" border="0" alt="" /></a>
		</div>
		<?php } ?>
		
	</article>
	<article class="mini_tour">
		<ul class="top_extr_links_new">
			<li><a  class="<?php echo ($tournament_active_link == 'mega') ? 'top_extr_select_new' : '';  ?>" href="<?php echo base_url('tournament/tournamentlisting'); ?>">Mega Tournaments</a></li>
			<li><a class="<?php echo ($tournament_active_link == 'mini') ? 'top_extr_select_new ' : '';  ?>" href="<?php echo base_url('tournament/minitournamentlist'); ?>">Mini Tournaments</a></li>
		</ul>
		<div class="bordered_row_new">
			<ul class="top_extr_sub_links_new sub_link">
				<li><a  class="<?php echo ($sub_tournament_active_link == 'Active') ? 'top_extr_select_sub' : '';  ?>" href="<?php echo ($tournament_active_link == 'mini' ) ? base_url('tournament/minitournamentlist') : base_url('tournament/tournamentlisting'); ?>">Active/On Tournaments</a></li>
				<li><a class="<?php echo ($sub_tournament_active_link == 'completed') ? 'top_extr_select_sub' : '';  ?>" href="<?php echo ($tournament_active_link == 'mega' ) ? base_url('admin/megacompleted') : base_url('admin/minicompleted'); ?>">Completed Tournaments</a></li> 
				<li><a class="<?php echo ($sub_tournament_active_link == 'off') ? 'top_extr_select_sub' : '';  ?>" href="<?php echo ($tournament_active_link == 'mega' ) ? base_url('admin/megaoff') : base_url('admin/minioff'); ?>">Off Tournaments</a></li>
			</ul>
		</div>
		<div class="inner_tournament">
		<?php if(count($tournament_list) == 0) { ?>
			<p style="text-align:center">No tournament found</p>
			<?php }else{ ?>
			<ul class="list_heading">
				<li class="user_list">Tournament Name</li>
				<li class="name_list">Tournament Prize</li>
				<!--<li class="image_list">Status</li>-->
				<li class="delete_list">Actions</li>
				<!--<li class="edit_list">-->
		   </ul>	
		 <?php foreach($tournament_list as $tournament) { ?>
		   <ul class="list_details">
				<li class="user_list"><?php echo limit_string($tournament->tournament_name,30); ?></li>
				<li class="name_list"><?php echo limit_string($tournament->prize_name,30); ?></li>
			<!--	<li class="image_list">
					<div class="vouchr_inner_img"> 
						<?php 
						//if(($tournament->date < date('Y-m-d')  AND $tournament->status = 1 AND $tournament->type == 1) OR $tournament->status == 2){ ?>
							<img src="<?php //echo base_url('images/completed_icon.png'); ?>" border="0" alt="" />
						<?php //}
						//elseif($tournament->status == 1 OR $tournament->status == 3){ ?>
									<img src="<?php //echo base_url('images/on_icon.png'); ?>" border="0" alt="" />
						<?php //}elseif($tournament->status == 0){ ?>
							<img src="<?php // echo base_url('images/off_icon.png'); ?>" border="0" alt="" />
						<?php ///}else{ ?>
							<img src="<?php //echo base_url('images/completed_icon.png'); ?>" border="0" alt="" />
					<?php	//} ?>
					</div>
				</li> -->
				<li class="delete_list"><a class="delete_listz" href="<?php echo base_url(); ?>admin/deletetournament/<?php echo $tournament->id . '/' . $page; ?>">Delete</a></li>
				<li class="edit_list"><a href="<?php echo base_url(); ?>admin/edittournament/<?php echo $tournament->id . '/' . $page; ?>">Edit</a></li>
		   </ul>
		  <?php } } ?>
		</div> 
		<?php
			echo $this->pagination->create_links();
		?>	
		<div class="icon_img"></div>    
	</article>
<div>
<script>
$('.delete_listz').click(function(e){
	if(confirm("Do you really want to delete tournament?")){
		return true;
	}else{
		return false;
	}
});
</script>