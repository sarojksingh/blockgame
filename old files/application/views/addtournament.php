<?php
 $data = array(); 
 if($type=='create')
 {
	 $data['form_action'] = 'admin/inserttournament';
	 $data['form_title'] = "";
	 $data['tour_type'] = "";
	 $data['ctr'] = 1;
 }else if($type=='edit')
 {
	 $data['ctr'] = 0;
	 $data['form_action'] = 'admin/updatetournament';
	 $data['form_title'] = "";
	 $data['tour_type'] = "";	 
	 $time = isset($tournamentData['time']) ? $tournamentData['time'] : '00:00';
	 // format the time field
	 $time = explode(":", $time);
	 $time_part1 = isset($time[0]) ? $time[0]: '00';
	 $time_part2 = isset($time[1]) ? $time[1]: '00';
	 $time = $time_part1 . ':' . $time_part2;
	 // format the date field

	 $date = isset($tournamentData['date']) ? explode("-", $tournamentData['date']) : '';
	 $date_part1 = isset($date[2]) ? $date[2]: ''; //for date
	 $date_part2 = isset($date[1]) ? $date[1]: ''; // for month
	 $date_part3 = isset($date[0]) ? $date[0]: ''; // for year
     		
 }
 ?>

<!-- login panel -->

<form method="post" action="<?php echo base_url($data['form_action']); ?>" name="form_addtournament" id="form_addtournament" enctype="multipart/form-data">
  <article class="loginpanel clearfix">
    <h2>ADMIN - <?php echo $type=='edit' ? 'EDIT' : 'CREATE' ?> TOURNAMENT</h2>
    <div class="create_touranment">
      <div class="clearfix padd_10"> <span id="type-errors" class="right">&nbsp;</span>
        <div class="clear"></div>
        <label class="">Mega Tournament</label>
        <input class="check_box" type="radio" <?php echo (isset($tournamentData['type']) && $tournamentData['type'] == 1) ? 'checked="checked"' : ''; ?> value="1" name="type" id="type" />
        <span class="labl_chk">MINI TOURNAMENT</span>
        <input class="check_box" type="radio" <?php echo (isset($tournamentData['type']) && $tournamentData['type'] == 2) ? 'checked="checked"' : ''; ?>  value="2" name="type" id="type" />
      </div>
      <div class="clearfix padd_10"> <span id="tournament_name-errors" class="right">&nbsp;</span>
        <div class="clear"></div>
        <label class="labl_padd">TOURNAMENT NAME<span class="req_red">*</span> :</label>
        <div class="date_left"> <span class="prize_name">
          <input class="" type="text" name="tournament_name" id="tournament_name" maxlength="50" value="<?php echo isset($tournamentData['tournament_name']) ? $tournamentData['tournament_name'] : ''; ?>"/>
          </span></div>
      </div>
      <div class="clearfix padd_10"> <span id="year-errors" class="right">&nbsp;</span>
        <div class="clear"></div>
        <label class="labl_padd">Date<span id="date_req" class="req_red"><?php echo (isset($tournamentData['type']) && $tournamentData['type'] == 2) ? '&nbsp;' : '*'; ?></span> :</label>
        <div class="date_left"> <span class="dd">
          <input class="" <?php echo (isset($tournamentData['type']) && $tournamentData['type'] == 2) ? 'style="background:#DDD;" disabled' : ''; ?> type="text" name="day" maxlength="2" id="day" value="<?php echo (isset($date_part1) && $tournamentData['type'] == 1) ? $date_part1 : ''; ?>"/>
          </span> <span class="mm">
          <input class="" <?php echo (isset($tournamentData['type']) && $tournamentData['type'] == 2) ? 'style="background:#DDD;" disabled' : ''; ?> type="text" name="month" maxlength="2" id="month" value="<?php echo (isset($date_part2) && $tournamentData['type'] == 1) ? $date_part2 : ''; ?>"/>
          </span> <span class="yy">
          <input class="" <?php echo (isset($tournamentData['type']) && $tournamentData['type'] == 2) ? 'style="background:#DDD;" disabled' : ''; ?> type="text" name="year" maxlength="4" id="year" value="<?php echo (isset($date_part3) && $tournamentData['type'] == 1) ? $date_part3 : ''; ?>"/>
          </span> </div>
        <div class="date_right"> DAY / MONTH / YEAR </div>
      </div>
      <div class="clearfix padd_10"> <span id="time-errors" class="right">&nbsp;</span>
        <div class="clear"></div>
        <label class="labl_padd">Time<span id="time_req" class="req_red"><?php echo (isset($tournamentData['type']) && $tournamentData['type'] == 2) ? '&nbsp;' : '*'; ?></span> :</label>
        <div class="date_left"> <span class="yy">
          <input class="" <?php echo (isset($tournamentData['type']) && $tournamentData['type'] == 2) ? 'style="background:#DDD;" disabled' : ''; ?> type="text" name="time" id="time" maxlength="5" value="<?php echo (isset($tournamentData['time'])  && $tournamentData['type'] == 1) ? $time : ''; ?>"/>
          </span></div>
        <div class="date_right" title="Australian Eastern Daylight Saving Time">(00:00) 24HR [AEDT] </div>
      </div>
      <div class="clearfix padd_10"> <span id="cost-errors" class="right">&nbsp;</span>
        <div class="clear"></div>
        <label class="labl_padd">COST TO ENTER<span class="req_red">*</span> :</label>
        <div class="date_left"> <span class="yy">
          <input class="" type="text" name="cost" id="cost" value="<?php echo isset($tournamentData['cost']) ? $tournamentData['cost'] : ''; ?>" maxlength="8" />
          </span></div>
      </div>
	  <?php if($data['ctr'] == 1){ ?>
	  <div class="clearfix padd_10"> <span id="no_of_tournaments-errors" class="right">&nbsp;</span>
        <div class="clear"></div>
        <label class="labl_padd">No. of Tournaments<span id="no_toru" class="req_red">*</span> :</label>
        <div class="date_left"> <span class="yy">
          <input class="digits" type="text" name="no_of_tournaments" id="no_of_tournaments" value="<?php echo isset($tournamentData['no_of_tournaments']) ? $tournamentData['no_of_tournaments'] : ''; ?>" maxlength="4" />
          </span></div>
      </div>
	  <?php } ?>
      <div class="clearfix padd_10"> <span id="prize_name-errors" class="right">&nbsp;</span>
        <div class="clear"></div>
        <label class="labl_padd">PRIZE NAME<span class="req_red">*</span> :</label>
        <div class="date_left"> <span class="prize_name">
          <input class="" type="text" name="prize_name" id="prize_name" maxlength="100" value="<?php echo isset($tournamentData['prize_name']) ? $tournamentData['prize_name'] : ''; ?>"/>
          </span></div>
      </div>
      <div class="clearfix padd_10"> <span id="prize_desc-errors" class="right">&nbsp;</span>
        <div class="clear"></div>
        <label class="labl_padd">PRIZE DESCRIPTION<span class="req_red">*</span> :</label>
        <div class="date_left"> <span class="prize_descpt">
          <input class="" type="text" name="prize_desc" id="prize_desc" maxlength="100" value="<?php echo isset($tournamentData['prize_desc']) ? $tournamentData['prize_desc'] : ''; ?>" />
          </span></div>
      </div>
	  <!-- for ON/OFF Tournaments starts -->
	   <?php // if($data['ctr'] != 1){ ?>
      <div class="create_touranment">
      <div class="clearfix padd_10"> <span id="current_status-errors" class="right">&nbsp;</span>
        <div class="clear"></div>
		<label class="labl_padd change_status">Change status to<span class="req_red">*</span> :</label>
        <label class="labl_chk1">ON</label>
        <input class="check_box_onoff" type="radio" <?php echo (isset($tournamentData['status']) && $tournamentData['status'] == 1) ? 'checked="checked"' : ''; ?> checked value="1" name="current_status" id="current_status" />
        <label class="labl_chk1">OFF</label>
        <input class="check_box_onoff" type="radio" <?php echo (isset($tournamentData['status']) && $tournamentData['status'] == 0) ? 'checked="checked"' : ''; ?>  value="0" name="current_status" id="current_status" />
      </div>
	  <?php // } ?>
	  <!-- for ON/OFF Tournaments Ends  -->
      <!-- Prize pic 1-->
      <div class="clearfix padd_10"> <span id="prize_picture1-errors" class="right">&nbsp;</span>
        <div class="clear"></div>
        <label class="labl_padd">PRIZE PICTURE 1<span class="req_red">*</span> :</label>
        <div class="date_left"> <span class="prize_picture">
          <?php if(isset($tournamentData['prize_img1']) && $tournamentData['prize_img1']) { ?>
          <img src="<?php echo base_url('upload/' . $tournamentData['prize_img1']);?>" border="0" alt="" />
          <?php } else { ?>
          <img src="<?php echo base_url('images/prize_image.png');?>" border="0" alt="" />
          <?php } ?>
          </span></div>
      </div>
      <div class="clearfix padd_10"> <span id="prize_picture1-name">&nbsp;</span>
        <label class="labl_padd">&nbsp;</label>
        <div class="upload_img date_left">
          <input class="uploadimg_button" type="file" size="3" name="prize_picture1" id="prize_picture1">
        </div>
      </div>
      
      <!-- Prize pic 2-->
      <div class="clearfix padd_10"> <span id="prize_picture2-errors" class="right">&nbsp;</span>
        <div class="clear"></div>
        <label class="labl_padd">PRIZE PICTURE 2 :</label>
        <div class="date_left"> <span class="prize_picture">
          <?php if(isset($tournamentData['prize_img2']) && $tournamentData['prize_img2']) { ?>
          <img src="<?php echo base_url('upload/' . $tournamentData['prize_img2']);?>" border="0" alt="" />
          <?php } else { ?>
          <img src="<?php echo base_url('images/prize_image.png');?>" border="0" alt="" />
          <?php } ?>
          </span></div>
      </div>
      <div class="clearfix padd_10"> <span id="prize_picture2-name">&nbsp;</span>
        <label class="labl_padd">&nbsp;</label>
        <div class="upload_img date_left">
          <input class="uploadimg_button" type="file" size="3" name="prize_picture2" id="prize_picture2">
        </div>
      </div>
      <!-- Prize pic 3-->
      <div class="clearfix padd_10"> <span id="prize_picture3-errors" class="right">&nbsp;</span>
        <div class="clear"></div>
        <label class="labl_padd">PRIZE PICTURE 3 :</label>
        <div class="date_left"> <span class="prize_picture">
          <?php if(isset($tournamentData['prize_img3']) && $tournamentData['prize_img3']) { ?>
          <img src="<?php echo base_url('upload/' . $tournamentData['prize_img3']);?>" border="0" alt="" />
          <?php }else{ ?>
          <img src="<?php echo base_url('images/prize_image.png');?>" border="0" alt="" />
          <?php } ?>
          </span></div>
      </div>
      <div class="clearfix padd_10"> <span id="prize_picture3-name">&nbsp;</span>
        <label class="labl_padd">&nbsp;</label>
        <div class="upload_img date_left">
          <input class="uploadimg_button" type="file" size="3" name="prize_picture3" id="prize_picture3">
        </div>
      </div>
      <div class="clearfix buttons_div_inner">
        <div class="right">
          <input id="id" type="hidden" name="id" value="<?php echo isset($tournamentData['id']) ? $tournamentData['id'] : 0; ?>" />
		  <?php
		  $redirect = "tournament/tournamentlisting";
			if(isset($tournamentData['id'])){
				$tour_date = strtotime($tournamentData["date"].' '. $tournamentData["time"]);
				$curr_date = strtotime(date('Y-m-d H:i:s'));
				if($tournamentData["type"] == 1){ 
					//mega redirect link here
					if($tournamentData["status"] == 1 && ($tournamentData['date'] > date('Y-m-d') || ($tournamentData['date'] == date('Y-m-d') && ($tournamentData['time'] <= date('H:i:s'))))){
						$redirect = "tournament/tournamentlisting";
					}else if($tournamentData["status"] == 0){
						$redirect = "admin/megaoff";
					}else{
						if($tour_date >= $curr_date){
							$redirect = "tournament/tournamentlisting";
						}else{
							$redirect = "admin/megacompleted";
						}						
					}					
				}else{
					//mini redirect link here
					if($tournamentData["status"] == 3 OR $tournamentData["status"] == 1){
						$redirect = "tournament/minitournamentlist";
					}elseif($tournamentData["status"] == 0){
						$redirect = "admin/minioff";
					}else{
						$redirect = "admin/minicompleted";
					}					
				}
				//echo $tournamentData["type"] ."____". $tournamentData["date"] ."____". $tournamentData["type"] ;
			}
			?>
          <a class="cancel_btn left" href="<?php echo base_url().''.$redirect; ?>"><img border="0" alt="" src="<?php echo base_url(); ?>images/cancel_btn.png"></a>
          <input type="submit" class="save_button left space_left" value="" />
        </div>
      </div>
    </div>
    <div class="clear"></div>
  </article>
</form>
