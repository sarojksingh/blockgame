<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Minidelete extends CI_Controller{
	
	function __construct()
	{
		parent::__construct();
		$this->template->set('nav_act','home');
	}
	function index()
	{		
		$where = array('id'=>195);
		$this->db->where($where);
		$this->db->delete('tournament');
		
		
		$query = $this->db->get('tournament');
		$all = $query->result();
		echo '<pre>';
		print_r($all);
		echo '</pre>';
		/*
		$this->db->where($where);
		$this->db->delete('tournament');
		
		$where = array('type'=>2);
		$this->db->where($where);
		$query = $this->db->get('tournament');
		$all = $query->result();
		echo '<pre>';
		print_r($all);
		echo '</pre>';*/
	}
	
}
?>
