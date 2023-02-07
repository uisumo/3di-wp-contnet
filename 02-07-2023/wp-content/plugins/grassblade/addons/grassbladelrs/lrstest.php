<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 *
 */
class LRSTEST
{
	public $grassblade_settings;
	public $xapi;
	public $activityId 	= "http://gblrs.com/lrstest";
	public $agent_email = "test@gblrs.com";
	public $agent_name 	= "test@gblrs.com";
	public $stateId 	= "gblrs_test";

	function __construct()
	{
		add_action( 'wp_ajax_lrstest', array($this, "run") );

		add_action( 'wp_ajax_nopriv_grassblade_completion_tracking', array($this, "completion_triggers"), 5 );
		add_action( 'wp_ajax_grassblade_completion_tracking', array($this, "completion_triggers"), 5 );

		add_action( 'wp_ajax_nopriv_grassblade_xapi_track', array($this, "completion_triggers"), 5 );
		add_action( 'wp_ajax_grassblade_xapi_track', array($this, "completion_triggers"), 5 );

		if(!empty($_GET["xapi_preview"]) && !empty($_SERVER["REQUEST_URI"]))
		add_action( 'template_redirect', array($this, "check_for_404") );
	}
	function run() {
		require_once(dirname(__FILE__)."/../nss_xapi_state.class.php");
		$this->grassblade_settings 	= $grassblade_settings	= grassblade_settings();
		if(empty($grassblade_settings) || empty($grassblade_settings["endpoint"]) || empty($grassblade_settings["user"]) || empty($grassblade_settings["password"]))
		{
			$this->out(array("error" => "not_configured"));
		}
		$this->xapi 				= new NSS_XAPI_STATE($grassblade_settings["endpoint"], $grassblade_settings["user"], $grassblade_settings["password"]);
		$this->xapi->set_actor( $this->agent_name, $this->agent_email );

		if( !empty($_REQUEST["check"]) )
		switch ( $_REQUEST["check"] ) {
			case 'state':
				$send_state = $this->send_state();

				if(empty($send_state) || !isset($send_state["status"]))
					$send_state = array("status" => false);
				else
				if( !current_user_can("manage_options") )
					$send_state = array("status" => $send_state["status"]);

				$this->out($send_state);
				break;
			case 'triggers':
				$this->out( array("triggers" => get_option("grassblade_lrstest_triggers", array()) ));
			case 'lms_check':
				$status = $this->lms_check();
				$this->out( $status );
				break;
		}

		$this->out(array("error" => "invalid_method"));
		exit();
	}
	function check_for_404() {
		if(is_404() && !empty($_SERVER["REQUEST_URI"]) && current_user_can("manage_options")) {
			$request_uri = $_SERVER["REQUEST_URI"];
			$slug = grassblade_settings("url_slug");
			$slug = empty($slug)? "gb_xapi_content":$slug;
			if(strpos($request_uri, "/".$slug."/") !== false) {
				wp_redirect(self_admin_url("options-permalink.php"));
				exit();
			}
		}
	}
	static function lms_check() {
		$lms_installed = array(
			"learnpress" 	=> class_exists("LearnPress"),
			"lifterlms" 	=> class_exists('LifterLMS'),
			"wp-courseware" => function_exists("wpcw"),
			"learndash" 	=> defined("LEARNDASH_VERSION"),
			"tutorlms" 		=> defined("TUTOR_VERSION"),
			"masterstudy"	=> defined("STM_LMS_VERSION")
		);
		$required_addons = array(
			"learnpress"	=> array("grassblade-xapi-learnpress/functions.php" => array("name" => "Experience API for LearnPress", "slug" => "grassblade-xapi-learnpress", "link" => "https://www.nextsoftwaresolutions.com/experience-api-for-learnpress/")),
			"lifterlms"	=> array("grassblade-xapi-lifterlms/functions.php" => array("name" => "Experience API for LifterLMS", "slug" => "grassblade-xapi-lifterlms", "link" => "https://www.nextsoftwaresolutions.com/experience-api-for-lifterlms/")),
			"wp-courseware"	=> array("grassblade-xapi-wp-courseware/functions.php" => array("name" => "Experience API for WP Courseware", "slug" => "grassblade-xapi-wp-courseware", "link" => "https://www.nextsoftwaresolutions.com/experience-api-for-wp-courseware/")),
			"tutorlms"	=> array("grassblade-xapi-tutorlms/functions.php" => array("name" => "Experience API for TutorLMS", "slug" => "grassblade-xapi-tutorlms", "link" => "https://www.nextsoftwaresolutions.com/experience-api-for-tutorlms/")),
			"masterstudy"	=> array("grassblade-xapi-masterstudy/functions.php" => array("name" => "Experience API for MasterStudy LMS", "slug" => "grassblade-xapi-masterstudy", "link" => "https://www.nextsoftwaresolutions.com/experience-api-for-masterstudy-lms/")),
			"learndash"	=> array()
		);
		$to_install = $to_activate = array();
	   	$installed_plugins = get_plugins();
	   	$message = "";

		foreach ($lms_installed as $lms => $installed) {
			if($installed) {
				foreach ($required_addons[$lms] as $plugin_file => $info) {
					if(empty($installed_plugins[$plugin_file])) {
						$info["install_link"] =  wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=' . urlencode($info["slug"]) ), 'install-plugin_' . $info["slug"] );
						$to_install[$plugin_file] = $info;
						$message = $message. ( !empty($message)? "<br>":"" ). " <a target='_blank' href='".$info["install_link"]."'>Click here</a> to install <b>".$info["name"]."</b>. ";
					}
					else
					if(!is_plugin_active($plugin_file)) {
						$info["activate_link"] = self_admin_url( wp_nonce_url( 'plugins.php?action=activate&amp;plugin=' . urlencode( $plugin_file ), 'activate-plugin_' . $plugin_file ) );
						$to_activate[$plugin_file] = $info;
						$message = $message. ( !empty($message)? "<br>":"" ). " <a target='_blank' href='".$info["activate_link"]."'>Click here</a> to activate <b>".$info["name"]."</b>. ";
					}
				}
			}
		}
		return array("status" => ( empty($to_install) && empty($to_activate) )*1, "lms_installed" => $lms_installed, "to_install" => $to_install, "to_activate" => $to_activate, "message" => $message );
	}
	function send_state() {
		$time = time();
		$data = array(
			$this->grassblade_settings["user"] => array(
				"time" => $time,
			)
		);

		$data = json_encode( $data );
		$send_state = $this->xapi->SendState($this->activityId, $this->xapi->actor, $this->stateId, $data);
		grassblade_debug("LRSTEST: send_state = ". print_r($send_state, true));
		$get_state = $this->xapi->GetState($this->activityId, $this->xapi->actor, $this->stateId);
		$get_state = json_decode($get_state, true);
		grassblade_debug("LRSTEST: get_state = ". print_r($get_state, true));

		if( !empty($get_state) && !empty( $get_state[$this->grassblade_settings["user"]] ) && !empty($get_state[$this->grassblade_settings["user"]]["time"]) &&  $get_state[$this->grassblade_settings["user"]]["time"] == $time )
			$status = true;
		else {
			$status = false;
		}

		$return = array(
			"status" 	=> $status,
			"send" 		=> $send_state,
			"get" 		=> $get_state
		);
		return $return;
	}

