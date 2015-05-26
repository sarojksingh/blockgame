<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Paymentmodel extends CI_Model {
	
	var $environment;
	var $API_UserName;
	var $API_Password;
	var $API_Signature;

	function __construct()
	{
		parent::__construct();
		$this->environment = $this->config->item('pay_mode');
		$this->API_UserName = 'funandprizes_api1.hotmail.com';
		$this->API_Password = 'TLNYYPNQ92986ABK';
		$this->API_Signature = 'AFcWxV21C7fd0v3bYYYRCpSSRl31AXXetmNM8r9jRfmiKUhCsz0PnuAY';
	}

	function PPHttpPost($methodName_, $nvpStr_){
		$environment = $this->environment;
	 
		// Set up your API credentials, PayPal end point, and API version.
		$API_UserName = urlencode( $this->API_UserName );
		$API_Password = urlencode( $this->API_Password );
		$API_Signature = urlencode( $this->API_Signature );
		$API_Endpoint = "https://api-3t.paypal.com/nvp";
		if("sandbox" === $environment || "beta-sandbox" === $environment) {
			$API_Endpoint = "https://api-3t.$environment.paypal.com/nvp";
		}
		$version = urlencode('86.0');
		/*print_r($methodName_);
		print_r($API_Endpoint);
		print_r($nvpStr_);die;*/
		// Set the curl parameters.
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $API_Endpoint);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
	 
		// Turn off the server and peer verification (TrustManager Concept).
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
	 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		
		// Set the API operation, version, and API signature in the request.
		$nvpreq = "METHOD=$methodName_&VERSION=$version&PWD=$API_Password&USER=$API_UserName&SIGNATURE=$API_Signature$nvpStr_";
	 
		// Set the request as a POST FIELD for curl.
		curl_setopt($ch, CURLOPT_POSTFIELDS, $nvpreq);
	 
		// Get response from the server.
		$httpResponse = curl_exec($ch);		
		if(!$httpResponse) {
			exit("$methodName_ failed: ".curl_error($ch).'('.curl_errno($ch).')');
		}
	 
		// Extract the response details.
		$httpResponseAr = explode("&", $httpResponse);
	 
		$httpParsedResponseAr = array();
		foreach ($httpResponseAr as $i => $value) {
			$tmpAr = explode("=", $value);
			if(sizeof($tmpAr) > 1) {
				$httpParsedResponseAr[$tmpAr[0]] = $tmpAr[1];
			}
		}
	 
		if((0 == sizeof($httpParsedResponseAr)) || !array_key_exists('ACK', $httpParsedResponseAr)) {
			exit("Invalid HTTP Response for POST request($nvpreq) to $API_Endpoint.");
		}
	 
		return $httpParsedResponseAr;
	}
	
	function expressCheckout($post)
	{
		$paymentType = urlencode('Sale'); // or Authorization
		$currencyID = urlencode('AUD');
		$amount = urlencode($_POST['amount']);
		$return = $post['RETURNURL'];
		$cancel = $post['CANCELURL'];
		$itemname = $post['prize_name'];
		$desc = $post['prize_desc'];
		$nvpStr =	"&PAYMENTREQUEST_0_PAYMENTACTION=$paymentType&L_PAYMENTREQUEST_0_AMT0=$amount&L_PAYMENTREQUEST_0_NAME0=$itemname&L_PAYMENTREQUEST_0_DESC0=$desc&PAYMENTREQUEST_0_AMT=$amount&RETURNURL=$return&CANCELURL=$cancel&PAYMENTREQUEST_0_CURRENCYCODE=$currencyID";
		$httpParsedResponseAr = $this->PPHttpPost('SetExpressCheckout', $nvpStr);
		$data = $httpParsedResponseAr;
		
		return $data;
	}

	function getTransactionDetails($post)
	{
		$paymentType = urlencode('Sale');  // or Authorization
		$token = $post['token'];
		$nvpStr =	"&PAYMENTREQUEST_0_PAYMENTACTION=$paymentType&TOKEN=$token";
		$httpParsedResponseAr = $this->PPHttpPost('GetExpressCheckoutDetails', $nvpStr);
		$data = $httpParsedResponseAr;
		return $data;
	}
	function doExpressCheckout($post)
	{
		$paymentType = urlencode('Sale'); // or Authorization
		$token = urldecode($post['token']);
		$amount = urldecode($post['amount']);
		$PayerID = urldecode($post['PayerID']);
		$currencyID = 'AUD';
		$nvpStr =	"&PAYMENTREQUEST_0_PAYMENTACTION=$paymentType&PAYERID=$PayerID&TOKEN=$token&PAYMENTREQUEST_0_AMT=$amount&PAYMENTREQUEST_0_CURRENCYCODE=$currencyID";
		$httpParsedResponseAr = $this->PPHttpPost('DoExpressCheckoutPayment', $nvpStr);
		$data = $httpParsedResponseAr;
		return $data;
	}

	function savepaymentdetails($post) {
		
		if($this->db->insert('payments', $post)) {
			return true;
		} else {
			return false;
		}
		
	}

	function pay_paypal($post)
	{	
		
		//$firstName = $_SWIFT->User->GetProperty('fullname');
		// Set request-specific fields.
		$paymentType = urlencode('Sale');				// or 'Authorization'

		$lastName = '';
		$creditCardType = urlencode($_POST['cardtype']);
		$creditCardNumber = urlencode($_POST['creditcardnumber']);
		$expDateMonth = $_POST['expdatemonth'];
		// Month must be padded with leading zero
		$padDateMonth = urlencode(str_pad($expDateMonth, 2, '0', STR_PAD_LEFT));
		 
		$expDateYear = urlencode($_POST['expdateyear']);
		$cvv2Number = urlencode($_POST['cvvnumber']);
		$address1 = urlencode($_POST['address1']);
		//$address2 = urlencode('customer_address2');
		$city = urlencode($_POST['city']);
		$state = urlencode($_POST['state']);
		$zip = urlencode($_POST['zip']);
		//$country = urlencode($this->get_country_iso_code('US'));		// US or other valid country code
		$country = urlencode($_POST['country']);		// US or other valid country code
		//$amount = urlencode($this->encrypt->decode(100));
		$amount = urlencode($_POST['amount']);
		//$currencyID = urlencode($this->encrypt->decode('USD'));				// or other currency ('GBP', 'EUR', 'JPY', 'CAD', 'AUD')
		$currencyID = 'USD';
		 // Add request-specific fields to the request string.
		$nvpStr =	"&PAYMENTACTION=$paymentType&AMT=$amount&CREDITCARDTYPE=$creditCardType&ACCT=$creditCardNumber".
		"&EXPDATE=$padDateMonth$expDateYear&CVV2=$cvv2Number&FIRSTNAME=$firstName&LASTNAME=$lastName".
		"&STREET=$address1&CITY=$city&STATE=$state&ZIP=$zip&COUNTRYCODE=$country&CURRENCYCODE=$currencyID";
		
		// Execute the API operation; see the PPHttpPost function above.
		$httpParsedResponseAr = $this->PPHttpPost('DoExpressCheckoutPayment', $nvpStr);
		$data = $httpParsedResponseAr;	

		return $data;
	}
}