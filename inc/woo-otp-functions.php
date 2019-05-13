<?php 

// Ajax function 
add_action( 'wp_ajax_order_creation_action', 'order_creation_action' );
add_action( 'wp_ajax_nopriv_order_creation_action', 'order_creation_action' );
function order_creation_action(){
	ob_clean();
	if(isset($_REQUEST['phone'])){
		$phone = $_REQUEST['phone'];
		$product_id = $_REQUEST['product_id'];
		$price = $_REQUEST['price'];
		$pro_qty = $_REQUEST['pro_qty'];
		$req_sender = $_REQUEST['req_sender'];
		$tracker_id = $_REQUEST['tracker_id'];
	}else{
		$phone = '';
		$product_sku = '';
		$product_id = '';
		$price = '';
		$pro_qty = 1;
	}

  global $woocommerce;
  global $product;


 
	
	// Create User & send message 
	$user_name = str_replace("+88", "", $phone);
	$pass  = rand(99000000,98000000);
	$woo_setting_info = get_option('wedevs_basics_woo_otp');
	$api_credentials = $woo_setting_info['woo_otp_api'];
	$sms_sender = $woo_setting_info['sender_name'];
	
	require_once __DIR__.'/php-rest-api-master/autoload.php';
	
	if ( !username_exists( $user_name )  ) {
		$created_user_id = wp_create_user( $user_name, $pass, '' );
		$user_s = new WP_User( $created_user_id );
		$user_created = $user_s->set_role( 'customer' );
		
	  $address = array(
		  'first_name' => 'New Customer',
		  'last_name'  => $phone,
		  'company'    => '',
		  'email'      => '',
		  'phone'      => $phone,
		  'address_1'  => '',
		  'address_2'  => '',
		  'city'       => '',
		  'state'      => '',
		  'postcode'   => '',
		  'country'    => ''
	  );


		$order = wc_create_order(array('customer_id'=>$created_user_id));
		if($req_sender == 'single'){
			$order->add_product( get_product($product_id, $pro_qty));
		}else{
			foreach ($woocommerce->cart->get_cart() as $cart_item_key => $values) {
				$item_id = $order->add_product(
						$values['data'], $values['quantity'], array(
					'variation' => $values['variation'],
					'totals' => array(
						'subtotal' => $values['line_subtotal'],
						'subtotal_tax' => $values['line_subtotal_tax'],
						'total' => $values['line_total'],
						'tax' => $values['line_tax'],
						'tax_data' => $values['line_tax_data'] // Since 2.2
					)
						)
				);
			}  
		}
			
	 

  // The add_product() function below is located in /plugins/woocommerce/includes/abstracts/abstract_wc_order.php
	//  $order->add_product( get_product($product_id, $pro_qty)); // This is an existing SIMPLE product
	  $order->set_address( $address, 'billing' );
	  
	  
	  $order->calculate_totals();
	  $order->update_status("Completed", 'Imported order', TRUE); 

	  $order->save(); 
	  
	  $order_number = $order->get_id();
	  
	  
	  update_post_meta($order->id, '_customer_user', $created_user_id);
	  
	  update_post_meta($order->id, 'tracker_id', $order_number);
		
		$messagebird = new MessageBird\Client($api_credentials);
		$message = new MessageBird\Objects\Message;
		$message->originator = $sms_sender;
		$message->recipients = [ $phone ];

		$message->body = 'Thanks for the order #'.$order_number.'. We will call you ASAP for the confirmation & quick delivery. Your user: '.$user_name.' pass: '.$pass.' for login.';

		$response = $messagebird->messages->create($message);
		
	}else{
		

		
		  $address = array(
			  'first_name' => 'Repeated Customer',
			  'last_name'  => $phone,
			  'company'    => '',
			  'email'      => '',
			  'phone'      => $phone,
			  'address_1'  => '',
			  'address_2'  => '',
			  'city'       => '',
			  'state'      => '',
			  'postcode'   => '',
			  'country'    => ''
		  );

		  // Now we create the order
		$userid = get_current_user_id();
		
		$order = wc_create_order(array('customer_id'=>$userid));
		
		
		if($req_sender == 'single'){
			$order->add_product( get_product($product_id, $pro_qty));
		}else{
			foreach ($woocommerce->cart->get_cart() as $cart_item_key => $values) {
				$item_id = $order->add_product(
						$values['data'], $values['quantity'], array(
					'variation' => $values['variation'],
					'totals' => array(
						'subtotal' => $values['line_subtotal'],
						'subtotal_tax' => $values['line_subtotal_tax'],
						'total' => $values['line_total'],
						'tax' => $values['line_tax'],
						'tax_data' => $values['line_tax_data'] // Since 2.2
					)
						)
				);
			}  
		}
			
		  $order->set_address( $address, 'billing' );
		  //
		  $order->calculate_totals();
		  $order->update_status("Completed", 'Imported order', TRUE); 

		  $order->save(); 
		  
		  update_post_meta($order->id, 'tracker_id', $order_number);
		  
		  $order_number = $order->get_id();
		$messagebird = new MessageBird\Client($api_credentials);
		$message = new MessageBird\Objects\Message;
		$message->originator = $sms_sender;
		$message->recipients = [ $phone ];

		$message->body = 'Thanks for the order #'.$order_number.'. We will call you ASAP for the confirmation & quick delivery.';

		$response = $messagebird->messages->create($message);
	}
	
	$postarr = array(
		'post_title' => $tracker_id,
		'post_type' => 'EWD-OTP-options',
		'meta_input' => array(
			'tracker_id' => $tracker_id,
		),
	);
	wp_insert_post($postarr);
	
	
	
	echo '{success : 1}';
	wp_die();
}