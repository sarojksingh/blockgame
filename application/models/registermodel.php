<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Registermodel extends CI_Model{
	
	function __construct()
	{
		parent::__construct();
	}

	function registerInsert($post)
	{
		
		$insert = array(
			'email'=>$post['email'],
			'username'=>strtolower($post['username']),
			'password'=>md5($post['password']),
			'name'=>$post['name'],
			'profileimg' => $post['profile_img'],
			'status'=>'1'
		);
		if(isset($post['current']) AND $post['current'] == 'admin'){
			$insert['user_role'] = '2';
		}else{
			$insert['user_role'] = '1';
		}
		
		if($this->db->insert('user',$insert))
		{
			return true;
		}else{
			return false;
		}
	}
	
	function updateProfile($id, $post)
	{		
		$update = array(
			'email'=>$post['email'],						
			'name'=>$post['name'],
			'profileimg'=>$post['profile_img']
		);
		if(!empty($post['password']) || !empty($post['confirm_password']))
        {
			$update['password'] = md5($post['password']);
		}
		$this->db->where('id',$id);
		if($this->db->update('user',$update))
		{
		     if($id==$this->session->userdata('id')){
			$this->session->set_userdata('email', $post['email']);
			$this->session->set_userdata('name', $post['name']);
			
			}
			return true;
		}else{
			return false;
		}
	}
}
?>
