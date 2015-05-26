<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Tournament extends MY_Controller{
	
	function __construct()
	{
		parent::__construct();
		$this->template->set('nav_act','tournament');
	}
	
	function index()
	{	
		$data = array();
		$user_id = $this->session->userdata('id');
		if($this->session->userdata('user_role') == 2){
			redirect('tournament/tournamentlisting');
		}else{
			if($user_id>0) {	
				$this->template->set('title',PAGE_TITLE_TOURNAMENT);		
				$this->load->model('Tournamentmodel');
				$data['tournament_active_link'] = 'active';
				$data['mega_tournament_list'] = $this->Tournamentmodel->get_mega_tournament_list_user();
				$data['mini_tournament_list'] = $this->Tournamentmodel->get_mini_tournament_list_user();
				$this->template->load('main','tournament', $data);
				
			} else {
				$current_url = $this->uri->uri_string();
				$this->session->set_userdata('after_login_url', $current_url);
				redirect('login');
			}
		}
	}

	function tournamentlisting($page=0){
		$data = array();
		$user_id = $this->session->userdata('id');
		if($user_id > 0) {	
		
			//pagination configurations
			
			$this->load->library('pagination');
			$this->load->model('Tournamentmodel');
			$config['total_rows'] = count( $this->Tournamentmodel->get_mega_tournament_list());			
			$config['base_url'] = base_url()."tournament/tournamentlisting/";
			$config['uri_segment'] = 3;			
			$this->pagination->initialize($config);
			
			$this->template->set('title',PAGE_TITLE_MEGA_ACTIVE);		
			$data['tournament_active_link'] = 'mega';
			$data['sub_tournament_active_link'] = 'Active';
			$data['tournament_list'] = $this->Tournamentmodel->get_mega_tournament_list($this->config->item('per_page'),$page);
			$data['page'] = $page;
			//$data['mini_tournament_list'] = $this->Tournamentmodel->get_mini_tournament_list();
			$this->template->load('main','tournamentlist', $data);
			
		} else {
			$current_url = $this->uri->uri_string();
			$this->session->set_userdata('after_login_url', $current_url);
			redirect('login');
		}
	}

	function minitournamentlist($page=0){
		$data = array();
		$user_id = $this->session->userdata('id');
		if($user_id > 0) {	
			$this->template->set('title',PAGE_TITLE_MINI_TOURNAMENT);
			
			$this->load->library('pagination');
			$this->load->model('Tournamentmodel');
			$config['total_rows'] = count($this->Tournamentmodel->get_mini_tournament_list());			
			$config['base_url'] = base_url()."tournament/minitournamentlist/";
			$config['uri_segment'] = 3;			
			$this->pagination->initialize($config);	
			
			$data['tournament_active_link'] = 'mini';
			$data['sub_tournament_active_link'] = 'Active';
			//$data['mega_tournament_list'] = $this->Tournamentmodel->get_mega_tournament_list();
			$data['tournament_list'] = $this->Tournamentmodel->get_mini_tournament_list($this->config->item('per_page'),$page);
			$data['page'] = $page;
			$this->template->load('main','tournamentlist', $data);
			
		} else {
			$current_url = $this->uri->uri_string();
			$this->session->set_userdata('after_login_url', $current_url);
			redirect('login');
		}
	}

	function entertournament($id) {
		if($this->session->userdata('id')>0) {			
			$data = array(
				'tournament_id' => $id
				);		
			$this->load->model('Tournamentmodel');			
			$result = $this->Tournamentmodel->enter_tournament($data);	
			if($result['result'] == true) {
				$this->session->set_flashdata(array('msg'=>$result['message'], 'type'=>'success'));
				redirect('play_game/tournament/' . $id);
			}
			if($result['result'] == false && $result['response_code'] == 3) {
				$this->session->set_flashdata(array('msg'=>$result['message'], 'type'=>'error'));
				redirect('tournament/payment/'.$id);
			}
			else if($result['result'] == false ) { //
				$this->session->set_flashdata(array('msg'=>$result['message'], 'type'=>'error'));				
				redirect('tournament');
			}			
			else {
				$this->template->set('error_msg',TOURNAMENT_ENTER_ERROR);
				$data['mega_tournament_list'] = $this->Tournamentmodel->get_mega_tournament_list();
				$data['mini_tournament_list'] = $this->Tournamentmodel->get_mini_tournament_list();
				$this->template->load('main','tournament', $data);
			}
		}
		else {			
			redirect('login');		// login to access the page
		}
		//$this->output->enable_profiler(TRUE);
	}

	function tournamentstart($id =0) {
		if($this->session->userdata('id')>0) {	
			$data = array( 'tournament_id' => $id);
			$this->load->model('Tournamentmodel');		
			$tournamentstart = $this->Tournamentmodel->tournament_start($data);
			if($tournamentstart['result']) {
				redirect('tournament/play');
			}			
			else {
				$this->session->set_flashdata(array('msg'=>$tournamentstart['message'], 'type'=>'error'));
				redirect('tournament');
			}			
		}
		else {
			redirect('login');		// login to access the page
		}
	}

	function mytournaments() {
		$data = array();	
		$user_id = $this->session->userdata('id');
		$data['user_id'] = $this->session->userdata('id');
		$this->template->set('title',PAGE_TITLE_TOURNAMENT);	
		if($user_id>0) {			
			$this->load->model('Tournamentmodel');
			$data['my_tournaments_mega'] = $this->Tournamentmodel->my_tournaments_mega($data['user_id']);
			$data['my_tournaments_mini'] = $this->Tournamentmodel->my_tournaments_mini($data['user_id']);
			$this->template->load('main','mytournaments', $data);
		}
		else {
			redirect();
		}
		
	}
	

	function payment($id = 0) {
		$user_id = $this->session->userdata('id');
		if($user_id>0) {
			$data = array();				
			$id = isset($id) ? $id : 0;
			$post = array(
				'tournament_id' => $id
			);	
			$this->template->set('title',PAGE_TITLE_PAYMENT);	
			$this->load->model('Tournamentmodel');			
			$tournament_details = $this->Tournamentmodel->get_tournament_details($id);	
			$tournament_start = $this->Tournamentmodel->tournament_start($post);	
			
			if($id ==0)
				$this->template->set('nav_act','profile');
			$data['tournament_details'] = $tournament_details;
			
			if(!empty($tournament_details)) {
				if(in_array($user_id, explode(',', $tournament_details['participants'])) && ($tournament_details['status'] == 1 || $tournament_details['status'] == 3)) {			
					//already entered the tournament.	
					$this->session->set_flashdata(array('msg'=>TOURNAMENT_ENTERED_ALREADY, 'type'=>'error'));
					redirect('tournament');
				}
			}
			if(!empty($tournament_details) && !$tournament_start['result'] ) {
				$this->session->set_flashdata(array('msg'=>TOURNAMENT_PAY_ACTIVE, 'type'=>'error'));
					redirect('tournament');
			}
			$this->template->load('main','payment', $data);
		}else {			
			redirect('login');
		}
	}

	public function paymentprocess()
	{ 
 		$this->load->model('Paymentmodel');
		$paypal = $this->Paymentmodel->expressCheckout($_POST);
		if($paypal['ACK']=='Success'){
			//header("Location:https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=".urldecode($paypal['TOKEN']));
			$environment = $this->config->item('pay_mode');
			$payPalURL = "https://www.paypal.com/webscr&cmd=_express-checkout&token=".urldecode($paypal['TOKEN']);
			if("sandbox" === $environment || "beta-sandbox" === $environment) {
				$payPalURL = "https://www.$environment.paypal.com/webscr&cmd=_express-checkout&token=".urldecode($paypal['TOKEN']);
			}
			
			header("Location: $payPalURL");
		}else{
			redirect('tournament/paymentfail');		
		}
	}

	function finalprocess($id=0)
	{
		$user_id = $this->session->userdata('id');
		if($user_id>0) {
			$this->load->model('Paymentmodel');

			$post=array();
			$post['token'] = $_GET['token'];
			$paypal = $this->Paymentmodel->getTransactionDetails($post);
			if($paypal['ACK']=='Success'){
				$postdata = array(
					'token'=>$paypal['TOKEN'],
					'PayerID'=>$paypal['PAYERID'],
					'amount'=>$paypal['AMT']
				);
				$express = $this->Paymentmodel->doExpressCheckout($postdata);
				if($paypal['ACK']=='Success'){
					$data = array();
					$post1['token'] = $express['TOKEN'];
					$getDetails = $this->Paymentmodel->getTransactionDetails($post1);
					if($getDetails['ACK']=='Success' && $getDetails['CHECKOUTSTATUS']=='PaymentActionCompleted'){
									
						$data['transaction_time'] = strtotime(urldecode($getDetails['TIMESTAMP']));
						$data['transaction_id'] = urldecode($getDetails['PAYMENTREQUEST_0_TRANSACTIONID']);
						$data['correlation_id'] = urldecode($getDetails['CORRELATIONID']);
						$data['amount'] = urldecode($getDetails['AMT']);
						$data['tournament_id'] = $id;
						$data['user_id'] = $user_id;
						if($this->Paymentmodel->savepaymentdetails($data)){

							$this->load->model('Tournamentmodel');
							$this->load->model('Usermodel');
							$account_balance = $this->Usermodel->userDetails($user_id, 'account_balance');
							//$session_user_account_balance = $this->session->userdata('account_balance');
							$balance = $account_balance + $data['amount'];
							$this->Tournamentmodel->update_account_balance($balance);
							if($id > 0) {
								redirect('play_game/tournament/'. $id);
							} else {
								$this->session->set_flashdata(array('msg'=>PAYMENT_TRANSFERRED_SUCCESSFULLY, 'type'=>'success'));
								redirect('profile');
							}
							
						}
					} else{
						$data = array();
						$this->template->set('title',PAGE_TITLE_PAYMENT_FAIL);	
						$this->template->load('main','paymentfail', $data);	
					}
				}else{
					$data = array();
					$this->template->set('title',PAGE_TITLE_PAYMENT_FAIL);	
					$this->template->load('main','paymentfail', $data);	
				}
				
			}else{
				$data = array();
				$this->template->set('title',PAGE_TITLE_PAYMENT_FAIL);	
				$this->template->load('main','paymentfail', $data);	
			}
		}
		
	}
	
	function paymentcancel() {
		$data = array();
		$this->template->set('title',PAGE_TITLE_PAYMENT_CANCEL);	
		$this->template->load('main','paymentcancel', $data);		
	}

	function paymentfail() {
		$data = array();
		$this->template->set('title',PAGE_TITLE_PAYMENT_FAIL);	
		$this->template->load('main','paymentfail', $data);		
	}

	function play() {
		$data = array();
		$this->template->set('title',PAGE_TITLE);	
		$this->template->load('main','tournament_play', $data);		
	}

	

}
?>

