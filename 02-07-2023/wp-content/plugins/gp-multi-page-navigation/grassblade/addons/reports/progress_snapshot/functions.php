<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class grassblade_reports_progress_snapshot {
	function __construct()
	{
		add_filter("grassblade/reports/available_reports", array($this, "report_name"));
		add_filter("grassblade/reports/filters/ux", array($this, "reports_field_ux"), 10, 1);
		add_filter("grassblade/reports/scripts", array($this, "report_scripts"), 10, 1);
		add_filter("grassblade/reports/get/progress_snapshot",  array($this, "get_report"), 10, 2);
		add_filter("grassblade/reports/get_courses/return", array($this, "get_courses"), 10, 2);
	}
	function report_name( $available_reports ) {
		$available_reports['progress_snapshot'] = __("Progress Snapshot Report", "grassblade");
		
		return $available_reports;
	}
	function report_scripts( $scripts ) {
		$scripts["progress_snapshot"] = array("file" => dirname(__FILE__)."/progress_snapshot.js");
		return $scripts;
	}
	function reports_field_ux( $report_filters_ux ) {
		$report_filters_ux["progress_snapshot"]	= array(
														""			=> "group",
														"group"		=> "course",
														"course"	=> "nss_report_submit"
													);
		return $report_filters_ux;
	}
	/* Hide All Courses option for Progress Snapshot Report */
	function get_courses($return, $p) {
		if( is_array($return) )
		foreach($return as $k => $r) {
			if(!empty($r["ID"]) && !empty($r["class"]) && $r["ID"] == "all")
			$return[$k]["class"] .= " hide_on_report_progress_snapshot ";
		}
		return $return;
	}
	function get_report($return, $params) {
		$return = apply_filters("grassblade/reports/progress_snapshot/data", array(), array("course_id" => $params["course_id"], "group_id" => $params["group_id"]));
		return $return;
	}
}
$grassblade_reports_progress_snapshot = new grassblade_reports_progress_snapshot();

