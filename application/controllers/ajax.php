<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Ajax extends MY_Controller{	
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('Usermodel');
		$this->load->model('Tournamentmodel');										
	}
	
	function SaveWinner()
	{
		$arr = array('NextRoundNumber'=>'0');
		$post = array();
		$post['tournament_id'] = $this->input->post('TournamentID',true);
		$post['users_id'] = $this->input->post('UsersID',true);
		$post['winner_id'] = $this->input->post('WinnerID',true);
		$post['round'] = $this->input->post('RoundNumber',true);
		//$post = $this->input->post(null,true);
		//print_r($post);
		//die;		
		$insert = $this->Usermodel->save_winner($post);		
		if($insert)
		{			
			// 1 for mega, 2 for mini.
			
			$touranamentdetails = $this->Tournamentmodel->get_tournament_details($post['tournament_id']);
			$type = $touranamentdetails['type'];
			$max_round = (($type==1) ? '3' : '2');			
			if($post['round'] < $max_round)
				$arr['NextRoundNumber'] = $post['round']+1;
			else {
				$type = ($type == 1) ? 'Mega' : 'Mini';
				$data = array();
				$emaildata = array();
				$emaildata['email'] = $this->Usermodel->userDetails($post['winner_id'], 'email');
				$emaildata['name'] = $this->Usermodel->userDetails($post['winner_id'], 'name');
				$emaildata['date'] = date('d-m-Y', strtotime($touranamentdetails['date']));
				$emaildata['time'] = $touranamentdetails['time'];
				$emaildata['type'] = $type;
				$emaildata['prize_name'] = $touranamentdetails['prize_name'];
				$emaildata['tournament_name'] = $touranamentdetails['tournament_name'];
				$data['tournament_id'] = $post['tournament_id'];				
				$data['winner_id'] = $post['winner_id'];
				$data['status'] = 2;
				$this->load->model('Psmails');
				$this->Tournamentmodel->updateTournamentWinner($data);				
				$this->Psmails->gameWinnerAdminEmail($emaildata);
				$arr['NextRoundNumber'] = -1;	
			}

			$arr['Result'] = "success";			
		}else{
			$arr['Result'] = "error";
		}
		echo $this->createJson($arr);
	}
	
	function saveWinnerDetails() {
	
		$post = array();
		$result = array();
		$emaildata = array();
		$post['tournament_id'] = $this->input->post('tournament_id',true);
		$post['address'] = $this->input->post('address',true);
		$post['city'] = $this->input->post('city',true);
		$post['postcode'] = $this->input->post('postcode',true);
		$post['email'] = $this->input->post('email',true);
		$post['telephone'] = $this->input->post('telephone', true);

		$tournamentdetails = $this->Tournamentmodel->get_tournament_details($post['tournament_id']);
		//$winner_id = $this->Tournamentmodel->get_tournament_details($post['tournament_id']);
		if(!empty($tournamentdetails)) {
			$type = ($tournamentdetails['type'] == 1) ? 'Mega' : 'Mini';
			if($this->Tournamentmodel->saveWinnerDetails($post)) {
				$result['Result'] = 'success';
				$this->load->model('Psmails');
				$emaildata['prize_name'] = $tournamentdetails['prize_name'] ;
				$emaildata['name'] = $this->Usermodel->userDetails($tournamentdetails['winner_id'], 'name');
				$emaildata['address'] = $post['address'];
				$emaildata['postcode'] = $post['postcode'];
				$emaildata['email'] = $post['email'];
				$emaildata['city'] = $post['city'];
				$emaildata['telephone'] = $post['telephone'];
				$emaildata['prize_img1'] = $tournamentdetails['prize_img1'];
				$emaildata['type'] = $type;
				$emaildata['date'] = date('d-m-Y', strtotime($tournamentdetails['date']));
				$emaildata['time'] =$tournamentdetails['time'];
				$emaildata['tournament_name'] =$tournamentdetails['tournament_name'];
				$this->Psmails->sentWinnerToAdminEmail($emaildata);
				$this->Psmails->gameWinnerEmail($emaildata);
				$arr['NextRoundNumber'] = -1;	
				$arr['Result'] = "success";
				$arr['type'] =  $emaildata;
			}
			else {
				$arr['Result'] = "error";
				//$arr['NextRoundNumber'] = -1;	
			}
		} else {
			$arr['Result'] = "Error, Tournament not found";
				//$arr['NextRoundNumber'] = -1;	
		}
		echo $this->createJson($arr);
	}
		
	/*
	function GetTournamentInfo()
	{
		$arr = array();
		$id = $this->input->post('UserID',true);
		$tournamentID = $this->input->post('TournamentID',true);
		if(!empty($id) && !empty($tournamentID))
		{
			$user = $this->Usermodel->userDetails($id);
			$arr['result'] = $user['success'];
			$arr['UserName'] = $user['username'];
			$arr['ImagePath'] = base_url('image/'.$user['profile_img']);
			$arr['TotalWins'] = $user['total_wins'];
			
			echo $this->createJson($arr);
		}else{
			$arr['result'] = "error";
			echo $this->createJson($arr);
		}
	}
	*/
	
	

	function createJson($arr)
	{
		return json_encode($arr);
	}

	function emailValidationRegister()
	{
		$email = $this->input->post('email');			
		$this->db->where(array('email'=>$email));
		$query = $this->db->get('user');
		if($query->num_rows > 0)
		{
			
			$valido = false;

		}else{
			 $valido = true;

		}		
		 header('Content-type: application/json');
         echo json_encode($valido);
	
	}

	function validateTournamentName(){
		$where = array();
		$tournament_name = $this->input->post('tournament_name');		
		$where['tournament_name'] = $tournament_name;			
		$id = $this->input->get_post('id');		
		if($id>0) {
			$where['id !='] = $id;
			
		}
		$this->db->where($where);
		$query = $this->db->get('tournament');
		
		if($query->num_rows > 0)
		{			
			$valido = false;
		}else{
			 $valido = true;
		}		
		 header('Content-type: application/json');
         echo json_encode($valido);		
		
	}

	function userValidation()
	{ 
		$username = $this->input->post('username');			
		
		$this->db->where(array('username'=>$username));
		$query = $this->db->get('user');
		if($query->num_rows > 0)
		{
			
			$valido = false;

		}else{
			 $valido = true;

		}		
		 header('Content-type: application/json');
         echo json_encode($valido);
	
	}
	function emailValidation()
	{
		$email = $this->input->get_post('email');
		$this->load->model('Usermodel');
		$id = $this->input->get_post('id');		
		$checkuser = $this->Usermodel->userDetails($id);		
		$data = array('email'=>$email);
		if(!empty($checkuser)){
			$data['id !='] = $id;
		}		
		$this->db->where($data);
		$query = $this->db->get('user');
		
		 if(!empty($checkuser) && $query->num_rows > 0 )
		{
			$valido = false;

		} 
		else{

			 $valido = true;
		}		
		 header('Content-type: application/json');
         echo json_encode($valido);
		// $this->output->enable_profiler(true);
	
	}

	function validateEnterTime()
	{
		$data = array();		
		$diff_in_mins = 0;		
		$entered_date = $this->input->get_post('yearmonthdaytime', true);
		$entered_date_in_sec = strtotime($entered_date);
		$current_date_in_sec = strtotime(date('Y-m-d H:i'));
	
		$diff_in_mins = ($entered_date_in_sec - $current_date_in_sec)/60;
		$data['diff_in_mins'] = $diff_in_mins;
		if($diff_in_mins > 15)
		{
			$valido = true;
		} 
		else{
			$valido = false;
		}
		
		header('Content-type: application/json');
        echo json_encode($valido);
		// $this->output->enable_profiler(true);
	
	}

	function show_history($user_id){
		$this->load->model('Usermodel');
		$checkuser = $this->Usermodel->userDetails($user_id);
		if($checkuser['status'] == 1){
			$status = 'Active';
		}else{
			$status = 'Inactive';
		}
		$str = $checkuser['username'] ."___".$checkuser['name']."___".$checkuser['email']."___".totalmatchwins($user_id)."___".$checkuser['account_balance']."___".$status."___".$checkuser['profileimg'];
		echo $str;die;
	}
}
?>
