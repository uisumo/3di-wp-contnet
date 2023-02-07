<?php
/**
 * Copyright (c) 2018-2022 David J Bullock
 * Web Power and Light, LLC
 * https://webpowerandlight.com
 * support@webpowerandlight.com
 *
 */

 class_exists('m4is_emz57o') || die(); final 
class m4is_d8yr0_ {  static 
function m4is_c2z3fw() { static $m4is_r9dhxg = false; if (! $m4is_r9dhxg) { $m4is_r9dhxg = true; if (! defined('LSCACHE_NO_CACHE') ) { define('LSCACHE_NO_CACHE', true); } if (! defined('DONOTCACHEPAGE')) { define('DONOTCACHEPAGE', true); } if (! headers_sent()) { header('X-Cache-Enabled: False'); header('X-Memberium-Caching: Plugin Caching Hinted Off'); } } } static 
function m4is_okts() { $m4is_yp8jv = defined('MEMBERIUM_DISABLE_CACHING') && MEMBERIUM_DISABLE_CACHING == true; if (function_exists('is_user_logged_in') && ! is_user_logged_in() ) { $m4is_yp8jv = true; } if ($m4is_yp8jv) { return; } self::m4is_c2z3fw(); if (! headers_sent() ) { header('X-Cache-Enabled: False'); header('Cache-Control: no-cache, max-age=0, must-revalidate, no-store'); header('Pragma: no-cache'); header('Expires: 0'); nocache_headers(); } }  static 
function m4is_vsv0mr() { static $m4is_gguex = false; if ($m4is_gguex) { return; } if (self::$m4is_kxn9fr) { return; } self::$m4is_kxn9fr = true; $m4is_gguex = true; self::m4is_okts();  if (! empty($_SERVER['HTTP_X_VARNISH']) ) { return; }  } static 
function m4is_oh_t() { return ! self::$m4is_kxn9fr; } private static $m4is_kxn9fr = false; }
