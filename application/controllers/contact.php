<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Contact extends MY_Controller{
	
	function __construct()
	{
		parent::__construct();
		$this->template->set('nav_act','');
			/* $config = array(
		'protocol' => 'smtp',
		'smtp_host' => 'ssl://smtp.googlemail.com',
		'smtp_port' => '465',
		'smtp_user' => '',
		'smtp_pass' => ''
		);*/		
		$this->load->library('email');
		

	}
	function index()
	{	$data = array();		
		$this->template->set('title',PAGE_TITLE_CONTACT);
		$this->template->set('nav_act','contact');
		$this->template->load('main','contact', $data);
	}	
	function sendEmail()
	{	$data = array();	
	    $name=$this->input->post('name');
		$email=$this->input->post('email');
		$message=$this->input->post('message');		
		$adminemail=$this->config->item('admin_email');		
		$message="NAME: $name<br>
		MESSAGE: $message
		<br><br>Thanks<br>
		BLOCKERS";		
		if ($this->sendEmailContact($adminemail,$email,$name,'BLOCKERS: Contact support',$message,'html')) {
		
		$this->session->set_flashdata(array('msg'=>'Your enquiry has been successfully sent to Admin. Admin will contact you soon.', 'type'=>'success'));
		} else {
		
		$this->session->set_flashdata(array('msg'=>'Please try again later or contact to site Admin.', 'type'=>'error'));
		}
			
		$this->template->set('title',PAGE_TITLE_CONTACT);
		$this->template->set('nav_act','contact');
		$this->template->load('main','contact', $data);
		redirect('contact');
		
	}
	public function sendEmailContact($to, $from, $fromName, $subject, $message, $mailtype) {
		$this->load->library('email');

		$config['mailtype']= ($mailtype) ? 'html' : 'text';
		$this->email->initialize($config);
		$this->email->from($from, $fromName);
		$this->email->to($to);
		//$this->email->cc('another@another-example.com');
		//$this->email->bcc('them@their-example.com');

		$this->email->subject($subject);
		$this->email->message($message);
		if($this->email->send()) {			
			return true;
		}
		else {			
			return false;
		}
		//echo $this->email->print_debugger();	
	}
	
}
?>
