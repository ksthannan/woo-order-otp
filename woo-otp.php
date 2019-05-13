<?php
/*
Plugin Name: Woo OTP
Plugin URI: #
Description: Woocommerce OTP verification for placing order.
Author: DevHannan
Version: 1.0.0
Author URI: https://devhannan.com
*/


function customer_order_info_scripts(){
    
	wp_enqueue_style( 'customer-main-style', plugin_dir_url( __FILE__ ).'css/main.css', array(), '1.0.0', 'all' );
	
	wp_enqueue_script( 'customer-main-script',  plugin_dir_url( __FILE__ ).'js/main.js', array('jquery'), '1.0.0', true );
}
add_action('wp_enqueue_scripts', 'customer_order_info_scripts');


// Ajax scripts
add_action( 'wp_enqueue_scripts', 'order_ajax_enqueue' );
function order_ajax_enqueue() {
	
	$woo_setting_info = get_option('wedevs_basics_woo_otp');

	$api_credentials = $woo_setting_info['woo_otp_api'];

	$sms_sender = $woo_setting_info['sender_name'];
	

	global $wp;
	$current_url = home_url( add_query_arg( array(), $wp->request ) );
	
	global $post;
	$id = $post->ID;
		
	wp_localize_script( 'customer-main-script', 'order_ajax', array(
		'ajax_url' => admin_url( 'admin-ajax.php' ),
		'otp_dir' => plugin_dir_url( __FILE__ ),
		'api_credentials' => $api_credentials,
		'sms_sender' => $sms_sender,
		'current_url' => $current_url,
		'current_id' => $id,
	));
}

add_filter( 'plugin_action_links', 'wpse_25030_settings_plugin_link', 10, 2 );

function wpse_25030_settings_plugin_link( $links, $file ) 
{
    if ( $file == plugin_basename(dirname(__FILE__) . '/woo-otp.php') ) 
    {

        $in = '<a href="options-general.php?page=woo_otp_setting">' . __('Settings','woo_otp') . '</a>';
        array_unshift($links, $in);
    }
    return $links;
}

require_once "inc/woo-otp-content.php";
require_once "inc/woo-otp-functions.php";

require_once "inc/wp-setting-metabox-api/setting-options.php";
require_once "inc/wp-setting-metabox-api/helper-init.php";