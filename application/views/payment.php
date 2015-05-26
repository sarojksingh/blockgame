<!-- login panel -->
<?php
$tournament_cost = isset($tournament_details['cost']) ? $tournament_details['cost'] : 0;
$mincosttoenter =  $tournament_cost - $this->session->userdata('account_balance');
	if($mincosttoenter<0) {
		$mincosttoenter = 0;	
	}
	if(!isset($tournament_details['id'])) {
		$mincosttoenter = 1;	
	}
?>
<article class="loginpanel clearfix">
	<h2>Payment</h2>
	<?php if(isset($tournament_details['id']) && $tournament_details['id'] > 0) { ?>
    <div class="tital_desc"><span class="turnm_tital">Title -</span> <span class="turnm_tital_matt"><?php echo isset($tournament_details['prize_name']) ? $tournament_details['prize_name'] : '' ;?></span></div>
	<div class="tital_desc"><span class="turnm_tital">Description -</span> <span class="turnm_tital_matt"><?php echo ($tournament_details['prize_desc']) ? $tournament_details['prize_desc'] : '' ;?></span></div>
	<?php } ?>
    <form method="post" action="<?php echo base_url() ?>tournament/paymentprocess" id="payment-form">
	
	<div class="contlog_left_login_pay">
		<div class="forms1 clearfix">
			<span id="amount-errors" class="error_show_out right"><?php echo form_error('amount'); ?>&nbsp;</span>
            <div class="clear"></div>
			<label class="labl_padd label_text_left">Amount: $</label>
			<span class="inout_box"><input type="text" name="amount" id="tournament_payment" value="<?php echo isset($tournament_details['cost']) ? $tournament_details['cost'] : '' ;?>" /></span> </div>
		<?php if(isset($tournament_details['id']) && $tournament_details['id'] > 0) { ?><span class="mini_paym">Min. payment amount is $<?php echo $mincosttoenter; ?></span><?php } ?>
        <div class="clear"></div>
        <div class="cancel_pay_btn">
    <input type="hidden" name="RETURNURL" value="<?php echo base_url() ?>tournament/finalprocess/<?php echo isset($tournament_details['id']) ? $tournament_details['id'] : 'pro' ;?>" />
	<input type="hidden" name="prize_name" value="<?php echo isset($tournament_details['prize_name']) ? $tournament_details['prize_name'] : 'Fund transfer' ;?>" />
	<input type="hidden" name="prize_desc" value="<?php echo isset($tournament_details['prize_desc']) ? limit_string( $tournament_details['prize_desc'], 100) : 'adding fund to your Blockers account ' ;?>" />
	<input type="hidden" name="CANCELURL" value="<?php echo base_url() ?>tournament/paymentcancel" />
	<?php if(isset($tournament_details['id'])) { ?>
		<a class="cancel_btn left" href="<?php echo base_url('tournament'); ?>"><img src="<?php echo base_url('images/cancel_btn.png'); ?>" alt="" border="0"  /></a>	
	<?php } else { ?>
		<a class="cancel_btn left" href="<?php echo base_url('profile'); ?>"><img src="<?php echo base_url('images/cancel_btn.png'); ?>" alt="" border="0"  /></a>	
	<?php } ?>
	<input type="submit" class="pay_button left space_left" name="paymentbtn" value="" />
	</div>
    </div>
	<div class="clear"></div>
      </form>
  
</article>
<script type="text/javascript">
	 $(document).ready(function() {
	    /*  start Login form validation  */
	    $('#tournament_payment').blur(function() {			
			var amount_val = $(this).val();	
			amount_val = parseFloat(amount_val).toFixed(2);
			if(!isNaN(amount_val)) {
				$(this).val(amount_val);
			}
	    });
	    
var validator = $("#payment-form").validate({
	  	errorPlacement: function(error,element) {
			var elementName = element.attr("name")+"-errors";
			$("#"+elementName).append(error);
		},	   
		rules: {			
			amount: {
				required: true,
				min: "<?php echo $mincosttoenter; ?>"					
			}
		},
		messages: {			
			amount: {
				required: "Please enter amount",
				min: jQuery.format("Please enter minimum ${0} amount")								
			}	
		}
		
		
	});


});
</script>
