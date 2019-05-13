<?php
require_once __DIR__.'/php-rest-api-master/autoload.php';

	$api_credentials = $_REQUEST['api_key'];
	$sms_sender = $_REQUEST['sender_name'];
	
if(isset($_REQUEST['number'])){
	
$phone = $_REQUEST['number'];	
$code = $_REQUEST['code'];	
$ccookie_code = setcookie('phone_otp', $code);

$messagebird = new MessageBird\Client($api_credentials);
$message = new MessageBird\Objects\Message;
$message->originator = $sms_sender;
$message->recipients = [ $phone ];
$message->body = 'Your verification code for placing order is '.$code;
$response = $messagebird->messages->create($message);
// var_dump($response);
// echo '{Number : '. $phone . ', Code : ' . $code .'}';

}


