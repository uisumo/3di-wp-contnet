<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class grassblade_reports_ld_profile {
	function __construct()
	{
		add_filter("grassblade/reports/available_reports", array($this, "report_name"));
		add_filter("grassblade/reports/filters/ux", array($this, "reports_field_ux"), 10, 1);
		add_filter("grassblade/reports/scripts", array($this, "report_scripts"), 10, 1);
		add_filter("grassblade/reports/get/ld_profile",  array($this, "get_report"), 10, 2);
	}
	function report_name( $available_reports ) {
		$available_reports['ld_profile'] = __("LearnDash Profile", "grassblade");
		
		return $available_reports;
	}
	function report_scripts( $scripts ) {
		$scripts["ld_profile"] = array("file" => dirname(__FILE__)."/ld_profile.js");
		return $scripts;
	}
	function reports_field_ux( $report_filters_ux ) {
		if(function_exists('learndash_30_template_assets'))
		learndash_30_template_assets();

		$report_filters_ux["ld_profile"]	= array(
													""			=> "group",
													"group"		=> "user",
													"user"		=> "nss_report_submit"
												);
		return $report_filters_ux;
	}
	function get_report($return, $params) {

		if(empty($params) || empty($params['user']->ID)) {
			return $return;
		}

		$load_script_on_ajax = array("file" => dirname(__FILE__)."/ld_profile_ajax.js" );

		ob_start();
		echo do_shortcode("[ld_profile user_id='".$params['user']->ID."']");
		echo gb_get_scripts( $load_script_on_ajax );
		$ld_profile = ob_get_clean();
		$return = array("html" => $ld_profile);
		return $return;
	}
}
$grassblade_reports_ld_profile = new grassblade_reports_ld_profile();

