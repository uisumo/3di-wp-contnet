<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function grassblade_get_groups_xmlrpc( $args ) {
    global $wp_xmlrpc_server;
    $wp_xmlrpc_server->escape( $args );

    $blog_id  = $args[0];
    $username = $args[1];
    $password = $args[2];

    if ( ! $user = $wp_xmlrpc_server->login( $username, $password ) )
        return $wp_xmlrpc_server->error;
    
    if(user_can($user, "manage_options") || user_can($user, "connect_grassblade_lrs")) {
        $params = $args[3];
        return grassblade_get_groups($params);
    }

    return;
}
function grassblade_get_group( $id ) {
    $groups = grassblade_get_groups( array("id" => $id) );
    return $groups;
}
function grassblade_get_groups( $params = array() ) {
    return apply_filters("grassblade_groups", array(), $params);
}
function grassblade_group_user_query($group_id) {
    return apply_filters("grassblade_group_user_query", $sql = "", $group_id);
}
function grassblade_add_group_user_query($sql, $group_id = "", $user_id_key = "user_id") {
    if(!empty($group_id) && is_numeric($group_id))
    $group_user_query = grassblade_group_user_query($group_id);

    if(!empty($group_user_query))
    $sql = preg_replace("/\sWHERE\s/i", " WHERE `".sanitize_key($user_id_key)."` IN ( ".$group_user_query." ) AND ", $sql);

    return $sql;
}
function grassblade_get_groups_rest_api( $d ) {
    $params = array();

    if(!empty($_REQUEST["id"]) && is_numeric($_REQUEST["id"]))
        $params["id"] = $_REQUEST["id"];

    if(!empty($_REQUEST["posts_per_page"]) && is_numeric($_REQUEST["posts_per_page"]))
        $params["posts_per_page"] = $_REQUEST["posts_per_page"];

    if(!empty($_REQUEST["leaders_list"]) && is_numeric($_REQUEST["leaders_list"]))
        $params["leaders_list"] = $_REQUEST["leaders_list"];

    if(!empty($_REQUEST["users_list"]) && is_numeric($_REQUEST["users_list"]))
        $params["users_list"] = $_REQUEST["users_list"];

    return grassblade_get_groups($params);
}
function grassblade_get_group_leaders($group) {
    global $grassblade_group_leaders;
    if(is_object($group))
        $group = (array) $group;

    if(empty($group["ID"]))
        return array();

    if(!isset($grassblade_group_leaders[$group["ID"]]))
        $grassblade_group_leaders[$group["ID"]] = apply_filters("grassblade_group_leaders", array(), $group);

    return $grassblade_group_leaders[$group["ID"]];
}
function grassblade_get_group_users($group) {
    return apply_filters("grassblade_group_users", array(), $group);
}
function grassblade_is_group_leader($user_id = null) {
    global $grassblade;

    if(is_null($user_id))
        $user_id = get_current_user_id();

    if(empty($user_id))
        return false;

    if(empty($grassblade["grassblade_is_group_leader"]))
        $grassblade["grassblade_is_group_leader"] = array();
    
    $grassblade["grassblade_is_group_leader"][$user_id] = apply_filters("grassblade_is_group_leader", false, $user_id);
    return $grassblade["grassblade_is_group_leader"][$user_id];
}
function grassblade_is_group_leader_of_user($group_leader_id, $user_id, $force = false) {
    global $grassblade_is_group_leader_of_user;

    if(empty($group_leader_id) || empty($user_id))
        return false;
    
    if(!isset($grassblade_is_group_leader_of_user[$group_leader_id]))
        $grassblade_is_group_leader_of_user[$group_leader_id] = array();

    if(!isset($grassblade_is_group_leader_of_user[$group_leader_id][$user_id]) || $force )
        $grassblade_is_group_leader_of_user[$group_leader_id][$user_id] = apply_filters("grassblade_is_group_leader_of_user", false, get_current_user_id(), $user_id);
    
    return $grassblade_is_group_leader_of_user[$group_leader_id][$user_id];
}
function grassblade_is_group_leader_of_group($group_leader_id, $group) {
    if(is_numeric($group))
        $group = grassblade_get_group($group);

    if(is_object($group))
        $group = (array) $group;

    $leaders = grassblade_get_group_leaders($group);

    if(!empty($group["ID"]) && !empty($leaders[$group_leader_id]))
        return true;
    else
        return false;
}
function grassblade_is_group_leader_of_course($group_leader_id, $course_id) {
    if(empty($group_leader_id))
        return false;

    $group_leader = get_user_by("id", $group_leader_id);
    if(empty($group_leader->ID))
        return false;

    $post_status = "publish,private,draft";
    $courses = grassblade_lms::get_courses(array("post_status" => $post_status, "user" => $group_leader));

    return !empty($courses[$course_id]);
}
function grassblade_xmlrpc_methods( $methods ) {
    $methods['grassblade.getGroups'] = 'grassblade_get_groups_xmlrpc';
    return $methods;   
}
add_filter( 'xmlrpc_methods', 'grassblade_xmlrpc_methods');

add_action( 'rest_api_init', function () {
  register_rest_route( 'grassblade/v1', '/getGroups', array(
    'methods' => 'GET',
    'callback' => 'grassblade_get_groups_rest_api',
    'permission_callback' => function () {
      return current_user_can( 'connect_grassblade_lrs' ) ||  current_user_can( 'manage_options' );
    }
  ) );
} );
