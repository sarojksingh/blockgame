 <?php $user_id = sessionData('id'); 
	   $account_balance = $this->session->userdata('account_balance');  
 ?>
 <style type="text/css">
	<!--
		.content{width:580px; padding:10px; overflow:auto; clear:both;}
		.content .images_container{overflow:hidden;}
		a[rel='toggle-buttons-scroll-type'].off{opacity:0.5;}
	-->
	</style>
	<!-- Custom scrollbars CSS -->
	<link href="<?php echo base_url(); ?>js/jquery.mCustomScrollbar.css" rel="stylesheet" type="text/css" />
 
        <!-- login panel -->
        <article class="loginpanel clearfix bord_bottom">
          <h2 class="bord_bottom">Mega Tournaments </h2>
          <div class="create_touranment_voucher">
		  <div class="wrapper">
 			<div id="content_1" class="content">
			<div class="images_container">
		  <?php foreach($my_tournaments_mega as $tournament) { ?>
			<div class="voucher_block">
            	<div class="back_imgdiv">
                	<span class="vouche_hed"><?php echo $tournament->prize_name; ?></span>
                    <span class="vouche_prizev">$<?php echo $tournament->cost; ?> to enter</span>					
						<span style="display:none;" class="add_fund_btn show-element"><a class="play_btn" href=""><img src="<?php echo base_url(); ?>images/play_btn.png" border="0" alt="" /></a></span>				
                </div>	               
				<p class="slide_content"><?php echo $tournament->prize_desc; ?></p>
				</div>
			
			<?php } ?>   
			 </div>
			 </div>
            </div>
          </div>
          <div class="clear"></div>
          <h2 class="bord_bottom">Mini tournaments</h2>
          <div class="create_touranment_voucher">
		  <div class="wrapper">
 			<div id="content_2" class="content">
			<div class="images_container">
		  <?php foreach($my_tournaments_mini as $tournament) { ?>
			<div class="voucher_block">
            	<div class="back_imgdiv">
                	<span class="vouche_hed"><?php echo $tournament->prize_name; ?></span>
                    <span class="vouche_prizev">$<?php echo $tournament->cost; ?> to enter</span>					
						<span style="display:none;" class="add_fund_btn show-element"><a class="play_btn" href=""><img src="<?php echo base_url(); ?>images/play_btn.png" border="0" alt="" /></a></span>				
                </div>	
				<p class="slide_content"><?php echo $tournament->prize_desc ?></p>
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
					},
					callbacks:{
						onScroll:function(){
							snapScrollbar();
						}
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
	</script>