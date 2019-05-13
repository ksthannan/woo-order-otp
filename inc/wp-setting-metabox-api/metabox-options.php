<?php

require_once( 'metabox-and-setting/hd-wp-metabox-api/class-hd-wp-metabox-api.php' );

$order_options = array(
	'metabox_title' => 'Order Tracker',
	'metabox_id'    => 'order_tracker',
	'post_type'     => array( 'shop_order' ),
	'context'       => 'normal',
	'priority'      => 'high',
);

$example_fields = array(
	'tracker_id' => array(
		'title'   => 'Tracker ID',
		'type'    => 'text',
		'desc'    => 'Order tracker ID (Phone Number)',
		'sanit'   => 'nohtml',
	),
	'tracking_info' => array(
		'title'   => 'Tracking information',
		'type'    => 'textarea',
		'desc'    => 'Tracking information input',
		'sanit'   => 'nohtml',
	),
	'pricked_date' => array(
		'title'   => 'Picked Date',
		'type'    => 'text',
		'desc'    => 'Picked date (01/01/2019)',
		'sanit'   => 'nohtml',
	),
);

$order_tracker = new HD_WP_Metabox_API( $order_options, $example_fields );