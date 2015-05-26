<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function sessionData($para=null)
{
	$CI =& get_instance();
	$data = $CI->session->userdata($para);
	return $data;
}

function userData($id, $para=null)
{
	$CI =& get_instance();
	$CI->load->model('Usermodel');
	$data = $CI->Usermodel->userDetails($id,$para);
	return $data;
}

function totalmatchwins($user_id) {
	$CI =& get_instance();
	$CI->load->model('Usermodel');
	$data = $CI->Usermodel->totalmatchwins($user_id);
	return $data;
}

function tournamentData($id, $para=null)
{
	$CI =& get_instance();
	$CI->load->model('Tournamentmodel');
	$data = $CI->Tournamentmodel->get_tournament_details($id,$para);
	return $data;
}

// function to limit a string by $limit.

function limit_string($string,$limit)
{
	$short = strip_tags($string);
	$shor = explode(" ",$short);
	 if(strlen($string)>$limit){
		$split = str_split($string,$limit);
		 return $split[0].'...';
	 }
	else if(count($shor)>=$limit)
	 {
		$chunk = array_chunk($shor,$limit);
		return implode(" ",$chunk[0]).'...';
	 }
		
	else{
		return $string;
	 }
}

function nltobr($string)
{
	$order   = array("\\r\\n", "\\n", "\\r");
	$replace = '<br />';
	$newstr = str_replace($order, $replace, $string);
	$strip = stripslashes($newstr);
	return $strip;
}

function check_tournament_active($date, $time) {
		$data = array();		
		$buffer_time = isset($config['buffer_time']) ? $cofig['buffer_time'] : 15;
		$time_calibration = isset($config['time_calibration']) ? $config['time_calibration'] : 0;
		$date_time = $date . ' ' . $time;
		$date_time_stamp = strtotime($date_time);
		$date_time_now_stamp = time('now');			
		$diff_time_stamp = $date_time_stamp - $date_time_now_stamp;
		$diff_time_stamp =  ($diff_time_stamp/60) - $time_calibration;	
		if($diff_time_stamp <= $buffer_time && $diff_time_stamp >=0) {
			//$data['']
			return true;
		} else {
			return false;
		}
		
	}
	
function get_user_role($id){
	$CI =& get_instance();
	$res = $CI->db->get_where('ps_user',array('id' => $id));
	$user_role = $res->row_array();
	return $user_role['user_role'];
}
?>
