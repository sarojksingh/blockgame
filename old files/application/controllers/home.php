<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Home extends MY_Controller{
	
	function __construct()
	{
		parent::__construct();
		$this->template->set('nav_act','home');
	}
	function index()
	{
		$data = array();		
		$this->template->set('title',PAGE_TITLE);
		$this->template->load('main','home', $data);
	}
	
	function sitemap()
	{		
		$data = array();		
		$this->template->set('nav_act','sitemap');
		$this->template->set('title',PAGE_TITLE_SITEMAP);
		$this->template->load('main','sitemap', $data);
	}

	function termsandconditions()
	{		
		$data = array();		
		$this->template->set('nav_act','termsandconditions');
		$this->template->set('title',PAGE_TITLE_TERMSANDCONDITION);
		$this->template->load('main','termsandconditions', $data);
	}

	function disclaimer()
	{		
		$data = array();		
		$this->template->set('nav_act','diclaimer');
		$this->template->set('title',PAGE_TITLE_DISCLAIMER);
		$this->template->load('main','disclaimer', $data);
	}

	function privacypolicy()
	{		
		$data = array();		
		$this->template->set('nav_act','privacypolicy');
		$this->template->set('title',PAGE_TITLE_PRIVACYPOLICY);
		$this->template->load('main','privacypolicy', $data);
	}
	
}
?>
