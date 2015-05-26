<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Admin extends MY_Controller{
	public $userrole;
	
	function __construct()
	{
		parent::__construct();		
		$this->template->set('nav_act','');
		$this->form_validation->set_error_delimiters('', '');	
		$this->userrole = 2;
		$this->load->model('Adminmodel');								
	}
	
	function index()
	{	
		$data = array();	
		if($this->who_is_logged_in($this->userrole)){
		
			$this->template->set('title',PAGE_TITLE_PROFILE);
			$this->template->set('nav_act','profile');			
			$data['id'] = $this->session->userdata('id');			
			$this->template->load('main','profile',$data);

		}else{
			redirect('login');
		}
	}
	
	function redirect_url($tour_id){
		$this->load->model('Tournamentmodel');
		$tournamentData = $this->Tournamentmodel->get_tournament_details($tour_id);
		$tour_date = strtotime($tournamentData["date"].' '. $tournamentData["time"]);
		$curr_date = strtotime(date('Y-m-d H:i:s'));
		//echo $tour_date ."	this is currdate:  ". $curr_date;die;
		//echo 'type : '.$tournamentData["type"];
		if($tournamentData["type"] == 1){ 
			//mega redirect link here
			
			if($tournamentData["status"] == 1 && ($tournamentData['date'] > date('Y-m-d') || ($tournamentData['date'] == date('Y-m-d') && ($tournamentData['time'] >= date('H:i:s'))))){
				$redirect = "tournament/tournamentlisting";
			}else if($tournamentData["status"] == 0){
				$redirect = "admin/megaoff";
			}else{
				
				if($tour_date >= $curr_date){
					$redirect = "tournament/tournamentlisting";
				}else{
					$redirect = "admin/megacompleted";
				}						
			}					
		}else{
			//mini redirect link here
			if($tournamentData["status"] == 3 OR $tournamentData["status"] == 1){
				$redirect = "tournament/minitournamentlist";
			}elseif($tournamentData["status"] == 0){
				$redirect = "admin/minioff";
			}else{
				$redirect = "admin/minicompleted";
			}					
		}
		return $redirect;
	}
	
	function tournament()
	{
		$data = array();
		if($this->who_is_logged_in($this->userrole)){			
			$this->template->set('title',PAGE_TITLE_TOURNAMENT);
			$this->template->set('nav_act','tournament');
			$data['tournament_active_link'] = 'active';
			$this->load->model('Tournamentmodel');
			$data['mega_tournament_list'] = $this->Tournamentmodel->get_mega_tournament_list();
			$data['mini_tournament_list'] = $this->Tournamentmodel->get_mini_tournament_list();
			$this->template->load('main','tournament',$data);

		}else{
			redirect('login');
		}
	}

	// list the completed tournament

	function completed() { 
		$data = array();
		$user_role = $this->session->userdata('user_role');
		if($user_role  == 2) {	
			$this->template->set('nav_act','tournament');
			$this->template->set('title',PAGE_TITLE_CMP_TOURNAMENT);		
			$this->load->model('Tournamentmodel');
			$data['tournament_active_link'] = 'completed';
			$data['mega_cmp_tournament_list'] = $this->Tournamentmodel->get_mega_cmp_tournament_list();
			$data['mini_cmp_tournament_list'] = $this->Tournamentmodel->get_mini_cmp_tournament_list();
			$this->template->load('main','completed_tournament', $data);		
			
		} else {		
			redirect('login');
		}
	
	}

	function megacompleted($page=0) { 
		$data = array();
		$user_role = $this->session->userdata('user_role');
		if($user_role  == 2) {	
			//pagination configurations
			
			$this->load->library('pagination');
			$this->load->model('Tournamentmodel');
			$config['total_rows'] = count( $this->Tournamentmodel->get_mega_cmp_tournament_list());			
			$config['base_url'] = base_url()."admin/megacompleted/";
			$config['uri_segment'] = 3;			
			$this->pagination->initialize($config);
			
			$this->template->set('nav_act','tournament');
			$this->template->set('title',PAGE_TITLE_CMP_TOURNAMENT);		
			$data['tournament_active_link'] = 'mega';
			$data['sub_tournament_active_link'] = 'completed';
			$data['tournament_list'] = $this->Tournamentmodel->get_mega_cmp_tournament_list($this->config->item('per_page'),$page);
			$data['page'] = $page;
			//$data['mini_cmp_tournament_list'] = $this->Tournamentmodel->get_mini_cmp_tournament_list();
			$this->template->load('main','tournamentlist', $data);		
			
		} else {		
			redirect('login');
		}	
	}

	function megaoff($page=0){
		$data = array();
		$user_role = $this->session->userdata('user_role');
		if($user_role  == 2) {	
		
		//pagination configurations
			
			$this->load->library('pagination');
			$this->load->model('Tournamentmodel');
			$config['total_rows'] = count($this->Tournamentmodel->get_mega_off_tournament_list());			
			$config['base_url'] = base_url()."admin/megaoff/";
			$config['uri_segment'] = 3;			
			$this->pagination->initialize($config);
			
			$this->template->set('nav_act','tournament');
			$this->template->set('title',PAGE_TITLE_OFF_TOURNAMENT);		
			$data['tournament_active_link'] = 'mega';
			$data['sub_tournament_active_link'] = 'off';
			//$data['mega_cmp_tournament_list'] = $this->Tournamentmodel->get_mega_cmp_tournament_list();
			$data['tournament_list'] = $this->Tournamentmodel->get_mega_off_tournament_list($this->config->item('per_page'),$page);
			$data['page'] = $page;
			$this->template->load('main','tournamentlist', $data);		
			
		} else {		
			redirect('login');
		}		
	}
	
	function minioff($page=0){
		$data = array();
		$user_role = $this->session->userdata('user_role');
		if($user_role  == 2) {

			//pagination configurations
			
			$this->load->library('pagination');
			$this->load->model('Tournamentmodel');
			$config['total_rows'] = count($this->Tournamentmodel->get_mini_off_tournament_list());			
			$config['base_url'] = base_url()."admin/minioff/";
			$config['uri_segment'] = 3;			
			$this->pagination->initialize($config);
					
			$this->template->set('nav_act','tournament');
			$this->template->set('title',MINI_TITLE_OFF_TOURNAMENT);		
			$data['tournament_active_link'] = 'mini';
			$data['sub_tournament_active_link'] = 'off';
			//$data['mega_cmp_tournament_list'] = $this->Tournamentmodel->get_mega_cmp_tournament_list();
			$data['tournament_list'] = $this->Tournamentmodel->get_mini_off_tournament_list($this->config->item('per_page'),$page);
			$data['page'] = $page;
			$this->template->load('main','tournamentlist', $data);		
			
		} else {		
			redirect('login');
		}	
	}
	
	function minicompleted($page=0) { 
		$data = array();
		$user_role = $this->session->userdata('user_role');
		if($user_role  == 2) {	
		
			//pagination configurations
			
			$this->load->library('pagination');
			$this->load->model('Tournamentmodel');
			$config['total_rows'] = count($this->Tournamentmodel->get_mini_cmp_tournament_list());			
			$config['base_url'] = base_url()."admin/minicompleted/";
			$config['uri_segment'] = 3;			
			$this->pagination->initialize($config);
			
			$this->template->set('nav_act','tournament');
			$this->template->set('title',MINI_TITLE_CMP_TOURNAMENT);		
			$data['tournament_active_link'] = 'mini';
			$data['sub_tournament_active_link'] = 'completed';
			//$data['mega_cmp_tournament_list'] = $this->Tournamentmodel->get_mega_cmp_tournament_list();
			$data['tournament_list'] = $this->Tournamentmodel->get_mini_cmp_tournament_list($this->config->item('per_page'),$page);
			$data['page'] = $page;
			$this->template->load('main','tournamentlist', $data);		
			
		} else {		
			redirect('login');
		}	
	}
	
	function addtournament()
	{ 
		$data = array();
		$data['type'] = 'create'; 
		$data['page'] = '';
		if($this->who_is_logged_in($this->userrole)){			
			$this->template->set('title',PAGE_TITLE_ADD_TOURNAMENT);
			$this->template->set('nav_act','tournament');
			$this->template->load('main','addtournament',$data);

		}else{
			redirect('login');
		}
	}
	
	function edittournament($id,$page)
	{
		$data = array();
		if($this->who_is_logged_in($this->userrole)){			
			if($id){	
				$this->load->model('Tournamentmodel');
				$tournamentData = $this->Tournamentmodel->get_tournament_details($id);
				$redirect = $this->redirect_url($id);
				if(!empty($tournamentData)) {
					$active_tournament = $this->Tournamentmodel->active_tournaments($id);
					$buffer_time =  $this->config->item('buffer_time');
					if($tournamentData['status'] == 2) { 
						$this->session->set_flashdata(array('msg'=>TOURNAMENT_COMPLETED, 'type'=>'error'));
						redirect($redirect.'/'.$page);
					} else if($tournamentData['status'] == 3) {
						$this->session->set_flashdata(array('msg'=>TOURNAMENT_ACTIVE_CAN_NOT_EDIT, 'type'=>'error'));
						redirect($redirect.'/'.$page);
					}						
					else {
					
						if($buffer_time > $active_tournament && $tournamentData['type'] == 1 && $tournamentData['status'] != 0) {
							$this->session->set_flashdata(array('msg'=>TOURNAMENT_COMPLETED, 'type'=>'error'));
							redirect($redirect.'/'.$page);
						} else {
							$data['tournamentData'] = $tournamentData;
							$data['tournament_id'] = $id;
							$data['type'] = 'edit';
							$data['page'] = $page;
							$this->template->set('title',PAGE_TITLE_EDIT_TOURNAMENT);
							$this->template->set('nav_act','tournament');
							$this->template->load('main','addtournament',$data);					
						}
					}					
				}else{
					$this->session->set_flashdata(array('msg'=>TOURNAMENT_NOT_FOUND, 'type'=>'error'));
					redirect($redirect.'/'.$page);
				}
				
			}else{
				redirect('tournament/tournamentlisting');
			}
		}else{
			redirect('login');
		}
	}
	
	function inserttournament()
	{
		$data = array();
		if($this->who_is_logged_in($this->userrole)){
			$post = $this->input->post(null,true);	
			$this->load->model('Psvalidation');
			if(isset($post['type']) && $post['type'] == 2) {
				
				$post['year'] = gmdate('Y');
				$post['month'] = gmdate('m');
				$post['day'] = gmdate('d');
				$post['time'] = gmdate('H:i');
 				$config = $this->Psvalidation->tournamentAddMini();
			}else {
				$config = $this->Psvalidation->tournamentAdd();
			}
			//echo "gmdate() :".gmdate('Y') ."  date : ".date("Y-m-d H:i:s") . "<br>gmdate: ".gmdate('m')."<br>".gmdate('d') ."gmdate" .gmdate('H:i')."actuall time".date('H:i');die;
			$this->form_validation->set_rules($config);
			if ($this->form_validation->run() == FALSE)
			{	
				$this->load->model('Tournamentmodel');
				$tournamentData = $this->Tournamentmodel->get_tournament_details($post['id']);
				$data['tournamentData'] = $tournamentData;
				$data['tournament_id'] = $post['id'];
				$data['type'] = 'create';		
				$this->template->set('title',PAGE_TITLE_EDIT_TOURNAMENT);
				$this->template->set('nav_act','tournament');
				$this->template->load('main','addtournament',$data);
			}else{				
				
				$post['date'] = $post['year'].'-'.$post['month'].'-'.$post['day'];				
				$post['type'] = $this->input->post('type',true);
				$this->load->model('Imagemodel');					
				$img1 = $this->Imagemodel->prizeimg('1');
				$img2 = $this->Imagemodel->prizeimg('2');
				$img3 = $this->Imagemodel->prizeimg('3');
				if($img1['success']){
					$post['prize_img1'] = $img1['result']['thumb'];
					$post['prize_img2'] = $img2['result']['thumb'];
					$post['prize_img3'] = $img3['result']['thumb'];
					$redirect = 'tournament/tournamentlisting';
					$create = $this->Adminmodel->createtournament($post);
					if($create){			
						//echo 'create is :'.$create;
						$redirect = $this->redirect_url($create);
						//echo "<br>redirect is ; ".$redirect;die;
						$this->session->set_flashdata(array('msg'=>TOUR_CREATE_SUCCESS, 'type'=>'success'));
					}else{
						$this->session->set_flashdata(array('msg'=>TOUR_CREATE_FAILURE, 'type'=>'error'));
					}

					//$this->output->enable_profiler(TRUE);
					redirect($redirect);
				}else{
					$this->session->set_flashdata(array('msg'=>$img1['result'], 'type'=>'error'));
					redirect('tournament/tournamentlisting');
				}
			}
		}else{
			redirect('login');
		}
	}

	function updatetournament()
	{
		$data = array();
		if($this->who_is_logged_in($this->userrole)){
			$post = $this->input->post(null,true);
			$this->load->model('Psvalidation');
			if(isset($post['type']) && $post['type'] ==2) {
				$post['year'] = gmdate('Y');
				$post['month'] = gmdate('m');
				$post['day'] = gmdate('d');
				$post['time'] = gmdate('H:i');
 				$config = $this->Psvalidation->tournamentAddMini();
			}else {
				$config = $this->Psvalidation->tournamentAdd();
			}			
			$this->form_validation->set_rules($config);
		
			if ($this->form_validation->run() == FALSE)
			{					
				$this->load->model('Tournamentmodel');
				$tournamentData = $this->Tournamentmodel->get_tournament_details($post['id']);
				$data['tournamentData'] = $tournamentData;
				$data['tournament_id'] = $post['id'];
				$data['type'] = 'edit';				
				$this->template->set('title',PAGE_TITLE);
				$this->template->set('nav_act','tournament');
				$this->template->load('main','addtournament',$data);
				//$this->output->enable_profiler(TRUE);
			}else{	
				// load Tournament model
				$this->load->model('Tournamentmodel');				
				$tournamentData = $this->Tournamentmodel->get_tournament_details($post['id']);
				$active_tournament = $this->Tournamentmodel->active_tournaments($post['id']);
				$buffer_time =  $this->config->item('buffer_time');
				$redirect = $this->redirect_url($post['id']);
				$post['date'] = $post['year'].'-'.$post['month'].'-'.$post['day'];				
				$post['type'] = $this->input->post('type',true);
				$this->load->model('Imagemodel');					
				$img1 = $this->Imagemodel->prizeimg('1');
				$img2 = $this->Imagemodel->prizeimg('2');
				$img3 = $this->Imagemodel->prizeimg('3');
				if($img1['success']){
					$post['prize_img1'] = isset($img1['result']['thumb']) ? $img1['result']['thumb'] : '';
					$post['prize_img2'] = isset($img2['result']['thumb']) ? $img2['result']['thumb'] : '';
					$post['prize_img3'] = isset($img3['result']['thumb']) ? $img3['result']['thumb'] : '';
					if($buffer_time > $active_tournament && $tournamentData['type'] == 1 && $tournamentData['status'] != 0) {
							$this->session->set_flashdata(array('msg'=>TOURNAMENT_ACTIVE_CAN_NOT_EDIT, 'type'=>'error'));
							redirect($redirect);
					}
					else if($tournamentData['status'] == 3) {
							$this->session->set_flashdata(array('msg'=>TOURNAMENT_ACTIVE_CAN_NOT_EDIT, 'type'=>'error'));
							redirect($redirect);
					}
					 else {
						$create = $this->Adminmodel->updatetournament($post);
						$redirect = $this->redirect_url($post['id']);
						if($create)
						{					
							$this->session->set_flashdata(array('msg'=>TOUR_UPDATE_SUCCESS, 'type'=>'success'));
						}else{
							$this->session->set_flashdata(array('msg'=>TOUR_UPDATE_FAILURE, 'type'=>'error'));
						}
						//$this->output->enable_profiler(TRUE);
						redirect($redirect);
					}
				}else{
					$this->session->set_flashdata(array('msg'=>$img['result'], 'type'=>'error'));
					redirect($redirect);
				}
			}
		}else{
			redirect('login');
		}
	}

	function deletetournament($id,$page) {
	
		$data = array();	
		if($this->who_is_logged_in($this->userrole)){
			if($id){
				$this->load->model('Tournamentmodel');
				$this->load->model('Adminmodel');
				$tournamentdetails = $this->Tournamentmodel->get_tournament_details($id);
				/*echo '<pre>';
				print_r($tournamentdetails);
				echo '</pre>';die;*/
				$active_tournament = $this->Tournamentmodel->active_tournaments($id);
				$buffer_time =  $this->config->item('buffer_time');
				$redirect = $this->redirect_url($id);
				if($buffer_time > $active_tournament && $tournamentdetails['type'] == 1 && $tournamentdetails['status'] == 1 && $tournamentdetails['total_participants'] > 2 && $active_tournament > -1) {
					$this->session->set_flashdata(array('msg'=>TOURNAMENT_ACTIVE_CAN_NOT_DELETE, 'type'=>'error'));
					redirect($redirect.'/'.$page);
				} 
				else if($tournamentdetails['status'] == 3)  {
					$this->session->set_flashdata(array('msg'=>TOURNAMENT_ACTIVE_CAN_NOT_DELETE, 'type'=>'error'));
					redirect($redirect.'/'.$page);
				} 
				else if(!empty($tournamentdetails)) {				
					if($this->Adminmodel->tournamentDelete($id))
					{
						$this->session->set_flashdata(array('msg'=>TOURNAMENT_DELETE_SUCCESS, 'type'=>'success'));
					}else{
						$this->session->set_flashdata(array('msg'=>TOURNAMENT_DELETE_FAILURE, 'type'=>'error'));
					}
					redirect($redirect.'/'.$page);
				}else{
					$this->session->set_flashdata(array('msg'=>TOURNAMENT_TYPE_MINI, 'type'=>'error'));
					redirect($redirect.'/'.$page);
				}
			}else{
				redirect('tournament/tournamentlisting');
			}
		}else{
			redirect('login');
		}
	}
	
	//delete tournament from completed tournament page 
	function deletecmptournament($id) {
	
		$data = array();	
		if($this->who_is_logged_in($this->userrole)){
			if($id){
				$this->load->model('Tournamentmodel');
				$this->load->model('Adminmodel');
				$tournamentdetails = $this->Tournamentmodel->get_tournament_details($id);
				$active_tournament = $this->Tournamentmodel->active_tournaments($id);
				$buffer_time =  $this->config->item('buffer_time');
				$redirect = $this->redirect_url($id);
				if($buffer_time > $active_tournament && $tournamentdetails['type'] == 1 && $tournamentdetails['status'] == 1 && $active_tournament >=0 ) {
					$this->session->set_flashdata(array('msg'=>TOURNAMENT_ACTIVE_CAN_NOT_DELETE, 'type'=>'error'));
					redirect($redirect);
				} 
				else if($tournamentdetails['status'] == 3)  {
					$this->session->set_flashdata(array('msg'=>TOURNAMENT_ACTIVE_CAN_NOT_DELETE, 'type'=>'error'));
					redirect($redirect);
				} 
				else if(!empty($tournamentdetails)) {				
					if($this->Adminmodel->tournamentDelete($id))
					{
						$this->session->set_flashdata(array('msg'=>TOURNAMENT_DELETE_SUCCESS, 'type'=>'success'));
					}else{
						$this->session->set_flashdata(array('msg'=>TOURNAMENT_DELETE_FAILURE, 'type'=>'error'));
					}
					redirect('admin/completed/'.$page);
				}else{
					$this->session->set_flashdata(array('msg'=>TOURNAMENT_TYPE_MINI, 'type'=>'error'));
					redirect($redirect);
				}
			}else{
				redirect('admin/completed');
			}
		}else{
			redirect('login');
		}
	}
	
	
	function users($page=0)
	{
		$data = array();
		if($this->who_is_logged_in($this->userrole)){
			$this->load->model('Usermodel');
			 $this->load->library('pagination');
				//pagination configurations
			$config['total_rows'] = count( $this->Usermodel->userList());			
			$config['base_url'] = base_url()."admin/users/";
			$config['uri_segment'] = 3;			
			$this->pagination->initialize($config);
			
			$data['current_user_role'] = "user";
			$data['users'] = $this->Usermodel->userList($this->config->item('per_page'),$page);
			$data['page'] = $page;			
			$this->template->set('title',PAGE_TITLE);
			$this->template->set('nav_act','users');
			if(count($data['users']) > 0){
				$this->template->load('main','users',$data);
			}else if(count($data['users']) == 0 && $page==0){
				$this->template->load('main','users',$data);			
			}else{
				redirect('admin/users/'.$page); 
			}			
		}else{
			redirect('login');
		}		
	}
	
	function adminusers($page=0)
	{
		$data = array();
		if($this->who_is_logged_in($this->userrole)){
			$this->load->model('Usermodel');
			 $this->load->library('pagination');
				//pagination configurations
			$config['total_rows'] = count( $this->Usermodel->adminuserList());			
			$config['base_url'] = base_url()."admin/adminusers/";
			$config['uri_segment'] = 3;			
			$this->pagination->initialize($config);
			
			$data['current_user_role'] = "admin";
			$data['users'] = $this->Usermodel->adminuserList($this->config->item('per_page'),$page);
			$data['page'] = $page;			
			$this->template->set('title',PAGE_TITLE);
			$this->template->set('nav_act','users');
			if(count($data['users']) > 0){
				$this->template->load('main','users',$data);
			}else if(count($data['users']) == 0 && $page==0){
				$this->template->load('main','users',$data);			
			}else{
				redirect('admin/users/'.$page); 
			}			
		}else{
			redirect('login');
		}		
	}
	
	function edituser($id,$page=0)
	{		
		$data = array();
		if($this->who_is_logged_in($this->userrole)){
			if($id){
				$this->load->model('Usermodel');
				$userid = $this->Usermodel->userDetails($id,'id');
				if($userid){
					$user = $this->Usermodel->userDetails($id);
					$data['username'] = $user['username'];
					$data['name'] = $user['name'];
					$data['email'] = $user['email'];
					$data['id'] = $user['id']; 
					$data['img'] = $user['profileimg']; 					
					$data['page'] = $page; 
					$data['user_role'] = $user['user_role'];
					$this->template->set('title',PAGE_TITLE);
					$this->template->set('nav_act','users');
					$this->template->load('main','edit_profile',$data);
				}else{
					$this->session->set_flashdata(array('msg'=>USER_NOT_EXISTS, 'type'=>'error'));
					redirect('admin/users/'.$page);
				}
			}else{
				redirect('admin/users'.$page);
			}
		}else{
			redirect('login');
		}		
	}
	
	function userdelete($id, $page=0)
	{	
		$data = array();	
		if($this->who_is_logged_in($this->userrole)){
			if($id){
				$current_user_role = get_user_role($id);
				if($current_user_role == 2){
					$redirect  = 'admin/adminusers/'.$page;
				}else{
					$redirect  = 'admin/users/'.$page;
				}
				$this->load->model('Usermodel');
				$userid = $this->Usermodel->userDetails($id,'id');
				if($userid){
					if($this->Usermodel->userDelete($id))
					{
						$this->session->set_flashdata(array('msg'=>USER_DELETE_SUCCESS, 'type'=>'success'));
					}else{
						$this->session->set_flashdata(array('msg'=>USER_DELETE_FAILURE, 'type'=>'error'));
					}
					redirect($redirect);
				}else{
					$this->session->set_flashdata(array('msg'=>USER_NOT_EXISTS, 'type'=>'error'));
					redirect($redirect);
				}
			}else{
				redirect($redirect);
			}
		}else{
			redirect('login');
		}
	}
	
	function createadmin(){
		$data = array();
		if($this->who_is_logged_in($this->userrole)){
			$data['username'] = '';
			$data['name'] = '';
			$data['email'] = '';
			$data['confirm_email'] = '';
			$data['password'] = '';
			$data['confirm_password'] = '';
			$data['current'] = 'admin';
			$this->template->set('title',PAGE_ADMIN_TITLE_REGISTER);
			$this->template->load('main','register',$data);
		}else{
			redirect('login');
		}
	}
	
	function reg_insert()
	{
		$data = array();
		if($this->who_is_logged_in($this->userrole)){
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
				$data['current'] = 'admin';
				$this->template->set('title',PAGE_TITLE_REGISTER);
				$this->template->load('main','register',$data);
			}else{
				$this->load->model('Registermodel');
				$this->load->model('Imagemodel');
				$this->load->model('Loginmodel');
				$img = $this->Imagemodel->uploadImg();
				if($img['success'])
				{
					$post = $this->input->post(null,true);
					$post['profile_img'] = $img['result']['thumb'];
					$post['current'] = 'admin';
					$this->Registermodel->registerInsert($post);
					redirect('admin/adminusers');
				}else{
					$this->session->set_flashdata(array('msg'=>$img['result'], 'type'=>'error'));
					redirect('profile');
				}
			}
		}else{
			redirect('login');
		}
	}	
}
?>
