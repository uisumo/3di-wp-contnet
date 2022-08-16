<?php

defined( 'ABSPATH' ) || exit;

class grassblade_user_report_block {

	function __construct() {
		add_action( 'init', array($this, "block") );
	}

	function block() {

		if ( ! function_exists( 'register_block_type' ) ) {
			// Gutenberg is not active.
			return;
		}

		wp_register_script(
			'grassblade/user-report',
			plugins_url( 'block.js', __FILE__ ),
			array( 'wp-blocks', 'wp-i18n', 'wp-element' ),
			filemtime( plugin_dir_path( __FILE__ ) . 'block.js' )
		);

		register_block_type( 'grassblade/user-report', array(
	        'editor_script' => 'grassblade/user-report',
	        'render_callback' => array($this, "render"),
	        'attributes' => array(
	                'bg_color' => array(
	                    'type' => 'string',
	                ),
	                'filter' => array(
	                    'type' => 'string',
	                ),
	                'className'         => array(
						'type' => 'string',
					)
	            ),
	    ) );

	  if ( function_exists( 'wp_set_script_translations' ) ) {
	  	wp_set_script_translations("grassblade", "grassblade");
	  }

	} // end of admin_report_block

	function render( $attributes = array(), $content = "") {
		$className 	= isset($attributes["className"]) ? $attributes["className"] : '';
		$bg_color 	= isset($attributes["bg_color"]) ? $attributes["bg_color"] : '';
		$filter 	= isset($attributes["filter"]) ? $attributes["filter"] : '';

		$grassblade_user_report = new grassblade_user_report();
		$profile = $grassblade_user_report->user_report(array("bg_color" => $bg_color, "filter" => $filter, "class" => $className));

		return $profile;
	} // end of admin_report_block_render_callback
}
new grassblade_user_report_block();
