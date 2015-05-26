<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Shop extends MY_Controller{
	public $userid;
	function __construct()
	{
		parent::__construct();		
		$this->template->set('nav_act','');
		$this->userid = $this->session->userdata('id');
		$this->load->model('Registermodel');		
		$this->form_validation->set_error_delimiters('', '');						
	}

	function index()
	{
		$data = array();
		if($this->userid){
			$data['id'] = $this->userid; 
			$this->template->set('title',PAGE_TITLE_PROFILE);
			$this->template->set('nav_act','shop');
			$this->template->load('main','shop',$data);
		}else{
			$current_url = $this->uri->uri_string();
			$this->session->set_userdata('after_login_url', $current_url);
			redirect('login');
		}
	}
}
?>	
