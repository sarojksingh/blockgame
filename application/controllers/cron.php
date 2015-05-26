<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cron extends MY_Controller{	
	
	function __construct()
	{
		parent::__construct();											
	}
	

	function checkresponse($url="http://110.234.223.202:22222/socket.io/socket.io.js")
    {
           //check, if a valid url is provided
           if(!filter_var($url, FILTER_VALIDATE_URL))
           {
               return 'URL provided wasn\'t valid';
           }
			$options = array(CURLOPT_URL => $url,CURLOPT_POSTFIELDS => 'para=1',CURLOPT_HEADER=>0,CURLOPT_RETURNTRANSFER=>0,CURLOPT_TIMEOUT=>30);
			$ch = curl_init();
			curl_setopt_array($ch, $options);
			curl_exec($ch);
			$info = curl_getinfo($ch);
			curl_close($ch); 
           //make the connection with curl

			if($info['http_code']!=200)
			{
				echo "hello";
				echo exec("node /home/govind/node_modules/Local.js");
			}
			// execute
			
			//return $this->http_response_code($info['http_code']);
    }
}
?>
