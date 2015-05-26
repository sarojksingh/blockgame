
 <?php $user_id = sessionData('id'); 
	   $account_balance = sessionData('account_balance');
	   $user_role = sessionData('user_role');
	   $timezone_offset = sessionData('timezone_offset');
	   $timeoffset_php_00gmt  = strtotime('today Europe/London');
	   $timeoffset_php_11gmt = strtotime('today Australia/Sydney');
	   $timeoffset_php = ($timeoffset_php_11gmt - $timeoffset_php_00gmt)/60;
	  
 ?>
 <style type="text/css">
	<!--
		.content{width:580px; padding:10px; overflow:hidden;height:auto; clear:both;}
		.content .images_container{overflow:hidden;
		a[rel='toggle-buttons-scroll-type'].off{opacity:0.5;}
	-->
	</style>
	<!-- Custom scrollbars CSS -->
	<link href="<?php echo base_url(); ?>js/jquery.mCustomScrollbar.css" rel="stylesheet" type="text/css" />
	 
        <!-- login panel -->
        <article class="loginpanel clearfix bord_bottom">
          <?php if($user_role == 2) {  ?>		
          <div class="bordered_row">
			  <ul class="top_extr_links">
					<li><a <?php echo ($tournament_active_link == 'active') ? 'top_extr_select' : '';  ?> href="<?php echo base_url('tournament'); ?>">Active Tournaments</a></li>
					<li><a <?php echo ($tournament_active_link == 'completed') ? 'top_extr_select' : '';  ?> class="top_extr_select" href="<?php echo base_url('admin/completed'); ?>">Completed Tournaments</a></li>
				</ul>          		
          </div>
          <div class="clear"></div>
          <?php } ?>
          <h2 class="bord_bottom"><?php echo ($user_role == 2) ? 'Admin - ' : '' ?>Mega Tournaments </h2>
          <div class="create_touranment_voucher voucher_mega">
			<?php if(count($mega_cmp_tournament_list) == 0) { ?>
				<p style="text-align:center">No tournament found</p>
			<?php } ?>
		  <div class="wrapper">
 			<div id="content_1" class="content">
			<div class="images_container" style="width:<?php echo (200*count($mega_cmp_tournament_list)) ?>px;">
		  <?php foreach($mega_cmp_tournament_list as $tournament) { ?>
			<div class="voucher_block">
            	<div class="back_imgdiv">
                	
                	<p class="vouche_hed" title="<?php echo $tournament->prize_name; ?>"><?php echo limit_string($tournament->prize_name, 6); ?></p>
                    <p class="vouche_prizev">$<?php echo $tournament->cost; ?> to enter</p>
					<p class="tour_date_time"><?php echo date('D dS H:i (M/y)',strtotime($tournament->date . ' ' . $tournament->time) + (($timeoffset_php-($timezone_offset))*60)); ?></p>
                    <div class="vouchr_inner_img">
						<?php if(file_exists(APPPATH . '../upload/'. $tournament->prize_img1)) { ?>
							<img src="<?php echo base_url(); ?>upload/<?php echo $tournament->prize_img1; ?>" border="0" alt="" />
						<?php } ?>
					</div>					
                </div>
                <?php if($user_role == 2) { ?><span class="delet_btn"><a class="del_tour_anchor" href="<?php echo base_url(); ?>admin/deletecmptournament/<?php echo $tournament->id; ?>">delete</a></span><?php } ?>
				<p class="slide_content"><?php echo limit_string($tournament->prize_desc, 100) ?></p>
				</div>
				<?php //} // end of if condition?>
			<?php } ?>   
			 </div>
			 </div>
            </div>
          </div>
          <div class="clear"></div>
          <h2 class="bord_bottom"><?php echo ($user_role == 2) ? 'Admin - ' : '' ?>Mini tournaments</h2>
          <div class="create_touranment_voucher voucher_mini">
			<?php if(count($mini_cmp_tournament_list) == 0) { ?>
				<p style="text-align:center">No tournament found</p>
			<?php } ?>
		  <div class="wrapper">
 			<div id="content_2" class="content">
			<div class="images_container" style="width:<?php echo (200*count($mini_cmp_tournament_list)) ?>px;">
		  <?php foreach($mini_cmp_tournament_list as $tournament) { ?>
			<div class="voucher_block">
            	<div class="back_imgdiv">
                	<p class="vouche_hed" title="<?php echo $tournament->prize_name; ?>"><?php echo limit_string($tournament->prize_name, 6); ?></p>
                    <p class="vouche_prizev">$<?php echo $tournament->cost; ?> to enter</p>
					<div class="vouchr_inner_img"> 
						<?php if(file_exists(APPPATH . '../upload/'. $tournament->prize_img1)) { ?>
							<img src="<?php echo base_url(); ?>upload/<?php echo $tournament->prize_img1; ?>" border="0" alt="" />
						<?php } ?>
					</div>					
                </div>
               <?php if($user_role == 2) { ?><span class="delet_btn"><a class="del_tour_anchor" href="<?php echo base_url(); ?>admin/deletecmptournament/<?php echo $tournament->id; ?>">delete</a></span><?php } ?>
				
				<p class="slide_content"><?php echo limit_string($tournament->prize_desc, 100) ?></p>
            </div>
			<?php } ?>  
			 </div>
			 </div>
			 </div>
          </div>
          <div class="clear"></div>
        </article>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
	<!-- mousewheel plugin -->
	<!-- custom scrollbars plugin -->
	<script src="<?php echo base_url(); ?>js/jquery.mCustomScrollbar.js"></script>
	<script>
	$(document).ready(function() {
		(function($){
			$(window).load(function(){
				$("#content_1").mCustomScrollbar({
					horizontalScroll:true,
					scrollButtons:{
						enable:true,
						scrollType:"pixels",
						scrollAmount:116
					}
				});
				$("#content_2").mCustomScrollbar({
					horizontalScroll:true,
					scrollButtons:{
						enable:true,
						scrollType:"pixels",
						scrollAmount:116
					}
				});
				/* toggle buttons scroll type */
				$("a[rel='toggle-buttons-scroll-type']").click(function(e){
					e.preventDefault();
					var $this=$(this);
					var cont=$("#content_2");
					var scrollType;
					if(cont.data("scrollButtons-scrollType")==="pixels"){
						scrollType="continuous";
					}else{
						scrollType="pixels";
					}
					cont.data({"scrollButtons-scrollType":scrollType}).mCustomScrollbar("update");
					$this.toggleClass("off");
				});
				/* snap scrollbar fn */
				var snapTo=[];
				$("#content_2 .images_container img").each(function(){
					var $this=$(this);
					var thisX=$this.position().left;
					snapTo.push(thisX);
				});
				function snapScrollbar(){
					if(!$(document).data("mCS-is-touch-device")){ //no snapping for touch devices
						var posX=$("#content_2 .mCSB_container").position().left;
						var closestX=findClosest(Math.abs(posX),snapTo);
						if(closestX===0){
							$("#content_2").mCustomScrollbar("scrollTo","left",{
								callback:false //scroll to is already a callback fn
							});
						}else{
							$("#content_2").mCustomScrollbar("scrollTo",closestX,{
								callback:false //scroll to is already a callback fn
							});
						}
					}
				}
				function findClosest(num,arr){
	                var curr=arr[0];
    	            var diff=Math.abs(num-curr);
        	        for(var val=0; val<arr.length; val++){
            	        var newdiff=Math.abs(num-arr[val]);
                	    if(newdiff<diff){
                    	    diff=newdiff;
                        	curr=arr[val];
                    	}
                	}
                	return curr;
            	}
			});
		})(jQuery);
		$('.del_tour_anchor').click(function(e){
	if(confirm("Do you really want to delete tournament?")){
		return true;
	}else{
		return false;
	}
});
	});


	</script>
