<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Play_game extends MY_Controller{
	public $userid;


	function __construct()
	{
		parent::__construct();
		$this->template->set('nav_act','');
		$this->userid = $this->session->userdata('id');						
	}
	
	function index()
	{

		$data 		= array();
		$gamedata 	= array();
		$id 		= (isset($id))?$id:0;
		
		//SANI: check if user exist
		if($this->userid)
		{ 
			$this->load->model('Tournamentmodel');		
			$this->load->model('Usermodel');
			$baseURL 				= base_url();  
			$tournamentdetails 		= $this->Tournamentmodel->get_tournament_details($id);

			$userdata 				= $this->Usermodel->userDetails($this->userid); 

			$user_total_match_wins 	= $this->Usermodel->totalmatchwins($this->userid);

			//echo "<pre>"; print_r($user_total_match_wins);exit;
			$date 					= isset($tournamentdetails['date']) ? $tournamentdetails['date'] : '';
			$time 					= isset($tournamentdetails['time']) ? $tournamentdetails['time'] : '';

			
			if($date)
			{
				$start_time 		= date("F d, Y H:i:s", strtotime($date . ' ' . $time));
				//echo $start_time;die;
			}else {
				$start_time 	= '';
			}
				  
			$gamedata['user_id'] 		= $this->userid;
			$gamedata['user_name'] 		= isset($userdata['username']) ? $userdata['username'] : '';
			$gamedata['user_wins'] 		= $user_total_match_wins;
			$gamedata['session_id'] 	= isset($userdata['session_id']) ? $userdata['session_id'] : '';
			$gamedata['user_avatar'] 	= (isset($userdata['profileimg']) && !empty($userdata['profileimg'])) ? $baseURL . 'upload/' . $userdata['profileimg'] : base_url('images/avtaar_img.png');
			$gamedata['tournament_id'] 	= 0;
			$gamedata['start_time'] 	= $start_time;
			$gamedata['tournament_type']= isset($tournamentdetails['type']) ? $tournamentdetails['type'] : '';
			$gamedata['round'] 			= 1;
			$gamedata['flag'] 			= 1;
			$gamedata['tournament_name']= isset($tournamentdetails['tournament_name']) ? $tournamentdetails['tournament_name'] : '';
			$gamedata['total_register'] = isset($tournamentdetails['total_participants']) ? $tournamentdetails['total_participants'] : 0;
			$data['gamedata'] 			= $gamedata;

			$this->template->set('title',PAGE_TITLE_PLAY_FOR_FUN);
			$this->template->set('nav_act','play_for_fun');
			
                    //SANI: comment this for test game
			//$this->template->load('main','play_for_fun',$data);
			
                    //SANI: show example canvas game
			$this->template->load('main','play_for_sani',$data); //SANI: make my own canvas game which shows me, there is no server problem.
		} else {			
			$current_url = $this->uri->uri_string();
			$this->session->set_userdata('after_login_url', $current_url);
			redirect('login');
		}
	}
	
	
	function tournament($id = 0) {
	
		$data = array();
		$gamedata = array();
		$id = isset($id) ? $id : 0;
		if($this->session->userdata('id')>0) {			
			$data = array(
				'tournament_id' => $id
				);		
			$this->load->model('Tournamentmodel');		
			$this->load->model('Usermodel');			
			$result = $this->Tournamentmodel->enter_tournament($data);	
			$user_total_match_wins =  $this->Usermodel->totalmatchwins($this->userid);
		/*	echo '<pre>';
			print_r($result);
			echo '</pre>';die;*/
			if($result['result'] == true) {
				$this->session->set_flashdata(array('msg'=>$result['message'], 'type'=>'success'));
				$tournamentdetails = $this->Tournamentmodel->get_tournament_details($id);
				$date = isset($tournamentdetails['date']) ? $tournamentdetails['date'] : '';
				$time = isset($tournamentdetails['time']) ? $tournamentdetails['time'] : '';
				if($date)
					$start_time = date("F d, Y H:i:s", strtotime($date . ' ' . $time));
				else
					$start_time = '';
				$baseURL = base_url();			
				$userdata = $this->Usermodel->userDetails($this->userid);
				$gamedata['user_id'] = $this->userid;
				$gamedata['user_name'] = isset($userdata['username']) ? $userdata['username'] : '';
				$gamedata['user_wins'] = $user_total_match_wins;
				$gamedata['session_id'] = isset($userdata['session_id']) ? $userdata['session_id'] : '';
				$gamedata['user_avatar'] = (isset($userdata['profileimg']) && !empty($userdata['profileimg'])) ? $baseURL . 'upload/' . $userdata['profileimg'] : base_url('images/avtaar_img.png');
				$gamedata['tournament_id'] = $id;
				$gamedata['start_time'] = $start_time;
				$gamedata['tournament_type'] = isset($tournamentdetails['type']) ? $tournamentdetails['type'] : '';
				$gamedata['round'] = 1;
				$gamedata['tournament_name'] = isset($tournamentdetails['tournament_name']) ? $tournamentdetails['tournament_name'] : '';
				$gamedata['flag'] = isset($result['enter_flag']) ? $result['enter_flag'] : '';
				$gamedata['total_register'] = isset($tournamentdetails['total_participants']) ? $tournamentdetails['total_participants'] : 0;
				$data['gamedata'] = $gamedata;
				$sign = '<div class="signdetails">Signed in as : <span>'.$userdata['name'].', $'.$userdata['account_balance'].'</span> <a href="'.base_url('logout').'">Sign out</a></div>';
				$this->template->set('sign',$sign);
				$this->template->set('title',PAGE_TITLE_TOURNAMENT);
				$this->template->set('nav_act','tournament');
				$this->template->load('main','play_for_fun',$data);	
						
			}else if($result['result'] == false && ($result['response_code'] == 3)) {
				$this->session->set_flashdata(array('msg'=>$result['message'], 'type'=>'error'));
				redirect('tournament/payment/'.$id);
			}
			else if($result['result'] == false) { //
				$this->session->set_flashdata(array('msg'=>$result['message'], 'type'=>'error'));				
				redirect('tournament');
			} else {
				$this->template->set('error_msg',TOURNAMENT_ENTER_ERROR);
				$data['mega_tournament_list'] = $this->Tournamentmodel->get_mega_tournament_list();
				$data['mini_tournament_list'] = $this->Tournamentmodel->get_mini_tournament_list();
				$this->template->load('main','tournament', $data);
			}
		}
		else {
			$current_url = base_url('tournament');
			$this->session->set_userdata('after_login_url', $current_url);
			$this->session->set_flashdata(array('msg'=>TOURNAMENT_ENTER_LOGIN, 'type'=>'error'));
			redirect('login');		// login to access the page
		}
		
	}

	function retournament($id) {
		$user_id = $this->userid;
		$get_session_id = $this->input->get_post('session_id', true);
		
		if($get_session_id) {
			if($user_id>0) {			
				$this->load->model('Tournamentmodel');		
				$this->load->model('Usermodel');
				$get_tournament_details = $this->Tournamentmodel->get_tournament_details($id, 'id');
				if(!empty($get_tournament_details) && $get_tournament_details['id']>0) {
					$user_session_value = $this->Usermodel->userDetails($user_id, 'session_id');
					if($user_session_value == $get_session_id) {
						
						$data['id'] = $id;
						$data['user_account_balance'] = $this->Usermodel->userDetails($user_id, 'account_balance');
						$refund_result = $this->Tournamentmodel->retournament($data);
						
						if($refund_result['result']) {
							$this->session->set_flashdata(array('msg'=>$refund_result['message'], 'type'=>'error'));							
						} else {
							$this->session->set_flashdata(array('msg'=>$refund_result['message'], 'type'=>'error'));
						}
						redirect('tournament');	
					} else {
						//redirect to invalid URL
						redirect('login');			
					}

				} else {
					$this->session->set_flashdata(array('msg'=>'Tournament not found', 'type'=>'error'));
					redirect('tournament');			
				}
			} else {
				redirect('login');			
			}
		} else {
			redirect('login');			
		}
	}
}
