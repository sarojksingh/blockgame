<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Psmails extends CI_Model {
	public $admin_mail,$mail_from, $timeoffset_php_00gmt, $timeoffset_php_11gmt, $timeoffset_php, $timezone_offset;
	private $timesp;
	function __construct()
	{
		parent::__construct();
		
		$this->load->library('email');		
		$this->admin_mail = $this->config->item('admin_email');
		$this->mail_from = EMAIL_FROM_NAME;
		$this->timeoffset_php_00gmt  = strtotime('today Europe/London');
		$this->timeoffset_php_11gmt = strtotime('today Australia/Sydney');
		$this->timeoffset_php = ($this->timeoffset_php_11gmt - $this->timeoffset_php_00gmt)/60;
		$this->timezone_offset = $this->session->userdata('timezone_offset');	
	}

	function send_mail($post)
	{
		//Default signature of BLOCKERS
		$post['msg'].="<br><br>Visit BLOCKERS <a href=".site_url().">here</a><br>";		

		// Send mail function used common to send mail //
		$config['protocol'] = 'sendmail';
		$config['mailpath'] = '/usr/sbin/sendmail';
		$config['charset'] = 'iso-8859-1';
		$config['wordwrap'] = TRUE;
		$config['mailtype'] = 'html';
		$this->email->initialize($config);
		$this->email->from($post['from'], $post['from_name']);
		$this->email->to($post['to']); 
		$this->email->subject($post['subject']);
		$this->email->message($post['msg']);	
		if($this->email->send())
		{
			return true;
		}else{
			return false;
		}
	}

	function forgetPassMail($arr)
	{
		$mail = array();
		$mail['from']= $this->admin_mail;
		$mail['from_name'] = $this->mail_from;
		$mail['to'] = $arr['email'];
		$mail['subject'] = "BLOCKERS: Your password has been reset successfully.";
		$mail['msg']= "Your new password is: ".$arr['pass'];
		if($this->send_mail($mail))
		{
			return true;
		}else{
			return false;
		}
	}
	
	function gameWinnerEmail($data) {

		$mail = array();
		
		$image_url =  base_url('upload/' . $data['prize_img1']);
		$mail['from']= $this->admin_mail;
		$mail['from_name'] = $this->mail_from;
		$mail['to'] = $data['email'];
		$mail['subject'] = "Congratulations! Win Notification";
		$mail['msg'] = "Congratulations " . $data['name'] . ", you've won " . $data['prize_name'] . '! <br><br>';
		$mail['msg'] .= "<img src='". $image_url ."'><br><br>";
		$mail['msg'] .=	"We've forwarded your information onto our admin team for processing, you'll be contacted within 24 hours for prize approval. <br><br>";		
		if(strtolower($data['type']) == 'mega') {
			if(date('I',time())){
				$this->timesp = strtotime($data['date'] . ' ' . $data['time']) + (($this->timeoffset_php -($this->timezone_offset))*60);
			}else{
				$this->timesp = strtotime($data['date'] . ' ' . $data['time']) + (($this->timeoffset_php -($this->timezone_offset))*60)-3600;
			}
			$mail['msg'] .= "DATE: " . date('d-M-Y',$this->timesp) . " <br>";
			$mail['msg'] .= "TIME: " . date('H:i',$this->timesp) . " <br>";
		}
		$mail['msg'] .= "PLAYER: " . $data['name'] . " <br>";
		$mail['msg'] .= "GAME TYPE: " . $data['type'] . " <br>";
		$mail['msg'] .= "TOURNAMENT CODE: " . $data['tournament_name'] . " <br>";		
		$mail['msg'] .= "<br> Thanks,<br>";
		$mail['msg'] .= "Blocker Team";
		if($this->send_mail($mail))
		{
			return true;
		}else{
			return false;
		}
	
	}

	function gameWinnerAdminEmail($data) {

		$mail = array();
		$mail['from']= $this->admin_mail;
		$mail['from_name'] = $this->mail_from;
		$mail['to'] = $this->admin_mail;
		$mail['subject'] = "Winner Declared for Tournament " . $data['tournament_name'];
		$mail['msg'] = "Blockers Admin,  <br><br>";
		if(strtolower($data['type']) == 'mega') {
			if(date('I',time())){
				$this->timesp = strtotime($data['date'] . ' ' . $data['time']) + (($this->timeoffset_php -($this->timezone_offset))*60);
			}else{
				$this->timesp = strtotime($data['date'] . ' ' . $data['time']) + (($this->timeoffset_php -($this->timezone_offset))*60)-3600;
			}
			$mail['msg'] .= "DATE: " . date('d-M-Y',$this->timesp) . " <br>";
			$mail['msg'] .= "TIME: " . date('H:i',$this->timesp) . " <br>";
		}
		$mail['msg'] .= "PLAYER: " . $data['name'] . " <br>";
		$mail['msg'] .= "GAME TYPE: " . $data['type'] . " <br>";
		$mail['msg'] .= "TOURNAMENT CODE: " . $data['tournament_name'] . " <br>";		
		$mail['msg'] .= "PRIZE: " . $data['prize_name'] . " <br>";
		$mail['msg'] .= "<br><br> Thanks,<br>";
		$mail['msg'] .= "Blocker Team";
		if($this->send_mail($mail))
		{
			return true;
		}else{
			return false;
		}
	
	}


	function sentWinnerToAdminEmail($data) {

		$mail = array();
		$mail['from']= $this->admin_mail;
		$mail['from_name'] = $this->mail_from;
		$mail['to'] = $this->admin_mail;
		$mail['subject'] = "Confirmation - Winner Declared for Tournament " . $data['tournament_name'];
		$mail['msg'] = "Blockers Admin,  <br><br>";
		if(strtolower($data['type']) == 'mega') {
			$mail['msg'] .= "DATE: " . date('d-M-Y',strtotime($data['date'] . ' ' . $data['time']) + (($this->timeoffset_php-($this->timezone_offset))*60)) . " <br>";
			$mail['msg'] .= "TIME: " . date('H:i',strtotime($data['date'] . ' ' . $data['time']) + (($this->timeoffset_php-($this->timezone_offset))*60)) . " <br>";
		}
		$mail['msg'] .= "PLAYER: " . $data['name'] . " <br>";
		$mail['msg'] .= "ADDRESS: " . $data['address'] . " <br>";
		$mail['msg'] .= "CITY: " . $data['city'] . " <br>";
		$mail['msg'] .= "POSTCODE: " . $data['postcode'] . " <br>";
		$mail['msg'] .= "EMAIL ADDRESS: " . $data['email'] . " <br>";
		$mail['msg'] .= "TEL NO: " . $data['telephone'] . " <br>";
		$mail['msg'] .= "GAME TYPE: " . $data['type'] . " <br>";
		$mail['msg'] .= "TOURNAMENT CODE: " . $data['tournament_name'] . " <br>";		
		$mail['msg'] .= "PRIZE: " . $data['prize_name'] . " <br>";
		$mail['msg'] .= "<br><br> Thanks, <br>";
		$mail['msg'] .= "Blocker Team";
		if($this->send_mail($mail))
		{
			return true;
		}else{
			return false;
		}
	
	}
}
?>
