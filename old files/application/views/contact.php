<div id="servertime" style="display:none"><?php echo date('d-m-Y H:i') ?></div>
        <!-- login panel -->
        <article class="loginpanel clearfix">
		 <form method="post" action="<?php echo base_url('contact/sendEmail'); ?>" id="contact_form" name="contact_form">
          <h2>Contact Us</h2>
          <div class="clear"></div>
          <span class="block_welcme"> Blocker welcomes your feedback and queries. You can email us by completing the form below.</span>
          <div class="clear"></div>
          <div class="contlog_left_login contact_center">
            <div class="forms1 clearfix">
           		<span id="name-errors" class="error_show1 right">&nbsp;</span>
                <div class="clear"></div>
              <label class="labl_padd">Name<span class="req_red">*</span> :</label>
              <span class="inout_box"><input class="" type="text" name="name" id="name" /></span> </div>
            <div class="forms1 clearfix">
           <span id="email-errors"  class="error_show1 right">&nbsp;</span>
           <div class="clear"></div>
              <label class="labl_padd">Email<span class="req_red">*</span> :</label>
              <span class="inout_box"><input class="" type="text" name="email"  id="email"/></span> </div>
              <div class="forms1 clearfix descriptions">
            	<span id="message-errors" class="error_show1 right">&nbsp;</span>
                <div class="clear"></div>
                  <label class="labl_padd">Message<span class="req_red">*</span> :</label>
                  <div class="desc_div left">
                    <span class="desc_top_bg"></span>
                    <span class="desc_mid_bg"><textarea name="message" id="message" class="" cols=""></textarea></span>
                    <span class="desc_bot_bg"></span>
                  </div>
              </div>
          </div>
          <div class="clear"></div>
          <div class="clearfix buttons_div_inner">
            <div class="right"><input type="submit" class="send_button send_btn_contact" value="" /></div>
          </div>
		   </form>
        </article>
