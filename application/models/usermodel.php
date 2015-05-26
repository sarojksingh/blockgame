<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Usermodel extends CI_Model{
	
	function __construct()
	{
		parent::__construct();
	}

	function userDetails($id, $param='')
	{
		if($param)
		{
			$this->db->select($param);
		}
		$this->db->where('id',$id);
		$query = $this->db->get('user');
		if($param)
		{
			$res = $query->row_array();
			return $res[$param];
		}else{
			return $query->row_array();
		}		
	}
	
	function save_winner($post){
		
		if(!empty($post['tournament_id']) && !empty($post['users_id']) && !empty($post['winner_id']) && !empty($post['round']))
		{
			if($this->db->insert('tournament_match',$post))
			{
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	
	function userList( $limit='',$offset='')
	{
		if($limit!='' || $offset!='')
		{
			$this->db->limit($limit, $offset);
		}
		$this->db->where('user_role','1');
		//$this->db->order_by('user_role','desc');
		$this->db->order_by('username','asc');
		$query = $this->db->get('user');
		$result = $query->result();
		return $result;
	}
	
	function adminuserList( $limit='',$offset='')
	{
		if($limit!='' || $offset!='')
		{
			$this->db->limit($limit, $offset);
		}
		$this->db->where('user_role','2');
		//$this->db->order_by('user_role','desc');
		$this->db->order_by('username','asc');
		$query = $this->db->get('user');
		$result = $query->result();
		return $result;
	}

	function totalmatchwins($id) {
		//$data = array("tournament_id", "winner_id", "round");
		$this->db->from('tournament_match');
		$this->db->where('users_id', $id);
		//$this->db->group_by($data); 

		return $this->db->count_all_results();		
	}
	
	function userDelete($id)
	{
		$this->db->where('id',$id);
		if($this->db->delete('user'))
		{
			return true; 
		}else{
			return false;
		}
	}
}
?>
