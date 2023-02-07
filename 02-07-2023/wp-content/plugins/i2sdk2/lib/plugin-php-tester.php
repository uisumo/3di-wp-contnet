<?php
if ( !defined( 'ABSPATH' ) ) {
	die();
}
include_once ABSPATH . 'wp-admin/includes/plugin.php';


$run_phptester = new i2sdk_phptester();
unset( $run_phptester );


class i2sdk_phptester {

	function __construct() {
		add_action( 'admin_notices', array( $this, 'i2sdk_admin_notice' ), 6 );
	}

	function check_php_version() {
		if ( phpversion() >= '5.3' ) {
			return true;
		}
		return false;
	}
	function i2sdk_admin_notice() {
		if ( ! function_exists( 'xml_parser_create' ) ) {
			echo '<div class="error" style="padding:5x 10px 10px 10px;"><h3>Your PHP environment is missing the<span style="color:red;font-weight:bold;">XML Parser</span> library.</h3>' .
				'Please contact your webhost to have your PHP compiled with the XML RPC Parser Library.</div>';
		}
		if ( ! $this->check_php_version() ) {
			echo '<div class="error" style="padding:5x 10px 10px 10px;"><h3>PHP version 5.3 is <span style="color:red;font-weight:bold;">NOT SETUP</span> on this web server.</h3>' .
			'Please contact your web host to upgrade your site to a version between PHP 5.3 and PHP 7.0</div>';
		}
		if ( ! class_exists( 'membershipcore' ) ) {
		}
	}
}  //info: end class
