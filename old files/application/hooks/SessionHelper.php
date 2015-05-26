<?php
class SessionHelper extends CI_Hooks{
  public $CI;
 
  function __construct()
  {
    parent::__construct();
    $this->CI = get_instance();
    $this->CI->load->helper('url');
  }
 
  function checkUserStatus()
  {
	 
     $url = current_url();
	 $id = $this->CI->session->userdata('id');
	 if($id){
		 $query = $this->CI->db->get_where('user',array('id'=>$id));		
		 if($query->num_rows()==0){			
			$newdata = array(
				'id' => '',
			   'email'  => '',
			   'user_role' => '',
				'name' => '',
				'username' => '',
				'account_balance' => '',
			   'logged_in' => false
			);	
			$this->CI->session->unset_userdata($newdata);			
			$this->CI->session->set_flashdata(array('msg'=> 'Your account is deleted','type'=>'error'));
			echo '<script>top.window.location.href="'.site_url().'";</script>';
		 }
	 }
  }  
}
?>
