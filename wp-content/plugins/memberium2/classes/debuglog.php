<?php
/**
 * Copyright (c) 2018-2020 David J Bullock
 * Web Power and Light, LLC
 * https://webpowerandlight.com
 * support@webpowerandlight.com
 *
 */

 if (!defined('ABSPATH') ) { die(); } final class wplzef1s7 { static function wplyybm($vwplf_3k79 = '', $vwpltgsaw = '', $vwplm1zxha = 0, $vwplwi6t5n = '', $vwplz4g7n = NULL) { if (isset($_GET['doing_wp_cron']) ) { return; } if (is_admin() ) { return; } global $user; $vwplpag6vp = $_SERVER['REMOTE_ADDR'] . '::' . isset($_SERVER['REQUEST_TIME_FLOAT']) ? $_SERVER['REQUEST_TIME_FLOAT'] : $_SERVER['REQUEST_TIME']; $vwpltlkdcw = $vwplpag6vp . ' :: ' . microtime(true); $vwpltlkdcw .= ' :: ' . (function_exists('get_current_user_id') ? get_current_user_id() : 0); if (function_exists('current_filter') ) { $vwpltlkdcw .= ' :: ' . current_filter(); } $vwpltlkdcw .= ' :: '; $vwpltlkdcw .= basename($vwplf_3k79) . ' -> ' . $vwpltgsaw . ' -> ' . $vwplm1zxha . " :: "; if (isset($vwplz4g7n) ) { $vwpltlkdcw .= $vwplwi6t5n . ' = '; if (is_array($vwplz4g7n) || is_object($vwplz4g7n) ) { $vwpltlkdcw .= print_r($vwplz4g7n, true); } elseif (is_bool($vwplz4g7n) ) { $vwpltlkdcw .= $vwplz4g7n ? 'True' : 'False'; } else { $vwpltlkdcw .= $vwplz4g7n; } } else { $vwpltlkdcw .= $vwplwi6t5n; } $vwpltlkdcw .= "\n"; if (MEMBERIUM_DEBUGLOG == 'error_log:') { error_log($vwpltlkdcw); } elseif (MEMBERIUM_DEBUGLOG > '') { file_put_contents(MEMBERIUM_DEBUGLOG, $vwpltlkdcw, FILE_APPEND); } else { echo nl2br($vwpltlkdcw); } } }
