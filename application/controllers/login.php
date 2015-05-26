<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Login extends MY_Controller{
	public $userrole;
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('Loginmodel');
		$this->template->set('nav_act','');
		$this->userrole = $this->session->userdata('user_role');
		$this->form_validation->set_error_delimiters('', '');		
	}
	
	function index()
	{	
		$data = array();
		if(!$this->userrole){
			$data['username'] =  $this->session->flashdata('loginusername');
			$data['password'] = '';
			$data['email'] = '';
			$this->template->set('title',PAGE_TITLE_LOGIN);
			$this->template->set('nav_act','login');
			$this->template->load('main','login',$data);
		}else if($this->userrole==1){			
				redirect('profile');			
			
		}else if($this->userrole==2)
		{
			redirect('admin');
		}
		
	}
	
	function loginCheck()
	{  
		$data = array();
		$post = $this->input->post(null,true);		


		if(!$this->userrole){
			$this->load->model('Psvalidation');
			$config = $this->Psvalidation->login();
			$this->form_validation->set_rules($config);
			if ($this->form_validation->run() == FALSE)
			{
				$data['username'] = set_value('username');
				$data['password'] = '';
				$data['email'] = '';
				$this->template->set('title',PAGE_TITLE_LOGIN);
				$this->template->set('nav_act','login');
				$this->template->load('main','login',$data);
			}else{
				$login = $this->Loginmodel->logincheck($post);

				if($login['logged_in'])
				{
					$this->session->set_flashdata(array('msg'=>LOGIN_SUCCESS, 'type'=>'success'));
					if($login['user_role']==1)
					{
						//Get the session url
						$session_url = $this->session->userdata('after_login_url');
						if($session_url != '') {
							$this->session->set_userdata('after_login_url', '');
							redirect($session_url);
						}else {
							redirect('profile');
						}
						
					}else if($login['user_role']==2){
						//Get the session url
						$session_url = $this->session->userdata('after_login_url');
						if($session_url != '') {
							$this->session->set_userdata('after_login_url', '');
							redirect($session_url);
						}else {
							redirect('admin');
						}
						
					}
				}else{
					$this->session->set_flashdata(array('msg'=>LOGIN_FAILURE, 'type'=>'error' ,'loginusername'=>$post['username']));
					redirect('login');
				}				
			}
		}else if($this->userrole==1){
			redirect('profile');
		}else if($this->userrole==2)
		{
			redirect('admin');
		}
	}	

	function forgotpassword () {
		$data = array();
		$data['email'] = $this->session->flashdata('femail');
		$this->template->set('title',PAGE_TITLE);
		$this->template->set('nav_act','login');
		$this->template->load('main','forgotpassword',$data);		
	}
	
	function forgot_password()
	{
	
		$post = $this->input->post(null,true);		
		$result = $this->Loginmodel->forgotPassword($post);		
		if($result['mailsent']==2){
			$this->session->set_flashdata(array('msg'=>USER_NOT_EXISTS,'type'=>'error','femail'=>$post['email']));
			redirect('login/forgotpassword');
		}else if($result['mailsent']==1){
			$this->session->set_flashdata(array('msg'=>PASSWORD_RESET_SUCCESSFULLY,'type'=>'success'));
			redirect('login');
		}else if($result['mailsent']==0){
			$this->session->set_flashdata(array('msg'=>PASSWORD_RESET_FAILURE,'type'=>'error'));
		}
		
	}
}
?>
