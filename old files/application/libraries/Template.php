<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Template {
		var $template_data = array();
		
		function set($name, $value)
		{
			$this->template_data[$name] = $value;
		}
	
		function load($template = '', $view = '' , $view_data = array(), $return = FALSE)
		{       
			$this->CI =& get_instance();

			$msg = $this->CI->session->flashdata('msg');
			$this->set('msg', $msg);
			
			$type = $this->CI->session->flashdata('type');
			$this->set('type', $type);

			$user_role = $this->CI->session->userdata('user_role');
			$this->set('user_role', $user_role);

			$user_id = $this->CI->session->userdata('id');
			$this->set('user_id', $user_id);

			$logged_in = $this->CI->session->userdata('logged_in');
			$this->set('logged_in', $logged_in);
			
			$this->set('contents', $this->CI->load->view($view, $view_data, TRUE));			
			return $this->CI->load->view($template, $this->template_data, $return);
		}
}

/* End of file Template.php */
/* Location: ./system/application/libraries/Template.php */
