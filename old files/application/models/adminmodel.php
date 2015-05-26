<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Adminmodel extends CI_Model{
	
	function __construct()
	{
		parent::__construct();
	}

	function createtournament($post)
	{
		if($post['no_of_tournaments']){
			for($i = 0;$i<$post['no_of_tournaments'];$i++){
				$insert = array(
					'type' => $post['type'],
					'cost' => $post['cost'],
					'prize_name'=> $post['prize_name'],
					'prize_desc'=>$post['prize_desc'],
					'prize_img1' =>$post['prize_img1'],
					'prize_img2' =>$post['prize_img2'],
					'prize_img3' =>$post['prize_img3'],					
					'date'=>$post['date'],
					'time'=>$post['time']
				);
				if(isset($post['current_status'])){
					$insert['status'] = $post['current_status'];
				}else{
					$insert['status'] = 1;
				}
				if($i == 0){
					$insert['tournament_name'] = $post['tournament_name'];
				}else{
					$insert['tournament_name'] = $post['tournament_name']."(".$i.")";
				}
				$ctr = $this->db->insert('tournament',$insert);
				$ctr = $this->db->insert_id();
			}
		}else{
				$insert = array(
					'tournament_name' => $post['tournament_name'],
					'type' => $post['type'],
					'cost' => $post['cost'],
					'prize_name'=> $post['prize_name'],
					'prize_desc'=>$post['prize_desc'],
					'prize_img1' =>$post['prize_img1'],
					'prize_img2' =>$post['prize_img2'],
					'prize_img3' =>$post['prize_img3'],					
					'date'=>$post['date'],
					'time'=>$post['time']
				);
				if(isset($post['current_status'])){
					$insert['status'] = $post['current_status'];
				}else{
					$insert['status'] = 1;
				}
				$ctr = $this->db->insert('tournament',$insert);
				$ctr = $this->db->insert_id();
		}
		if($ctr)
		{
			return $ctr;
		}else{
			return false;
		}
	}

	function updatetournament($post)
	{
		$update = array(
			'type' => $post['type'],
			'cost' => $post['cost'],
			'tournament_name' => $post['tournament_name'],
			'prize_name'=> $post['prize_name'],
			'prize_desc'=>$post['prize_desc'],			
			'date'=>$post['date'],
			'time'=>$post['time']			
		);
		if(isset($post['current_status'])){
			$update['status'] = $post['current_status'];
		}else{
			$update['status'] = 1;
		}
		if(isset($post['prize_img1']) && $post['prize_img1'] !="") {
			$update['prize_img1'] = $post['prize_img1'];
		}
		if(isset($post['prize_img2']) && $post['prize_img2'] !="") {
			$update['prize_img2'] = $post['prize_img2'];
		}
		if(isset($post['prize_img3']) && $post['prize_img3'] !="") {
			$update['prize_img3'] = $post['prize_img3'];
		}
		
		$this->db->where('id', $post['id']);
		if($this->db->update('tournament',$update))
		{
			return true;
		}else{
			return false;
		}
	}

	function tournamentDelete($id) {
		$this->db->where('id',$id);
		if($this->db->delete('tournament'))
		{
			return true; 
		}else{
			return false;
		}
	}
}
?>
