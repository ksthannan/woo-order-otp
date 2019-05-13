/*
JS for Woo OTP for order placement.

OTP service provider: 
https://dashboard.messagebird.com
https://dashboard.messagebird.com/en/user/index

*/

// Change the add to cart button text.
jQuery(document).ready(function(){
	// jQuery('.cart button').text('Order Now');
});
jQuery(document).ready(function(){
	jQuery('.wc-proceed-to-checkout a.checkout-button').text('Proceed to Order');
});

jQuery(document).on('click','.add_to_order',function(e){
	
	jQuery('#req_sender').val('single');
	
});
jQuery(document).on('click','.wc-proceed-to-checkout a.checkout-button',function(e){
	
	jQuery('#req_sender').val('cart');
	
});


// Show the popup after click.
jQuery(document).on('click','.add_to_order, .checkout-button',function(e){
	e.preventDefault();
	setTimeout(function(){
		jQuery('.otp_modal').attr('style','display:block !important;');
	}, 300 );
});

// Hide the popup after click.
jQuery(document).on('click','.toggle_btn',function(e){
	e.preventDefault();
	setTimeout(function(){
		jQuery('.otp_modal').attr('style','display:none !important;');
	}, 100 );
});

// // Send OTP to the user's mobile number. 
// jQuery(document).on('click','.cart button',function(e){
	
	// var qty = jQuery('.qty').val();
	
	// jQuery.ajax({
		 // url : order_ajax.current_url+'/?add-to-cart='+order_ajax.current_id+'&quantity='+qty,
		// type : 'get',
		// data : {
		// },
		// dataType: 'html',
		// success : function(response){
			
			// console.log('Product has been added to the cart. '+order_ajax.current_id+' '+qty);
			
	 // },
	 // cache: false
	// });
// });
jQuery(document).on('click','.otP_inner form #otp_send_code',function(e){
	e.preventDefault();
	
	
	var otp_country_code   = jQuery('#country_code').val();
	var otp_sending_number = jQuery('#phone_number').val();
	var full_phone_number  = '+' + otp_country_code + otp_sending_number;
	if(otp_sending_number !== ''){
		var full_phone_number  = '+' + otp_country_code + otp_sending_number;
		
		var very_gen_code  = Math.floor((Math.random() * 9900) + 9800);
		
			jQuery('.otP_inner h3').html('OTP is being sent ...');
			
			jQuery.ajax({
				 url : order_ajax.otp_dir+'otp-send-code.php/?number='+full_phone_number+'&api_key='+order_ajax.api_credentials+'&sender_name='+order_ajax.sms_sender+'&code='+very_gen_code,
				type : 'get',
				data : {
				},
				dataType: 'html',
				success : function(response){
					
					console.log('SMS OTP has been sent to '+full_phone_number);
					
					setTimeout(function(){
						jQuery('select#country_code, #phone_number, #otp_send_code').fadeOut();
						jQuery('.otP_inner h3').html('Verification code has been sent to '+full_phone_number);
					}, 500);
					
					setTimeout(function(){
						jQuery('.otP_inner form').append('<input type="hidden" name="session_otp" id="session_otp" value="'+very_gen_code+'"><input type="text" name="otp_input" id="otp_input" value="" placeholder="Verification Code"><input type="hidden" name="phone_number" id="phone_number_two" value="'+full_phone_number+'"><input type="submit" id="otp_verify_submit" value="Place Order">');
					}, 1000);
					
					// console.log(very_gen_code);
			 },
			 cache: false
		});
	}

    
});

// Verify OTP and do action
 jQuery(document).on('click','.otP_inner form #otp_verify_submit',function(e){
	e.preventDefault();
	
	var re_session_otp   = jQuery('#session_otp').val();
	var re_otp_input = jQuery('#otp_input').val();
	var re_phone_number = jQuery('#phone_number_two').val();
		
	if(re_session_otp == re_otp_input){
		var product_id	  = jQuery('#product_id').val();
		var req_sender	  = jQuery('#req_sender').val();
		var phone_number_two  = jQuery('#phone_number_two').val();
		var product_qty  = jQuery('input.qty').val();
		var tracker_id = jQuery('#phone_number').val();
			
		jQuery('.otP_inner .box_content').html('<h3>Progressing Your Order </br>Please wait...</h3>');
		setTimeout(function(){
			jQuery('.otP_inner .box_content').html('<h3>Progressing Your Order 20% </br>Please wait...</h3>');
		}, 300);
		setTimeout(function(){
			jQuery('.otP_inner .box_content').html('<h3>Progressing Your Order 50% </br>Please wait...</h3></br>');
		}, 500);
		setTimeout(function(){
			jQuery('.otP_inner .box_content').html('<h3>Progressing Your Order 75% </br>Please wait...</h3>');
		}, 800);
		setTimeout(function(){
			jQuery('.otP_inner .box_content').html('<h3>Progressing Your Order 95% </br>Please wait...</h3>');
		}, 1500);
		
		jQuery.ajax({
			url : order_ajax.ajax_url,
			type : 'get',
			data : {
				action : 'order_creation_action',
				product_id : product_id,
				phone : phone_number_two,
				pro_qty : product_qty,
				req_sender : req_sender,
				tracker_id : tracker_id,
			},
			dataType: 'html',
			success : function(response){
						jQuery('.otP_inner form').fadeOut();
                        setTimeout(function(){
						jQuery('.otP_inner .box_content').html('<h3 class="verification_message">Thanks for the order. </br> We will call you as soon as possible for the details of the product and delivery.</h3>');
						console.log('Order completed from '+phone_number_two);
						console.log(response);
                        }, 1600);
			 },
			 cache: false
		});

	}else{
		setTimeout(function(){
			jQuery('<h4 class="verification_nmatch">OTP not matched! Please input correct code.</h4>').insertBefore('.otP_inner form #otp_verify_submit');
		}, 500);
	}
	
});