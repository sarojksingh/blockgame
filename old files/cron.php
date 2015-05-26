<?php

//$url = "http://54.252.99.185:55555/socket.io/socket.io.js";
//$url = "http://http://54.252.230.61:55555/socket.io/socket.io.js"; 
//$url = "http://localhost:99/Game/node_modules/socket.io/node_modules/socket.io-client/socket.io.js";   //SANI: try to play on local server
$url = "http://http://localhost:55555/socket.io/socket.io.js"; 
//$url = "http://funandprizes.com.au/node_modules/socket.io/node_modules/socket.io-client/socket.io.js"; 
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
if($info['http_code'] != 200)
{
	exec("/usr/local/bin/node /var/www/html/UbontuServer.js");	
}
?>
