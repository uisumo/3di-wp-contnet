<?php

defined( 'ABSPATH' ) || exit;

class grassblade_admin_reports_block {

	function __construct() {
		add_action( 'init', array($this, "block") );
	}

	function block() {

		if ( ! function_exists( 'register_block_type' ) ) {
			// Gutenberg is not active.
			return;
		}

		wp_register_script(
			'grassblade/admin-reports',
			plugins_url( 'block.js', __FILE__ ),
			array( 'wp-blocks', 'wp-i18n', 'wp-element' ),
			filemtime( plugin_dir_path( __FILE__ ) . 'block.js' )
		);

		register_block_type( 'grassblade/admin-reports', array(
	        'editor_script' => 'grassblade/admin-reports',
	        'render_callback' => array($this, "render"),
	        'attributes' => array()
	    ) );

	  if ( function_exists( 'wp_set_script_translations' ) ) {
	  	wp_set_script_translations("grassblade", "grassblade");
	  }

	} // end of admin_report_block

	function render( $attributes = array(), $content = "") {

		$grassblade_reports = new grassblade_reports();
		$report = $grassblade_reports->show_reports();//array("bg_color" => $bg_color, "filter" => $filter, "class" => $className));

		return $report;
	} // end of admin_report_block_render_callback
}
new grassblade_admin_reports_block();

