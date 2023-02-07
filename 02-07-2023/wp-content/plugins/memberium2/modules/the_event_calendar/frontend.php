<?php
/**
 * Copyright (c) 2012-2019 David J Bullock
 * Web Power and Light, LLC
 * https://webpowerandlight.com
 * support@webpowerandlight.com
 *
 */

 class_exists('m4is_emz57o') || die(); final 
class m4is_uan6 { 
function m4is_tu2f3($m4is_zv59, $m4is_lv52a, $m4is_k2qb08, $m4is_lsvyxw) { if (is_null($m4is_zv59) ) { $m4is_hf76 = is_a($m4is_lv52a, 'WP_Post') ? $m4is_lv52a->ID : (int) $m4is_lv52a; $m4is_zv59 = m4is_pcys::m4is_a6x52r()->m4is_whka($m4is_hf76) ? $m4is_zv59 : false; } return $m4is_zv59; } private 
function m4is_ap508() { add_filter('tribe_get_event_before', [$this, 'm4is_tu2f3'], 1, 4); } private 
function __construct() { $this->m4is_ap508(); } static 
function m4is_a6x52r() : self { static $m4is_jprj8 = false; return $m4is_jprj8 ? $m4is_jprj8 : $m4is_jprj8 = new self; } }
