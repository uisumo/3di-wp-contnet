<?php
/**
 * Copyright (c) 2012-2022 David J Bullock
 * Web Power and Light, LLC
 * https://webpowerandlight.com
 * support@webpowerandlight.com
 *
 */

 class_exists('m4is_emz57o') || die(); final 
class m4is_qmpq8 {  
function __construct() { }  private static 
function m4is_brb6() : array { if ( MEMBERIUM_SKU == 'm4is' ) { $m4is_tsra = [ 'access_tags' => '_is4wp_access_tags', 'access_tags2' => '_is4wp_access_tags2', 'anonymous_only' => '_is4wp_anonymous_only', 'any_loggedin_user' => '_is4wp_any_loggedin_user', 'any_membership' => '_is4wp_any_membership', 'can_comment' => '_is4wp_can_comment', 'commenter_action' => '_is4wp_commenter_action', 'commenter_goal' => '_is4wp_commenter_goal', 'commenter_tag' => '_is4wp_commenter_tag', 'contact_ids' => '_is4wp_contact_ids', 'custom_code' => '_iswp_custom_code', 'discourage_cache' => '_is4wp_discourage_cache', 'facebook_crawler' => '_is4wp_facebook_crawler', 'force_public' => '_is4wp_force_public', 'google_1st_click' => '_is4wp_google_1stclick', 'hide_from_menu' => '_is4wp_hide_from_menu', 'memberships' => '_is4wp_membership_levels', 'private_comments' => '_is4wp_private_comments', 'prohibited_action' => '_is4wp_prohibited_action', 'redirect_url' => '_is4wp_redirect_url', ]; } elseif ( MEMBERIUM_SKU == 'm4ac' ) { $m4is_tsra = []; } return $m4is_tsra; } static 
function m4is_utcaxj( int $m4is__xysg ) : array { $m4is_tsra = self::m4is_brb6(); $m4is_galwv0 = get_post_meta( $m4is__xysg ); $m4is_tct_hk = false; if ( is_array( $m4is_galwv0 ) && ! empty( $m4is_galwv0 ) ) { $m4is_tct_hk = []; foreach ( $m4is_tsra as $m4is_e3k_mi => $m4is_waxrhu ) { if ( isset( $m4is_galwv0[$m4is_waxrhu][0] ) ) { $m4is_tct_hk[$m4is_e3k_mi] = $m4is_galwv0[$m4is_waxrhu][0]; } } } return $m4is_tct_hk; } static 
function m4is_mp57d( int $m4is__xysg = 0, $m4is_dwgs_ = [], $m4is_rhfd = null ) { if ( empty( $m4is_dwgs_ ) || empty( $m4is__xysg ) ) { return false; } if ( ! current_user_can( 'edit_post', $m4is__xysg ) ) { return false; } if ( is_string( $m4is_dwgs_ ) ) { $m4is_dwgs_ = [ $m4is_dwgs_ => $m4is_rhfd, ]; } $m4is_psuj_o = [ 'any_loggedin_user', 'any_membership', 'facebook_crawler', 'google_1st_click', 'hide_completely', 'hide_from_menu', 'private_comments', ]; $m4is_tsra = self::m4is_brb6();  foreach( $m4is_dwgs_ as $m4is_ap3_ => $m4is_rhfd ) { if ( array_key_exists( $m4is_ap3_, $m4is_tsra ) ) { $m4is_rhfd = array_key_exists( $m4is_ap3_, $m4is_psuj_o ) ? (int) (bool) trim( $m4is_rhfd ) : $m4is_rhfd; $m4is_rhfd = is_string( $m4is_rhfd ) ? trim( $m4is_rhfd ) : $m4is_rhfd; add_post_meta( $m4is__xysg, $m4is_tsra[$m4is_ap3_], $m4is_rhfd, true ) or update_post_meta( $m4is__xysg, $m4is_tsra[$m4is_ap3_], $m4is_rhfd ); } else {  } } } }