	function completion_triggers() {
		if(empty($_REQUEST["grassblade_trigger"]) || !empty($_REQUEST["action"]) && $_REQUEST["action"] == "grassblade_completion_tracking" && empty($_REQUEST["grassblade_completion_tracking"]))
			return;

		if( !empty($_REQUEST["statement"]) && !empty($_REQUEST["objectid"]) && !empty($_REQUEST["agent_id"]) && !empty($_REQUEST["verb_id"]) && $_REQUEST["agent_id"] == $this->agent_email && $_REQUEST["objectid"] == $this->activityId )
		{
			$lrstest = get_option("grassblade_lrstest_triggers");

			if(empty($lrstest))
				$lrstest = array();

			$lrstest[$_REQUEST["verb_id"]] = array(
					"time" 		=> time(),
					"action"	=> $_REQUEST["action"],
					"grassblade_completion_tracking" => !empty($_REQUEST["grassblade_completion_tracking"])? 1:0,
					"grassblade_trigger" => !empty($_REQUEST["grassblade_completion_tracking"])? 1:0
				);
			update_option("grassblade_lrstest_triggers", $lrstest);
			grassblade_show_trigger_debug_messages("LRS Configuration Test verb_id: ".$_REQUEST["verb_id"]);
			exit();
		}
	}
	function out($data) {
		$data["v"] = GRASSBLADE_VERSION;
		header('Content-Type: application/json');
		echo json_encode($data);
		exit();
	}
}

new LRSTEST();