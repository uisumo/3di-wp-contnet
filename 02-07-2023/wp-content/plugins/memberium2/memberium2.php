<?php
/*
Plugin Name: Memberium for Keap
Description: Membership system for Keap and WordPress
Author URI: http://www.webpowerandlight.com/
Author: David Bullock
License: Copyright (c) 2012-2022 David Bullock, Web Power and Light
Plugin URI: http://www.memberium.com/
Requires at least: 5.8
Requires PHP: 7.0
Text Domain: memberium
Update URI: https://memberium.com/keap/
Version: 2.206
*/



defined( 'ABSPATH' ) || die();

if ( ! function_exists( 'memberium_app' ) ) {
	define( 'MEMBERIUM_HOME', __FILE__ );

	if ( include_once __DIR__ . '/classes/core.php' ) {
		
function memberium_app() : m4is_emz57o {
			static $m4is_bxv7u;
			return isset( $m4is_bxv7u ) ? $m4is_bxv7u : $m4is_bxv7u = m4is_emz57o::m4is_a6x52r( __DIR__, __FILE__ );
		}

		memberium_app();
	}
}
