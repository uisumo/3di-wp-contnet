<?php
/**
* Copyright (c) 2018-2022 David J Bullock
* Web Power and Light
*/

  class_exists('m4is_emz57o') || die(); final 
class m4is_jf1i { static 
function m4is_a6x52r() : self { static $m4is_jprj8 = false; return $m4is_jprj8 ? $m4is_jprj8 : $m4is_jprj8 = new self; } private 
function __construct() { $this->m4is_ap508(); } private 
function m4is_ap508() { add_filter( 'bbp_get_topic_subscribers', [$this, 'm4is_fhrdz'] ); } 
function m4is_fhrdz( $m4is_yj5ls9 ) { if ( ! empty( $m4is_yj5ls9 ) && is_array( $m4is_yj5ls9 ) ) { global $wpdb; $m4is_vkz7na = implode( ',', $m4is_yj5ls9 ); $m4is_ioxk = "SELECT user_id FROM {$wpdb->usermeta} WHERE user_id IN (" . $m4is_vkz7na . ") AND `meta_key` = 'memberium_optout' AND `meta_value` = 1"; $m4is_zn9aj_ = $wpdb->get_col( $m4is_ioxk ); $m4is_yj5ls9 = array_diff( $m4is_yj5ls9, $m4is_zn9aj_ ); } return $m4is_yj5ls9; } }
