<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Tournamentmodel extends CI_Model{
	
	function __construct()
	{
		parent::__construct();
	}
	
	function get_mega_tournament_list_user(){
		$where = "( date > '" . date('Y-m-d') . "' OR ( date = '" . date('Y-m-d') . "' AND time > '" . date('H:i:s') . "' ))";
		//echo $where ; 
		$this->db->where('type', 1);	
		$this->db->where('status', 1);
		$this->db->where($where);
		//$this->db->or_where('status', 0);
		$this->db->order_by('date', 'ASC');
		$this->db->order_by('time', 'ASc');
		$query = $this->db->get('tournament');
		$result = $query->result();			
		return $result;
	}
	
	function get_mini_tournament_list_user()
	{	
		//$where = "( date >= '" . date('Y-m-d') . "' OR ( date = '" . date('Y-m-d') . "' AND time >= '" . date('H:i:s') . "' ))";
		//$this->db->where($where);
		
		$where = "type = 2 AND (status = 1 OR status = 3)";
		$this->db->where($where);
		/*$this->db->where('type', 2);
		$this->db->where('status', 1);
		$this->db->or_where('status', 3); */
		$this->db->order_by('id', 'DESC');		
		$query = $this->db->get('tournament');		
		$result = $query->result();
		return $result;
	}
	
	function get_mega_tournament_list($limit='',$offset='')
	{	
		$where = "( date > '" . date('Y-m-d') . "' OR ( date = '" . date('Y-m-d') . "' AND time >= '" . date('H:i:s') . "' ))";
		if($limit!='' || $offset!='')
		{
			$this->db->limit($limit, $offset);
		}
		$this->db->where('type', 1);	
		$this->db->where('status', 1);
		$this->db->where($where);
		//$this->db->or_where('status', 0);
		$this->db->order_by('date', 'ASC');
		$this->db->order_by('time', 'ASc');
		$query = $this->db->get('tournament');
		$result = $query->result();	
			//print_r($result);die;
		return $result;
	}

	function get_mini_tournament_list($limit='',$offset='')
	{	
		//$where = "( date >= '" . date('Y-m-d') . "' OR ( date = '" . date('Y-m-d') . "' AND time >= '" . date('H:i:s') . "' ))";
		//$this->db->where($where);
		if($limit!='' || $offset!='')
		{
			$this->db->limit($limit, $offset);
		}
		$where = "type = 2 AND (status = 1 OR status = 3)";
		$this->db->where($where);
		/*$this->db->where('status', 1);
		$this->db->or_where('status', 3); */
		$this->db->order_by('id', 'DESC');		
		$query = $this->db->get('tournament');		
		$result = $query->result();
		return $result;
	}

	function get_mega_cmp_tournament_list($limit='',$offset='') {
		// SELECT * FROM (`ps_tournament`) WHERE ((date < '2012-11-07' AND status = 1 ) OR ( `status` =  2  )) AND `type` =  1
		$where = "((date < '" . date('Y-m-d') . "' AND status = 1 ) OR ( `status` =  2  )) OR (date = '" . date('Y-m-d') . "' AND time <= '" . date('H:i:s') . "')";
		$this->db->where('type', 1);
		$this->db->where($where);
		$this->db->order_by('date', 'DESC');
		$this->db->order_by('time', 'DESC');
		if($limit!='' || $offset!='')
		{
			$this->db->limit($limit, $offset);
		}
		$query = $this->db->get('tournament');
		$result = $query->result();		
		
		return $result;
	
	}

	function get_mini_cmp_tournament_list($limit='',$offset='') {
		
		//$where = "( date >= '" . date('Y-m-d') . "' OR ( date = '" . date('Y-m-d') . "' AND time >= '" . date('H:i:s') . "' ))";
		//$this->db->where($where);
		if($limit!='' || $offset!='')
		{
			$this->db->limit($limit, $offset);
		}
		$this->db->where('type', 2);
		$this->db->where('status', 2);	
		$this->db->order_by('id', 'DESC');		
		$query = $this->db->get('tournament');		
		$result = $query->result();
		return $result;
		
	}
	
	function get_tournament_details($id, $param='') {
		if($param)
		{
			$this->db->select($param);
		}
		$this->db->where('id', $id);
		$query = $this->db->get('tournament');		
		if(!empty($param))
		{
			$res = $query->row_array();
			return isset($res[$param]) ? $res[$param] : '' ;
		}else{	
			
			return $query->row_array();
		}
	
	}

	function my_tournaments_mega($post) {
		$tournament_participants = $this->tournament_participants(1);
		$mytournaments_ids = array();
		foreach($tournament_participants as $participants) {		
			if(in_array($post['user_id'], explode(',', $participants->participants))) {				
				$mytournaments_ids[] = $participants->id;				
			}
		}
		$result = array();
		if(!empty($mytournaments_ids)) {
			$this->db->where_in('id', $mytournaments_ids);		
			$query = $this->db->get('tournament');	
			$result = $query->result();
			return $result;
		}
		else {
			return $result;
		}	
		
	}

	function my_tournaments_mini($post) {
		$tournament_participants = $this->tournament_participants(2);
		$mytournaments_ids = array();
		$result = array();
		foreach($tournament_participants as $participants) {			
			if(in_array($post['user_id'], explode(',', $participants->participants))) {				
				$mytournaments_ids[] = $participants->id;				
			}
		}
		if(!empty($mytournaments_ids)) {
			$this->db->where_in('id', $mytournaments_ids);		
			$query = $this->db->get('tournament');	
			$result = $query->result();
			return $result;
		}
		else {
			return $result;
		}	
	
	}

	function tournament_participants($type='', $id = 0) {
		if($id>0) {
			$this->db->where('id', $id);
		} 
		if($type) { 
			$this->db->where('type', $type);
		}
		
		$this->db->select('id, participants');
		$query = $this->db->get('tournament');
		$result = $query->result();
		
		return $result;
	}

	function enter_tournament($post) {
		$data = array(
			'result' => '',
			'message' => '',
			'response_code' => ''
		);
		//tournament id
		$id = isset($post['tournament_id']) ? $post['tournament_id'] : 0;
		//user id
		$session_user_id = $this->session->userdata('id');	
		
		$this->load->model('Usermodel');
		
		$get_account_bal = 'account_balance';
		
		$account_balance = $this->Usermodel->userDetails($session_user_id,$get_account_bal);
		$session_user_account_balance = $account_balance;	
		
		$tournamentstart = $this->tournament_start($post);
		
		if(isset($tournamentstart['result']) && $tournamentstart['result'] == true) {
			//$this->db->trans_strict(FALSE);
			//$this->db->trans_start();
			// get the tournament details
			$query = $this->db->query('SELECT total_participants, participants, cost, type, status FROM ps_tournament WHERE id = ' .$id . '');			
			$result = $query->row();			
			
			// check if already entered the tournament
			if($result->status == 2) {
				$data['result'] = false; 
				$data['message'] = TOURNAMENT_IS_COMPLETED;
				$data['response_code'] = 1;  // 1 for tournament is completed.
			}
		/*	else if(in_array($session_user_id, explode(',', $result->participants)) && ($result->status == 1 || $result->status == 3)) {			
				$data['result'] = false;  
				$data['message'] = TOURNAMENT_ENTERED_ALREADY;
				$data['response_code'] = 2;  // 2 for already entered the tournament.
			
			}*/
			else if($session_user_account_balance < $result->cost) { // compare the tournament cost with user account balance
					$data['result'] = false;  // for insufficient fund
					$data['message'] = TOURNAMENT_INSUFFICIENT_FUND;
					$data['response_code'] = 3;  // 3 for insufficient fund.
			} else if(($result->type == 1 && $result->total_participants == 32) || ($result->type == 2 && $result->total_participants == 16) ) {
					$data['result'] = false;  
					$data['message'] = TOURNAMENT_NO_SEAT_AVAILABLE;
					$data['response_code'] = 4;  // 4 no seat available
			} else {
				$querydata = array();
				if($result->type == 2) {
					$querydata['status'] = 3;
				}
					
				//check if user previously registered for tournament..
				
				if(in_array($session_user_id, explode(',', $result->participants)) && ($result->status == 1 || $result->status == 3)) {	
					$data['enter_flag'] = 0;	
					$data['result'] = true;  // for updated successfully
					$data['message'] = '';					
				
				}else{					// update user entry in the tournament 
					
					$querydata['participants'] = $result->participants . $session_user_id . ',';
					$querydata['total_participants'] = ((int)$result->total_participants + 1);
					
					$balance = $session_user_account_balance - $result->cost;
					$this->update_account_balance($balance);
					$data['enter_flag'] = 1;
					$this->db->where('id', $id);
				
					if($this->db->update('tournament', $querydata)){
						$data['result'] = true;  // for updated successfully
						$data['message'] = '';
					} else {
						$data['result'] = false;  // for updated successfully
						$data['message'] = TOURNAMENT_ENTER_ERROR;
					}
				}
				
			}
		} else {
			$data['result'] = $tournamentstart['result'];
			$data['message'] = $tournamentstart['message'];
			
		}		
		return $data;
	}
	
	function tournament_start($post) {
		$data = array(
					'result' => '',
					'message' => '',
					'response_code' =>''
				);
		$id = isset($post['tournament_id']) ? $post['tournament_id'] : 0;			
		$buffer_time =  $this->config->item('buffer_time');
		$time_calibration =  $this->config->item('time_calibration');
		$tournamentdetails = $this->get_tournament_details($id);		
	
		if(!empty($tournamentdetails)) {
			
			if($tournamentdetails['type'] == 1) { // type = 1 is for mega tournament
				
				$date_time = $tournamentdetails['date'] . ' ' . $tournamentdetails['time'];
				$date_time_stamp = strtotime($date_time);
				$date_time_now_stamp =strtotime("now");			
				$diff_time_stamp = $date_time_stamp - $date_time_now_stamp;
				$diff_time_stamp =  ($diff_time_stamp/60) - $time_calibration;			
				
				if($diff_time_stamp <= $buffer_time && $diff_time_stamp >=0) {
					
					$data['result'] = true;
					$data['message'] = '';
				}
				else if($diff_time_stamp>$buffer_time && $tournamentdetails['status'] == 1) {
					$data['result'] = false;
					$data['message'] = TOURNAMENT_MEGA_BUFFER_TIME_MSG;					
				}
				else if($diff_time_stamp<0 && $tournamentdetails['status'] == 1) {
					$data['result'] = false;  // tournament has been started
					$data['message'] = TOURNAMENT_STARTED;					
				}
				else if($diff_time_stamp<0 && $tournamentdetails['status'] == 2) {
					$data['result'] = false;  // tournament has been completed
					$data['message'] = TOURNAMENT_COMPLETED;		
				}
			}else {
				$data['result'] = true; // tournament type is mini
				$data['message'] = TOURNAMENT_TYPE_MINI;				
			}
		} else {
			$data['result'] = false; // tournament not found
			$data['message'] = TOURNAMENT_NOT_FOUND;			
		}	
		return $data;
	}

	function retournament($post) {
		$id = $post['id'];
		$data = array();
		$session_user_id = $this->session->userdata('id');
		$get_tournament_details = $this->get_tournament_details($id);
		$participants = array();
		
		if(isset($get_tournament_details['participants'])) {
			$participants =  explode(",", $get_tournament_details['participants']); 
		} 
		if(in_array($session_user_id,$participants) && ($get_tournament_details['status'] == 1 || $get_tournament_details['status'] == 3)) {
			
			$remaining_participants = $this->remove_participant($participants);		
			$tournament_cost = $get_tournament_details['cost'];			
			$querydata = array();
			$querydata['participants'] = implode(',', $remaining_participants);
			$querydata['total_participants'] = (((int)$get_tournament_details['total_participants']) - 1);
			$this->db->where('id', $id);
			if($this->db->update('tournament', $querydata)){
				$new_user_account_balance = $post['user_account_balance'] + $tournament_cost;
				$this->update_account_balance($new_user_account_balance);
				$data['result'] = true;  // for updated successfully
				$data['message'] = TOURNAMENT_SERVER_CONNECT_ERROR;
			} else {
				$data['result'] = false;  // for updated successfully
				$data['message'] = TOURNAMENT_REFUND_ERROR;
			}			
			
		} else {
			$data['result'] = false;
			$data['message'] = TOURNAMENT_YOUR_NOT_PARTICIPANT;
		}
			
		return $data;
	}

	function remove_participant($participants) {
		$remaining_participants = array();
		$user_id = $this->session->userdata('id');
		foreach($participants as $user) {
			if($user != $user_id) {
				$remaining_participants[] = $user;
			}
		}
		return $remaining_participants;
	}

	function updateTournamentWinner($post) {
		$data = array();
		$data['winner_id'] = $post['winner_id'];
		$data['status'] = 2;
		$this->db->where('id' , $post['tournament_id']);
		if($this->db->update('tournament', $data)) {
			return true;
		}	
		else {
			return false;
		}
	}

	function saveWinnerDetails($post) {
		$data = array(); 		
		$data['address'] = $post['address'];
		$data['city'] =	$post['city'];
		$data['postcode'] =	$post['postcode'];
		$data['email'] = $post['email'];
		$data['telephone'] = $post['telephone'];
		$this->db->where('id' , $post['tournament_id']);
		if($this->db->update('tournament', $data)) {
			return true;
		}	
		else {
			return false;
		}
	}

	function active_tournaments($id) {
		$time_calibration = $this->config->item('time_calibration');
		$tournamentdetails = $this->get_tournament_details($id);
		$date_time = $tournamentdetails['date'] . ' ' . $tournamentdetails['time'];
		$date_time_stamp = strtotime($date_time);		
		$date_time_now_stamp = time('now');				
		$diff_time_stamp = $date_time_stamp - $date_time_now_stamp;
		$diff_time_stamp =  ($diff_time_stamp/60) - $time_calibration;		
		//echo $diff_time_stamp;
		return $diff_time_stamp;		
	}

	
	function update_account_balance($balance) {
		$data = array();
		$session_user_id = $this->session->userdata('id');		
		$data['account_balance'] = $balance;
		$data['session_id'] = $this->random_string();
		$this->db->where('id', $session_user_id);		
		if($this->db->update('user', $data)) {
			$this->session->set_userdata('account_balance', $balance);		
			return true;
		}
		else {
			return false;
		}		
	}

	function random_string($lenth =8)
	{ 
		// makes a random alpha numeric string of a given length 
		$aZ09 = array_merge(range('A', 'Z'), range('a', 'z'),range(0, 9)); 
		$out =''; 
		for($c=0;$c < $lenth;$c++)
		{ 
		 $out .= $aZ09[mt_rand(0,count($aZ09)-1)]; 
		} 
    return $out; 
	}
	
	function get_mini_off_tournament_list($limit='',$offset=''){
		if($limit!='' || $offset!='')
		{
			$this->db->limit($limit, $offset);
		}
		$this->db->where('type', 2);
		$this->db->where('status', 0);	
		$this->db->order_by('id', 'DESC');		
		$query = $this->db->get('tournament');		
		$result = $query->result();
		return $result;
	}
	
	function get_mega_off_tournament_list($limit='',$offset=''){
		if($limit!='' || $offset!='')
		{
			$this->db->limit($limit, $offset);
		}
		$this->db->where('type', 1);
		$this->db->where('status', 0);
		$this->db->order_by('date', 'ASC');
		$this->db->order_by('time', 'ASC');
		$query = $this->db->get('tournament');
		$result = $query->result();
		return $result;
	}
}
?>
