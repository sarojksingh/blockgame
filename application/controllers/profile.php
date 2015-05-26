<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Profile extends MY_Controller{
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
			$this->template->set('nav_act','profile');
			$this->template->load('main','profile',$data);
		}else{
			$current_url = $this->uri->uri_string();
			$this->session->set_userdata('after_login_url', $current_url);
			redirect('login');
		}
	}	
	
	function edit()
	{	
		$data = array();
		if($this->userid){
			$this->load->model('Usermodel');
			$data['username'] = $this->Usermodel->userDetails($this->userid, 'username');
			$data['name'] = $this->Usermodel->userDetails($this->userid, 'name'); 
			$data['email'] = $this->Usermodel->userDetails($this->userid, 'email'); 
			$data['id'] = $this->Usermodel->userDetails($this->userid, 'id');
			$data['user_role'] = $this->Usermodel->userDetails($this->userid, 'user_role');
			$data['img'] =$this->Usermodel->userDetails($this->session->userdata('id'),'profileimg'); 		
			$data['page'] = '';
			$this->template->set('title',PAGE_TITLE_EDIT_PROFILE);
			$this->template->set('nav_act','profile');
			$this->template->load('main','edit_profile',$data);
		}else{
			redirect('login');
		}
	}
	
	function update()
	{
	
		$data = array();
		if($this->userid){
			$this->load->model('Psvalidation');
			$config = $this->Psvalidation->profileUpdate();
			$this->form_validation->set_rules($config);
			if ($this->form_validation->run() == FALSE)
			{
				$data['username'] = $this->session->userdata('username');
				$data['name'] = set_value('name'); 
				$data['email'] = set_value('email');
				$data['id'] = $this->input->post('id'); 
				$data['page'] = '';
				$this->template->set('title',PAGE_TITLE_EDIT_PROFILE);
				$this->template->set('nav_act','profile');
				$this->template->load('main','edit_profile',$data);
			}else{
				$id = $this->input->post('id',true);
				$post = $this->input->post(null,true);			
				$this->load->model('Usermodel');
				$prev_img = $this->Usermodel->userDetails($id,'profileimg');
				$post['profile_img'] = $prev_img;
				if($_FILES['profile_img']['error']==0)
				{
					$this->load->model('Imagemodel');					
					$img = $this->Imagemodel->uploadImg();					
					if($img['success'])
					{
						$post['profile_img'] = $img['result']['thumb'];
						@unlink(APPPATH.'../upload/'.$prev_img);						
					}
				}				
				if($this->Registermodel->updateProfile($id,$post))
				{
					$this->session->set_flashdata(array('msg'=>PROFILE_UPDATE_SUCCESS, 'type'=>'success'));
				}else{
					$this->session->set_flashdata(array('msg'=>PROFILE_UPDATE_FAILURE, 'type'=>'error'));
				}
				$userrole = $this->session->userdata('user_role');
				$session_user_id = $this->session->userdata('id');
				
				if($userrole==1 || $id == $session_user_id)
				{
					redirect('profile');
				}else{
					$page = isset($post['page']) ? $post['page'] : 0 ;
					$current_user_role = get_user_role($id);
					if($current_user_role == 2){
						redirect('admin/adminusers/'.$page);
					}else{
						redirect('admin/users/'.$page);
					}
						
				}
			}			
		}else{
			redirect('login');
		}
	}
	
	function validate_email($str)
	{
		$id = $this->input->post('id');
		$this->db->where(array('email'=>$str,'id !='=>$id));
		$query = $this->db->get('user');
		if($query->num_rows > 0)
		{
			$this->form_validation->set_message('validate_email', 'Email id already exists.');
			return false;
		}else{
			return true;
		}	
	}
	
}
?>
