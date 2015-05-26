<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Logout extends MY_Controller{
	
	function __construct()
	{
		parent::__construct();		
	}

	/* function to logout the logged in User */
	function index()
	{
		$id = $this->session->userdata('id');
		if($id){			
			$this->load->model('Loginmodel');
			$check = $this->Loginmodel->logout();			
			if($check['logout']){
			$this->session->set_flashdata(array('msg'=>LOGOUT_SUCCESS, 'type'=>'success'));		
			}else{
			$this->session->set_flashdata(array('msg'=>LOGOUT_FAILURE, 'type'=>'error'));		}			
		}		
		redirect('login');
	}

}
?>
