<?php
/**
 * Copyright (c) 2012-2020 David J Bullock
 * Web Power and Light
 */



if (! defined('ABSPATH') ) {
	die();
}


function memb_doShortcode($content, $do_regular_shortcodes = true) {
	return do_shortcode($content);
}


function memb_getLoggedIn() {
	return is_user_logged_in();
}

function memb_hasAllTags($tags, $contact_id = false) {
	return wplj_l2t::wplid3nye($tags, $contact_id);
}

function memb_hasAnyTags($tags, $contact_id = false){
	if ((! $contact_id) && is_super_admin() ) {
		return true;
	}

	if (! $contact_id) {
		$contact_id = isset($_SESSION['memb_db_fields']['id']) ? $_SESSION['memb_db_fields']['id'] : 0;
	}

	if ($contact_id) {
		$is_current_user = isset($_SESSION['memb_db_fields']['id']) ? $_SESSION['memb_db_fields']['id'] == $contact_id : false;


		if ($is_current_user) {
			$contact_tags = isset($_SESSION['memb_db_fields']['groups']) ? $_SESSION['memb_db_fields']['groups'] : '';
		}
		else {
			$contact_tags = wpllbej::wplrande($contact_id)['Groups'];
		}

		if (! empty($contact_tags)) {
			return wplj_l2t::wpl_z7ir($tags, $contact_tags);
		}
	}

	return false;
}

function memb_hasAnyMembership() {
	return memberium_app()->wplbg3oj()->wplilgp5();
}

function memb_hasMembership($level) {
	return memberium_app()->wplbg3oj()->wplds1m_($level);
}

function memb_hasMembershipLevel($level) {
	return memberium_app()->wplbg3oj()->wplcfd7b($level);
}

function memb_isPostProtected($post) {
	return memberium_app()->wplbg3oj()->wplvloqm($post);
}

function memb_hasPostAccess($post_id) {
	return memberium_app()->wplbg3oj()->wpls9nje($post_id);
}

function memb_is_loggedin() {
	return is_user_logged_in();
}


function memb_getUserField($field_name, $user_id = 0) {
	return wplsbzgvp::wpllnxp8($field_name, $user_id);
}

function memb_setUserField($field_name, $value, $user_id = 0) {
	return wplsbzgvp::wplq27h($field_name, $value, $user_id);
}


function memb_overrideProhibitedAction($action) {
	return memberium_app()->wplbg3oj()->wplc2skz8($action);
}


function memb_getAffiliateField($fieldname = '', $sanitize = FALSE) {
	return memberium_app()->wplbg3oj()->wplrrdu6($fieldname, $sanitize);
}

function memb_changeContactPassword($password, $contact_id = false) {
	return memberium_app()->wplr2rtyo($password, $contact_id);
}

function memb_changeContactEmail($email, $user_id, $force_username = false) {
	return memberium_app()->wplqrq4d($user_id, $email, 0, $force_username);
}

function memb_getContactField($fieldname = '', $sanitize = FALSE) {
	return memberium_app()->wplbg3oj()->wplvyjh($fieldname, $sanitize);
}

function memb_getContactId() {
	return wplsbzgvp::wplfhxj9();
}

function memb_getContactIdByUserId($user_id) {
	return wpllbej::wplbmo_1($user_id);
}

function memb_getUserIdByContactId($contact_id) {
	return wpllbej::wplsgpnk($contact_id);
}

function memb_loadContactById($contact_id) {
	return wpllbej::wplrande($contact_id);
}

function memb_syncContact($contact_id = 0, $cascade = false) {
	return memberium_app()->wplj9ye($contact_id, $cascade);
}

function memb_setTags($tags = '', $contact_id = false, $force = false) {
	return memberium_app()->wplt263_($tags, $contact_id, $force);
}

function memb_getReceipt($args = array()) {
	return memberium_app()->wplxjyl9($args);
}

function memb_setContactField($key = '', $value = '', $contact_id = 0) {
	if (empty($key) ) {
		return false;
	}
	return memberium_app()->wplox2qcd($key, $value, $contact_id);
}

function memb_getSession($user_id) {
	return memberium_app()->get_session($user_id);
}


function memb_getMembershipMap(){
	return wplz8bid::wplvf1d('memberships');
}

function memb_getTagMap( $cache_bust = false, $negatives = false ){
	return memberium_app()->wplaajf($cache_bust,$negatives);
}

function memb_getContactFieldsMap(){
	global $i2sdk;
	return $i2sdk->getInfusionsoftFieldsByTable( 'Contact' );
}



function doMemberiumLogin($username, $password = '', $idempotent = false) {
	return memberium_app()->wplbg3oj()->wplewep($username, $password, $idempotent);
}

function memb_setSSOMode($mode = true) {
	return memberium_app()->wpljmvd7( (boolean) $mode);
}

function memb_getAppName() {
	return wplz8bid::wplm3z9k('appname');
}

function memb_getPostSettings($post_id) {
	return wpla0ovhi::wplq_i47r($post_id);
}
