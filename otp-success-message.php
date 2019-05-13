<?php
require_once __DIR__.'/php-rest-api-master/autoload.php';

	$woo_setting_info = get_option('wedevs_basics_woo_otp');
	$api_credentials = $woo_setting_info['woo_otp_api'];
	$sms_sender = $woo_setting_info['sender_name'];

if(isset($_REQUEST['number']) && !isset($_REQUEST['pass']) || empty($_REQUEST['pass'])){

	$phone_number = $_REQUEST['number'];	

	$messagebird = new MessageBird\Client($api_credentials);
	$message = new MessageBird\Objects\Message;
	$message->originator = $sms_sender;
	$message->recipients = [ $phone_number ];

	$message->body = 'Thanks for the order. We will call you ASAP for the confirmation & quick delivery.';

	$response = $messagebird->messages->create($message);
	// var_dump($response);
	// echo '{Success : 1}';
	
}

if(isset($_REQUEST['number']) && isset($_REQUEST['pass']) && !empty($_REQUEST['pass'])){
	
	$phone_number = $_REQUEST['number'];	
	$pass_word = $_REQUEST['pass'];	

	$messagebird = new MessageBird\Client($api_credentials);
	$message = new MessageBird\Objects\Message;
	$message->originator = $sms_sender;
	$message->recipients = [ $phone_number ];

	$message->body = 'Thanks for the order. We will call you ASAP for the confirmation & quick delivery. Your user: '.$phone_number.' pass: '.$pass_word.' for login.';

	$response = $messagebird->messages->create($message);
	// var_dump($response);
	// echo '{Success : 1}';
	
}