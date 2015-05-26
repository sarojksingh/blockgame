<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Loginmodel extends CI_Model{
	
	function __construct()
	{
		parent::__construct();
	    // $this->load->database();
	}
	
	function logincheck($post)
	{	
		$post = $this->input->post(null,true);
		$where = array(
			'username'=>$post['username'],
			'password'=>md5($post['password'])			
			);
		
		$query = $this->db->get_where('user',$where);	

		if($query->num_rows()>0)
		{
			$res = $query->row_array();
			if($res['status']==1){						
				$newdata = array(
					'id' => $res['id'],
				   'email'  => $res['email'],
				   'user_role' => $res['user_role'],
					'name' => $res['name'],
					'username' => $res['username'],
					'account_balance' => $res['account_balance'],
				   'logged_in' => TRUE
			   );
			   $this->session->set_userdata($newdata);				
				$data['logged_in']=true;
				$data['user_role']=$res['user_role'];
				$data['id'] = $res['id'];
				$data['status'] = $res['status'];
				$timezoneupdate = array('id' =>$res['id'], 'timezone_offset'=>$post['tmz']);
				$this->update_user_timezone($timezoneupdate);
				$this->session->set_userdata('timezone_offset',$post['tmz']);	
			}else if($res['status']==2){
				$data['logged_in']=false;
				$data['status'] = '0';
			}
		}else{
			$data['logged_in']=false;
			$data['status'] = '2';
		}
		return $data;
	}

	function logout()
	{
		$data = array();
		$newdata = array(
				'id' => '',
			   'email'  => '',
			   'user_role' => '',
				'name' => '',
				'username' => '',
				'account_balance' => '',
			   'logged_in' => false
		 );	
		$this->session->unset_userdata($newdata);		
		$data['logout']=true;		
		return $data;
	}

	function forgotPassword($arr)
	{
	
		$data = array();
		$query = $this->db->get_where('user',array('email'=>$arr['email']));
		if($query->num_rows()>0)
		{
			$res = $query->row_array();
			$this->load->model('Psmails');
			$mail = array();
			$mail['email'] = $arr['email'];
			$mail['pass'] = $this->random_pass();
			$this->Psmails->forgetPassMail($mail);
			$this->db->where('id',$res['id']);
			$update = array(
				'password'=>md5($mail['pass'])	
				);
			if($this->db->update('user',$update))
			{
				$data['mailsent']=1;
				
			}else{
				$data['mailsent']=0;				
			}			
		}else{
			$data['mailsent']=2;
		}
		return $data;
	}

	function random_pass($lenth =8)
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
	
	function update_session_id() {
		$data = array();
		$logged_in_user = $this->session->userdata('id');
		$data['session_id'] = $this->session->userdata('session_id');
		$this->db->where('id', $logged_in_user);
		$this->db->update('user', $data);
	}
	
	function update_user_timezone($data) {
		$update = array();
		$update['timezone_offset'] = $data['timezone_offset'];
		$this->db->where('id', $data['id']);
		$this->db->update('user', $update);
		
	}
}
?>
