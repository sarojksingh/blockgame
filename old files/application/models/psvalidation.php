<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Psvalidation extends CI_Model{
	public $data;

	function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
	}
	
	function register()
	{
		$config = array(
               array(
                     'field'   => 'name',
                     'label'   => 'Name',
                     'rules'   => 'trim|required|xss_clean'
                  ),             
               
                 array(
                     'field'   => 'username',
                     'label'   => 'User Name',
                     'rules'   => 'trim|required|is_unique[user.username]|xss_clean'
                  ),
			   array(
                     'field'   => 'email',
                     'label'   => 'Email',
                     'rules'   => 'trim|required|matches[confirm_email]|valid_email|is_unique[user.email]|xss_clean'
                  ),
			   array(
                     'field'   => 'password',
                     'label'   => 'Password',
                     'rules'   => 'trim|required|xss_clean|matches[confirm_password]|min_length[6]'
                  )
            );
		$this->data = $config;
		return $this->data;
	}
	
	function login()
	{
		$config = array(                  
               
                 array(
                     'field'   => 'username',
                     'label'   => 'User Name',
                     'rules'   => 'trim|required|xss_clean'
                  ),
			    array(
                     'field'   => 'password',
                     'label'   => 'Password',
                     'rules'   => 'trim|required|xss_clean'
                  )
            );
		$this->data = $config;
		return $this->data;
	}	
	
	function profileUpdate()
	{
		$config = array(
               array(
                     'field'   => 'name',
                     'label'   => 'Name',
                     'rules'   => 'trim|required|xss_clean'
                  ),                              
			   array(
                     'field'   => 'email',
                     'label'   => 'Email',
                     'rules'   => 'trim|required|valid_email|xss_clean|callback_validate_email'
                  )			 
            );
        $post = $this->input->post(null,true);
        if(!empty($post['password']) || !empty($post['confirm_password']))
        {
		$config[2] =   array(
                     'field'   => 'password',
                     'label'   => 'Password',
                     'rules'   => 'trim|required|xss_clean|matches[confirm_password]|min_length[6]'
                  );	
		}
		$this->data = $config;
		return $this->data;
	}
	
	function tournamentAdd()
	{
		$config = array(
               array(
                     'field'   => 'type',
                     'label'   => 'Tournament type',
                     'rules'   => 'trim|required|xss_clean'
                  ),             
				 array(
                     'field'   => 'day',
                     'label'   => 'Day',
                     'rules'   => 'trim|required|xss_clean'
                  ),
                 array(
                     'field'   => 'month',
                     'label'   => 'Month',
                     'rules'   => 'trim|required|xss_clean'
                  ),
                  array(
                     'field'   => 'year',
                     'label'   => 'Year',
                     'rules'   => 'trim|required|xss_clean'
                  ),
                   array(
                     'field'   => 'time',
                     'label'   => 'Time',
                     'rules'   => 'trim|required|xss_clean'
                  ),
                   array(
                     'field'   => 'cost',
                     'label'   => 'Cost',
                     'rules'   => 'trim|required|xss_clean'
                  ),
                   array(
                     'field'   => 'prize_name',
                     'label'   => 'Prize name',
                     'rules'   => 'trim|required|xss_clean'
                  ),
                   array(
                     'field'   => 'prize_desc',
                     'label'   => 'Prize description',
                     'rules'   => 'trim|required|xss_clean'
                  ),			  
            );
		$this->data = $config;
		return $this->data;
	}
	
	function tournamentAddMini() {
		$config = array(
               array(
                     'field'   => 'type',
                     'label'   => 'Tournament type',
                     'rules'   => 'trim|required|xss_clean'
                  ),			 
                  array(
                     'field'   => 'cost',
                     'label'   => 'Cost',
                     'rules'   => 'trim|required|xss_clean'
                  ),
                   array(
                     'field'   => 'prize_name',
                     'label'   => 'Prize name',
                     'rules'   => 'trim|required|xss_clean'
                  ),
                   array(
                     'field'   => 'prize_desc',
                     'label'   => 'Prize description',
                     'rules'   => 'trim|required|xss_clean'
                  ),
				 array(
                     'field'   => 'no_of_tournaments',
                     'label'   => 'No. of tournaments',
                     'rules'   => 'trim|xss_clean|integer'
                  ),
            );
		$this->data = $config;
		return $this->data;
	
	}
}
?>
