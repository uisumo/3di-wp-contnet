<?php
if ( ! defined( 'ABSPATH' ) ) exit;

// base function are protected and addon private
class gb_groups_learndash extends gb_groups_base
{
	public static $short_key = "ld";
	public static $meta_key = ""; //gb_group_leader_".self::$short_key;
	public static $group_type = "WP: LearnDash LMS";

	function __construct()
	{
		parent::__construct();
	}

	function run()
	{
		if ($this->is_plugin_active()) {
			add_filter("grassblade_groups", array($this, "filter_grassblade_groups"), 10, 2); // in base
			add_filter("grassblade_get_courses", array($this, "filter_get_courses"), 10, 2); // in base

			add_filter("grassblade_reports_menu_cap", array($this, "filter_group_leader_menu_cap"), 10, 1);
			add_filter("grassblade_is_group_leader", array($this, "filter_is_group_leader"), 11, 2);
			add_filter("grassblade_is_group_leader_of_user", array($this, "filter_is_group_leader_of_user"), 10, 3);
			add_filter("grassblade_group_user_query", array($this, 'filter_get_group_user_query'), 10, 3);
			add_filter('grassblade/groups/get/courses/'.self::$short_key, array($this, "filter_get_group_courses"), 10, 4);
		}
	}
	function is_plugin_active() {
		return defined("LEARNDASH_VERSION");
	}
	static function filter_get_group_courses($all_courses, $group_id, $params, $ids_only = false) {

		if($group_id == 'all') {
			$post_status = !empty($params["post_status"])? trim($params["post_status"]):"publish";
			$courses = get_posts("post_type=sfwd-courses&post_status=$post_status&posts_per_page=-1");
			foreach($courses as $course) {
				$course->lms = self::$short_key;
				$all_courses[] = $course;
			}

			return ($ids_only)? wp_list_pluck($all_courses, "ID"):$all_courses;
		}

		$group = is_numeric($group_id) ? get_post($group_id) : array();
		if (empty($group) || empty($group->post_type) || $group->post_type != "groups")
			return $all_courses;

		$course_ids = learndash_get_group_courses_list($group_id);

		if( $ids_only )
			return $course_ids;

		if(!empty($course_ids))
		foreach ($course_ids as $course_id) {
			$course = get_post($course_id);
			$course->lms = self::$short_key;
			$all_courses[] = $course;
		}

		return $all_courses;
	}
	function filter_get_group_user_query($sql, $group_id, $group_type = '')
	{
		if (!is_numeric($group_id) || !empty($sql) || !empty($group_type) && $group_type != self::$group_type)
			return $sql;

		$group = get_post($group_id);
		if (empty($group) || empty($group->post_type) || $group->post_type != "groups")
			return $sql;

		global $wpdb;
		return $wpdb->prepare("SELECT user_id FROM $wpdb->usermeta WHERE meta_key = 'learndash_group_users_{$group_id}' AND meta_value = '%d'", $group_id);
	}

	static function get_groups($params)
	{
		$groups = array();
		$params["post_type"] = "groups";

		if (empty($params["posts_per_page"]))
			$params["posts_per_page"] = -1;

		if (isset($params["leaders_list"]))
			unset($params["leaders_list"]);

		if (isset($params["users_list"]))
			unset($params["users_list"]);

		if (!empty($params["group_leader_id"])) {
			$group_leader_group_ids = self::get_leaders_group_ids($params["group_leader_id"]);
			if (empty($group_leader_group_ids) || !empty($params["id"]) && !in_array($params["id"], $group_leader_group_ids))
				return array();

			$params["post__in"] = $group_leader_group_ids;
			$groups = get_posts($params);
		} else if (!empty($params["id"])) {
			$groups = array(get_post($params["id"]));
		} else {
			$groups = get_posts($params);
		}

		$groups_return = array();
		foreach ($groups as $k => $group) {
			if (!empty($group->ID) && !empty($group->post_type) && $group->post_type == "groups")
				$groups_return[] = array(
					"ID" 	=> $group->ID,
					"name"	=> $group->post_title,
					"type"	=> self::$group_type
				);
		}
		return $groups_return;
	}

	function filter_is_group_leader_of_user($r, $leader_id, $user_id)
	{
		if (!function_exists('learndash_is_group_leader_user') || !empty($r))
			return $r;

		return learndash_is_group_leader_user($leader_id) && learndash_is_group_leader_of_user($leader_id, $user_id);
	}

	function filter_is_group_leader($r, $current_user_id)
	{
		if (!function_exists('learndash_is_group_leader_user') || $r)
			return $r;

		return learndash_is_group_leader_user($current_user_id);
	}

	function filter_group_leader_menu_cap($menu_cap)
	{
		if (function_exists("learndash_is_group_leader_user") && !current_user_can("manage_options") && learndash_is_group_leader_user())
			return LEARNDASH_GROUP_LEADER_CAPABILITY_CHECK;
		return $menu_cap;
	}
	static function get_leader_ids($group_id)
	{
		return (!function_exists("learndash_get_groups_administrator_ids")) ? array() : learndash_get_groups_administrator_ids($group_id);
	}
	static function get_leaders_group_ids($group_leader_id)
	{
		if(function_exists('learndash_is_group_leader_user') && !learndash_is_group_leader_user($group_leader_id) || !function_exists("learndash_get_administrators_group_ids"))
			return array();

		return apply_filters("grassblade/groups/get/get_leaders_group_ids", learndash_get_administrators_group_ids($group_leader_id), $group_leader_id, self::$short_key);
	}
	static function get_user_ids($group_id)
	{
		return (!function_exists("learndash_get_groups_user_ids")) ? array() : learndash_get_groups_user_ids($group_id);
	}
} // end of gb_groups_learndash class

return new gb_groups_learndash();
