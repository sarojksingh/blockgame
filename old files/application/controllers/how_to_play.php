<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class How_to_play extends MY_Controller{
	
	function __construct()
	{
		parent::__construct();
		$this->template->set('nav_act','how_to_play');
	}
	function index()
	{	$data = array();		
		$this->template->set('title',PAGE_TITLE_HOW_TO_PLAY);
		$this->template->load('main','how_to_play', $data);
	}	
	
}
?>
