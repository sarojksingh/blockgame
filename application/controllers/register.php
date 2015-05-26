<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Register extends MY_Controller{
	public $logged_in;
	
	function __construct()
	{
		parent::__construct();
		$this->template->set('nav_act','register');
		$this->logged_in = $this->session->userdata('logged_in');
		$this->load->model('Registermodel');		
		$this->form_validation->set_error_delimiters('', '');		
	}
	
	function index()
	{	
		$data = array();
		if(!$this->logged_in){
			$data['username'] = '';
			$data['name'] = '';
			$data['email'] = '';
			$data['confirm_email'] = '';
			$data['password'] = '';
			$data['confirm_password'] = '';
			$this->template->set('title',PAGE_TITLE_REGISTER);
			$this->template->load('main','register',$data);
		}else{
			redirect('profile');
		}
	}	
	
	function reg_insert()
	{
		$data = array();
		if(!$this->logged_in){
			$this->load->model('Psvalidation');
			$config = $this->Psvalidation->register();
			$this->form_validation->set_rules($config);
			if ($this->form_validation->run() == FALSE)
			{
				$data['username'] = set_value('username');
				$data['name'] =  set_value('name');
				$data['email'] =  set_value('email');
				$data['confirm_email'] =  set_value('confirm_email');
				$data['password'] =  set_value('password');
				$data['confirm_password'] =  set_value('confirm_password');
				$this->template->set('title',PAGE_TITLE_REGISTER);
				$this->template->load('main','register',$data);
			}else{
				$this->load->model('Imagemodel');
				$this->load->model('Loginmodel');
				$img = $this->Imagemodel->uploadImg();
				if($img['success'])
				{
					$post = $this->input->post(null,true);
					$post['profile_img'] = $img['result']['thumb'];
					
					if($this->Registermodel->registerInsert($post))
					{
						$loginarray = array();
						$loginarray['username'] = $post['username'];
						$loginarray['password'] = $post['password'];
						$login = $this->Loginmodel->logincheck($loginarray);
						$this->session->set_flashdata(array('msg'=>REGISTER_SUCCESS, 'type'=>'success'));
					}else{
						$this->session->set_flashdata(array('msg'=>REGISTER_FAILURE, 'type'=>'error'));
					}
					redirect('profile');
				}else{
					$this->session->set_flashdata(array('msg'=>$img['result'], 'type'=>'error'));
					redirect('register');
				}
			}
		}else{
			redirect('profile');
		}
	}	
	
}
?>
