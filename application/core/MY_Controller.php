<?php 

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class MY_Controller extends CI_Controller{
	
	private $user_role;

	function __construct()
	{		
            
		parent::__construct();		
		$this->user_role = $this->session->userdata('user_role');
		$id = $this->session->userdata('id');
		$this->template->set('sign','');
		if($id){
			$this->load->model('Usermodel');
			$this->load->helper('Common');			
			$user = $this->Usermodel->userDetails($id);
			$name = isset($user['name']) ? $user['name'] : '';
			$account_balance = isset($user['account_balance']) ? $user['account_balance'] : '';
			$full_name = limit_string($name, 25);
			$sign = '<div class="signdetails">Signed in as : <span title="' . $name . '">'. $full_name;
			if($this->user_role == 1) {
				$sign .= ', $'.$account_balance;
			}
			$sign .='</span> <a href="'.base_url('logout').'">Sign out</a></div>';
			$this->template->set('sign',$sign);
		}
	}
	
	/* Function to check which type of User is logged in. */
	function who_is_logged_in($type)		
	{	
		if($this->user_role==$type){
			return true;
		}else{
			return false;
		}
	}
	/* Function to convert static array to object array */

	function arrayToObject($array) 
	{
		if(!is_array($array)) {
			return $array;
		}
		
		$object =new StdClass();
		if (is_array($array) && count($array) > 0) {
		  foreach ($array as $name=>$value) {
			 $name = strtolower(trim($name));
			 if (!empty($name)) {
				$object->$name = $this->arrayToObject($value);
			 }
		  }
		  return $object;
		}
		else {
		  return FALSE;
		}
	}

}
?>
