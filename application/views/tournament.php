<?php $user_id = sessionData('id'); 
	   $account_balance = sessionData('account_balance');
	   $user_role = sessionData('user_role');
	   $timezone_offset = sessionData('timezone_offset');
	   $timeoffset_php_00gmt  = strtotime('today Europe/London');
	   $timeoffset_php_11gmt = strtotime('today Australia/Melbourne');
	   $timeoffset_php = ($timeoffset_php_11gmt - $timeoffset_php_00gmt)/60;
	   
	 /*  echo 'timeoffset_php_00gmt : '.$timeoffset_php_00gmt;
	   echo '<br>timeoffset_php_11gmt : '.$timeoffset_php_11gmt;
	   echo '<br>timezone_offset : '.$timezone_offset;
	   echo '<br>timeoffset_php_00gmt date : '.date('y-m-d H:i:s',$timeoffset_php_00gmt);
	   echo '<br>timeoffset_php_11gmt : '.date('y-m-d H:i:s',$timeoffset_php_11gmt);
	   echo '<br>timezone_offset : '.date('y-m-d H:i:s',$timezone_offset);
	   echo "<br>daylight saving ". date('I',time());
	   
	   die;*/
	  	   
 ?>
<style type="text/css">
/*
.content {
	width: 600px;
	padding: 10px;
	overflow: hidden;
	height: auto;
	clear: both;
}
.content .images_container {
	overflow: hidden;
	opacity:0.5;
}*/

</style>
<script type="text/javascript" src="<?php echo base_url(); ?>js/new_js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/new_js/jquery.jcarousel.min.js"></script>
<!-- Custom scrollbars CSS -->
<link href="<?php echo base_url(); ?>css/skin.css" rel="stylesheet" type="text/css" />

