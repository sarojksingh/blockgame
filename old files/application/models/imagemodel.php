<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Imagemodel extends CI_Model{

	var $img_path;	
	function __construct()
	{
		parent::__construct();
		 $this->img_path = realpath(APPPATH . '../upload');
		 
	}

	function uploadImg()
	{
		$this->load->library('upload');			
		if($_FILES['profile_img']['error']==0)
		{
			$config = array(
			'allowed_types' => 'jpg|jpeg|png|gif',
			'upload_path' => $this->img_path,
			'max_size' => '2048',			
			'file_name' => time()
			);
		
			$this->upload->initialize($config);
			if ( ! $this->upload->do_upload('profile_img'))
			{
				$data = array('result' => $this->upload->display_errors('',''),'success'=>false);				
			}
			else
			{
				$data = array('result' => $this->upload->data(),'success'=>true);
				
				
				$thumb = $this->thumbCreate($data['result']['full_path'],'_99X77','99','77');				
				$data['result']['thumb'] =  $data['result']['raw_name'].'_99X77'.$data['result']['file_ext'];
				//@unlink(APPPATH.'../upload/'.$data['result']['file_name']);
			}
		}else{
			$data['result']= '';
			$data['success'] = true;
		}
		return $data;
	}

	function thumbCreate($file='',$thumb_marker='',$width='',$height='')
	{
		$config = array(
					'source_image' => $file,
					'new_image' => $this->img_path,
					'maintain_ration' => true,
					'thumb_marker' => $thumb_marker,
					'create_thumb' => true,
					'width' => $width,
					'height' => $height
				);
		$this->load->library('image_lib', $config);
		$this->image_lib->initialize($config);
		$this->image_lib->resize();		
		$this->image_lib->clear();	
		return true;
	}
	
	function prizeimg($id)
	{
		$this->load->library('upload');		
		if($_FILES['prize_picture'.$id]['error']==0)
		{
			$config = array(
			'allowed_types' => 'jpg|jpeg|png|gif',
			'upload_path' => $this->img_path,
			'max_size' => '2048',			
			'file_name' => time()
			);
		
			$this->upload->initialize($config);
			if ( ! $this->upload->do_upload('prize_picture'.$id))
			{
				$data = array('result' => $this->upload->display_errors('',''),'success'=>false);				
			}
			else
			{
				$data = array('result' => $this->upload->data(),'success'=>true);
				$thumb = $this->thumbCreate($data['result']['full_path'],'__prize_img'.$id.'_156X156','156','156');
				$data['result']['thumb'] =  $data['result']['raw_name'].'__prize_img'.$id.'_156X156'.$data['result']['file_ext'];
				@unlink(APPPATH.'../upload/'.$data['result']['file_name']);
			}
		}else{
			$data['result']= '';
			$data['success'] = true;
		}
		return $data;
	}	
}
?>
