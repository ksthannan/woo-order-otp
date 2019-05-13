<?php
/**
	Name: WordPress Metabox and Settings API
	Author: Abdul Hannan
	Author URI: http://www.devhannan.com
	Description: The is the great API for WordPress custom metabox and setting fields. 
	Version: 1.0.0
*/

// Required files
require_once dirname( __FILE__ ) . '/metabox-and-setting/src/class.settings-api.php';
require_once dirname( __FILE__ ) . '/setting-options.php';
require_once dirname( __FILE__ ) . '/metabox-options.php';

new WeDevs_Settings_API_Test();