<!-- login panel -->
<article class="loginpanel clearfix bord_bottom">
  <?php if($user_role == 2) {  ?>
  <div class="bordered_row">
    <ul class="top_extr_links">
      <li><a  class="<?php echo ($tournament_active_link == 'active') ? 'top_extr_select' : '';  ?>" href="<?php echo base_url('admin/tournament'); ?>">Active Tournaments</a></li>
      <li><a <?php echo ($tournament_active_link == 'completed') ? 'top_extr_select' : '';  ?> href="<?php echo base_url('admin/completed'); ?>">Completed Tournaments</a></li>
    </ul>
    <a href="<?php echo base_url('admin/addtournament'); ?>" class="right add_tournament_btn" href=""><img src="<?php echo base_url(); ?>images/add_tournament_btn.png" border="0" alt="" /></a> </div>
  <div class="clear"></div>
  <?php } ?>
  <h2 class="bord_bottom"><?php echo ($user_role == 2) ? 'Admin - ' : '' ?>Mega Tournaments - Coming Soon!</h2>
  
  <!--Table starts from here-->
  <div class="clear"></div>
  <div class="create_touranment_voucher voucher_mega">
    <?php if(count($mega_tournament_list) == 0) { ?>
    <p style="text-align:center">No tournament found</p>
    <?php }else{ ?>
    <div class="wrapper">
      <div id="content_1" class="content">
        <div class="images_container" style="width:<?php echo (200*count($mega_tournament_list)) ?>px;">
        <ul id="mycarousel_1" class="jcarousel-skin-tango">
          <?php foreach($mega_tournament_list as $tournament) { 
			// echo check_tournament_active($tournament->date, $tournament->time);
			// var_dump(check_tournament_active($tournament->date, $tournament->time));
			// if(check_tournament_active($tournament->date, $tournament->time)) { ?>
            <li>
          <div class="voucher_block">
            <div class="back_imgdiv">
              <p class="vouche_head_counter"><?php echo $tournament->total_participants; ?>/32</p>
              <p class="vouche_hed" title="<?php echo $tournament->prize_name; ?>"><?php echo limit_string($tournament->prize_name, 6); ?></p>
              <p class="vouche_prizev">$<?php echo $tournament->cost; ?> to enter</p>
              <p class="tour_date_time">
                <?php //echo date('D dS H:i (M/y)', strtotime($tournament->date . ' ' . $tournament->time)); ?>
                <?php 
				//echo 'datae '.date('I',time());
						if(date('I',time())){
							$timesp = strtotime($tournament->date . ' ' . $tournament->time) + (($timeoffset_php -($timezone_offset))*60);
						}else{
							$timesp = strtotime($tournament->date . ' ' . $tournament->time) + (($timeoffset_php -($timezone_offset))*60)-3600;
						}
					echo  date('D dS H:i (M/y)',$timesp); ?>
              </p>
              <div class="vouchr_inner_img"> <img src="<?php echo base_url(); ?>images/prize_image_new.png" border="0" alt="" />
                <?php if(file_exists(APPPATH . '../upload/'. $tournament->prize_img1)) { ?>
                <img src="<?php echo base_url(); ?>upload/<?php echo $tournament->prize_img1; ?>" border="0" alt="" class="test" />
                <?php } ?>
              </div>
              <?php if($user_role == 1) { ?>
              <?php if($tournament->cost <= $account_balance) { ?>
              <span style="display:none;" class="add_fund_btn<?php echo ($tournament->cost <= $account_balance) ? ' show-element ' : ''; ?>"><span class="left yes_left yes_btn" rel="<?php echo base_url(); ?>/play_game/tournament/<?php echo $tournament->id;?>"><img src="<?php echo base_url(); ?>images/yes_btn.png" border="0" alt="" /></span> <span class="<?php echo base_url(); ?>right yes_right no_btn" rel=""><img src="<?php echo base_url(); ?>images/no_btn.png" border="0" alt="" /></span></span>
              <?php } else { ?>
              <span style="display:none;" class="add_fund_btn<?php echo ($tournament->cost > $account_balance) ? ' show-element ' : ''; ?>"><span class="addfundspn" rel="<?php echo base_url(); ?>/tournament/payment/<?php echo $tournament->id; ?>"><img src="<?php echo base_url(); ?>images/addfund_btn.png" border="0" alt="" /></span></span>
              <?php } 
					} else if($user_role == 2) { ?>
              <span style="display:none;" class="add_fund_btn show-element"><span class="edit_btn" rel="<?php echo base_url(); ?>admin/edittournament/<?php echo $tournament->id; ?>"><img src="<?php echo base_url(); ?>images/edit_btn.png" border="0" alt="" /></span></span>
              <?php } ?>
            </div>
            <?php if($user_role == 2) { ?>
            <span class="delet_btn"><a class="del_tour_anchor" href="<?php echo base_url(); ?>admin/deletetournament/<?php echo $tournament->id; ?>">delete</a></span>
            <?php } ?>
            <p class="slide_content"><?php echo limit_string($tournament->prize_desc, 100) ?></p>
          </div>
          <?php //} // end of if condition?>
          </li>
          <?php } ?>
          </ul>
        </div>
      </div>
    </div>
	 <?php } ?>
  </div>
  <div class="clear"></div>
  <h2 class="bord_bottom"><?php echo ($user_role == 2) ? 'Admin - ' : '' ?>Mini tournaments - Coming Soon!</h2>
  <div class="create_touranment_voucher voucher_mini">
    <?php if(count($mini_tournament_list) == 0) { ?>
    <p style="text-align:center">No tournament found</p>
     <?php }else{ ?>
    <div class="wrapper">
      <div id="content_2" class="content">
         <ul id="mycarousel" class="jcarousel-skin-tango">
          <?php foreach($mini_tournament_list as $tournament) { ?>
          <li>
          <div class="voucher_block">
            <div class="back_imgdiv">
              <p class="vouche_head_counter"><?php echo $tournament->total_participants; ?>/16</p>
              <p class="vouche_hed" title="<?php echo $tournament->prize_name; ?>"><?php echo limit_string($tournament->prize_name, 6); ?></p>
              <p class="vouche_prizev">$<?php echo $tournament->cost; ?> to enter</p>
              <div class="vouchr_inner_img"> <img src="<?php echo base_url(); ?>images/prize_image_new.png" border="0" alt="" />
                <?php if(file_exists(APPPATH . '../upload/'. $tournament->prize_img1)) { ?>
                <img src="<?php echo base_url(); ?>upload/<?php echo $tournament->prize_img1; ?>" border="0" alt=""  class="test"/>
                <?php } ?>
              </div>
              <?php if($user_role == 1) { ?>
              <?php if($tournament->cost <= $account_balance) { ?>
              <span style="display:none;" class="add_fund_btn<?php echo ($tournament->cost <= $account_balance) ? ' show-element ' : '';?>"><span class="left yes_left yes_btn" rel="<?php echo base_url(); ?>/play_game/tournament/<?php echo $tournament->id; ?>"><img src="<?php echo base_url(); ?>images/yes_btn.png" border="0" alt="" /></span> <span class="right yes_right no_btn" rel=""><img src="<?php echo base_url(); ?>images/no_btn.png" border="0" alt="" /></span></span>
              <?php } else { ?>
              <span style="display:none;" class="add_fund_btn<?php echo ($tournament->cost > $account_balance) ? ' show-element ' : '';?>"><span class="addfundspn" rel="<?php echo base_url(); ?>/tournament/payment/<?php echo $tournament->id; ?>"><img src="<?php echo base_url(); ?>images/addfund_btn.png" border="0" alt="" /></span></span>
              <?php } 
						} else if($user_role == 2) { ?>
              <span style="display:none;" class="add_fund_btn show-element"><span class="edit_btn" rel="<?php echo base_url(); ?>admin/edittournament/<?php echo $tournament->id; ?>"><img src="<?php echo base_url(); ?>images/edit_btn.png" border="0" alt="" /></span></span>
              <?php } ?>
            </div>
            <?php if($user_role == 2) { ?>
            <span class="delet_btn"><a class="del_tour_anchor" href="<?php echo base_url(); ?>admin/deletetournament/<?php echo $tournament->id; ?>">delete</a></span>
            <?php } ?>
            <p class="slide_content"><?php echo limit_string($tournament->prize_desc, 100) ?></p>
             </div>
          </li>
          <?php } ?>
        </ul>
       </div>
    </div>
	 <?php } ?>
  </div>
  <div class="clear"></div>
</article>
<script type="text/javascript">
jQuery(document).ready(function() {
    jQuery('#mycarousel_1').jcarousel({
       
    });
	jQuery('#mycarousel').jcarousel({
       
    });
});
</script>
<script>
$(document).ready(function() {
	// for delete confirmation
	$('.del_tour_anchor').click(function(e){
		if(confirm("Do you really want to delete tournament?")){
			return true;
		}else{
			return false;
		}
	});

	//Redirect to location using jquery
	$(".yes_btn, .addfundspn, .edit_btn").click(function() {
		var redirect_url = $(this).attr('rel');
		if(redirect_url !='') {
			window.location.href= redirect_url;
		}
	});				
});
</script> 
 

